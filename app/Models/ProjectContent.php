<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectContent extends Model
{
    use HasFactory;

    protected $primaryKey = 'content_id';

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'due_date',
        'link_task',
        'progress',
        'project_id',
        'application_id',
        'created_by',
        'assigned_to'
    ];

    protected $dates = [
        'start_date',
        'due_date',
        'created_at',
        'updated_at',
    ];

    // Relasi dengan Project
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    // Relasi dengan Application
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id', 'application_id');
    }

    // Relasi dengan User (pembuat konten)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    // Relasi dengan User (yang ditugaskan)
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'user_id');
    }

    // Method untuk mendapatkan status waktu
    public function getTimeStatus()
    {
        $now = now();
        $dueDate = $this->due_date;

        if ($now > $dueDate) {
            return 'overdue';
        }

        $daysRemaining = $now->diffInDays($dueDate);
        if ($daysRemaining <= 3) {
            return 'critical';
        } elseif ($daysRemaining <= 7) {
            return 'warning';
        }

        return 'normal';
    }

    // Method untuk mendapatkan sisa waktu dalam format yang readable
    public function getRemainingTime()
    {
        $now = now();
        $dueDate = $this->due_date;

        if ($now > $dueDate) {
            return 'Telah lewat ' . $now->diffForHumans($dueDate);
        }

        return $dueDate->diffForHumans($now, true) . ' tersisa';
    }
}
