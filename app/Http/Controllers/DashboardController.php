<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Report;
use App\Models\StaffRequest;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $projects = Project::with('assignedUser')->get();

            // Analytics
            $statusCounts = $projects->groupBy('status')->map->count();
            $overdueCount = $projects->where('due_at', '<', now())
                ->where('status', '!=', 'completed')
                ->count();
            $staffPerformance = $projects->groupBy('assigned_user_id')->map(function ($group) {
                return [
                    'name' => optional($group->first()->assignedUser)->name ?? 'Unassigned',
                    'total' => $group->count(),
                    'completed' => $group->where('status', 'completed')->count(),
                ];
            })->values();

            return view('admin.dashboard', [
                // existing metrics
                'projects_count' => Project::count(),
                'staff_count' => User::where('role', 'staff')->count(),
                'requests_count' => StaffRequest::where('status', 'pending')->count(),
                'reports_count' => Report::count(),
                'recent_reports' => Report::with('project', 'user')->latest()->take(5)->get(),
                'recent_requests' => StaffRequest::latest()->take(5)->get(),

                // analytics
                'statusCounts' => $statusCounts,
                'overdueCount' => $overdueCount,
                'staffPerformance' => $staffPerformance,
            ]);
        }

        // Staff dashboard
        $myProjects = Project::where('assigned_user_id', auth()->id())->get();

        $statusCounts = $myProjects->groupBy('status')->map->count();

        return view('staff.dashboard', [
            'my_projects' => $myProjects->take(5),
            'my_reports' => Report::where('user_id', auth()->id())->latest()->take(5)->get(),
            'notifications' => auth()->user()->notifications()->latest()->take(5)->get(),

            // add progress analytics for staff
            'statusCounts' => $statusCounts,
        ]);
    }
}