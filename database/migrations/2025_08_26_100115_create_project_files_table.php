<?php 
// database/migrations/2025_08_26_000001_create_project_files_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void {
Schema::create('project_files', function (Blueprint $table) {
$table->id();
$table->foreignId('project_id')->constrained()->cascadeOnDelete();
$table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete(); // who uploaded
$table->string('file_name');
$table->string('file_path');
$table->timestamps();
});
}
public function down(): void {
Schema::dropIfExists('project_files');
}
};