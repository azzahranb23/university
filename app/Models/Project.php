<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $primaryKey = 'project_id';

    protected $fillable = [
        'title',
        'description',
        'photo',
        'positions',
        'duration',
        'benefits',
        'quota',
        'applicants',
        'category_id',
        'user_id',
        'status',
    ];

    protected $casts = [
        'positions' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'project_id');
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'project_id');
    }

    public function forums()
    {
        return $this->hasMany(Forum::class, 'project_id');
    }

    public function projectContents()
    {
        return $this->hasMany(ProjectContent::class, 'project_id', 'project_id');
    }
}
