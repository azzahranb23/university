<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectContent;

class ApplicationController extends Controller
{
    public function store(Request $request, Project $project)
    {
        try {

            // Validasi apakah user sudah pernah mendaftar
            $existingApplication = Application::where('project_id', $project->project_id)
                ->where('user_id', Auth::user()->user_id)
                ->exists();

            if ($existingApplication) {
                return back()
                    ->withInput()
                    ->with('error', 'Anda sudah pernah mendaftar di proyek ini.');
            }

            // Validasi input
            $validated = $request->validate([
                'position' => 'required|string',
                'motivation' => 'required|string|min:50',
                'documents' => 'nullable|string'
            ], [
                'position.required' => 'Posisi proyek wajib dipilih.',
                'motivation.required' => 'Motivasi wajib diisi.',
                'motivation.min' => 'Motivasi minimal 50 karakter.',
            ]);

            // Buat aplikasi baru
            $application = Application::create([
                'date' => now(),
                'status' => 'pending',
                'position' => $validated['position'],
                'motivation' => $validated['motivation'],
                'documents' => $validated['documents'],
                'project_id' => $project->project_id,
                'user_id' => Auth::user()->user_id
            ]);

            return redirect()
                ->route('projects.public')
                ->with('showSuccessApply', true);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi: ' . $e->getMessage());
        }
    }

    public function all()
    {
        $applications = Application::with(['project', 'user'])
            ->where('user_id', Auth::user()->user_id)
            ->latest('date')
            ->get();

        // Hitung remaining days untuk setiap aplikasi
        $applications->each(function ($application) {
            if ($application->finish_date) {
                $application->remaining_days = $application->remaining_days;
            }
        });

        return view('projects.my-projects', [
            'applications' => $applications,
            'activeTab' => 'semua'
        ]);
    }

    public function request()
    {
        $applications = Application::with(['project', 'user'])
            ->where('user_id', Auth::user()->user_id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('projects.my-projects', [
            'applications' => $applications,
            'activeTab' => 'request'
        ]);
    }

    public function onGoing()
    {
        $applications = Application::with(['project', 'user'])
            ->where('user_id', Auth::user()->user_id)
            ->where('status', 'accepted')
            ->where('progress', '<', 100)
            ->latest()
            ->get();

        return view('projects.my-projects', [
            'applications' => $applications,
            'activeTab' => 'on-going'
        ]);
    }

    public function finished()
    {
        $applications = Application::with(['project', 'user'])
            ->where('user_id', Auth::user()->user_id)
            ->where('status', 'accepted')
            ->where('progress', 100)
            ->latest()
            ->get();

        return view('projects.my-projects', [
            'applications' => $applications,
            'activeTab' => 'selesai'
        ]);
    }

    public function rejected()
    {
        $applications = Application::with(['project', 'user'])
            ->where('user_id', Auth::user()->user_id)
            ->where('status', 'rejected')
            ->latest()
            ->get();

        return view('projects.my-projects', [
            'applications' => $applications,
            'activeTab' => 'ditolak'
        ]);
    }

    public function finish($application)
    {
        try {
            // Cari aplikasi berdasarkan ID
            $application = Application::findOrFail($application);

            // Update status aplikasi
            $application->update(['progress' => '100']);

            // Update status proyek
            $application->project->update(['status' => 'finished']);

            return response()->json([
                'success' => true,
                'message' => 'Proyek berhasil diselesaikan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyelesaikan proyek.'
            ]);
        }
    }

    public function accept(Request $request, $id)
    {
        try {
            // Cari aplikasi berdasarkan ID
            $application = Application::findOrFail($id);

            // Validasi akses
            if ($application->project->user_id !== Auth::user()->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk menerima aplikasi ini.'
                ]);
            }

            // Validasi input
            $validated = $request->validate([
                'start_date' => 'required|date',
                'finish_date' => 'required|date|after:start_date',
                'link_room_discus' => 'required|url'
            ]);

            // Update aplikasi
            $application->update([
                'status' => 'accepted',
                'start_date' => $validated['start_date'],
                'finish_date' => $validated['finish_date'],
                'link_room_discus' => $validated['link_room_discus'],
                'progress' => 0
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi berhasil diterima!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses aplikasi: ' . $e->getMessage()
            ]);
        }
    }

    public function reject(Application $application)
    {
        try {
            if ($application->project->user_id !== Auth::user()->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk menolak aplikasi ini.'
                ]);
            }

            $application->update(['status' => 'rejected']);

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi berhasil ditolak!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses aplikasi.'
            ]);
        }
    }

    public function show(Application $application)
    {

        // Load relationships and project contents
        $application->load(['user', 'project']);

        $projectContents = ProjectContent::where('project_id', $application->project_id)
            ->get();


        return view('projects.my-project-detail', compact('application', 'projectContents'));
    }
}
