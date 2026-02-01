<?php

namespace App\Http\Controllers;

use App\Exports\BoothCheckin as ExportsBoothCheckin;
use App\Models\Booth;
use App\Models\BoothCheckin;
use App\Models\Scan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BoothController extends Controller
{
    public function login(Request $request) {
        if ($request->method() == "GET") {
            $message = Session::get('message');
            
            return view('booth.login', [
                'message' => $message,
            ]);
        } else {
            $loggingIn = Auth::guard('booth')->attempt([
                'username' => $request->username,
                'password' => $request->password,
            ]);

            if (!$loggingIn) {
                return redirect()->back()->withErrors([
                    'Kombinasi username dan password tidak tepat'
                ]);
            }

            return redirect()->route('booth.dashboard');
        }
    }
    public function store(Request $request) {
        $cover = $request->file('cover');

        $toCreate = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'description' => $request->description,
        ];

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconFileName = time() . "_" . $icon->getClientOriginalName();
            $toCreate['icon'] = $iconFileName;
            $icon->move(
                public_path('storage/booth_icons'), $iconFileName,
            );
        }
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverFileName = time() . "_" . $cover->getClientOriginalName();
            $toCreate['cover'] = $coverFileName;
            $cover->move(
                public_path('storage/booth_covers'), $coverFileName,
            );
        }

        $booth = Booth::create($toCreate);

        return redirect()->back()->with([
            'message' => "Berhasil menambahkan booth " . $booth->name,
        ]);
    }

    public function update(Request $request, $id) {
        $me = me('booth');
        $boo = Booth::where('id', $id);
        $booth = $boo->first();
        $logout = false;

        $toUpdate = [
            'name' => $request->name,
            'username' => $request->username,
            'description' => $request->description,
        ];

        if ($request->password != "") {
            $toUpdate['password'] = bcrypt($request->password);
            if ($me != null) {
                $logout = true;
            }
        }

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconFileName = time()."_".$icon->getClientOriginalName();
            Storage::delete('public/booth_icons/' . $booth->icon);
            $toUpdate['icon'] = $iconFileName;
            $icon->move(
                public_path('storage/booth_icons/'), $iconFileName
            );
        }
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverFileName = time()."_".$cover->getClientOriginalName();
            Storage::delete('public/booth_covers/' . $booth->cover);
            $toUpdate['cover'] = $coverFileName;
            $cover->move(
                public_path('storage/booth_covers/'), $coverFileName
            );
        }

        $boo->update($toUpdate);

        return redirect()->back()->with([
            'message' => "Berhasil mengubah booth " . $booth->name,
        ]);
    }
    public function delete(Request $request, $id) {
        $boo = Booth::where('id', $id);
        $booth = $boo->first();

        $boo->delete();

        if ($booth->cover != null) {
            Storage::delete('public/booth_covers/' . $booth->cover);
        }
        if ($booth->icon != null) {
            Storage::delete('public/booth_icons/' . $booth->icon);
        }

        return redirect()->back()->with([
            'message' => "Berhasil menghapus booth " . $booth->name,
        ]);

    }
    public function checkin(Request $request) {
        $me = me('booth');
        $user = User::where('id', $request->user_id)->first();

        BoothCheckin::create([
            'user_id' => $user->id,
            'booth_id' => $me->id,
        ]);

        return redirect()->back()->with([
            'message' => $user->name . " berhasil Check-in"
        ]);
    }

    public function dashboard(Request $request) {
        $me = me('booth');
        $check = BoothCheckin::where('booth_id', $me->id)->with(['user']);

        if ($request->download == 1) {
            $filename = "Data_Checkin_Booth"."-Exported_at_" . Carbon::now()->isoFormat('DD-MMM-Y') . ".xlsx";
            $checkins = $check->get();

            return Excel::download(
                new ExportsBoothCheckin([
                    'role' => "BOOTH",
                    'checkins' => $checkins,
                ]),
                $filename
            );
        }

        $checkins = $check->paginate(25);
        // $checkins = Scan::with(['user'])->paginate(25);

        return view('booth.dashboard', [
            'me' => $me,
            'checkins' => $checkins,
        ]);
    }
    public function scan() {
        $me = me('booth');
        $message = Session::get('message');

        return view('booth.scan', [
            'me' => $me,
            'message' => $message,
        ]);
    }
    public function profile() {
        $me = me('booth');
        $message = Session::get('message');

        return view('booth.profile', [
            'me' => $me,
            'message' => $message,
        ]);
    }
}
