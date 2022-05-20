<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex justify-between">
                    <span class="bg-white border-gray-200 mt-2">
                        Create new ticket
                    </span>
                    <button class="bg-green-500 text-white rounded py-2 px-4 hover:bg-green-400">
                        <a href="/create">Create</a>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-flash-message />

</x-app-layout>
