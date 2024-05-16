<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail as NotificationsVerifyEmail;

class VerifyEmail extends NotificationsVerifyEmail implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //specifying queue is optional but recommended
        // $this->queue = 'auth';
    }
}
