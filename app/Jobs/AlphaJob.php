<?php

namespace App\Jobs;

use App\Models\Broadcast;
use App\Models\BroadcastLog;
use App\Notifications\Broadcast as NotificationsBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AlphaJob implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $device;
    protected $message;
    protected $broadcast;

    /**
     * Create a new job instance.
     */
    public function __construct($props)
    {
        $this->user = $props['user'];
        $this->device = $props['device'];
        $this->message = $props['message'];
        $this->broadcast = $props['broadcast'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(rand(1, 5));

        $this->user->notify(new NotificationsBroadcast([
            'user' => $this->user,
            'subject' => $this->broadcast->title,
            'message' => $this->message,
        ]));

        BroadcastLog::create([
            'broadcast_id' => $this->broadcast->id,
            'body' => "Message sent to " . $this->user->name . " via email",
        ]);

        sleep(rand(1, 5));

        if ($this->user->whatsapp != null) {
            Http::post(env('WA_URL') . "/send", [
                'client_id' => $this->device->client_id,
                'number' => "62" . $this->user->whatsapp,
                'message' => $this->message,
            ]);

            BroadcastLog::create([
                'broadcast_id' => $this->broadcast->id,
                'body' => "Message sent to " . $this->user->name . " via whatsapp from device " . $this->device->name,
            ]);
        }

        Broadcast::where('id', $this->broadcast->id)->increment('sent');
        Log::info($this->message);
    }
}
