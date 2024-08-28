<!-- resources/views/layouts/components/toast.blade.php -->
@if (session('success') || session('error') || $errors->any())
    <div id="toast"
        class="fixed top-16 right-5 bg-opacity-90 rounded-md shadow-lg px-5 py-3 z-50 
        transform transition-all duration-500 ease-in-out
        {{ session('success') ? 'bg-green-500 text-white' : '' }} 
        {{ session('error') ? 'bg-red-500 text-white' : '' }} 
        {{ $errors->any() ? 'bg-red-500 text-white' : '' }}">

        @if (session('success'))
            <p class="text-lg font-medium pr-4">{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p class="text-lg font-medium pr-4">{{ session('error') }}</p>
        @endif

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-lg font-medium pr-4">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <button id="closeToast" class="absolute top-1/2 -translate-y-1/2 right-1 text-lg">
            <i data-feather="x"></i>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toast');
            const closeToast = document.getElementById('closeToast');

            // Apply initial styles for smooth entry
            toast.classList.add('opacity-0', 'translate-y-4', 'scale-95', 'blur-sm');
            setTimeout(() => {
                toast.classList.remove('opacity-0', 'translate-y-4', 'scale-95', 'blur-sm');
            }, 200); // Small delay to trigger the transition

            // Close the toast when the close button is clicked
            closeToast.addEventListener('click', function() {
                hideToast();
            });

            // Automatically close the toast after 5 seconds with a 2-second delay
            setTimeout(() => {
                hideToast();
            }, 5000);

            function hideToast() {
                // Apply exit transition
                toast.classList.add('opacity-0', 'translate-y-4', 'scale-95', 'blur-sm');
                setTimeout(() => {
                    toast.style.display = 'none';
                }, 500); // Match this duration with Tailwind's duration-500
            }
        });
    </script>
@endif
