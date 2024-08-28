@extends('admin.layouts.layout')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-semibold text-gray-800 mt-10">Chat with {{ $user->name }}</h1>

        <div id="messages" class="bg-gray-100 p-4 rounded-lg h-80 overflow-y-auto mb-4">
            <!-- Messages will be loaded here -->
            @foreach ($messages as $message)
                <div class="mb-4 {{ $message->sender_id === Auth::id() ? 'text-right' : 'text-left' }}">
                    <div class="inline-block">
                        <span
                            class="text-sm text-text">{{ $message->sender_id === Auth::id() ? 'Admin' : $user->name }}</span>
                        <p class="mt-1 text-mostly-text bg-white p-2 rounded-lg">
                            {{ $message->message }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Reply box -->
        <div class="flex items-center border-t border-gray-200 pt-4 mt-4">
            <input id="replyMessage" type="text" placeholder="Type your reply..."
                class="flex-grow px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button id="sendReply" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-700">
                Send
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ mix('js/app.js') }}"></script> <!-- Pastikan app.js sudah build -->

    <script>
        const userId = {{ $user->id }};
        let lastMessageId = null;
        const pollingInterval = 5000; // Polling setiap 5 detik

        function fetchMessages() {
            axios.get(`/admin/messages/${userId}`)
                .then(function(response) {
                    $('#messages').empty();
                    response.data.messages.forEach(function(message) {
                        addMessage(message);
                    });
                    lastMessageId = response.data.lastMessageId;
                    scrollChatToBottom();
                })
                .catch(function(error) {
                    console.error('Error fetching messages:', error);
                });
        }

        function pollNewMessages() {
            setInterval(function() {
                axios.get(`/admin/messages/${userId}`, {
                    params: {
                        last_message_id: lastMessageId
                    }
                }).then(function(response) {
                    response.data.messages.forEach(function(message) {
                        addMessage(message);
                    });
                    if (response.data.messages.length > 0) {
                        lastMessageId = response.data.messages[response.data.messages.length - 1].id;
                        scrollChatToBottom();
                    }
                }).catch(function(error) {
                    console.error('Error fetching new messages:', error);
                });
            }, pollingInterval);
        }

        function sendReplyMessage(userId, message) {
            axios.post(`/admin/send-message`, {
                user_id: userId,
                message: message,
                _token: '{{ csrf_token() }}'
            }).then(function(response) {
                // Add the sent message manually
                addMessage(response.data.message);
                scrollChatToBottom();
            }).catch(function(error) {
                console.error('Error sending message:', error);
            });
        }

        function addMessage(data) {
            const sender = data.sender_id === {{ Auth::id() }} ? 'Admin' : '{{ $user->name }}';
            const messageElement = `<div class="mb-4 ${data.sender_id === {{ Auth::id() }} ? 'text-right' : 'text-left'}">
                <div class="inline-block">
                    <span class="text-sm text-text">${sender}</span>
                    <p class="mt-1 text-mostly-text bg-white p-2 rounded-lg">${data.message}</p>
                </div>
            </div>`;
            document.getElementById('messages').insertAdjacentHTML('beforeend', messageElement);
        }

        function scrollChatToBottom() {
            const messagesDiv = document.getElementById('messages');
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        document.getElementById('sendReply').addEventListener('click', function() {
            const message = document.getElementById('replyMessage').value.trim();
            if (message !== '') {
                sendReplyMessage(userId, message);
                document.getElementById('replyMessage').value = '';
            }
        });

        fetchMessages(); // Fetch existing messages on page load
        pollNewMessages(); // Start polling for new messages
    </script>
@endsection
