<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-2 md:gap-6">


                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="py-3 px-6">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Teams</h3>
                            <p class="mt-1 text-sm text-gray-600">Teams in Regional.</p>
                        </div>
                    </div>
                    @livewire('teams')
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="py-3 px-6">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Match List</h3>
                            <p class="mt-1 text-sm text-gray-600">Match List for Regional.</p>
                        </div>
                    </div>
                    @livewire('teams')
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
