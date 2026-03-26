<?php

namespace App\Jobs;

use App\Mail\Expiring;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class ExpiringJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pendingOrders = Transaction::where('payment_status', 'PENDING')
        ->with(['user', 'ticket'])->get();
        
        foreach ($pendingOrders as $order) {
            $expired = Carbon::parse($order->expired_at)->isPast();
            if ($expired) {
                $u = User::where('id', $order->user_id);
                $user = $u->first();

                Transaction::where('id', $order->id)->delete();
                $u->delete();
                
                Mail::to($user->email)->send(
                    new Expiring([
                        'trx' => $order
                    ])
                );
            }
        }
    }
}
