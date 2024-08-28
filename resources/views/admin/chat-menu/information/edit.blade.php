@extends('admin.layouts.layout')

@section('content')
    <div class="bg-indigo-600 px-8 pt-10 lg:pt-14 pb-16 flex justify-between items-center mb-3">
        <!-- title -->
        <h1 class="text-xl text-white">Edit Informasi</h1>
    </div>
    <div class="mx-6 my-6">
        <div class="card h-full shadow">
            <div class="border-b border-gray-300 px-5 py-4">
                <h4>Form Edit Informasi</h4>
            </div>
            <div class="p-6">
                <form action="{{ route('information.update', $information->id) }}" method="POST" id="edit-form">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700">Judul Informasi</label>
                        <input type="text" id="title" name="title"
                            class="w-full border border-gray-300 p-2 rounded-md @error('title') border-red-500 @enderror"
                            value="{{ old('title', $information->title) }}" required>
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="topic_id" class="block text-gray-700">Topik</label>
                        <select id="topic_id" name="topic_id"
                            class="w-full border border-gray-300 p-2 rounded-md @error('topic_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Topik</option>
                            @foreach ($topics as $topic)
                                <option value="{{ $topic->id }}"
                                    {{ $information->topic_id == $topic->id ? 'selected' : '' }}>
                                    {{ $topic->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('topic_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block text-gray-700">Konten Informasi</label>
                        <textarea id="content" name="content"
                            class="w-full border border-gray-300 p-2 rounded-md @error('content') border-red-500 @enderror" required>{{ old('content', $information->content) }}</textarea>
                        @error('content')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
                    <a href="{{ route('chat-menu') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        var uploadImageCK = "{{ route('information.upload') }}?_token={{ csrf_token() }}";

        $(document).ready(function() {
            // CKEditor Initialization
            CKEDITOR.ClassicEditor.create(document.querySelector('#content'), {
                toolbar: {
                    items: [
                        "findAndReplace", "selectAll", "|",
                        "heading", "|",
                        "fontSize", "fontFamily", "fontColor", "fontBackgroundColor", "highlight", "|",
                        "bulletedList", "numberedList", "todoList", "|",
                        "outdent", "indent", "|",
                        "undo", "redo", "|",
                        "specialCharacters", "horizontalLine", "|",
                        "link", "insertImage", "blockQuote", "insertTable", "mediaEmbed",
                        "-",
                        "alignment", "|",
                        "bold", "italic", "strikethrough", "underline", "code", "subscript",
                        "superscript",
                        "removeFormat", "|",
                        "exportPDF", "exportWord", "|",
                    ],
                    shouldNotGroupWhenFull: true
                },
                removePlugins: [
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    'MathType',
                    'WebSocketGateway'
                ],
                ckfinder: {
                    uploadUrl: uploadImageCK,
                    options: {
                        resourceType: 'Images'
                    }
                },
                mediaEmbed: {
                    previewsInData: true
                }
            }).then(editor => {
                editor.ui.view.editable.element.style.minHeight = "200px";
                editor.ui.view.editable.element.style.borderBottomLeftRadius = "15px";
                editor.ui.view.editable.element.style.borderBottomRightRadius = "15px";
                editor.ui.view.editable.element.closest('.ck-editor').style.borderRadius = "15px";

                // Update the textarea with CKEditor content on form submission
                $('#edit-form').on('submit', function(e) {
                    const content = editor.getData();
                    if (content.trim() === '') {
                        alert('Konten tidak boleh kosong.');
                        e.preventDefault(); // Prevent form submission if content is empty
                    } else {
                        $('#content').val(content); // Transfer CKEditor data to textarea
                    }
                });
            }).catch(error => {
                console.error(error);
            });
        });
    </script>
    <style>
        .ck-editor__editable {
            border-bottom-left-radius: 15px !important;
            border-bottom-right-radius: 15px !important;
            min-height: 200px;
        }

        .ck-toolbar {
            background: #F2F4F7 !important;
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
        }
    </style>
@endsection
