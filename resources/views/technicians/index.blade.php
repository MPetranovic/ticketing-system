<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center">
            <div class="rounded-xl">
                <form method="GET" action="#">
                    {{-- @if (request('client'))
                        <input type="hidden" name="client" value="{{ request('client') }}">
                    @endif --}}
                    <input type="text" name="search" placeholder="Search the database..."
                           class="text-center border-none outline-none bg-transparent placeholder-black font-semibold text-xl"
                           value="{{ request('search') }}">
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2 mb-2 ml-3">
                List of technicians:
            </h2>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                @if (! $technicians->count())
                    <p class="w-full bg-violet-300 text-center px-2 py-2 border-violet-400"> There are no technicians. </p>
                @else
                    <div class="table w-full">
                        <div class="table-header-group">
                            <div class="table-row bg-violet-300 border-violet-400">
                                <div class="table-cell text-center py-2">@sortablelink('name', 'Name')</div>
                                <div class="table-cell text-center py-2">@sortablelink('email', 'Email')</div>
                                <div class="table-cell text-center py-2">@sortablelink('created_at', 'Registered')</div>
                                <div class="table-cell text-center py-2">Number of tickets</div>
                                <div class="table-cell text-center py-2">Inspect</div>
                            </div>
                        </div>
                        <div class="table-row-group">
                            @foreach($technicians as $technician)
                                <div class="table-row">
                                    <div class="table-cell text-center py-2">{{ $technician->name }}</div>
                                    <div class="table-cell text-center py-2">{{ $technician->email }}</div>
                                    <div class="table-cell text-center py-2">{{ substr($technician->created_at, 0, 10) }}</div>
                                    <div class="table-cell text-center py-2">{{ $technician->technician_tickets->count() }}</div>
                                    <div class="table-cell text-center py-2"><a href="/technicians/{{ $technician->name }}"><button class="bg-violet-500 text-white rounded-full border-4 border-violet-500">Open</button></a></div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                @endif

            </div>
            <div class="mt-4">
                {!! $technicians->appends(\Request::except('page'))->render() !!}
            </div>
        </div>
    </div>

    <x-flash-message />

</x-app-layout>
