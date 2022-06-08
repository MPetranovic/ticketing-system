<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center">
            <div class="rounded-xl">
                <form method="GET" action="#">
                    @if (request('client'))
                        <input type="hidden" name="client" value="{{ request('client') }}">
                    @endif
                    <input type="text" name="search" placeholder="Search the database..."
                           class="text-center border-none outline-none bg-transparent placeholder-black font-semibold text-xl"
                           value="{{ request('search') }}">
                </form>
            </div>
        </div>
    </x-slot>

    @if (auth()->user()->role == 'agent')
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex justify-between">
                    <span class="bg-white border-gray-200 mt-2">
                        New ticket
                    </span>
                    <a href="/create">
                        <button class="bg-green-500 text-white rounded py-2 px-4 hover:bg-green-400">
                            Create
                        </button>
                        {{-- Animacija za kasnije
                        <span class="flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-sky-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
                        </span> --}}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-3">
                List of tickets:
            </h2>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                @if (! $tickets->count())
                    <p class="w-full bg-sky-300 text-center px-2 py-2 border-sky-400"> You have no tickets to show. </p>
                @else
                    <div class="table w-full">
                        <div class="table-header-group">
                            <div class="table-row bg-sky-300 border-sky-400">
                                <div class="table-cell text-center py-2">Title</div>
                                <div class="table-cell text-center py-2">Client</div>
                                <div class="table-cell text-center py-2">Created</div>
                                <div class="table-cell text-center py-2">Status</div>
                                <div class="table-cell text-center py-2">Inspect</div>
                            </div>
                        </div>
                        <div class="table-row-group">
                            @foreach($tickets as $ticket)
                                <div class="table-row">
                                    <div class="table-cell text-center py-2">{{ $ticket->title }}</div>
                                    <a href="/dashboard/?client={{ $ticket->client->name }} && {{ http_build_query(request()->except('client', 'page')) }}">
                                        <div class="table-cell text-center py-2">{{ $ticket->client->name }}</div>
                                    </a>
                                    <div class="table-cell text-center py-2">{{ substr($ticket->created_at, 0, 10) }}</div>
                                    <div class="table-cell text-center py-2">{{ $ticket->status->status }}</div>
                                    <div class="table-cell text-center py-2"><a href="/view/{{ $ticket->title }}"><button class="bg-sky-500 text-white rounded-full border-4 border-sky-500">Open</button></a></div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                @endif

            </div>
            <div class="mt-4">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>

    <x-flash-message />

</x-app-layout>
