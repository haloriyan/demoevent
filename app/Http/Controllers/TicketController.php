<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // TICKET HANDLER
    public function store(Request $request) {
        $ticket = Ticket::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'start_quantity' => $request->quantity,
            'start_date' => $request->date,
            'end_date' => $request->date,
            'visible' => true,
        ]);

        return redirect()->back()->with([
            'message' => "Berhasil menambahkan tiket " . $ticket->name,
        ]);
    }
    public function update(Request $request, $id) {
        $tick = Ticket::where('id', $id);
        $ticket = $tick->first();

        $toUpdate = [
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'start_quantity' => $request->quantity,
            'start_date' => $request->date,
            'end_date' => $request->date,
            'visible' => true,
        ];

        $tick->update($toUpdate);
        
        return redirect()->back()->with([
            'message' => "Berhasil menghapus tiket " . $ticket->name,
        ]);
    }
    public function delete(Request $request, $id) {
        $tick = Ticket::where('id', $id);
        $ticket = $tick->first();

        $tick->delete();
        
        return redirect()->back()->with([
            'message' => "Berhasil menghapus tiket " . $ticket->name,
        ]);
    }

    // CATEGORY HANDLER
    public function storeCategory(Request $request) {
        $category = TicketCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with([
            'message' => "Berhasil membuat kategori " . $request->name,
        ]);
    }
    public function updateCategory(Request $request, $id) {
        $cat = TicketCategory::where('id', $id);
        $category = $cat->first();

        $cat->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with([
            'message' => "Berhasil mengubah kategori " . $category->name,
        ]);
    }
    public function deleteCategory(Request $request, $id) {
        $cat = TicketCategory::where('id', $id);
        $category = $cat->first();
        
        $cat->delete();

        return redirect()->back()->with([
            'message' => "Berhasil menghapus kategori " . $category->name,
        ]);
    }
}
