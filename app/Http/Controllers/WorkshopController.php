<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function store(Request $request) {
        $ws = Workshop::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'count' => 0,
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with([
            'message' => "Berhasil menambahkan workshop baru"
        ]);
    }
    public function update(Request $request, $id) {
        $ws = Workshop::where('id', $id);
        $ws->update([
            'title' => $request->title,
            'quantity' => $request->quantity,
        ]);
        
        $workshop = $ws->first();

        return redirect()->back()->with([
            'message' => "Berhasil mengubah workshop " . $workshop->title
        ]);
    }
    public function delete($id) {
        $ws = Workshop::where('id', $id);
        $workshop = $ws->first();

        $ws->delete();

        return redirect()->back()->with([
            'message' => "Berhasil menghapus workshop " . $workshop->title
        ]);
    }
}
