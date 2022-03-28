<?php

namespace App\Http\Middleware;

use App\Models\Activity;
use Closure;
use Illuminate\Http\Request;

class ActivityCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (app('currentTenant')->is_aspak) {
            $active = Activity::where('is_active', '=', 1)->first();

            if (!$active) {
                if ($request->ajax()) {
                    return response()->json(["err" => "Kegiatan kalibrasi aktif tidak ditemukan!", "msg" => ["doofus", "douchebag"]], 404);
                } else {
                    return redirect()->route('activity.create')->with('error', 'Buat kegiatan kalibrasi terlebih dahulu!');
                }
                
            } else {
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}
