<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function update(Request $request, $id) {
        $sched = Schedule::where('id', $id);
        $schedule = $sched->first();

        $sched->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->back()->with([
            'message' => "Berhasil mengubah jadwal " . $schedule->title
        ]);
    }
}
