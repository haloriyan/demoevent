<?php

namespace App\Http\Controllers;

use App\Models\Rundown;
use Illuminate\Http\Request;

class RundownController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'title' => "required",
        ]);
        
        $rundown = Rundown::create([
            'schedule_id' => $request->schedule_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with([
            'message' => $rundown->title . " berhasil ditambahkan"
        ]);
    }
    public function update($rundownID, Request $request) {
        $rund = Rundown::where('id', $rundownID);
        $rundown = $rund->first();

        $request->validate([
            'title' => "required",
        ], [
            'title.required' => __('organizer.rundown_title_required')
        ]);
        
        $rund->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with([
            'message' => $rundown->title . " berhasil diubah"
        ]);
    }
    public function delete($rundownID) {
        $rund = Rundown::where('id', $rundownID);
        $rundown = $rund->first();

        $rund->delete();

        return redirect()->back()->with([
            'message' => $rundown->title . " berhasil dihapus"
        ]);
    }
}
