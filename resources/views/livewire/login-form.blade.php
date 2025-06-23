<div class="flex items-center justify-center min-h-screen px-4 transition-colors duration-300 
    bg-gradient-to-tr from-rose-100 via-blue-100 to-violet-100
    dark:bg-gradient-to-tr dark:from-gray-900 dark:via-gray-800 dark:to-gray-950">

    <div class="w-full max-w-md bg-white/80 dark:bg-gray-800 backdrop-blur-md shadow-2xl 
        rounded-3xl px-10 py-12 border border-white/40 dark:border-gray-700 transition-all duration-300">

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="text-5xl">🐣💫</div>
            <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white mt-4">Welcome Back 🎉</h2>
            <p class="text-gray-500 dark:text-gray-300 text-sm mt-1">Start your adventure today!</p>
        </div>

        <!-- Flash messages -->
        @if (session()->has('message'))
            <div class="mb-4 text-green-600 dark:text-green-400 text-center font-medium">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-4 text-red-600 dark:text-red-400 text-center font-medium">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form -->
        <form wire:submit.prevent="login" class="space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">📧 Email</label>
                <div class="relative">
                    <input wire:model.lazy="email" type="email" id="email"
                        class="w-full pl-11 pr-4 py-3 rounded-xl border 
                        bg-white/70 dark:bg-gray-700 dark:text-white 
                        border-pink-200 dark:border-pink-600 
                        focus:ring-2 focus:ring-pink-300 dark:focus:ring-pink-500 
                        focus:outline-none shadow-inner transition" 
                        placeholder="you@example.com" />
                    <div class="absolute inset-y-0 left-3 flex items-center text-pink-400 dark:text-pink-300 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m0 0v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                        </svg>
                    </div>
                </div>
                @error('email')
                    <span class="text-sm text-red-500 dark:text-red-400 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">🔒 Password</label>
                <div class="relative">
                    <input wire:model.lazy="password" type="password" id="password"
                        class="w-full pr-12 pl-4 py-3 rounded-xl border 
                        bg-white/70 dark:bg-gray-700 dark:text-white 
                        border-purple-200 dark:border-purple-600 
                        focus:ring-2 focus:ring-purple-300 dark:focus:ring-purple-500 
                        focus:outline-none shadow-inner transition" 
                        placeholder="••••••••" />
                    <button type="button"
                        onclick="togglePassword('password', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 
                        text-purple-600 dark:text-purple-300 hover:text-purple-800 
                        focus:outline-none select-none cursor-pointer text-xl"
                        aria-label="Toggle Password Visibility">
                        👁️
                    </button>
                </div>
                @error('password')
                    <span class="text-sm text-red-500 dark:text-red-400 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full py-3 px-4 rounded-xl text-white text-lg font-semibold shadow-lg 
                bg-gradient-to-r from-pink-400 via-fuchsia-400 to-purple-400 
                dark:from-indigo-700 dark:via-indigo-800 dark:to-indigo-900 
                hover:brightness-110 transition duration-200">
                Sign In
            </button>
        </form>
    </div>

    <!-- Password toggle script -->
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                btn.textContent = "🙈";
            } else {
                input.type = "password";
                btn.textContent = "👁️";
            }
        }
    </script>
</div>
