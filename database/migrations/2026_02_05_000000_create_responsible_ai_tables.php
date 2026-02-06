<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Governance Policies (Rules the AI must follow)
        Schema::create('governance_policies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description'); // The actual rule content
            $table->string('category')->default('general'); // e.g., 'safety', 'ethics', 'legal'
            $table->boolean('is_active')->default(true);
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->timestamps();
        });

        // 2. Knowledge Documents (RAG Source)
        Schema::create('knowledge_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('filename')->nullable();
            $table->longText('content'); // Extracted text content for searching
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Audit Logs (Tamper-proof history)
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // If logged in
            $table->text('input_prompt');
            $table->longText('ai_response');
            
            // AI Self-Reflection Scores
            $table->integer('risk_score')->default(0); // 0-100
            $table->integer('confidence_score')->default(0); // 0-100
            
            // Metadata
            $table->json('sources_used')->nullable(); // IDs or titles of documents used
            $table->string('model_version')->default('gemini-2.5-flash');
            $table->string('status')->default('approved'); // approved, flagged, rejected
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('knowledge_documents');
        Schema::dropIfExists('governance_policies');
    }
};
