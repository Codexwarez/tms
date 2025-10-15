<?php

namespace App\Http\Controllers;

use App\Models\StaffRequest;
use App\Models\Project;
use App\Notifications\StaffRequestSubmitted;
use App\Notifications\StaffRequestUpdated;
use Illuminate\Http\Request;

class StaffRequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $requests = StaffRequest::with('project','user')->latest()->paginate(10);
            return view('admin.requests.index', compact('requests'));
        }
        $requests = StaffRequest::with('project')->where('user_id', auth()->id())->latest()->paginate(10);
        return view('staff.requests.index', compact('requests'));
    }

    public function create(Project $project)
    {
        abort_unless($project->assigned_user_id === auth()->id(), 403);
        return view('staff.requests.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        abort_unless($project->assigned_user_id === auth()->id(), 403);
        $data = $request->validate([
            'type' => 'required|in:time_extension,project_review',
            'reason' => 'nullable|string',
            'proposed_due_at' => 'nullable|date',
        ]);
        $data['project_id'] = $project->id;
        $data['user_id'] = auth()->id();
        $staffRequest = StaffRequest::create($data);

        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new StaffRequestSubmitted($staffRequest));
        }

        return redirect()->route('requests.index')->with('success', 'Request submitted.');
    }

    public function updateStatus(Request $request, StaffRequest $staffRequest)
    {
        abort_unless(auth()->user()->role === 'admin', 403);
        $data = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_response' => 'nullable|string',
        ]);
        $staffRequest->update($data);
        $staffRequest->user->notify(new StaffRequestUpdated($staffRequest));
        return back()->with('success', 'Request updated.');
    }
}