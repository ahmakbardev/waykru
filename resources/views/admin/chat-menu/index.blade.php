@extends('admin.layouts.layout')

@section('content')
    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-16 flex justify-between items-center mb-3">
        <!-- title -->
        <h1 class="text-xl text-white">Chat Menu</h1>
    </div>
    <div class="mx-6 my-6 grid grid-cols-1 lg:grid-cols-2 grid-rows-1 grid-flow-row-dense gap-6">
        <!-- Topik Informasi -->
        <div>
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <h4>Topik Informasi</h4>
                    <button id="create-topic-btn"
                        class="btn btn-sm bg-white text-gray-800 border-gray-300 border hover:text-white hover:bg-gray-700 hover:border-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300">
                        Tambah Topik
                    </button>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="text-left w-full whitespace-nowrap">
                        <thead class="text-gray-700">
                            <tr>
                                <th scope="col" class="border-b bg-gray-100 px-6 py-3">Nama Topik</th>
                                <th scope="col" class="border-b bg-gray-100 px-6 py-3">Dibuat</th>
                                <th scope="col" class="border-b bg-gray-100 px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody id="topic-list">
                            @foreach ($topics as $topic)
                                <tr id="topic-{{ $topic->id }}">
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">{{ $topic->name }}
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        {{ $topic->created_at->format('d M Y') }}
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <button class="edit-topic-btn bg-yellow-500 text-white px-2 py-1 rounded-md"
                                            data-id="{{ $topic->id }}" data-name="{{ $topic->name }}">Edit</button>
                                        <button class="delete-topic-btn bg-red-500 text-white px-2 py-1 rounded-md"
                                            data-id="{{ $topic->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Isi Informasi -->
        <div>
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <h4>Isi Informasi</h4>
                    <a href="{{ route('information.create') }}"
                        class="btn btn-sm bg-white text-gray-800 border-gray-300 border hover:text-white hover:bg-gray-700 hover:border-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300">
                        Tambah Informasi
                    </a>
                </div>

                <div class="relative overflow-x-auto">
                    <table class="text-left w-full whitespace-nowrap">
                        <thead class="text-gray-700">
                            <tr>
                                <th scope="col" class="border-b bg-gray-100 px-6 py-3">Nama Informasi</th>
                                <th scope="col" class="border-b bg-gray-100 px-6 py-3">Dibuat</th>
                                <th scope="col" class="border-b bg-gray-100 px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody id="information-list">
                            @foreach ($informations as $information)
                                <tr id="information-{{ $information->id }}">
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        {{ $information->title }}
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        {{ $information->created_at->format('d M Y') }}
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <a href="{{ route('information.edit', $information->id) }}"
                                            class="edit-information-btn bg-yellow-500 text-white px-2 py-1 rounded-md">Edit</a>
                                        <button type="button"
                                            class="delete-information-btn bg-red-500 text-white px-2 py-1 rounded-md"
                                            data-id="{{ $information->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Topik -->
    <div id="topic-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div id="modal-content"
            class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg transform scale-90 opacity-0 blur-sm transition-all duration-300 ease-in-out">
            <h2 id="topic-modal-title" class="text-xl font-semibold mb-4"></h2>
            <form id="topic-modal-form">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Nama Topik</label>
                    <input type="text" id="name" name="name" class="w-full border border-gray-300 p-2 rounded-md"
                        required>
                </div>
                <input type="hidden" id="topic-id">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Simpan</button>
                <button type="button" id="cancel-topic-btn"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div id="delete-modal-content"
            class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg transform scale-90 opacity-0 blur-sm transition-all duration-300 ease-in-out">
            <h2 class="text-xl font-semibold mb-4">Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus item ini?</p>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="mt-4 flex justify-end">
                    <button type="button" id="cancel-delete-btn"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Batal</button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // --- TOPIC MODAL ---
            $('#create-topic-btn').click(function() {
                $('#topic-modal-title').text('Tambah Topik Baru');
                $('#name').val('');
                $('#topic-id').val('');
                openTopicModal();
            });

            $('#topic-list').on('click', '.edit-topic-btn', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                $('#topic-modal-title').text('Edit Topik');
                $('#name').val(name);
                $('#topic-id').val(id);
                openTopicModal();
            });

            $('#topic-modal-form').submit(function(e) {
                e.preventDefault();

                const id = $('#topic-id').val();
                const url = id ? `{{ url('topics') }}/${id}` : `{{ url('topics') }}`;
                const method = id ? 'PUT' : 'POST';
                const formData = $(this).serialize();

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        if (id) {
                            $(`#topic-${id}`).replaceWith(renderTopicRow(response));
                        } else {
                            $('#topic-list').append(renderTopicRow(response));
                        }
                        closeTopicModal();
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });

            // --- DELETE MODAL ---
            // Show delete confirmation modal
            $('#topic-list, #information-list').on('click', '.delete-topic-btn, .delete-information-btn',
                function() {
                    const id = $(this).data('id');
                    const url = $(this).hasClass('delete-topic-btn') ?
                        `{{ route('topics.destroy', ':id') }}`.replace(':id', id) :
                        `{{ route('information.destroy', ':id') }}`.replace(':id', id);

                    $('#delete-form').attr('action', url); // Set action URL for the form
                    openDeleteModal();
                });

            // Handle delete form submission with AJAX
            $('#delete-form').submit(function(e) {
                e.preventDefault();

                const url = $(this).attr('action');

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            // Remove the topic or information from the list
                            const id = url.split('/').pop(); // Extract ID from URL
                            $(`#topic-${id}, #information-${id}`).remove();
                            closeDeleteModal();
                        } else {
                            console.error('Failed to delete');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });

            // Close delete confirmation modal
            $('#cancel-delete-btn').click(function() {
                closeDeleteModal();
            });

            function openDeleteModal() {
                $('#delete-modal').removeClass('hidden');
                setTimeout(function() {
                    $('#delete-modal-content').removeClass('scale-90 opacity-0 blur-sm').addClass(
                        'scale-100 opacity-100 blur-none');
                }, 50);
            }

            function closeDeleteModal() {
                $('#delete-modal-content').removeClass('scale-100 opacity-100 blur-none').addClass(
                    'scale-90 opacity-0 blur-sm');
                setTimeout(function() {
                    $('#delete-modal').addClass('hidden');
                }, 300);
            }

            function openTopicModal() {
                $('#topic-modal').removeClass('hidden');
                setTimeout(function() {
                    $('#modal-content').removeClass('scale-90 opacity-0 blur-sm').addClass(
                        'scale-100 opacity-100 blur-none');
                }, 50);
            }

            $('#cancel-topic-btn').click(function() {
                closeTopicModal();
            });

            function closeTopicModal() {
                $('#modal-content').removeClass('scale-100 opacity-100 blur-none').addClass(
                    'scale-90 opacity-0 blur-sm');
                setTimeout(function() {
                    $('#topic-modal').addClass('hidden');
                }, 300);
            }

            function renderTopicRow(topic) {
                const formattedDate = new Date(topic.created_at).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }).replace(/ /g, ' ');

                return `<tr id="topic-${topic.id}">
                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">${topic.name}</td>
                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">${formattedDate}</td>
                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                        <button class="edit-topic-btn bg-yellow-500 text-white px-2 py-1 rounded-md" data-id="${topic.id}" data-name="${topic.name}">Edit</button>
                        <button class="delete-topic-btn bg-red-500 text-white px-2 py-1 rounded-md" data-id="${topic.id}">Delete</button>
                    </td>
                </tr>`;
            }
        });
    </script>
@endsection
