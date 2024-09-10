<div id="chat-button"
    class="fixed bottom-5 right-5 z-50 cursor-pointer bg-[#FB8226] text-white p-3 rounded-full shadow-lg hover:bg-[#FB8226]">
    <i data-feather="message-circle" class="w-6 h-6"></i>
</div>

<div id="chat-box"
    class="fixed bottom-20 right-5 z-50 bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden transform scale-0 opacity-0 transition-all duration-300 ease-out origin-bottom-right w-full max-w-[80%] md:max-w-screen-sm h-full max-h-[65%] flex flex-col">
    <div class="bg-[#FB8226] text-white p-4 flex items-center justify-between">
        <h3 class="text-lg">Chat</h3>
        <button id="close-chat-box" class="text-white">
            <i data-feather="x"></i>
        </button>
    </div>
    <div id="chat-content" class="flex-1 p-1 overflow-y-auto">
        <div id="realtime-chat-content" class="flex-1 flex flex-col justify-between">
            <div id="messages" class="flex-1 overflow-y-auto">
                <!-- Real-time chat messages will appear here -->
            </div>
            <div class="border-t p-3 sticky bottom-0 bg-white flex">
                <input type="text" placeholder="Type a message..." id="realtime-message-input"
                    class="flex-1 border border-gray-300 rounded-md p-2 focus:outline-none">
                <button id="send-message-button"
                    class="ml-2 bg-[#FB8226] text-white px-3 py-1 rounded-md hover:bg-[#FB8226] transition-all duration-300">
                    Send
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatButton = document.getElementById('chat-button');
        const chatBox = document.getElementById('chat-box');
        const closeChatBox = document.getElementById('close-chat-box');
        const messagesDiv = document.getElementById('messages');

        @auth
        var userId = {{ Auth::id() }};
        var lastMessageId = null;

        Pusher.logToConsole = true;

        Echo.channel('chat.' + userId)
            .listen('AdminReplySent', (e) => {
                console.log(e); // Log event data for debugging
                validateAndAddMessage(e); // Pass the event directly to the function
            });

        function validateAndAddMessage(message) {
            if (message.id !== lastMessageId) {
                addMessage(message);
                lastMessageId = message.id;
            }
        }

        function addMessage(message) {
            var sender = message.sender_id === userId ? 'You' : 'Admin';
            var messageElement = `<div class="mb-4 ${message.sender_id === userId ? 'text-right' : 'text-left'}">
                    <div class="inline-block">
                        <span class="text-sm text-text">${sender}</span>
                        <p class="mt-1 text-mostly-text bg-white p-2 rounded-lg">
                            ${message.message}
                        </p>
                    </div>
                </div>`;
            $('#messages').append(messageElement);
            forceScrollToBottom(); // Ensure scrolling after each new message is added
        }

        function forceScrollToBottom() {
            setTimeout(() => {
                messagesDiv.scrollTo({
                    top: messagesDiv.scrollHeight,
                    behavior: 'smooth' // Optional: remove if you don't want smooth scrolling
                });
            }, 100); // Adjust timeout as necessary if you notice it doesn't scroll completely
        }

        function fetchMessages() {
            axios.get('/fetch-messages/' + userId)
                .then(function(response) {
                    $('#messages').empty();
                    response.data.messages.forEach(function(message) {
                        addMessage(message);
                    });
                    forceScrollToBottom(); // Scroll to bottom after fetching messages
                })
                .catch(function(error) {
                    console.error('Error fetching messages:', error);
                });
        }

        $('#send-message-button').on('click', function() {
            var message = $('#realtime-message-input').val();

            if (message.trim() === '') {
                alert('Message cannot be empty');
                return;
            }

            axios.post('{{ route('send-message') }}', {
                message: message,
                _token: '{{ csrf_token() }}'
            }).then(function(response) {
                $('#realtime-message-input').val('');
                fetchMessages();
                forceScrollToBottom(); // Ensure scrolling after sending a message
            }).catch(function(error) {
                console.error('Error sending message:', error);
            });
        });

        fetchMessages(); // Fetch existing messages on page load and scroll to bottom
    @else
        // Jika user tidak terautentikasi, kirim mereka ke halaman login saat mereka mencoba mengirim pesan
        $('#send-message-button').on('click', function() {
            window.location.href = '{{ route('login') }}';
        });
    @endauth

    // Show/hide chat box
    chatButton.addEventListener('click', function() {
        if (chatBox.classList.contains('scale-0')) {
            chatBox.classList.remove('scale-0', 'opacity-0');
            chatBox.classList.add('scale-100', 'opacity-100');

            // Scroll to bottom when chat box is opened
            forceScrollToBottom();
        } else {
            chatBox.classList.remove('scale-100', 'opacity-100');
            chatBox.classList.add('scale-0', 'opacity-0');
            chatBox.classList.remove('w-screen', 'h-screen', 'max-w-full', 'max-h-full');
        }
    });

    closeChatBox.addEventListener('click', function() {
        chatBox.classList.remove('scale-100', 'opacity-100');
        chatBox.classList.add('scale-0', 'opacity-0');
        chatBox.classList.remove('w-screen', 'h-screen', 'max-w-full', 'max-h-full');
    });

    // Expand the chat box when real-time chat is opened
    chatBox.classList.add('w-screen', 'h-screen', 'max-w-full', 'max-h-full'); chatBox.classList.remove('w-80',
        'h-96', 'max-w-[80%]', 'max-h-[70%]');
    });
</script>
