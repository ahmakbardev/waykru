@extends('admin.layouts.layout')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-semibold text-gray-800 mt-10">Chat with Users</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-8">
            @foreach ($users as $user)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-700">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>
                    <div class="p-4 border-t border-gray-200">
                        <a href="{{ route('chat.detail', $user->id) }}"
                            class="text-blue-500 hover:text-blue-700 view-chat">
                            View Chat
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
