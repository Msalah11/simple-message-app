<?php

namespace App\Actions;

use App\Events\MessageSent;
use App\Models\Message;

class MessageAction
{
    /**
     * Store a new message.
     *
     * @param array $data The data for the message.
     * @return Message The created message instance.
     */
    public function store(array $data): Message
    {
        // Create a new message using the Message model's create method
        $message =  Message::create([
            'message' => $data['message'],
            'user_id' => auth()->id(),
        ]);

        broadcast(new MessageSent($message))->toOthers(); // Broadcast the message using the MessageSent event

        return $message; // Return the created message
    }
}
