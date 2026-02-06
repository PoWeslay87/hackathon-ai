<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovernancePolicy extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'category', 'is_active', 'severity'];
}
