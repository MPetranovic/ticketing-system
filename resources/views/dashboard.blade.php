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
    <div class="py-3">
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
                        {{-- Za kasnije
                        <span class="flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-sky-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
                        </span>

                        <span class="relative inline-block">
                                <svg class="w-6 h-6 text-gray-700 fill-current" viewBox="0 0 20 20"><path d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">99</span>
                        </span>

                        <span class="relative inline-block ml-8">
                                <svg class="w-6 h-6 text-gray-700 fill-current" viewBox="0 0 20 20"><path d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                                <span class="absolute top-0 right-0 inline-block w-2 h-2 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
                        </span>

                        --}}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2 mb-2 ml-3">
                All tickets:
            </h2>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                @if (! $tickets->count())
                    <p class="w-full bg-sky-300 text-center px-2 py-2 border-sky-400"> You have no tickets to show. </p>
                @else
                    <div class="table w-full">
                        <div class="table-header-group">
                            <div class="table-row bg-sky-300 border-sky-400">
                                <div class="table-cell text-center py-2">@sortablelink('title', 'Title')</div>
                                <div class="table-cell text-center py-2">@sortablelink('client.name', 'Client')</div>
                                <div class="table-cell text-center py-2">@sortablelink('updated_at', 'Updated')</div>
                                <div class="table-cell text-center py-2">@sortablelink('status.status', 'Status')</div>
                                <div class="table-cell text-center py-2">Inspect</div>
                            </div>
                        </div>
                        <div class="table-row-group">
                            @foreach($tickets as $ticket)
                                <div class="table-row">
                                    <div class="table-cell text-center py-2">{{ $ticket->title }}</div>
                                    <div class="table-cell text-center py-2"><a href="/dashboard/?client={{ $ticket->client->name }} && {{ http_build_query(request()->except('client', 'page')) }}">{{ $ticket->client->name }}</a></div>
                                    <div class="table-cell text-center py-2">{{ substr($ticket->updated_at, 0, 10) }}</div>
                                    <div class="table-cell text-center py-2">{{ $ticket->status->status }}</div>
                                    <div class="table-cell text-center py-2"><a href="/view/{{ $ticket->title }}"><button class="bg-sky-500 text-white rounded-full border-4 border-sky-500">Open</button></a></div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                @endif

            </div>
            <div class="mt-4">
                {!! $tickets->appends(\Request::except('page'))->render() !!}
            </div>
        </div>
    </div>

    <x-flash-message />

</x-app-layout>
