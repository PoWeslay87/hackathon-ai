<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 
        'input_prompt', 
        'ai_response', 
        'risk_score', 
        'safety_reasoning',
        'confidence_score', 
        'sources_used', 
        'model_version', 
        'status'
    ];

    protected $casts = [
        'sources_used' => 'array',
    ];
}
