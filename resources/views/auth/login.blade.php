@extends('layouts.layout')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-body-bg">
        <div class="bg-container shadow-lg rounded-lg p-8 max-w-md w-full">
            <h2 class="text-title text-center text-2xl font-bold mb-6">Login to Your Account</h2>

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-text mb-2">Email Address</label>
                    <input type="email" name="email" id="email"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-first-primary focus:border-transparent"
                        required>
                    <span class="text-sm text-red-600" id="emailError"></span>
                </div>

                <div class="mb-6 relative">
                    <label for="password" class="block text-text mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-first-primary focus:border-transparent"
                            required>
                        <span class="text-sm text-red-600" id="passwordError"></span>
                        <span
                            class="absolute inset-y-0 right-0 pr-3 top-1/2 -translate-y-1/2 h-fit flex items-center cursor-pointer"
                            id="togglePassword">
                            <i data-feather="eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="text-first-primary focus:ring-0">
                        <label for="remember" class="ml-2 text-text">Remember Me</label>
                    </div>
                    <a href="#" class="text-second-primary hover:text-second-primary-dark">Forgot Password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-second-primary text-default-white p-3 rounded-lg hover:bg-second-primary-dark transition duration-300">
                    Login
                </button>
            </form>

            <p class="mt-6 text-center text-text">Don't have an account? <a href="{{ route('register') }}"
                    class="text-second-primary hover:text-second-primary-dark">Sign Up</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                eyeIcon.setAttribute('data-feather', type === 'password' ? 'eye' : 'eye-off');
                feather.replace(); // Re-render the icon
            });

            // Simple form validation
            const loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', function(e) {
                let valid = true;

                const email = document.getElementById('email');
                const emailError = document.getElementById('emailError');
                if (!email.value) {
                    emailError.textContent = 'Email is required.';
                    valid = false;
                } else if (!email.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    emailError.textContent = 'Please enter a valid email address.';
                    valid = false;
                } else {
                    emailError.textContent = '';
                }

                const password = document.getElementById('password');
                const passwordError = document.getElementById('passwordError');
                if (!password.value) {
                    passwordError.textContent = 'Password is required.';
                    valid = false;
                } else if (password.value.length < 6) {
                    passwordError.textContent = 'Password must be at least 6 characters long.';
                    valid = false;
                } else {
                    passwordError.textContent = '';
                }

                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
