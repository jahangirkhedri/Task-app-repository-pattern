<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public const  STATUSES = ['todo', 'doing', 'pending', 'done', 'cancelled'];
    protected $fillable = ['title', 'description', 'user_id', 'status'];
}
