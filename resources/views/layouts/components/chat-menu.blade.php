<div id="chat-button"
    class="fixed bottom-5 right-5 z-50 cursor-pointer bg-indigo-600 text-white p-3 rounded-full shadow-lg hover:bg-indigo-500">
    <i data-feather="message-circle" class="w-6 h-6"></i>
</div>

<div id="chat-box"
    class="fixed bottom-20 right-5 z-50 bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden transform scale-0 opacity-0 transition-all duration-300 ease-out origin-bottom-right w-80 max-w-[80%] md:max-w-screen-sm h-96 max-h-[70%] flex flex-col">
    <div class="bg-indigo-600 text-white p-4 flex items-center justify-between">
        <h3 class="text-lg">Chat</h3>
        <button id="close-chat-box" class="text-white">
            <i data-feather="x"></i>
        </button>
    </div>
    <div id="chat-content" class="flex-1 p-1 overflow-y-auto">
        <div id="chat-buttons" class="flex justify-around">
            <button id="topics-button"
                class="bg-indigo-600 text-white px-3 py-1 rounded-md shadow-lg hover:bg-indigo-500 transition-all duration-300">
                View Topics
            </button>
            <button id="realtime-chat-button"
                class="bg-indigo-600 text-white px-3 py-1 rounded-md shadow-lg hover:bg-indigo-500 transition-all duration-300">
                Real-time Chat
            </button>
        </div>

        <!-- Back Button (shown after clicking a topic or real-time chat) -->
        <button id="back-button"
            class="hidden text-indigo-600 text-sm hover:text-indigo-800 mb-4 flex items-center group">
            <i data-feather="arrow-left"
                class="mr-2 group-hover:mr-3 group-hover:w-8 p-1 aspect-square h-full w-7 group-hover:border group-hover:border-indigo-600 rounded-full transition-all ease-in-out"></i>
            <p>Kembali</p>
        </button>

        <!-- Display initial chat prompt for unauthenticated users in real-time chat -->
        <div id="guest-prompt" class="hidden p-4 bg-gray-100 rounded-lg shadow-md">
            <p>Mau tanya tentang web ini?</p>
            <button id="guest-send-button"
                class="mt-2 bg-indigo-600 text-white px-3 py-1 rounded-md shadow-lg hover:bg-indigo-500 transition-all duration-300">
                Send
            </button>
        </div>

        <ul id="topic-list" class="space-y-2 overflow-y-auto hidden">
            <!-- Topics will be loaded via AJAX -->
        </ul>

        <div id="information-detail" class="mt-4 text-gray-700 hidden">
            <div id="information-content" class="w-full px-7">
                <!-- Detailed information will be displayed here -->
            </div>
        </div>

        <div id="realtime-chat-content" class="hidden flex-1 flex flex-col justify-between">
            <div id="messages" class="flex-1 overflow-y-auto">
                <!-- Real-time chat messages will appear here -->
            </div>
            <div class="border-t p-3 sticky bottom-0 bg-white flex">
                <input type="text" placeholder="Type a message..." id="realtime-message-input"
                    class="flex-1 border border-gray-300 rounded-md p-2 focus:outline-none">
                <button id="send-message-button"
                    class="ml-2 bg-indigo-600 text-white px-3 py-1 rounded-md hover:bg-indigo-500 transition-all duration-300">
                    Send
                </button>
            </div>
        </div>

    </div>
</div>

