@extends('layouts.admin')

@section('title', __('quiz.system_settings') ?? 'System Settings')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white">{{ __('quiz.system_settings') ?? 'System Settings' }}</h1>
    <p class="text-gray-400 text-sm mt-1">{{ __('quiz.update_system_settings') ?? 'Update the platform name and logo globally.' }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="glass rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-white mb-4">{{ __('quiz.platform_customization') ?? 'Platform Customization' }}</h2>
        
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="site_name" class="block text-sm font-medium text-gray-300 mb-2">{{ __('quiz.platform_name') ?? 'Platform Name' }}</label>
                <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Quizez') }}" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200">
                @error('site_name')
                    <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="logo" class="block text-sm font-medium text-gray-300 mb-2">{{ __('quiz.platform_logo') ?? 'Platform Logo' }}</label>
                
                @if(isset($settings['logo']))
                    <div class="mb-4 bg-dark-lighter p-4 rounded-xl inline-block">
                        <img src="{{ '/files/' . $settings['logo'] }}" alt="Current Logo" class="h-16 object-contain">
                    </div>
                @endif
                
                <input type="file" name="logo" id="logo" accept="image/*"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200">
                <p class="mt-2 text-xs text-gray-400">{{ __('quiz.logo_hint') ?? 'Leave empty to keep the current logo. Allowed types: png, jpg, svg.' }}</p>
                @error('logo')
                    <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                @enderror
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
