<?php

// app/Http/Controllers/TimeLogController.php
namespace App\Http\Controllers;

use App\Models\TimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'hours' => 'required|numeric|min:0.25|max:24',
            'notes' => 'nullable|string|max:1000',
        ]);

        TimeLog::create([
            'project_id' => $request->project_id,
            'user_id' => Auth::id(),
            'hours' => $request->hours,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Time logged successfully!');
    }

    public function destroy(TimeLog $timeLog)
    {
        if ($timeLog->user_id !== Auth::id()) {
            abort(403);
        }
        $timeLog->delete();
        return back()->with('success', 'Time log deleted.');
    }
}