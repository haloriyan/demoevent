<?php

namespace App\Http\Controllers;

use App\Models\Rundown;
use App\Models\RundownSpeaker;
use App\Models\Speaker;
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
            // 'description' => $request->description,
            'description' => "-",
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
    public function addSpeaker($rundownID, Request $request) {
        $speakerIDs = json_decode($request->speaker_ids);
        $rundown = Rundown::where('id', $rundownID)->first();

        foreach ($speakerIDs as $id) {
            RundownSpeaker::create([
                'rundown_id' => $rundownID,
                'speaker_id' => $id,
            ]);
        }

        return redirect()->back()->with([
            'message' => "Berhasil menambahkan speaker ke rundown " . $rundown->title 
        ]);
    }
    public function deleteSpeaker($rundownID, $speakerID, Request $request) {
        $speaker = Speaker::where('id', $speakerID)->first();
        $rundown = Rundown::where('id', $rundownID)->first();

        RundownSpeaker::where([
            ['speaker_id', $speakerID],
            ['rundown_id', $rundownID]
        ])->delete();

        return redirect()->back()->with([
            'message' => "Berhasil menghapus " . $speaker->name . " dari rundown " . $rundown->title 
        ]);
    }
}
