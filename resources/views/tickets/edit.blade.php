<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight">
            {{ __('Create a ticket') }}
        </h2>
    </x-slot>

    <section class="px-6">
        <main class="max-w-lg mx-auto mt-10">

            <form method="POST" action="/updated/{{ $ticket->title }}">
                @csrf

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                            for="title">
                            Title
                    </label>

                    <input class="border border-gray-400 outline-none focus:outline-none p-2 w-full"
                            type="text" name="title" id="title" value="{{ $ticket->title }}" required
                            @if (auth()->user()->role == 'technician')
                                readonly
                            @endif>


                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <div class="mb-6">
                    <label class="py-10 mb-2 uppercase font-bold text-xs text-gray-700"
                            for="description">
                            Description
                    </label>

                    <textarea class="border-gray-400 w-full"
                            type="text" name="description" id="description" required>{{ $ticket->description }}</textarea>

                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                            for="client_name">
                            Client name
                    </label>

                    <input class="border border-gray-400 p-2 w-full"
                            type="text" name="client_name" id="client_name" value="{{ $ticket->client->name }}" required
                            @if (auth()->user()->role == 'technician')
                                readonly
                            @endif>


                    @error('client_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                            for="client_email">
                            Client email
                    </label>

                    <input class="border border-gray-400 p-2 w-full"
                            type="email" name="client_email" id="client_email" value="{{ $ticket->client->email }}" required
                            @if (auth()->user()->role == 'technician')
                                readonly
                            @endif>

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <div class="mb-6">
                    <label class="mb-2 uppercase font-bold text-xs text-gray-700"
                            for="technician">
                            Assigned technicians
                    </label>

                    @if (auth()->user()->role == 'agent')
                        <select class="border border-gray-400 p-2 w-full"
                                name="technicians[]" id="myselect" multiple="multiple" required>
                                @foreach ($technicians as $technician)
                                    <option value="{{ $technician->id }}" selected>{{ $technician->name }}</option>
                                @endforeach
                                @foreach ($others as $other)
                                    <option value="{{ $other->id }}">{{ $other->name }}</option>
                                @endforeach
                        </select>
                    @else
                        <ul class="list-disc list-inside">
                            @foreach ($technicians as $technician)
                                    <li>{{ $technician->name }}</li>
                                    <input type="hidden" name="technicians" value="{{ $technician->id }}">
                            @endforeach
                        </ul>
                    @endif

                </div>

                <div class="mb-6">
                    <label class="mb-2 uppercase font-bold text-xs text-gray-700"
                        for="status">
                        Status:
                    </label><br>

                    <input type="radio" name="status" id="status" value="Open" class="ml-4"
                        @if ($ticket->status->status == 'Open')
                            checked
                        @endif
                    />
                    <label for="status">Open</label>

                    <input type="radio" name="status" id="status" value="Pending" class="ml-4"
                        @if ($ticket->status->status == 'Pending')
                            checked
                        @endif
                    />
                    <label for="status">Pending</label>

                    <input type="radio" name="status" id="status" value="Closed" class="ml-4"
                        @if ($ticket->status->status == 'Closed')
                            checked
                        @endif
                    />
                    <label for="status">Closed</label>
                </div>

                <div class="mb-6 text-center">
                    <button type="submit"
                            class="bg-green-500 text-white rounded py-2 px-4 hover:bg-green-400">
                            Submit
                    </button>
                </div>

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </form>
        </main>
    </section>
    <a href="{{ url('/dashboard') }}"><button class="fixed bg-sky-400 text-white py-2 px-4 rounded-xl bottom-3 left-3">Back</button></a>
</x-app-layout>
