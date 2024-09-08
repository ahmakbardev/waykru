@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto my-24 p-4 py-10 bg-container rounded-lg shadow-lg">
        <div class="flex justify-between items-center border-b pb-2 mb-4 border-text">
            <h2 class="text-lg font-semibold text-title">Information Topics</h2>
        </div>

        <!-- Chat box where selected topics and responses will appear -->
        <div id="chat-box-container"
            class="bg-white border border-gray-200 rounded-lg shadow-lg h-[550px] overflow-y-scroll transition-all duration-500">
            <div id="chat-box" class="flex flex-col space-y-4 p-4">
                <!-- Chat-like messages will be displayed here -->
            </div>
        </div>

        <!-- Chat input -->
        <div class="chat mt-4 relative overflow-visible">
            <div
                class="search-results bg-white border border-gray-300 rounded-lg shadow-lg p-2 w-full absolute bottom-16 z-10 hidden max-h-48 overflow-y-auto">
            </div>

            <div class="flex items-center border rounded-lg p-2 relative">
                <input type="text" class="flex-1 bg-transparent outline-none text-gray-700 p-2"
                    placeholder="Type a message...">
                <button class="p-2 rounded-full text-gray-500 hover:text-indigo-600 transition-colors relative group"
                    disabled>
                    <i data-feather="send" class="h-6 w-6"></i>
                    <!-- Tooltip -->
                    <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-700 z-[11] text-white text-sm rounded-lg px-2 py-1 opacity-0 transition-opacity duration-300"
                        id="tooltip">
                        Topik tidak ditemukan
                    </div>

                </button>
            </div>
        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.getElementById('chat-box');
            const chatBoxContainer = document.getElementById('chat-box-container');
            const inputField = document.querySelector('.chat input[type="text"]');
            const sendButton = document.querySelector('.chat button');
            const searchResultsContainer = document.querySelector('.search-results');
            let topicData = [];
            let selectedTopic = null;
            let typingTimeout = null;
            let isFetching = false;
            let isShowingAll = false; // State for showing all topics

            // Smooth scroll to bottom function
            function scrollToBottomSmooth() {
                setTimeout(() => {
                    chatBoxContainer.scrollTo({
                        top: chatBoxContainer.scrollHeight,
                        behavior: 'smooth'
                    });
                }, 100);
            }

            // Fetch topics and display them in the chat-box initially
            function fetchTopics() {
                axios.get('/api/topics')
                    .then(function(response) {
                        topicData = response.data; // Store topics for searching
                        displayTopicList(); // Initially display topics
                    })
                    .catch(function(error) {
                        console.error('Error fetching topics:', error);
                    });
            }

            // Function to display the topic list dynamically
            function displayTopicList() {
                const topicListContainer = document.createElement('div');
                topicListContainer.classList.add('space-y-2', 'bg-gray-50', 'p-4', 'rounded-lg', 'shadow-lg',
                    'transition-all', 'duration-500', 'ease-in-out', 'ml-auto', 'max-w-xs');

                // Add a heading for "Pilihan Topik" at the top
                const heading = document.createElement('h1');
                heading.classList.add('text-lg', 'font-semibold');
                heading.textContent = 'Pilihan Topik';
                topicListContainer.appendChild(heading);

                // Display all topics, with a limit of 3 visible topics at first
                topicData.forEach(function(topic, index) {
                    const listItem = document.createElement('div');
                    listItem.classList.add('cursor-pointer', 'bg-gray-100', 'p-3', 'rounded-lg',
                        'shadow-md', 'hover:bg-indigo-100', 'transition', 'duration-300', 'ease-in-out',
                        'flex', 'items-center', 'justify-between');
                    listItem.setAttribute('data-id', topic.id);

                    // Hide topics after the third one, initially
                    if (index >= 3 && !isShowingAll) {
                        listItem.classList.add('hidden');
                    }

                    // Main layout for each topic
                    listItem.innerHTML = `
                        <div class="flex items-center">
                            <span class="text-gray-700">${topic.name}</span>
                        </div>
                    `;

                    // Add event listener to handle click
                    listItem.addEventListener('click', function() {
                        selectTopic(topic, listItem);
                    });

                    topicListContainer.appendChild(listItem);
                });

                // Add the "Lihat Semua Topik" button if there are more than 3 topics
                if (topicData.length > 3) {
                    const seeAllButton = document.createElement('button');
                    seeAllButton.classList.add('text-indigo-600', 'text-sm', 'hover:text-indigo-800', 'mt-4',
                        'flex', 'items-center');
                    seeAllButton.innerHTML = `<p>Lihat Semua Topik</p>`;
                    topicListContainer.appendChild(seeAllButton);

                    // Add event listener to toggle visibility of hidden topics
                    seeAllButton.addEventListener('click', function() {
                        isShowingAll = !isShowingAll;

                        topicListContainer.querySelectorAll('div.cursor-pointer').forEach((item, index) => {
                            if (index >= 3) {
                                item.classList.toggle('hidden');
                            }
                        });

                        seeAllButton.innerHTML = isShowingAll ? `<p>Sembunyikan Topik</p>` :
                            `<p>Lihat Semua Topik</p>`;
                    });
                }

                // Append the topic list container to chat box
                chatBox.appendChild(topicListContainer);
                scrollToBottomSmooth();
            }

            // Function to handle topic selection
            function selectTopic(topic, listItem) {
                if (listItem) listItem.parentElement.remove(); // Remove the topic list after selecting

                // Add the selected topic to the chat window (left side message for user)
                const userMessage = document.createElement('div');
                userMessage.classList.add('flex', 'justify-start', 'space-x-2', 'p-3', 'rounded-lg', 'shadow-sm',
                    'bg-gray-100', 'mb-2', 'transition-all', 'duration-500', 'ease-in-out', 'max-w-xs');
                userMessage.innerHTML = `
                    <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded-full" alt="Avatar">
                    <div>
                        <p class="font-bold">{{ Auth::user()->name }}</p>
                        <p class="text-gray-600">${topic.name}</p>
                    </div>
                `;
                chatBox.append(userMessage);
                scrollToBottomSmooth();

                // Show typing animation for 2 seconds (right side message for system)
                const systemMessage = document.createElement('div');
                systemMessage.classList.add('flex', 'justify-end', 'space-x-2', 'p-3', 'rounded-lg', 'shadow-sm',
                    'bg-blue-100', 'mb-2', 'transition-all', 'duration-500', 'ease-in-out', 'ml-auto',
                    'max-w-xs');
                systemMessage.innerHTML = `
                    <div>
                        <p class="font-bold">System</p>
                        <p class="text-gray-500 italic typing-indicator">Typing</p>
                        <span class="dot-pulse"></span>
                    </div>
                `;
                chatBox.append(systemMessage);
                scrollToBottomSmooth();

                setTimeout(() => {
                    systemMessage.innerHTML = `
                        <div>
                            <p class="font-bold">System</p>
                            <p class="text-gray-600">
                                ${topic.information ? topic.information.content : 'No content available for this topic.'}
                            </p>
                        </div>
                    `;

                    systemMessage.classList.add('transition-opacity', 'duration-500', 'ease-in-out');
                    systemMessage.style.opacity = '1';

                    feather.replace();

                    // Display the topic list again after the system message
                    displayTopicList();

                    scrollToBottomSmooth();
                }, 2000); // Simulate typing for 2 seconds
            }

            // Real-time search function with 2 seconds delay after typing
            inputField.addEventListener('input', function() {
                const searchQuery = inputField.value.toLowerCase();
                searchResultsContainer.innerHTML = '';
                searchResultsContainer.classList.remove('hidden');
                sendButton.disabled = true;
                hideTooltip(); // Hide tooltip initially

                if (typingTimeout) clearTimeout(typingTimeout);

                if (!isFetching && searchQuery.length > 0) showFetchingState();

                typingTimeout = setTimeout(function() {
                    searchResultsContainer.innerHTML = '';
                    if (searchQuery.length > 0) {
                        const filteredTopics = topicData.filter(topic => topic.name.toLowerCase()
                            .includes(searchQuery));
                        if (filteredTopics.length > 0) {
                            filteredTopics.forEach(topic => {
                                const resultItem = document.createElement('div');
                                resultItem.classList.add('cursor-pointer', 'p-2',
                                    'hover:bg-gray-100', 'rounded');
                                resultItem.textContent = topic.name;
                                resultItem.addEventListener('click', function() {
                                    selectTopicFromSearch(
                                        topic); // Set the selected topic on click
                                });
                                searchResultsContainer.appendChild(resultItem);
                            });
                            hideFetchingState();

                            const exactMatch = filteredTopics.find(topic => topic.name
                                .toLowerCase() === searchQuery);
                            if (exactMatch) {
                                sendButton.disabled = false; // Enable send button if exact match
                                hideTooltip(); // Hide tooltip if exact match is found
                                selectedTopic = exactMatch; // Set selected topic to exact match
                            } else {
                                sendButton.disabled = true; // Disable send button if no exact match
                                showTooltip(); // Show tooltip when no exact match is found
                            }
                        } else {
                            // If no matching topics, show "no topics found" and show tooltip
                            const noResults = document.createElement('div');
                            noResults.textContent = 'No topics found';
                            noResults.classList.add('text-gray-500', 'italic');
                            searchResultsContainer.appendChild(noResults);
                            sendButton.disabled = true; // Disable send button
                            hideFetchingState();
                            showTooltip(); // Show tooltip when no topics found
                        }
                    } else {
                        hideFetchingState();
                        sendButton.disabled = true; // Disable send button if input is empty
                    }
                }, 2000); // 2 seconds delay before search
            });

            // Function to hide topic list after sending message
            function hideTopicList() {
                const topicListContainer = document.querySelector('.space-y-2'); // Select the topic list container
                if (topicListContainer) {
                    topicListContainer.classList.add('hidden'); // Add 'hidden' class to hide the topic list
                }
            }

            // Function to handle send button click and check if input matches a topic
            sendButton.addEventListener('click', function() {
                const searchQuery = inputField.value.toLowerCase();
                const exactMatch = topicData.find(topic => topic.name.toLowerCase() === searchQuery);

                if (exactMatch) {
                    selectTopic(exactMatch); // Send the selected topic if it matches
                    inputField.value = ''; // Clear input
                    sendButton.disabled = true; // Disable button after sending
                    hideTooltip(); // Ensure tooltip is hidden
                    hideTopicList(); // Hide the topic list after sending
                } else {
                    showTooltip(); // Show tooltip if no match is found on send click
                }
            });


            // Show tooltip when no matching topic
            function showTooltip() {
                const tooltip = document.getElementById('tooltip');
                tooltip.textContent = 'Topik tidak ditemukan'; // Set tooltip message
                tooltip.classList.remove('opacity-0');
                tooltip.classList.add('opacity-100');
            }

            // Hide tooltip when topic is found or input matches
            function hideTooltip() {
                const tooltip = document.getElementById('tooltip');
                tooltip.classList.add('opacity-0');
                tooltip.classList.remove('opacity-100');
            }

            // Handle send button hover and tooltip
            sendButton.addEventListener('mouseenter', function() {
                if (sendButton.disabled) {
                    showTooltip(); // Show tooltip if button is disabled
                }
            });

            sendButton.addEventListener('mouseleave', function() {
                hideTooltip(); // Hide tooltip when hover ends
            });


            // Show fetching state
            function showFetchingState() {
                isFetching = true;
                const fetchingState = document.createElement('div');
                fetchingState.textContent = 'Mencari topik...';
                fetchingState.classList.add('text-gray-500', 'italic', 'fetching-state');
                searchResultsContainer.appendChild(fetchingState);
                searchResultsContainer.classList.remove('hidden');
            }

            // Hide fetching state
            function hideFetchingState() {
                isFetching = false;
                const fetchingStateElement = document.querySelector('.fetching-state');
                if (fetchingStateElement) fetchingStateElement.remove();
            }

            // Function to handle topic selection from search results
            function selectTopicFromSearch(topic) {
                inputField.value = topic.name;
                selectedTopic = topic;
                sendButton.disabled = false;
                hideTooltip();
                searchResultsContainer.classList.add('hidden');
            }

            // Initial fetch call to load topics
            fetchTopics();
        });
    </script>


    <style>
        /* Dot Pulse animation */
        .dot-pulse {
            display: inline-block;
            width: 6px;
            height: 6px;
            margin-left: 4px;
            background-color: #4299e1;
            border-radius: 50%;
            animation: pulse 1s infinite ease-in-out;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.5);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endsection
