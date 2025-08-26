<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\ProjectAssigned;
use App\Notifications\ProjectStatusUpdated;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {

        $projects = Project::with('assignedUser')->latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {

        $users = \App\Models\User::where('role', 'staff')->get();
        return view('admin.projects.create', compact('users'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files.*' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2097152',
            'assigned_user_id' => 'required|exists:users,id',
            'priority' => 'required|in:Low,Medium,High',
            'start_at' => 'required|date',
            'due_at' => 'required|date',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'assigned_user_id' => $request->assigned_user_id,
            'start_at' => $request->start_at,
            'due_at' => $request->due_at,
            'status' => 'incomplete',
            'priority' => $request->priority,
            'progress' => 0,
        ]);

        // Handle file uploads
        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $file) {
                $path = $file->store('project_files', 'local'); // private storage
                ProjectFile::create([
                    'project_id' => $project->id,
                    'user_id' => auth()->id(),
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                ]);
            }
        }
        if ($project->assigned_user_id) {
            $project->assignedUser->notify(new ProjectAssigned($project));
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {

        $users = \App\Models\User::where('role', 'staff')->get();
        return view('admin.projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:incomplete,in_progress,completed',
            'start_at' => 'nullable|date',
            'due_at' => 'required|date',
            'progress' => 'nullable|numeric|min:0|max:100',
            'priority' => 'required|in:Low,Medium,High',
        ]);

        $wasAssigned = $project->assigned_user_id;
        $project->update($data);

        if ($project->assigned_user_id && !$wasAssigned) {
            $project->assignedUser->notify(new ProjectAssigned($project));
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function staffIndex()
    {
        $projects = Project::where('assigned_user_id', auth()->id())->paginate(10);
        return view('staff.projects.index', compact('projects'));
    }

    public function updateStatus(Request $request, Project $project)
    {
        abort_unless($project->assigned_user_id === auth()->id(), 403);
        $data = $request->validate(['status' => 'required|in:incomplete,in_progress,completed']);
        $project->update($data);
        // Notify admin
        $adminUsers = \App\Models\User::where('role', 'admin')->get();
        foreach ($adminUsers as $admin) {
            $admin->notify(new ProjectStatusUpdated($project, auth()->user()));
        }
        return back()->with('success', 'Status updated.');
    }

    public function show(Project $project)
    {
        $project->load(['files', 'comments.user', 'assignedUser']);

        if (auth()->user()->role === 'admin') {
            return view('admin.projects.show', compact('project'));
        }

        return view('staff.projects.show', compact('project'));
    }
    public function updateProgress(Request $request, Project $project)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        // only staff assigned to this project can update progress
        if (auth()->id() !== $project->assigned_user_id) {
            abort(403, 'Unauthorized');
        }

        $project->progress = $request->progress;
        $project->save();

        return back()->with('success', 'Project progress updated successfully.');
    }
}