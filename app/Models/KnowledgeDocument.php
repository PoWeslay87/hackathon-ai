<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeDocument extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'filename', 'content', 'is_active'];
}
