<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpeakerController extends Controller
{
    public function search(Request $request) {
        $u = Speaker::where('name', 'LIKE', "%".$request->q."%");
        if ($request->with != "") {
            $u = $u->with($request->with);
        }
        $speakers = $u->take(20)->get();

        return response()->json([
            'speakers' => $speakers,
        ]);
    }
    public function store(Request $request) {
        $toCreate = [
            'name' => $request->name,
            'credential' => $request->credential,
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoFileName = $photo->getClientOriginalName();
            $photo->move(
                public_path('storage/speaker_photos'),
                $photoFileName
            );
            $toCreate['photo'] = $photoFileName;
        }

        $speaker = Speaker::create($toCreate);

        return redirect()->back()->with([
            'message' => "Berhasil menambahkan " . $speaker->name,
        ]);
    }
    public function update($id, Request $request) {
        $toUpdate = [
            'name' => $request->name,
            'credential' => $request->credential,
        ];
        $speak = Speaker::where('id', $id);
        $speaker = $speak->first();

        if ($request->hasFile('photo')) {
            if ($speaker->photo != null) {
                Storage::delete('public/speaker_photos/' . $speaker->photo);
            }

            $photo = $request->file('photo');
            $photoFileName = $photo->getClientOriginalName();
            $photo->move(
                public_path('storage/speaker_photos'),
                $photoFileName
            );
            $toUpdate['photo'] = $photoFileName;
        }

        $speak->update($toUpdate);

        return redirect()->back()->with([
            'message' => "Berhasil menambahkan " . $speaker->name,
        ]);
    }
    public function delete($id) {
        $speak = Speaker::where('id', $id);
        $speaker = $speak->first();

        $speak->delete();
        if ($speaker->photo != null) {
            Storage::delete('public/speaker_photos/' . $speaker->photo);
        }

        return redirect()->back()->with([
            'message' => "Berhasil menghapus " . $speaker->name,
        ]);
    }
}
