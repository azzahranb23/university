<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_name',
        'image'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }
}
