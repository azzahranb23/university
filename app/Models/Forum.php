<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $primaryKey = 'forum_id';
    protected $fillable = ['title', 'created_by', 'project_id'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'forum_id');
    }
}
