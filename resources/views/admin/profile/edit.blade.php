@extends('layouts.admin')

@section('title', __('quiz.profile_settings') ?? 'Profile Settings')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white">{{ __('quiz.profile_settings') ?? 'Profile Settings' }}</h1>
    <p class="text-gray-400 text-sm mt-1">{{ __('quiz.update_profile') ?? 'Update your account\'s profile information and standard security.' }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Personal Information --}}
    <div class="glass rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-white mb-4">{{ __('quiz.personal_info') ?? 'Personal Information' }}</h2>
        
        <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">{{ __('quiz.name') ?? 'Name' }}</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200">
                @error('name')
                    <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">{{ __('quiz.email') ?? 'Email' }}</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200">
                @error('email')
                    <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-white/10 my-6">

            <h2 class="text-lg font-semibold text-white mb-4">{{ __('quiz.update_password') ?? 'Update Password' }}</h2>
            <p class="text-xs text-gray-400 mb-4">{{ __('quiz.update_password_hint') ?? 'Ensure your account is using a long, random password to stay secure.' }}</p>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">{{ __('quiz.new_password') ?? 'New Password' }}</label>
                <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200">
                @error('password')
                    <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">{{ __('quiz.confirm_password') ?? 'Confirm Password' }}</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200">
            </div>

            <div class="pt-4">
                <button type="submit" class="px-6 py-3 bg-primary hover:bg-primary-dark text-dark font-bold rounded-xl transition-colors">
                    {{ __('quiz.save_changes') ?? 'Save Changes' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
