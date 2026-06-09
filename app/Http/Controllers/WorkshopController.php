<?php

namespace App\Http\Controllers;

use App\Exports\WorkshopExport;
use App\Models\Transaction;
use App\Models\Workshop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class WorkshopController extends Controller
{
    public function store(Request $request) {
        $ws = Workshop::create([
            'rundown_id' => $request->rundown_id,
            'category_id' => $request->category_id,
            'ticket_category_id' => $request->ticket_category_id,
            'title' => $request->title,
            'count' => 0,
            'quantity' => $request->quantity,
            'start_quantity' => $request->quantity,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'speakers' => $request->speakers,
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
            'start_quantity' => $request->start_quantity,
            'rundown_id' => $request->rundown_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'speakers' => $request->speakers,
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
    public function export() {
        $workshops = Workshop::orderBy('title', 'ASC')->get();
        foreach ($workshops as $w => $ws) {
            $workshops[$w]->users = [];
        }

        $transactionsRaw = Transaction::where([
            ['payment_status', 'PAID']
        ])
        ->whereNotNull('workshops')
        ->whereNotNull('user_id')
        ->with([
            'user'
        ])
        ->get();

        $users = [];

        foreach ($transactionsRaw as $t => $trx) {
            if ($trx->user != null) {
                $uworkshops = collect(json_decode($trx->workshops));
                $user = $trx->user;
                $user->transaction = $trx;
                $user->workshops = $uworkshops;
                $user->workshop_ids = $uworkshops->pluck('id')->toArray();

                unset($user->transaction->user);

                $users[] = $user;
            }
        }

        foreach ($users as $u => $user) {
            foreach ($workshops as $w => $ws) {
                if (in_array($ws->id, $user->workshop_ids)) {
                    $cleanUser = clone $user;

                    unset($cleanUser->workshops);
                    unset($cleanUser->workshop_ids);

                    $tempUsers = $ws->users;
                    $tempUsers[] = $cleanUser;

                    $ws->users = $tempUsers;
                }
            }
        }

        $filename = "Peserta_Workshop-Exported_at_" . Carbon::now()->isoFormat('DD-MMM-Y HH:mm:ss') . ".xlsx";

        return Excel::download(
            new WorkshopExport([
                'workshops' => $workshops
            ]),
            $filename,
        );
    }
}
