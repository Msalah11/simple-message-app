@extends('layouts.app')
@section('title', 'Messages')

@section('content')
    <div class="card">
        <div class="card-header">Chat</div>
        <div class="card-body">
            <div class="message-listing" id="messageWrapper">
                <!-- Chat messages will be appended here -->
            </div>
        </div>
        <div class="card-footer">
            <div class="input-group ">
                <input type="text" class="form-control" id="chatInput" placeholder="Type a message...">
                <button class="btn btn-primary" type="button" id="chatButton">{{__('Send')}}</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.5/socket.io.js"></script>
    <script>
        const socket = io("{{ env('PUBLISHER_URL') }}:3000");
        const userId = "{{ auth()->user()->id }}";

        socket.on('connect', function () {
            socket.emit('user_connected', userId);
        });

        const chatButton = $("#chatButton");
        const messageWrapper = $("#messageWrapper");
        const chatInput = $("#chatInput");

        chatButton.click(function () {
            const message = chatInput.val();
            chatInput.val('');

            callSendMessage(message);
        });

        function callSendMessage(message) {
            let url = "{{ route('message.send-message') }}";
            let formData = new FormData();
            let token = "{{ csrf_token() }}";

            formData.append('message', message);
            formData.append('_token', token);


            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function (response) {
                    console.log('response', response);
                    socket.emit('chat-message', { message: message });
                },
                error: function (response) {
                    alert('Error occurred while sending message to server')
                    console.log(response);
                }
            });
        }

        function appendMessageToSender(message) {
            let messageHtml = `<div class="message sender">
                <div class="message-content">
                    <p>${message}</p>
                </div>
            </div>`;
            messageWrapper.append(messageHtml);
        }

        function appendMessageToReceiver(message) {
            let messageHtml = `<div class="message receiver">
                <div class="message-content">
                    <p>${message}</p>
                </div>
            </div>`;
            messageWrapper.append(messageHtml);
        }

        socket.on('chat-message', function (data) {
            appendMessageToReceiver(data.message);
        });
    </script>

@endsection
