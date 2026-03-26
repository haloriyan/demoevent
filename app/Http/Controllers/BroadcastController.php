<?php

namespace App\Http\Controllers;

use App\Jobs\CharlieJob;
use App\Models\Broadcast;
use App\Models\User;
use App\Models\WaDevice;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    public static function getVars($string) {
        $pattern = '/%([^%]*)%/';
        preg_match_all($pattern, $string, $matches);
        return $matches[1];
    }
    public static function blast($broadcast, $users, $device) {
        foreach ($users as $user) {
            $theContent = $broadcast->content;
            $vars = self::getVars($theContent);
            $templates = [
                'user' => $user,
                'transaction' => $user->transaction,
                'ticket' => $user->transaction->ticket,
            ];

            foreach ($vars as $var) {
                $v = explode(".", $var);
                $theContent = str_replace("%".$var."%", $templates[$v[0]]->{$v[1]}, $theContent);
            }

            CharlieJob::dispatch([
                'broadcast' => $broadcast,
                'user' => $user,
                'device' => $device,
                'message' => $theContent,
            ]);
        }
    }
    public function detail(Request $request, $id) {
        $broadcast = Broadcast::where('id', $id)
        ->with(['device', 'logs'])
        ->first();

        return view('admin.broadcast.detail', [
            'broadcast' => $broadcast,
        ]);
    }

    public function store(Request $request) {
        $users = User::whereHas('transaction', function ($q) {
            $q->where('payment_status', 'PAID');
        })
        ->with(['transaction.ticket'])
        ->get();
        $device = WaDevice::where('id', $request->device_id)->first();

        $broadcast = Broadcast::create([
            'device_id' => $request->device_id,
            'title' => $request->title,
            'content' => $request->content,
            'sent' => 0,
            'total' => $users->count(),
        ]);

        self::blast($broadcast, $users, $device);

        return redirect()->back()->with([
            'message' => "OK"
        ]);
    }
}
