<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Project;
use App\Notifications\ReportSubmitted;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $reports = Report::with('project','user')->latest()->paginate(10);
            return view('admin.reports.index', compact('reports'));
        }
        $reports = Report::with('project')->where('user_id', auth()->id())->latest()->paginate(10);
        return view('staff.reports.index', compact('reports'));
    }

    public function create(Project $project)
    {
        abort_unless($project->assigned_user_id === auth()->id(), 403);
        return view('staff.reports.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        abort_unless($project->assigned_user_id === auth()->id(), 403);
        $data = $request->validate([
            'work_done' => 'nullable|string',
            'challenges' => 'nullable|string',
            'suggestions' => 'nullable|string',
        ]);
        $data['project_id'] = $project->id;
        $data['user_id'] = auth()->id();
        $report = Report::create($data);

        // Notify admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ReportSubmitted($report));
        }

        return redirect()->route('reports.index')->with('success', 'Report submitted.');
    }
}