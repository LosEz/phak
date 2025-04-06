<?php

namespace App\Http\Controllers;

use App\Notifications\DiscordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class DiscordNotificationController extends Controller
{
    
    public function sendNotification()
    {

        Notification::route('slack',"https://discord.com/api/webhooks/1356807090232098836/uSJ1Rzq-rODDOxf2SfyeJOJAJ_q1zG0J7daHM5ipRTcYEpmPImSCaDmsWx1i8itU3ypU")
            ->notify(new DiscordNotification('Hello from Laravel!'));

        return response()->json(['status' => 'success', 'message' => 'Notification sent successfully!']);
    }
}
