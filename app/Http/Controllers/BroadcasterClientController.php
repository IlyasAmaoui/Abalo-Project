<?php

namespace App\Http\Controllers;
use WebSocket\Client;

class BroadcasterClientController extends Controller
{
    public function sendMaintenanceMessage()
    {
        $message = <<<MSG
In Kürze verbessern wir Abalo für Sie!
Nach einer kurzen Pause sind wir wieder
für Sie da! Versprochen.
MSG;

        try {
            $client = new Client("ws://localhost:4010/hinweis");
            $client->send($message);
            $client->close();

            return response()->json(['status' => 'success', 'message' => 'Nachricht gesendet.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
}