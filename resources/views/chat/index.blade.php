@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto my-24 p-4 py-10 bg-container rounded-lg shadow-lg">
        <div class="flex justify-between items-center border-b pb-2 mb-4 border-text">
            <h2 class="text-lg font-semibold text-title">Private Chat with Admin</h2>
        </div>

        <div id="messages" class="bg-body-bg p-4 rounded-lg overflow-y-auto" style="height: 400px;">
            <!-- Pesan akan dimuat di sini melalui AJAX -->
        </div>

        <!-- Input message box -->
        <div class="flex items-center border-t border-text pt-4 mt-4">
            <input id="message-input" type="text" placeholder="Write your message..."
                class="flex-grow px-4 py-2 border border-text rounded-full focus:outline-none focus:ring-2 focus:ring-second-primary" />
            <button id="send-button"
                class="ml-2 px-4 py-2 bg-second-primary text-default-white rounded-full hover:bg-second-primary-dark">
                Send
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ mix('js/app.js') }}"></script> <!-- Pastikan app.js sudah build -->

    <script>
        Pusher.logToConsole = true;

        var userId = {{ Auth::id() }};
        var lastMessageId = null;

        Echo.channel('chat.' + userId)
            .listen('AdminReplySent', (e) => {
                console.log(e); // Periksa struktur data
                validateAndAddMessage(e); // Langsung kirim objek e ke fungsi
            });

        function validateAndAddMessage(message) {
            if (message.id !== lastMessageId) {
                addMessage(message);
                lastMessageId = message.id;
            }
        }

        function addMessage(message) {
            var sender = message.sender_id === userId ? 'You' : 'WAYKRU';
            var messageElement = `<div class="mb-4 ${message.sender_id === userId ? 'text-right' : 'text-left'}">
                    <div class="inline-block">
                        <span class="text-sm text-text">${sender}</span>
                        <p class="mt-1 text-mostly-text bg-white p-2 rounded-lg">
                            ${message.message}
                        </p>
                    </div>
                </div>`;
            $('#messages').append(messageElement);
            scrollChatToBottom();
        }


        function scrollChatToBottom() {
            var messagesDiv = document.getElementById('messages');
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function fetchMessages() {
            axios.get('/fetch-messages/' + userId)
                .then(function(response) {
                    $('#messages').empty();
                    response.data.messages.forEach(function(message) {
                        addMessage(message);
                    });
                })
                .catch(function(error) {
                    console.error('Error fetching messages:', error);
                });
        }

        $('#send-button').on('click', function() {
            var message = $('#message-input').val();

            if (message.trim() === '') {
                alert('Message cannot be empty');
                return;
            }

            axios.post('{{ route('send-message') }}', {
                message: message,
                _token: '{{ csrf_token() }}'
            }).then(function(response) {
                $('#message-input').val('');
                fetchMessages();
            }).catch(function(error) {
                console.error('Error sending message:', error);
            });
        });

        fetchMessages(); // Fetch existing messages on page load
    </script>
@endsection
