<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a class= "flex justify-center"> {{ $ticket->title }} </a>
        </h2>
    </x-slot>

    <x-ticket-modal :ticket="$ticket"/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="text-lg text-indigo-900 mb-4">
                <strong>Created:</strong> {{ $ticket->created_at }}
            </div>

            <div class="text-lg text-indigo-900 mb-4">
                <strong>Client:</strong> <a href="/dashboard/?client={{ $ticket->client->name }}" class="text-indigo-700">{{ $client->name }}</a>
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
                <strong>Assigned technicians:</strong>
                @if (! $technicians->count())
                    <p class="text-xl text-red-500 mt-2">WARNING There are no technicians assigned to this ticket!</p>
                @endif
                <ul class="list-disc list-inside ml-4">
                    @foreach ($technicians as $technician)
                            <li>{{ $technician->name }}</li>
                    @endforeach
                </ul>
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

                <button type="button" data-modal-toggle="popup-modal"
                    class="bg-red-500 text-white py-2 px-4 hover:bg-red-400 rounded-xl">
                    Delete this ticket
                </button></a>


                <a href ="/update/{{ $ticket->title }}"><button class="bg-green-500 text-white py-2 px-4 hover:bg-green-400 rounded-xl">Update</button></a>
            </div>
        </div>
    </div>

    <a href ="{{ url()->previous() }}"><button class="fixed bg-sky-400 text-white py-2 px-4 rounded-xl bottom-3 left-3">Back</button></a>
</x-app-layout>



