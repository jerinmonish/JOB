<?php

namespace App\Listeners;

use App\Events\AuthOwnLoginEventHandler;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use Auth;
class LastLoginWelcomeNote
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AuthOwnLoginEventHandler  $event
     * @return void
     */
    public function handle(AuthOwnLoginEventHandler $event)
    {
        /*$event->last_logged_in = Carbon::now()->toDateTimeString();
        $event->save();*/
        Auth::user()->last_logged_in = Carbon::now()->toDateTimeString();
        Auth::user()->save();
    }
}
