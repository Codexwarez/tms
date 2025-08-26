<?php
// database/migrations/2025_08_26_000004_add_priority_progress_to_projects_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
            $table->unsignedTinyInteger('progress')->default(0); // 0-100 %
        });
    }
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['priority', 'progress']);
        });
    }
};