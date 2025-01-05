<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thank you for signing up! Please verify your email address by entering the OTP code sent to your email. If you did not receive the email or the code has expired, you can request a new one.') }}
    </div>

    @if (session('status') == 'otp-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new OTP code has been sent to the email address you provided during registration. Please check your inbox or spam folder. This code will expire in 10 minutes.') }}
        </div>
    @endif

    <div class="mt-4">
        <form method="POST" action="{{ route('verification.verify') }}" class="mt-4">
            @csrf
            <x-input-label for="otp_code" :value="__('OTP CODE')"/>
            <div class="mb-3 flex w-full items-start">
                <div class="w-full">
                    <x-text-input id="email" class="block mt-1 w-full" type="text" name="otp_code" required autofocus />
                    <x-input-error :messages="$errors->get('otp_code')" class="mt-2" />
                </div>
                <x-primary-button class="ml-4 mt-1 py-3">
                    {{ __('Verify') }}
                </x-primary-button>
            </div>
        </form>
        <form method="POST" action="{{ route('verification.send') }}" class="mb-2">
            @csrf
            <x-primary-button>
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
