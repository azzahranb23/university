<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\User;
use App\Models\Application;
use App\Models\ProjectContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function publicIndex(Request $request)
    {
        // Query untuk daftar proyek di sidebar
        $query = Project::with(['category', 'user'])
            ->latest();

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Ambil semua proyek untuk sidebar
        $projects = $query->get();

        // Ambil detail proyek yang dipilih
        $selectedProject = null;
        if ($request->filled('project')) {
            $selectedProject = Project::with(['category', 'user'])
                ->find($request->project);
        }

        $categories = Category::all();
        return view('projects.public', compact('projects', 'selectedProject', 'categories'));
    }

    public function owner($user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        $projects = Project::where('user_id', $user_id)->get();

        return view('projects.owner', compact('user', 'projects'));
    }

    public function myProjects(Request $request)
    {
        // cek apakah ada user_id di table aplication
        $check = Application::leftJoin('projects', 'applications.project_id', '=', 'projects.project_id')
            ->where('projects.user_id', Auth::user()->user_id)
            ->exists();

        if (!$check) {
            return redirect()->route('home')
                ->with('error', 'Tidak ada Pendaftar!');
        }

        // Ambil proyek yang dibuat oleh user yang login
        $myProject = Project::where('projects.user_id', Auth::user()->user_id)
            ->join('applications', 'projects.project_id', '=', 'applications.project_id')
            ->first();

        if ($myProject) {
            // Query untuk aplikasi yang masuk ke proyek user
            $query = Application::with(['user', 'user.major', 'user.department', 'project'])
                ->where('project_id', $myProject->project_id);

            // Filter berdasarkan pencarian nama/nim/nama proyek
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('nim_nip', 'like', '%' . $searchTerm . '%');
                    })
                        ->orWhereHas('project', function ($projectQuery) use ($searchTerm) {
                            $projectQuery->where('title', 'like', '%' . $searchTerm . '%');
                        });
                });
            }

            // Filter berdasarkan posisi
            if ($request->filled('position')) {
                $query->where('position', $request->position);
            }

            $applications = $query->latest()->get();

            // Ubah JSON string positions menjadi array
            $positions = json_decode($myProject->positions, true);

            // Ambil aplikasi yang dipilih
            $selectedApplication = null;
            if ($request->filled('application')) {
                $selectedApplication = $applications->where('application_id', $request->application)->first();
            } else {
                $selectedApplication = $applications->first();
            }

            if ($selectedApplication) {
                $projectContents = ProjectContent::where('application_id', $selectedApplication->application_id)
                    ->latest()
                    ->get();
            } else {
                $projectContents = collect();
            }
        } else {
            $applications = collect();
            $selectedApplication = null;
            $positions = [];
        }

        $categories = Category::all();

        return view('projects.my-initiated-projects', compact(
            'applications',
            'selectedApplication',
            'categories',
            'positions',
            'projectContents',
        ));
    }

    public function create()
    {
        $testjumlahprogress = Project::select('projects.*', 'applications.progress')
            ->leftJoin('applications', 'projects.project_id', '=', 'applications.project_id')
            ->where('projects.user_id', Auth::user()->user_id)
            ->get();

        $allComplete = $testjumlahprogress->every(function ($application) {
            return $application->progress == 100;
        });

        if (!$allComplete) {
            return redirect()->route('projects.public')
                ->with('error', 'Anda tidak dapat membuat proyek baru karena masih memiliki proyek yang sedang berjalan. Harap selesaikan proyek yang sedang aktif terlebih dahulu.');
        }

        $categories = Category::all();
        return view('projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'positions' => 'required|array',
            'duration' => 'required|string',
            'benefits' => 'required|string',
            'quota' => 'required|integer|min:1',
            'applicants' => '0',
            'category_id' => 'required|exists:categories,category_id'
        ]);

        $validated['user_id'] = Auth::user()->user_id;
        $validated['positions'] = json_encode($request->positions);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . Str::random(10) . '.' . $extension;
            $file->move(public_path('images/projects'), $fileName);
            $validated['photo'] = 'images/projects/' . $fileName;
        }

        try {
            Project::create($validated);
            return redirect()->route('projects.public')
                ->with('success', 'Proyek berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat proyek: ' . $e->getMessage());
        }
    }

    public function edit(Project $project)
    {
        // Pastikan user hanya bisa edit projectnya sendiri
        if ($project->user_id !== Auth::user()->user_id) {
            return redirect()->route('projects.my')
                ->with('error', 'Anda tidak memiliki akses ke proyek ini.');
        }

        $categories = Category::all();
        return view('projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        // Validasi akses
        if ($project->user_id !== Auth::user()->user_id) {
            return redirect()->route('projects.my')
                ->with('error', 'Anda tidak memiliki akses ke proyek ini.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'positions' => 'required|array',
            'duration' => 'required|string',
            'benefits' => 'required|string',
            'category_id' => 'required|exists:categories,category_id'
        ]);

        try {
            $project->update($validated);
            return redirect()->route('projects.my', ['project' => $project->project_id])
                ->with('success', 'Proyek berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui proyek.');
        }
    }

    public function destroy(Project $project)
    {
        try {
            if ($project->user_id !== Auth::user()->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke proyek ini.'
                ]);
            }

            if ($project->applications()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus proyek karena sudah ada pendaftar.'
                ]);
            }

            if ($project->photo) {
                Storage::disk('public')->delete($project->photo);
            }

            $project->delete();

            return response()->json([
                'success' => true,
                'message' => 'Proyek berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus proyek.'
            ]);
        }
    }

    public function complete($applicationId)
    {
        try {
            $application = Application::findOrFail($applicationId);

            // Update status aplikasi
            $application->update([
                'progress' => 100,
                'finish_date' => now()
            ]);

            // Update status proyek
            $project = Project::findOrFail($application->project_id);
            $project->update([
                'status' => 'completed'
            ]);

            return redirect()->back()->with('success', 'Proyek berhasil diselesaikan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyelesaikan proyek.');
        }
    }

    public function activate($applicationId)
    {
        try {
            $application = Application::findOrFail($applicationId);

            // Update status aplikasi
            $application->update([
                'finish_date' => null
            ]);

            // Update status proyek
            $project = Project::findOrFail($application->project_id);
            $project->update([
                'status' => 'active'
            ]);

            return redirect()->back()->with('success', 'Proyek berhasil diaktifkan kembali!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengaktifkan proyek.');
        }
    }
}
