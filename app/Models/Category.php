<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name', 'date_created'
    ];

    public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}