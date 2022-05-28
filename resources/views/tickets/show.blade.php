<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a class= "flex justify-center"> {{ $ticket->title }} </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="text-lg text-indigo-900 mb-4">
                <strong>Created:</strong> {{ $ticket->created_at }}
            </div>

            <div class="text-lg text-indigo-900 mb-4">
                <strong>Client:</strong> {{ $client->name }}
            </div>

            <div class="text-lg text-indigo-900 mb-4">
                <strong>Contact address:</strong> {{ $client->email }}
            </div>

            <div class="text-lg text-indigo-900">
                <strong>Description:</strong>
            </div>
            <div class="container mx-auto px-4 py-6">
                {{ $ticket->description }}
            </div>


            <div class="text-lg text-indigo-900 mb-4">
                <strong>Assigned technician:</strong> {{ $technician->name }}
            </div>

            <div class="flex justify-between text-lg text-indigo-900 mb-4">
                <strong class="mt-2">Status:
                    @if ($status->status == 'Open')
                        <span class="text-emerald-400">{{ $status->status }}</span>
                    @elseif ($status->status == 'Pending')
                        <span class="text-yellow-400">{{ $status->status }}</span>
                    @else
                        <span class="text-red-400">{{ $status->status }}</span>
                    @endif
                </strong>
                <a href ="/update/{{ $ticket->title }}"><button class="bg-green-400 text-white py-2 px-4 rounded-xl">Update</button></a>
            </div>
        </div>
    </div>

    <a href ="{{ url('/dashboard') }}"><button class="fixed bg-sky-400 text-white py-2 px-4 rounded-xl bottom-3 left-3">Back</button></a>
</x-app-layout>



