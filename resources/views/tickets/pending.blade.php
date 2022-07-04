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

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (auth()->user()->role == 'agent')
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2 mb-2 ml-3">
                    Tickets awaiting approval:
                </h2>
            @else
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2 mb-2 ml-3">
                    Open tickets:
                </h2>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                @if (! $tickets->count())
                    <p class="w-full bg-teal-300 text-center px-2 py-2 border-teal-400"> You have no tickets to show. </p>
                @else
                    <div class="table w-full">
                        <div class="table-header-group">
                            <div class="table-row bg-teal-300 border-teal-400">
                                <div class="table-cell text-center py-2">@sortablelink('title', 'Title')</div>
                                <div class="table-cell text-center py-2">@sortablelink('client.name', 'Client')</div>
                                <div class="table-cell text-center py-2">@sortablelink('updated_at', 'Updated')</div>
                                <div class="table-cell text-center py-2">Inspect</div>
                            </div>
                        </div>
                        <div class="table-row-group">
                            @foreach($tickets as $ticket)
                                <div class="table-row">
                                    <div class="table-cell text-center py-2">{{ $ticket->title }}</div>
                                    <div class="table-cell text-center py-2"><a href="/dashboard/?client={{ $ticket->client->name }} && {{ http_build_query(request()->except('client', 'page')) }}">{{ $ticket->client->name }}</a></div>
                                    <div class="table-cell text-center py-2">{{ substr($ticket->updated_at, 0, 10) }}</div>
                                    <div class="table-cell text-center py-2"><a href="/view/{{ $ticket->title }}"><button class="bg-teal-500 text-white rounded-full border-4 border-teal-500">Open</button></a></div>
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

</x-app-layout>
