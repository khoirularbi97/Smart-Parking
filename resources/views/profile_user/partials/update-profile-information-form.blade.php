<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <!-- UID -->
        <div class="mb-4">
            <x-input-label for="uid" :value="__('UID')" />
            <span class="text-red-500">*</span>
            <x-text-input id="uid" class="block mt-1 w-full bg-gray-100" type="text" name="uid" :value="old('uid', $user->uid)" readonly />
            <x-input-error :messages="$errors->get('uid')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
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
</section>
