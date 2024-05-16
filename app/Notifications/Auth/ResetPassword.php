<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Auth\Notifications\ResetPassword as NotificationsResetPassword;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends NotificationsResetPassword implements ShouldQueue
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        //required to persist the token for the queue
        $this->token = $token;
        //specifying queue is optional but recommended
        // $this->queue = 'auth';
    }
}
