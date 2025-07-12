<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <!-- UID-->
        <div>
            <x-input-label for="uid" :value="__('UID')" />
            <x-text-input id="uid" class="block mt-1 w-full bg-gray-100" type="text" name="uid" :value="old('uid')" autofocus autocomplete="uid" readonly/>
            <x-input-error :messages="$errors->get('uid')" class="mt-2" />
        </div>
        <!-- TELEPON -->
        <div>
            <x-input-label for="telepon" :value="__('Telepon')" />
            <x-text-input id="telepon" class="block mt-1 w-full" type="text" name="telepon" :value="old('telepon')" autofocus autocomplete="telepon" />
            <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
        </div>
        <!-- Alamat -->
        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" autofocus autocomplete="alamat" />
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    @push('scripts')
                <script>
                    // Script untuk toggle password 
                    function togglePassword() {
                        const input = document.getElementById('password');
                        input.type = input.type === 'password' ? 'text' : 'password';
                    }
                 const ws = new WebSocket("wss://scurebot.cloud/ws/"); // ganti jika ws lokal: ws://localhost:5000

                    ws.onopen = () => {
                        console.log("✅ WebSocket frontend terhubung.");
                    };

                  ws.onmessage = (event) => {
                    console.log("📨 Pesan masuk:", event.data);

                    try {
                        const data = JSON.parse(event.data);

                        if (data.type === "uid_scanned" && data.uid) {
                            const inputUID = document.getElementById("uid");
                            if (inputUID) {
                                inputUID.value = data.uid;
                                console.log("✅ UID dimasukkan:", data.uid);
                            } else {
                                console.warn("⚠️ Input UID tidak ditemukan.");
                            }
                        } else {
                            console.warn("⚠️ Format data tidak dikenali:", data);
                        }
                    } catch (e) {
                        console.error("❌ Gagal parsing JSON:", e, event.data);
                    }
                };


                    ws.onerror = (e) => console.error("❌ WebSocket error:", e);

                </script>
                @endpush
</x-guest-layout>
