<?php

namespace App\Http\Controllers;

use App\Actions\MessageAction;
use App\Http\Requests\Message\StoreMessage;
use App\Traits\ApiResponse;

class MessageController extends Controller
{
    use ApiResponse; // Importing the ApiResponse trait

    private MessageAction $messageAction; // Declaring a private property $messageAction of type MessageAction
    public function __construct()
    {
        $this->messageAction = new MessageAction(); // Instantiating the MessageAction class
    }

    // Method to display the chat view
    public function chat()
    {
        return view('chat.index'); // Returning the chat index view
    }

    // Method to store a new message
    public function store(StoreMessage $request)
    {
        // Validating the request data using the StoreMessage request class
        $validatedData = $request->validated();

        // Storing the message using the MessageAction store method
        $message = $this->messageAction->store($validatedData);

        // Checking if the message is empty
        if (empty($message)) {
            return $this->sendError(__('Failed to send message')); // Sending error response if message is empty
        }

        // Sending success response if message is sent successfully
        return $this->sendSuccess($message, __('Message sent successfully'));
    }
}
