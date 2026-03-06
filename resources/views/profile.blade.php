<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#00f5ff] leading-tight uppercase tracking-widest">
            {{ __('Mi Perfil y Seguridad') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <livewire:profile-avatar />

            <div class="p-4 sm:p-8 bg-[#050814] border border-[#0a192f] shadow-2xl sm:rounded-2xl">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[#050814] border border-[#0a192f] shadow-2xl sm:rounded-2xl">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[#050814] border border-[#ff0055]/30 shadow-2xl sm:rounded-2xl">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
