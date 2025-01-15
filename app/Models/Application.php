<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Application extends Model
{
    protected $primaryKey = 'application_id';

    protected $fillable = [
        'date',
        'status',
        'position',
        'motivation',
        'documents',
        'progress',
        'start_date',
        'finish_date',
        'link_room_discus',
        'project_id',
        'user_id'
    ];

    protected $casts = [
        'date' => 'datetime',
        'start_date',
        'finish_date'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projectContents()
    {
        return $this->hasMany(ProjectContent::class, 'application_id', 'application_id');
    }

    public function getRemainingDaysAttribute()
    {
        if (!$this->finish_date) {
            return "Belum ada tenggat";
        }

        $now = now();
        $finish = Carbon::parse($this->finish_date);

        // Jika sudah lewat deadline
        if ($now->greaterThan($finish)) {
            return "Tenggat telah lewat";
        }

        $interval = $now->diff($finish);

        if ($interval->days >= 1) {
            return "Sisa " . $interval->format('%a') . " hari";
        } elseif ($interval->h >= 1) {
            return "Sisa " . $interval->format('%h') . " jam";
        } elseif ($interval->i >= 1) {
            return "Sisa " . $interval->format('%i') . " menit";
        } else {
            return "Tenggat hari ini";
        }
    }
}
