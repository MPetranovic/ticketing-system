<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a class= "flex justify-center"> {{ $technician->name }} </a>
        </h2>
    </x-slot>

    <x-technician-modal :technician="$technician"/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="text-lg text-fuchsia-900 mb-4">
                <strong>Registered:</strong> {{ $technician->created_at }}
            </div>

            <div class="text-lg text-fuchsia-900 mb-4">
                <strong>Email address:</strong> {{ $technician->email }}
            </div>

            <div class="text-lg text-fuchsia-900 mb-4">
                <strong>Tickets:</strong>
                @if (! $tickets->count())
                    <p class="ml-4"> This technician has no tickets. </p>
                @endif
                <ul class="list-disc list-inside ml-4">
                @foreach ($tickets as $ticket)
                    <li>
                        <a href="/view/{{ $ticket->title }}" class="text-fuchsia-700">{{ $ticket->title }}</a>
                        {{-- <span class="ml-2">Client: <a href="/dashboard/?client={{ $ticket->client->name }}" class="text-purple-700">{{ $ticket->client->name }}</a></span> --}}
                    </li>
                @endforeach
            </div>

            <div class="mb-6 text-center">
                <button type="button" data-modal-toggle="popup-modal" class="bg-red-500 text-white rounded py-2 px-4 hover:bg-red-400">Delete this technician</button></a>
            </div>

        </div>
    </div>
    <a href ="{{ url('/technicians') }}"><button class="fixed bg-sky-400 text-white py-2 px-4 rounded-xl bottom-3 left-3">Back</button></a>
</x-app-layout>



