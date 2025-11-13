<x-guest-layout>
    <a href="/"
        class="fixed left-4 top-6 z-50 inline-flex items-center gap-3 px-4 py-2.5 rounded-full shadow-xl bg-linear-to-r from-indigo-600 to-sky-500 text-white hover:brightness-110 hover:scale-105 transition-transform"
        aria-label="Kembali ke Halaman Utama">

        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M8 .5l6 5V15a1 1 0 0 1-1 1h-3v-4H6v4H3a1 1 0 0 1-1-1V5.5l6-5z" />
        </svg>

        <span class="hidden sm:inline font-medium">Kembali ke Beranda</span>
    </a>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="mt-4 mb-4">
        <h2 class="text-2xl font-bold text-black-900 tracking-wide relative inline-block pb-2">
            Login
            <!-- garis bawah -->
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf


        {{-- NIP --}}
        <div>
            <x-input-label for="nip" :value="__('NIP')" />
            <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip')"
                required autofocus autocomplete="nip" inputmode="numeric" pattern="[0-9]*" maxlength="18"
                oninput="this.value=this.value.replace(/[^0-9]/g,'');" />
            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ showLoginPwd: false }">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                    x-bind:type="showLoginPwd ? 'text' : 'password'" name="password" required
                    autocomplete="current-password" />

                <!-- tombol mata -->
                <button type="button" @click="showLoginPwd = !showLoginPwd"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                    <!-- mata tertutup -->
                    <svg x-show="!showLoginPwd" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    <!-- mata dicoret -->
                    <svg x-show="showLoginPwd" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.284m3.657-2.43A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.3 5.046M3 3l18 18" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded-sm border-gray-300 text-indigo-600 shadow-xs focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
