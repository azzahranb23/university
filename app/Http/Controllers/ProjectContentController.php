<?php

namespace App\Http\Controllers;

use App\Models\ProjectContent;
use App\Models\Application;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;


class ProjectContentController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'due_date' => 'required|date|after_or_equal:start_date',
                'link_task' => 'nullable|url',
                'application_id' => 'required|exists:applications,application_id',
            ]);

            // Dapatkan application untuk mendapatkan project_id
            $application = Application::findOrFail($validated['application_id']);

            // Buat project content
            $projectContent = ProjectContent::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'start_date' => $validated['start_date'],
                'due_date' => $validated['due_date'],
                // 'link_task' => $validated['link_task'],
                'project_id' => $application->project_id,
                'application_id' => $validated['application_id'],
                'created_by' => Auth::id(),
                'assigned_to' => $application->user_id, // Assign ke pelamar proyek
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Konten proyek berhasil ditambahkan',
                'data' => $projectContent
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan konten proyek',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($content_id)
    {
        try {
            $content = ProjectContent::with(['creator', 'assignee'])->findOrFail($content_id);

            // Periksa apakah user memiliki akses
            if (!$this->userHasAccess($content)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke konten ini'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => $content
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Konten tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $content_id)
    {
        try {
            $content = ProjectContent::findOrFail($content_id);

            // Periksa apakah user memiliki akses
            if (!$this->userHasAccess($content)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk mengubah konten ini'
                ], 403);
            }

            // Validasi input
            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'start_date' => 'sometimes|required|date',
                'due_date' => 'sometimes|required|date|after_or_equal:start_date',
                'link_task' => 'nullable|url',
                'progress' => 'sometimes|required|integer|min:0|max:100',
            ]);

            $content->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Konten proyek berhasil diperbarui',
                'data' => $content
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui konten proyek',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($content_id)
    {
        try {
            $content = ProjectContent::findOrFail($content_id);

            // Periksa apakah user memiliki akses
            if (!$this->userHasAccess($content)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk menghapus konten ini'
                ], 403);
            }

            $content->delete();

            return response()->json([
                'success' => true,
                'message' => 'Konten proyek berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus konten proyek',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function userHasAccess(ProjectContent $content)
    {
        $user = Auth::user();

        // Jika user adalah pembuat konten
        if ($content->created_by === $user->user_id) {
            return true;
        }

        // Jika user adalah yang ditugaskan
        if ($content->assigned_to === $user->user_id) {
            return true;
        }

        // Jika user adalah pemilik proyek
        if ($content->project->user_id === $user->user_id) {
            return true;
        }

        return false;
    }

    public function updateLink(ProjectContent $content, Request $request)
    {
        try {
            $validated = $request->validate([
                'link_task' => 'nullable|url'
            ]);

            $content->update([
                'link_task' => $validated['link_task']
            ]);

            // Cari aplikasi menggunakan application_id dari content
            if ($content->application_id) {
                $application = Application::find($content->application_id);

                if ($application) {
                    // Hitung total konten untuk aplikasi ini
                    $totalContents = $application->projectContents()->count();
                    $completedContents = $application->projectContents()
                        ->whereNotNull('link_task')
                        ->where('link_task', '!=', '')
                        ->count();

                    $progressPercentage = ($totalContents > 0)
                        ? round(($completedContents / $totalContents) * 100)
                        : 0;

                    $application->update([
                        'progress' => $progressPercentage
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Link berhasil diperbarui',
                        'progress' => $progressPercentage
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Link berhasil diperbarui',
                'progress' => 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui link',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function uploadDocument(Request $request, $contentId)
    {
        try {
            // Validasi - menambahkan rar dan zip
            $request->validate([
                'document' => 'required|file|mimes:pdf,doc,docx,txt,rar,zip|max:5120'
            ]);

            $content = ProjectContent::findOrFail($contentId);

            if ($request->hasFile('document')) {
                $file = $request->file('document');

                // Nama file unik
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Path tujuan
                $destinationPath = public_path('documents');

                // Buat directory jika belum ada
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Pindahkan file
                $file->move($destinationPath, $fileName);

                // Update database
                $content->update([
                    'document_path' => 'documents/' . $fileName
                ]);

                // Cari aplikasi menggunakan application_id dari content
                if ($content->application_id) {
                    $application = Application::find($content->application_id);

                    if ($application) {
                        // Hitung total konten untuk aplikasi ini
                        $totalContents = $application->projectContents()->count();
                        $completedContents = $application->projectContents()
                            ->whereNotNull('document_path')
                            ->where('document_path', '!=', '')
                            ->count();

                        $progressPercentage = ($totalContents > 0)
                            ? round(($completedContents / $totalContents) * 100)
                            : 0;

                        $application->update([
                            'progress' => $progressPercentage
                        ]);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Dokumen berhasil diupload'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Tidak ada file yang diupload'
            ], 400);
        } catch (\Exception $e) {
            Log::error('Upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteDocument($contentId)
    {
        try {
            $content = ProjectContent::findOrFail($contentId);

            if ($content->document_path) {
                Storage::disk('public')->delete($content->document_path);

                $content->update([
                    'document_path' => null
                ]);

                // Cari aplikasi menggunakan application_id dari content
                if ($content->application_id) {
                    $application = Application::find($content->application_id);

                    if ($application) {
                        // Hitung total konten untuk aplikasi ini
                        $totalContents = $application->projectContents()->count();
                        $completedContents = $application->projectContents()
                            ->whereNotNull('document_path')
                            ->where('document_path', '!=', '')
                            ->count();

                        $progressPercentage = ($totalContents > 0)
                            ? round(($completedContents / $totalContents) * 100)
                            : 0;

                        $application->update([
                            'progress' => $progressPercentage
                        ]);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Dokumen berhasil dihapus'
                ]);
            }

            throw new \Exception('Dokumen tidak ditemukan');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
