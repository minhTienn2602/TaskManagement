<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks'; // Chỉ định tên bảng là 'tasks'

    protected $fillable = [
        'name', 'description', 'start_date', 'due_date', 'finished_date', 'status', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}