<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');

        // Filter by event type
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(50);
        
        // Get unique events for filter
        $events = ActivityLog::select('event')
            ->distinct()
            ->orderBy('event')
            ->pluck('event');

        // Get users for filter
        $users = User::orderBy('name')->get();

        return view('activity-logs.index', compact('logs', 'events', 'users'));
    }

    /**
     * Display the specified activity log.
     */
    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');
        return view('activity-logs.show', compact('activityLog'));
    }

    /**
     * Clear old activity logs.
     */
    public function clear(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        $date = now()->subDays($request->days);
        $count = ActivityLog::where('created_at', '<', $date)->delete();

        return redirect()->route('activity-logs.index')
            ->with('success', "Deleted {$count} activity logs older than {$request->days} days.");
    }

    /**
     * Export activity logs to CSV.
     */
    public function export(Request $request)
    {
        $query = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');

        // Apply same filters as index
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->get();

        $filename = 'activity_logs_' . now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, ['ID', 'Date Time', 'User', 'Event', 'Description', 'Subject', 'IP Address']);

            // Data
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user_name,
                    $log->event,
                    $log->description,
                    $log->subject_type ? class_basename($log->subject_type) . ' #' . $log->subject_id : 'N/A',
                    $log->ip_address,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get activity log statistics.
     */
    public function stats()
    {
        $stats = [
            'total_logs' => ActivityLog::count(),
            'today_logs' => ActivityLog::whereDate('created_at', today())->count(),
            'this_week_logs' => ActivityLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month_logs' => ActivityLog::whereMonth('created_at', now()->month)->count(),
            'events_breakdown' => ActivityLog::selectRaw('event, COUNT(*) as count')
                ->groupBy('event')
                ->orderBy('count', 'desc')
                ->get(),
            'top_users' => ActivityLog::selectRaw('user_id, user_name, COUNT(*) as count')
                ->whereNotNull('user_id')
                ->groupBy('user_id', 'user_name')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
        ];

        return view('activity-logs.stats', compact('stats'));
    }
}
