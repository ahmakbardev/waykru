@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto my-24 p-4 py-10 bg-container rounded-lg shadow-lg">
        <div class="flex justify-between items-center border-b pb-2 mb-4 border-text">
            <h2 class="text-lg font-semibold text-title">Information Topics</h2>
        </div>

        <div class="flex justify-between">
            <div class="flex-1">
                <div id="topic-list" class="space-y-2 bg-white border border-gray-200 rounded-lg shadow-lg p-2 w-80 ml-auto">
                    <!-- Topics will be loaded via AJAX -->
                </div>

                <!-- Back Button -->
                <button id="back-button"
                    class="hidden text-indigo-600 text-sm hover:text-indigo-800 mb-4 flex items-center group">
                    <i data-feather="arrow-left"
                        class="mr-2 group-hover:mr-3 group-hover:w-8 p-1 aspect-square h-full w-7 group-hover:border group-hover:border-indigo-600 rounded-full transition-all ease-in-out"></i>
                    <p>Kembali</p>
                </button>

                <div id="information-detail"
                    class="hidden bg-white p-4 rounded-lg shadow-lg w-full transition-all duration-500">
                    <div id="information-content" class="w-full px-7">
                        <!-- Detailed information will be displayed here -->
                    </div>
                </div>

                <div class="chat mt-4">
                    <div class="flex items-center border rounded-lg p-2">
                        <input type="text" class="flex-1 bg-transparent outline-none text-gray-700 p-2"
                            placeholder="Type a message...">
                        <button class="p-2 rounded-full text-gray-500 hover:text-indigo-600 transition-colors">
                            <i data-feather="send" class="h-6 w-6"></i>
                        </button>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ mix('js/app.js') }}"></script> <!-- Pastikan app.js sudah build -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const topicList = document.getElementById('topic-list');
            const informationDetail = document.getElementById('information-detail');
            const informationContent = document.getElementById('information-content');
            let activeItem = null; // To track the active/opened item

            // Fetch topics and display them
            function fetchTopics() {
                axios.get('/api/topics')
                    .then(function(response) {
                        response.data.forEach(function(topic) {
                            // Create topic list item
                            const listItem = document.createElement('div');
                            listItem.classList.add('cursor-pointer', 'bg-gray-100', 'p-3', 'rounded-lg',
                                'shadow-md', 'hover:bg-indigo-100', 'transition', 'duration-300',
                                'ease-in-out', 'flex', 'items-center', 'justify-between');
                            listItem.setAttribute('data-id', topic.id);
                            listItem.setAttribute('data-clickable',
                            'true'); // Custom attribute to check if it's clickable

                            // Main layout for each topic
                            listItem.innerHTML = `
                        <div class="flex items-center">
                            <i data-feather="message-circle" class="mr-2 h-6 w-6 text-gray-500"></i>
                            <span class="text-gray-700">${topic.name}</span>
                        </div>
                        <i data-feather="chevron-right" class="h-6 w-6 text-gray-500 transition-transform duration-300"></i>
                    `;

                            topicList.appendChild(listItem);

                            // Event listener for accordion behavior
                            listItem.addEventListener('click', function() {
                                if (listItem.getAttribute('data-clickable') === 'true') {
                                    // Hide currently active item smoothly
                                    if (activeItem && activeItem !== listItem) {
                                        activeItem.querySelector(
                                                'i[data-feather="chevron-right"]').classList
                                            .remove('rotate-90');
                                        activeItem.nextElementSibling.style.maxHeight = '0px';
                                        activeItem.nextElementSibling.style.opacity = '0';
                                        setTimeout(() => {
                                            activeItem.nextElementSibling.classList.add(
                                                'hidden');
                                        }, 500);
                                    }

                                    // Toggle the clicked item
                                    const contentDiv = listItem.nextElementSibling;
                                    if (contentDiv.classList.contains('hidden')) {
                                        contentDiv.classList.remove('hidden');
                                        setTimeout(() => {
                                            contentDiv.style.maxHeight = contentDiv
                                                .scrollHeight + 'px';
                                            contentDiv.style.opacity = '1';
                                        }, 10); // Ensure smooth show transition

                                        // Mengubah lebar menjadi penuh (100%)
                                        topicList.classList.remove('w-80');
                                        topicList.classList.add('w-full');

                                        listItem.querySelector(
                                                'i[data-feather="chevron-right"]').classList
                                            .add('rotate-90');
                                        activeItem = listItem;
                                    } else {
                                        // Hide the content smoothly
                                        contentDiv.style.maxHeight = '0px';
                                        contentDiv.style.opacity = '0';
                                        setTimeout(() => {
                                            contentDiv.classList.add('hidden');
                                        }, 500);

                                        // Mengembalikan ke ukuran awal (w-80)
                                        topicList.classList.remove('w-full');
                                        topicList.classList.add('w-80');

                                        listItem.querySelector(
                                                'i[data-feather="chevron-right"]').classList
                                            .remove('rotate-90');
                                        activeItem = null;
                                    }
                                }

                                // Replace feather icons after rotation
                                feather.replace();
                            });

                            // Content container (hidden by default)
                            const contentDiv = document.createElement('div');
                            contentDiv.classList.add('hidden', 'bg-gray-50', 'p-4', 'rounded-lg',
                                'mt-2', 'transition-all', 'duration-500', 'ease-in-out',
                                'opacity-0', 'max-h-0', 'overflow-hidden');
                            contentDiv.innerHTML = `
                        <h4 class="text-lg font-semibold mb-2">${topic.information ? topic.information.title : 'No information available'}</h4>
                        <p>${topic.information ? topic.information.content : 'No content available for this topic.'}</p>
                    `;

                            topicList.appendChild(contentDiv);
                        });

                        // Replace feather icons after content load
                        feather.replace();
                    })
                    .catch(function(error) {
                        console.error('Error fetching topics:', error);
                    });
            }

            // Initial fetch call to load topics
            fetchTopics();
        });
    </script>
@endsection