<!-- Include SimpleBar -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.css" />
<script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
            const chatButton = document.getElementById('chat-button');
            const chatBox = document.getElementById('chat-box');
            const closeChatBox = document.getElementById('close-chat-box');
            const topicList = document.getElementById('topic-list');
            const informationDetail = document.getElementById('information-detail');
            const informationContent = document.getElementById('information-content');
            const backButton = document.getElementById('back-button');
            const messagesDiv = document.getElementById('messages');

            const topicsButton = document.getElementById('topics-button');
            const realtimeChatButton = document.getElementById('realtime-chat-button');
            const chatButtons = document.getElementById('chat-buttons');
            const realtimeChatContent = document.getElementById('realtime-chat-content');
            const guestPrompt = document.getElementById('guest-prompt');

            @guest
            const guestSendButton = document.getElementById('guest-send-button');
            guestSendButton.addEventListener('click', function() {
                window.location.href = '{{ route('login') }}'; // Redirect to login
            });
        @endguest

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
            scrollChatToBottom(); // Ensure scrolling after each new message is added
        }

        function scrollChatToBottom() {
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function fetchMessages() {
            axios.get('/fetch-messages/' + userId)
                .then(function(response) {
                    $('#messages').empty();
                    response.data.messages.forEach(function(message) {
                        addMessage(message);
                    });
                    scrollChatToBottom(); // Scroll to bottom after fetching messages
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
                scrollChatToBottom(); // Ensure scrolling after sending a message
            }).catch(function(error) {
                console.error('Error sending message:', error);
            });
        });

        fetchMessages(); // Fetch existing messages on page load and scroll to bottom
    @endauth

    // Show/hide chat box
    chatButton.addEventListener('click', function() {
        if (chatBox.classList.contains('scale-0')) {
            chatBox.classList.remove('scale-0', 'opacity-0');
            chatBox.classList.add('scale-100', 'opacity-100');
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

    // Toggle between views
    topicsButton.addEventListener('click', function() {
        chatButtons.classList.add('hidden');
        topicList.classList.remove('hidden');
        backButton.classList.remove('hidden');
    });

    realtimeChatButton.addEventListener('click', function() {
        chatButtons.classList.add('hidden');
        realtimeChatContent.classList.remove('hidden');
        backButton.classList.remove('hidden');

        @guest
        guestPrompt.classList.remove('hidden');
        realtimeChatContent.classList.add('hidden');
    @endguest

    // Expand the chat box when real-time chat is opened
    chatBox.classList.add('w-screen', 'h-screen', 'max-w-full', 'max-h-full'); chatBox.classList.remove('w-80',
        'h-96', 'max-w-[80%]', 'max-h-[75%]');

    scrollChatToBottom(); // Scroll to bottom when opening the real-time chat view
    });

    backButton.addEventListener('click', function() {
        if (!topicList.classList.contains('hidden')) {
            topicList.classList.add('hidden');
            informationDetail.classList.add('hidden');
            chatButtons.classList.remove('hidden');
            backButton.classList.add('hidden');
        } else if (!realtimeChatContent.classList.contains('hidden')) {
            realtimeChatContent.classList.add('hidden');
            guestPrompt.classList.add('hidden');
            chatButtons.classList.remove('hidden');
            chatBox.classList.add('w-80', 'h-96', 'max-w-[80%]', 'max-h-[75%]');
            chatBox.classList.remove('w-screen', 'h-screen', 'max-w-full', 'max-h-full');
            backButton.classList.add('hidden');
        } else if (!informationDetail.classList.contains('hidden')) {
            informationDetail.classList.add('hidden');
            topicList.classList.remove('hidden');
        }
    });

    // Load topics and information
    fetch('/api/topics')
        .then(response => response.json())
        .then(topics => {
            topics.forEach(topic => {
                const listItem = document.createElement('li');
                listItem.classList.add('cursor-pointer', 'bg-gray-100', 'p-3', 'rounded-lg',
                    'shadow-md', 'hover:bg-indigo-100', 'transition', 'duration-300',
                    'ease-in-out');
                listItem.setAttribute('data-id', topic.id);
                listItem.textContent = topic.name;
                topicList.appendChild(listItem);

                listItem.addEventListener('click', function() {
                    if (topic.information) {
                        informationContent.innerHTML = `
                                        <h4 class="text-lg font-semibold mb-2">${topic.information.title}</h4>
                                        <p>${topic.information.content}</p>
                                    `;
                    } else {
                        informationContent.innerHTML =
                            `<p>Informasi tidak tersedia untuk topik ini.</p>`;
                    }
                    informationDetail.classList.remove('hidden');
                    topicList.classList.add('hidden');

                    // Show back button when viewing topic details
                    backButton.classList.remove('hidden');

                    // Expand the chat box when a topic is clicked
                    chatBox.classList.add('w-screen', 'h-screen', 'max-w-full',
                        'max-h-full');
                    chatBox.classList.remove('w-80', 'h-96', 'max-w-[80%]',
                        'max-h-[75%]');
                });
            });
        })
        .catch(error => console.error('Error fetching topics:', error));
    });
</script>
