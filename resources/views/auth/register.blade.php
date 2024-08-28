@extends('layouts.layout')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-body-bg">
        <div class="bg-container shadow-lg rounded-lg p-8 max-w-lg w-full">
            <h2 class="text-title text-center text-2xl font-bold mb-6">Create Your Account</h2>

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" id="registerForm">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-text mb-2">Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-first-primary focus:border-transparent"
                        required>
                    <span class="text-sm text-red-600" id="nameError"></span>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-text mb-2">Email Address</label>
                    <input type="email" name="email" id="email"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-first-primary focus:border-transparent"
                        required>
                    <span class="text-sm text-red-600" id="emailError"></span>
                </div>

                <div class="mb-4 relative">
                    <label for="password" class="block text-text mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-first-primary focus:border-transparent"
                            required>
                        <span class="text-sm text-red-600" id="passwordError"></span>
                        <span
                            class="absolute inset-y-0 right-0 top-1/2 -translate-y-1/2 pr-3 flex items-center cursor-pointer"
                            id="togglePassword">
                            <i data-feather="eye" id="eyeIconPassword"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-4 relative">
                    <label for="password_confirmation" class="block text-text mb-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-first-primary focus:border-transparent"
                            required>
                        <span class="text-sm text-red-600" id="confirmPasswordError"></span>
                        <span
                            class="absolute inset-y-0 right-0 top-1/2 -translate-y-1/2 pr-3 flex items-center cursor-pointer"
                            id="toggleConfirmPassword">
                            <i data-feather="eye" id="eyeIconConfirmPassword"></i>
                        </span>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-second-primary text-default-white p-3 rounded-lg hover:bg-second-primary-dark transition duration-300">
                    Register
                </button>
            </form>

            <p class="mt-6 text-center text-text">Already have an account? <a href="{{ route('login') }}"
                    class="text-second-primary hover:text-second-primary-dark">Login</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const eyeIconPassword = document.getElementById('eyeIconPassword');

            const confirmPasswordField = document.getElementById('password_confirmation');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const eyeIconConfirmPassword = document.getElementById('eyeIconConfirmPassword');

            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                eyeIconPassword.setAttribute('data-feather', type === 'password' ? 'eye' : 'eye-off');
                feather.replace(); // Re-render the icon
            });

            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordField.setAttribute('type', type);
                eyeIconConfirmPassword.setAttribute('data-feather', type === 'password' ? 'eye' :
                'eye-off');
                feather.replace(); // Re-render the icon
            });

            const registerForm = document.getElementById('registerForm');

            // Real-time validation
            document.getElementById('email').addEventListener('input', function() {
                const emailError = document.getElementById('emailError');
                if (!this.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    emailError.textContent = 'Please enter a valid email address.';
                } else {
                    emailError.textContent = '';
                }
            });

            document.getElementById('name').addEventListener('input', function() {
                const nameError = document.getElementById('nameError');
                if (this.value.length < 3) {
                    nameError.textContent = 'Name must be at least 3 characters long.';
                } else {
                    nameError.textContent = '';
                }
            });

            passwordField.addEventListener('input', function() {
                const passwordError = document.getElementById('passwordError');
                if (this.value.length < 8) {
                    passwordError.textContent = 'Password must be at least 8 characters long.';
                } else {
                    passwordError.textContent = '';
                }
            });

            confirmPasswordField.addEventListener('input', function() {
                const confirmPasswordError = document.getElementById('confirmPasswordError');
                if (this.value !== passwordField.value) {
                    confirmPasswordError.textContent = 'Passwords do not match.';
                } else {
                    confirmPasswordError.textContent = '';
                }
            });

            registerForm.addEventListener('submit', function(e) {
                const email = document.getElementById('email');
                const emailError = document.getElementById('emailError');
                const name = document.getElementById('name');
                const nameError = document.getElementById('nameError');
                const password = document.getElementById('password');
                const passwordError = document.getElementById('passwordError');
                const confirmPassword = document.getElementById('password_confirmation');
                const confirmPasswordError = document.getElementById('confirmPasswordError');

                let valid = true;

                if (!email.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    emailError.textContent = 'Please enter a valid email address.';
                    valid = false;
                } else {
                    emailError.textContent = '';
                }

                if (name.value.length < 3) {
                    nameError.textContent = 'Name must be at least 3 characters long.';
                    valid = false;
                } else {
                    nameError.textContent = '';
                }

                if (password.value.length < 8) {
                    passwordError.textContent = 'Password must be at least 8 characters long.';
                    valid = false;
                } else {
                    passwordError.textContent = '';
                }

                if (password.value !== confirmPassword.value) {
                    confirmPasswordError.textContent = 'Passwords do not match.';
                    valid = false;
                } else {
                    confirmPasswordError.textContent = '';
                }

                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
