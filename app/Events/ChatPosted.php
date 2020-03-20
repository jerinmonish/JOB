<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Chat;
class ChatPosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $newChat;
    public $main_message;
    public $from_id;
    public $to_id;
    public $datetimes;
    public $to_idonly;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chat $newChat)
    {
        $this->message      = @$newChat['setNewMsgPosted'];
        $this->main_message = @$newChat['msgdata'];
        $this->from_id      = @$newChat['from_id'];
        $this->to_id        = @$newChat['to_id'];
        $this->datetimes    = @$newChat['datetimes'];
        $this->to_idonly    = @$newChat['to_idonly'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('my-channel');
    }

    public function broadcastAs()
    {
        return 'job-submitted';
    }
}
