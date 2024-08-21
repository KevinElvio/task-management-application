<?php

namespace App\Http\Middleware;

use App\Models\Project;
use App\Models\Task;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = Auth::user();
        $project = Project::findOrFail($request->id);
        $task = Task::findOrFail($request->id);

        if($currentUser->id != $task->user_id || $currentUser->id != $project->user_id ) {
            return response()->json([
                "status"=> "failed",
                "message"=> "Data Tidak Ditemukan",
            ], 404);
        }
        return $next($request);
    }
}
