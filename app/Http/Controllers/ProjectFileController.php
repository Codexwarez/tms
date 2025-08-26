<?php

// app/Http/Controllers/ProjectFileController.php
namespace App\Http\Controllers;

use App\Models\ProjectFile;
use App\Models\Project;
use App\Models\User;
use App\Notifications\FileUploadedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectFileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:2097152',
        ]);

        $path = $request->file('file')->store('project_files');

        $file = ProjectFile::create([
            'project_id' => $request->project_id,
            'user_id' => Auth::id(),
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_path' => $path,
        ]);
        // notify admin + assigned staff
        $project = $file->project;
        $recipients = collect([$project->assignedUser, User::where('role', 'admin')->first()])
            ->filter();

        foreach ($recipients as $recipient) {
            $recipient->notify(new FileUploadedNotification($file));
        }
        return back()->with('success', 'File uploaded successfully!');
    }

    public function destroy(ProjectFile $projectFile)
    {
        $user = auth()->user();

        // Only admin or uploader can delete
        if (!($user->role === 'admin' || $projectFile->user_id === $user->id)) {
            return back()->with('error', 'Unauthorized to delete this file.');
        }

        // Delete file from storage if it exists
        if (Storage::exists($projectFile->file_path)) {
            Storage::delete($projectFile->file_path);
        }

        // Delete record from DB
        $projectFile->delete();

        return back()->with('success', 'File and record deleted successfully!');
    }



    public function download(ProjectFile $projectFile)
    {
        $user = Auth::user();
        $project = $projectFile->project;

        // authorize: admin or assigned staff
        if (!($user->role === 'admin' || $project->assigned_user_id === $user->id)) {
            return back()->with('error', 'Unauthorized to download this file.');
        }

        // check if file still exists
        if (!Storage::exists($projectFile->file_path)) {
            return back()->with('error', 'File not found on server.');
        }

        return Storage::download($projectFile->file_path, $projectFile->file_name);
    }
}