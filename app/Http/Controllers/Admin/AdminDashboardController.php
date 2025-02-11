<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Department;
use App\Models\Category;
use App\Models\Application;
use App\Models\Major;
use App\Models\ProjectContent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik yang sudah ada
        $stats = [
            // User Stats
            'totalUsers' => User::count(),
            'totalStudents' => User::where('role', 'student')->count(),
            'totalLecturers' => User::where('role', 'lecturer')->count(),
            'recentUsers' => User::latest()->take(5)->get(),

            // Project Stats
            'totalProjects' => Project::count(),
            'activeProjects' => Project::where('status', 'active')->count(),
            'completedProjects' => Project::where('status', 'completed')->count(),
            'recentProjects' => Project::with(['user', 'category'])->latest()->take(5)->get(),

            // Applications Stats
            'totalApplications' => Application::count(),
            'pendingApplications' => Application::where('status', 'pending')->count(),
            'acceptedApplications' => Application::where('status', 'accepted')->count(),
            'rejectedApplications' => Application::where('status', 'rejected')->count(),
            'recentApplications' => Application::with(['user', 'project'])->latest()->take(5)->get(),

            // Project Contents Stats
            'totalContents' => ProjectContent::count(),
            'withLink' => ProjectContent::whereNotNull('link_task')->count(),
            'withoutLink' => ProjectContent::whereNull('link_task')->count(),
            'upcomingDeadlines' => ProjectContent::where('due_date', '>=', now())
                ->where('due_date', '<=', now()->addDays(7))
                ->with(['project', 'application.user'])
                ->orderBy('due_date')
                ->take(5)
                ->get(),

            // Department & Category Statistics
            'totalDepartments' => Department::count(),
            'totalCategories' => Category::count(),
            'totalMajors' => Major::count(),

            // Project per Category Chart Data
            'categoryProjects' => Category::withCount('projects')->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users(Request $request)
    {
        // Ambil data untuk filter
        $departments = Department::all();
        $majors = Major::all();

        // Query dasar
        $usersQuery = User::with(['department', 'major', 'projects'])
            ->select('users.*');

        // Filter berdasarkan role
        if ($request->filled('role')) {
            $usersQuery->where('role', $request->role);
        }

        // Filter berdasarkan departemen
        if ($request->filled('department')) {
            $usersQuery->where('department_id', $request->department);
        }

        // Filter berdasarkan program studi
        if ($request->filled('major')) {
            $usersQuery->where('major_id', $request->major);
        }

        // Filter berdasarkan search query
        if ($request->filled('search')) {
            $searchQuery = $request->search;
            $usersQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', "%{$searchQuery}%")
                    ->orWhere('email', 'like', "%{$searchQuery}%")
                    ->orWhere('nim_nip', 'like', "%{$searchQuery}%");
            });
        }

        // Statistik untuk summary cards
        $stats = [
            'totalUsers' => User::count(),
            'totalStudents' => User::where('role', 'student')->count(),
            'totalLecturers' => User::where('role', 'lecturer')->count(),
            'totalProjects' => Project::count()
        ];

        // Get users dengan pagination
        $users = $usersQuery->latest()->paginate(10);

        // Jika request adalah Ajax
        if ($request->ajax()) {
            return response()->json([
                'users' => view('admin.users.partials.table-data', compact('users'))->render(),
                'pagination' => view('admin.users.partials.pagination', compact('users'))->render(),
            ]);
        }

        return view('admin.users.index', compact('users', 'stats', 'departments', 'majors'));
    }

    public function createUser($role)
    {
        if (!in_array($role, ['student', 'lecturer'])) {
            return redirect()->route('admin.users')->with('error', 'Role tidak valid!');
        }

        $departments = Department::all();
        $majors = Major::all();

        return view('admin.users.create', compact('role', 'departments', 'majors'));
    }

    // Menyimpan user baru
    public function storeUser(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'nim_nip' => 'required|string|unique:users,nim_nip',
                'password' => 'required|string|min:8',
                'role' => 'required|in:student,lecturer',
                'gender' => 'required|in:male,female',
                'phone' => 'required|string',
                'department_id' => 'required_if:role,lecturer|exists:departments,department_id',
                'major_id' => 'required_if:role,student|exists:majors,major_id',
                'photo' => 'nullable|image|max:2048'
            ]);

            // Persiapkan data user
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'nim_nip' => $request->nim_nip,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'year' => date('Y')
            ];

            // Tambahkan department_id atau major_id sesuai role
            if ($request->role === 'lecturer') {
                $userData['department_id'] = $request->department_id;
            } else {
                $userData['major_id'] = $request->major_id;
            }

            // Handle upload foto
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoName = time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('storage/photos'), $photoName);
                $userData['photo'] = 'photos/' . $photoName;
            }

            // Buat user baru
            $user = User::create($userData);

            DB::commit();
            return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    // Menampilkan detail user
    public function showUser($id)
    {
        $user = User::with(['department', 'major', 'projects'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // Menampilkan form edit user
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $departments = Department::all();
        $majors = Major::all();

        return view('admin.users.edit', compact('user', 'departments', 'majors'));
    }

    // Update data user
    public function updateUser(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            // Validasi input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
                'nim_nip' => 'required|string|unique:users,nim_nip,' . $user->user_id . ',user_id',
                'gender' => 'required|in:male,female',
                'phone' => 'required|string',
                'department_id' => 'required_if:role,lecturer|exists:departments,department_id',
                'major_id' => 'required_if:role,student|exists:majors,major_id',
                'photo' => 'nullable|image|max:2048',
                'password' => 'nullable|string|min:8'
            ]);

            // Persiapkan data update
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'nim_nip' => $request->nim_nip,
                'gender' => $request->gender,
                'phone' => $request->phone
            ];

            // Update password jika ada
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            // Update department_id atau major_id sesuai role
            if ($user->role === 'lecturer') {
                $userData['department_id'] = $request->department_id;
            } else {
                $userData['major_id'] = $request->major_id;
            }

            // Handle upload foto
            if ($request->hasFile('photo')) {
                // Hapus foto lama
                if ($user->photo && file_exists(public_path('storage/' . $user->photo))) {
                    unlink(public_path('storage/' . $user->photo));
                }

                $photo = $request->file('photo');
                $photoName = time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('storage/photos'), $photoName);
                $userData['photo'] = 'photos/' . $photoName;
            }

            // Update user
            $user->update($userData);

            DB::commit();
            return redirect()->route('admin.users')->with('success', 'Data user berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    // Hapus user
    public function destroyUser($id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            // Hapus foto jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->delete();

            DB::commit();
            return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus user.');
        }
    }

    public function projects(Request $request)
    {
        // Statistik untuk summary cards
        $stats = [
            'totalProjects' => Project::count(),
            'activeProjects' => Project::where('status', 'active')->count(),
            'completedProjects' => Project::where('status', 'completed')->count(),
            'totalApplications' => Application::count(),
            'pendingApplications' => Application::where('status', 'pending')->count(),
            'acceptedApplications' => Application::where('status', 'accepted')->count(),
        ];

        // Query dasar
        $query = Project::with(['user', 'category'])
            ->withCount([
                'applications',
                'applications as pending_applications_count' => function ($query) {
                    $query->where('status', 'pending');
                },
                'applications as accepted_applications_count' => function ($query) {
                    $query->where('status', 'accepted');
                }
            ]);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->latest()->get();
        $categories = Category::all();
        $users = User::all();

        return view('admin.projects.index', compact('projects', 'stats', 'categories', 'users'));
    }

    public function categories()
    {
        // Statistik untuk summary cards
        $stats = [
            'totalCategories' => Category::count(),
            'totalProjects' => Project::count(),
            'activeProjects' => Project::where('status', 'active')->count(),
            'avgProjectsPerCategory' => Category::withCount('projects')->get()->avg('projects_count')
        ];

        // Data kategori dengan projects count
        $categories = Category::withCount(['projects', 'projects as active_projects_count' => function ($query) {
            $query->where('status', 'active');
        }])->latest()->get();

        return view('admin.categories.index', compact('categories', 'stats'));
    }

    public function storeCategory(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'category_name' => 'required|string|max:255|unique:categories',
                'image' => 'nullable|image|max:2048'
            ]);

            $categoryData = [
                'category_name' => $request->category_name
            ];

            // Handle upload gambar
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                // Gunakan getClientOriginalName() untuk mendapatkan nama asli file
                $imageName = $image->getClientOriginalName();

                // Upload file ke folder public/images/categories
                $image->move(public_path('images/categories'), $imageName);

                // Simpan path gambar ke database sesuai format
                $categoryData['image'] = 'images/categories/' . $imageName;
            } else {
                // Set default image path jika tidak ada upload
                $categoryData['image'] = 'images/categories/default.jpg';
            }

            Category::create($categoryData);

            DB::commit();
            return redirect()->route('admin.categories')->with('success', 'Kategori berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function updateCategory(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $category = Category::findOrFail($id);

            $request->validate([
                'category_name' => 'required|string|max:255|unique:categories,category_name,' . $id . ',category_id',
                'image' => 'nullable|image|max:2048'
            ]);

            $categoryData = [
                'category_name' => $request->category_name
            ];

            // Handle upload gambar
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($category->image && file_exists(public_path($category->image))) {
                    unlink(public_path($category->image));
                }

                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images/categories'), $imageName);
                $categoryData['image'] = 'images/categories/' . $imageName;
            }

            $category->update($categoryData);

            DB::commit();
            return redirect()->route('admin.categories')->with('success', 'Kategori berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroyCategory($id)
    {
        try {
            DB::beginTransaction();

            $category = Category::findOrFail($id);

            // Check jika kategori masih digunakan di proyek
            if ($category->projects()->count() > 0) {
                return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan dalam proyek.');
            }

            // Hapus gambar jika ada
            if ($category->image && file_exists(public_path('storage/' . $category->image))) {
                unlink(public_path('storage/' . $category->image));
            }

            $category->delete();

            DB::commit();
            return redirect()->route('admin.categories')->with('success', 'Kategori berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function departments()
    {
        // Statistik untuk summary cards
        $stats = [
            'totalDepartments' => Department::count(),
            'totalMajors' => Major::count(),
            'totalStudents' => User::where('role', 'student')->count(),
            'totalLecturers' => User::where('role', 'lecturer')->count()
        ];

        $departments = Department::withCount([
            'majors',
            'users as students_count' => function ($query) {
                $query->where('role', 'student');
            },
            'users as lecturers_count' => function ($query) {
                $query->where('role', 'lecturer');
            }
        ])->latest()->get();

        return view('admin.departments.index', compact('departments', 'stats'));
    }

    public function storeDepartment(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'department_name' => 'required|string|max:255|unique:departments'
            ]);

            Department::create($validated);

            DB::commit();
            return redirect()->route('admin.departments')->with('success', 'Departemen berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function updateDepartment(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $department = Department::findOrFail($id);

            $validated = $request->validate([
                'department_name' => 'required|string|max:255|unique:departments,department_name,' . $id . ',department_id'
            ]);

            $department->update($validated);

            DB::commit();
            return redirect()->route('admin.departments')->with('success', 'Departemen berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroyDepartment($id)
    {
        try {
            DB::beginTransaction();

            $department = Department::findOrFail($id);

            // Check jika departemen masih memiliki program studi
            if ($department->majors()->count() > 0) {
                return back()->with('error', 'Departemen tidak dapat dihapus karena masih memiliki program studi.');
            }

            // Check jika departemen masih memiliki user (dosen/mahasiswa)
            if ($department->users()->count() > 0) {
                return back()->with('error', 'Departemen tidak dapat dihapus karena masih memiliki dosen/mahasiswa.');
            }

            $department->delete();

            DB::commit();
            return redirect()->route('admin.departments')->with('success', 'Departemen berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function majors()
    {
        // Statistik untuk summary cards
        $stats = [
            'totalMajors' => Major::count(),
            'totalStudents' => User::where('role', 'student')->count(),
            'totalDepartments' => Department::count(),
            'avgStudentsPerMajor' => Major::withCount(['users' => function ($query) {
                $query->where('role', 'student');
            }])->get()->avg('users_count')
        ];

        // Data program studi dengan department dan jumlah mahasiswa
        $majors = Major::with('department')
            ->withCount(['users' => function ($query) {
                $query->where('role', 'student');
            }])
            ->latest()
            ->get();

        // Data departments untuk dropdown
        $departments = Department::all();

        return view('admin.majors.index', compact('majors', 'stats', 'departments'));
    }

    public function storeMajor(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'major_name' => 'required|string|max:255|unique:majors',
                'department_id' => 'required|exists:departments,department_id'
            ]);

            Major::create($validated);

            DB::commit();
            return redirect()->route('admin.majors')->with('success', 'Program Studi berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function updateMajor(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $major = Major::findOrFail($id);

            $validated = $request->validate([
                'major_name' => 'required|string|max:255|unique:majors,major_name,' . $id . ',major_id',
                'department_id' => 'required|exists:departments,department_id'
            ]);

            $major->update($validated);

            DB::commit();
            return redirect()->route('admin.majors')->with('success', 'Program Studi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroyMajor($id)
    {
        try {
            DB::beginTransaction();

            $major = Major::findOrFail($id);

            // Check jika program studi masih memiliki mahasiswa
            if ($major->users()->where('role', 'student')->count() > 0) {
                return back()->with('error', 'Program Studi tidak dapat dihapus karena masih memiliki mahasiswa.');
            }

            $major->delete();

            DB::commit();
            return redirect()->route('admin.majors')->with('success', 'Program Studi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeProject(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'photo' => 'nullable|image|max:2048',
                'positions' => 'required|array',
                'duration' => 'required|string',
                'benefits' => 'required|string',
                'category_id' => 'required|exists:categories,category_id',
                'user_id' => 'required|exists:users,user_id'
            ]);

            $projectData['status'] = 'active';

            $projectData = $request->except('photo', 'positions');
            $projectData['positions'] = json_encode($request->positions);

            // Handle upload foto
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoName = $photo->getClientOriginalName();
                $photo->move(public_path('images/projects'), $photoName);
                $projectData['photo'] = 'images/projects/' . $photoName;
            }

            Project::create($projectData);

            DB::commit();
            return redirect()->route('admin.projects')->with('success', 'Proyek berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function updateProject(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $project = Project::findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'photo' => 'nullable|image|max:2048',
                'positions' => 'required|array',
                'duration' => 'required|string',
                'benefits' => 'required|string',
                'category_id' => 'required|exists:categories,category_id',
                'user_id' => 'required|exists:users,user_id'
            ]);

            $projectData = $request->except('photo', 'positions');
            $projectData['positions'] = json_encode($request->positions);

            // Handle upload foto
            if ($request->hasFile('photo')) {
                if ($project->photo && file_exists(public_path($project->photo))) {
                    unlink(public_path($project->photo));
                }

                $photo = $request->file('photo');
                $photoName = $photo->getClientOriginalName();
                $photo->move(public_path('images/projects'), $photoName);
                $projectData['photo'] = 'images/projects/' . $photoName;
            }

            $project->update($projectData);

            DB::commit();
            return redirect()->route('admin.projects')->with('success', 'Proyek berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroyProject($id)
    {
        try {
            DB::beginTransaction();

            $project = Project::findOrFail($id);

            // Check jika proyek masih memiliki aplikasi
            if ($project->applications()->count() > 0) {
                return back()->with('error', 'Proyek tidak dapat dihapus karena masih memiliki aplikasi mahasiswa.');
            }

            // Hapus foto jika ada
            if ($project->photo && file_exists(public_path($project->photo))) {
                unlink(public_path($project->photo));
            }

            $project->delete();

            DB::commit();
            return redirect()->route('admin.projects')->with('success', 'Proyek berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function applications()
    {
        $stats = [
            'totalApplications' => Application::count(),
            'pendingApplications' => Application::where('status', 'pending')->count(),
            'acceptedApplications' => Application::where('status', 'accepted')->count(),
            'rejectedApplications' => Application::where('status', 'rejected')->count(),
        ];

        $applications = Application::with(['user', 'project', 'user.major', 'project.user'])
            ->latest('date')
            ->get();

        return view('admin.applications.index', compact('applications', 'stats'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $application = Application::findOrFail($id);

            $request->validate([
                'status' => 'required|in:accepted,rejected'
            ]);

            $application->update([
                'status' => $request->status
            ]);

            DB::commit();
            return redirect()->route('admin.applications')->with('success', 'Status aplikasi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function projectContents()
    {
        $stats = [
            'totalContents' => ProjectContent::count(),
            'withLink' => ProjectContent::whereNotNull('link_task')->count(),
            'withoutLink' => ProjectContent::whereNull('link_task')->count(),
            'totalProjects' => Project::has('projectContents')->count(),
        ];

        $contents = ProjectContent::with([
            'project',
            'application',
            'application.user',
            'creator',
            'assignee'
        ])
            ->orderBy('due_date')
            ->get();

        $contentsByProject = $contents->groupBy('project_id');

        return view('admin.project-contents.index', compact('contents', 'stats', 'contentsByProject'));
    }
}
