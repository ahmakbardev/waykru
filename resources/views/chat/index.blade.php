@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto my-24 p-4 py-10 bg-container rounded-lg shadow-lg">
        <div class="flex justify-between items-center border-b pb-2 mb-4 border-text">
            <h2 class="text-lg font-semibold text-title">Information Topics</h2>
        </div>

        <div id="topic-list" class="space-y-2 overflow-y-auto" style="height: 400px;">
            <!-- Topics will be loaded via AJAX -->
        </div>

        <!-- Back Button (shown after clicking a topic) -->
        <button id="back-button" class="hidden text-indigo-600 text-sm hover:text-indigo-800 mb-4 flex items-center group">
            <i data-feather="arrow-left"
                class="mr-2 group-hover:mr-3 group-hover:w-8 p-1 aspect-square h-full w-7 group-hover:border group-hover:border-indigo-600 rounded-full transition-all ease-in-out"></i>
            <p>Kembali</p>
        </button>

        <div id="information-detail" class="mt-4 text-gray-700 hidden">
            <div id="information-content" class="w-full px-7">
                <!-- Detailed information will be displayed here -->
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
            const backButton = document.getElementById('back-button');

            // Fetch topics and display them
            function fetchTopics() {
                axios.get('/api/topics')
                    .then(function(response) {
                        response.data.forEach(function(topic) {
                            const listItem = document.createElement('li');
                            listItem.classList.add('cursor-pointer', 'bg-gray-100', 'p-3', 'rounded-lg',
                                'shadow-md', 'hover:bg-indigo-100', 'transition', 'duration-300',
                                'ease-in-out');
                            listItem.setAttribute('data-id', topic.id);
                            listItem.textContent = topic.name;
                            topicList.appendChild(listItem);

                            listItem.addEventListener('click', function() {
                                displayInformation(topic);
                            });
                        });
                    })
                    .catch(function(error) {
                        console.error('Error fetching topics:', error);
                    });
            }

            // Display information for a selected topic
            function displayInformation(topic) {
                if (topic.information) {
                    informationContent.innerHTML = `
                        <h4 class="text-lg font-semibold mb-2">${topic.information.title}</h4>
                        <p>${topic.information.content}</p>
                    `;
                } else {
                    informationContent.innerHTML = `<p>Informasi tidak tersedia untuk topik ini.</p>`;
                }
                informationDetail.classList.remove('hidden');
                topicList.classList.add('hidden');
                backButton.classList.remove('hidden');
            }

            backButton.addEventListener('click', function() {
                informationDetail.classList.add('hidden');
                topicList.classList.remove('hidden');
                backButton.classList.add('hidden');
            });

            fetchTopics();
        });
    </script>
@endsection
