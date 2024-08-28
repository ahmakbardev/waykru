<!-- chat-menu.blade.php -->
<div id="chat-button"
    class="fixed bottom-5 right-5 z-50 cursor-pointer bg-indigo-600 text-white p-3 rounded-full shadow-lg hover:bg-indigo-500">
    <i data-feather="message-circle" class="w-6 h-6"></i>
</div>

<div id="chat-box"
    class="fixed bottom-20 right-5 z-50 bg-white border border-gray-300 shadow-lg rounded-lg transform scale-0 opacity-0 transition-all duration-300 ease-out origin-bottom-right w-80 h-96 flex flex-col">
    <div class="bg-indigo-600 text-white p-4 flex items-center justify-between">
        <h3 class="text-lg">Chat</h3>
        <button id="close-chat-box" class="text-white">
            <i data-feather="x"></i>
        </button>
    </div>
    <div class="flex-1 p-4 overflow-y-auto">
        <!-- Chat messages go here -->
        <div class="text-center text-gray-500">No messages yet...</div>
    </div>
    <div class="border-t p-3">
        <input type="text" placeholder="Type a message..."
            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatButton = document.getElementById('chat-button');
        const chatBox = document.getElementById('chat-box');
        const closeChatBox = document.getElementById('close-chat-box');

        chatButton.addEventListener('click', function() {
            if (chatBox.classList.contains('scale-0')) {
                chatBox.classList.remove('scale-0', 'opacity-0');
                chatBox.classList.add('scale-100', 'opacity-100');
            } else {
                chatBox.classList.remove('scale-100', 'opacity-100');
                chatBox.classList.add('scale-0', 'opacity-0');
            }
        });

        closeChatBox.addEventListener('click', function() {
            chatBox.classList.remove('scale-100', 'opacity-100');
            chatBox.classList.add('scale-0', 'opacity-0');
        });
    });
</script>
