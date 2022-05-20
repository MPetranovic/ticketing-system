<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight">
            {{ __('Create a ticket') }}
        </h2>
    </x-slot>

    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10">

            <form method="POST" action="/created">
                @csrf

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                            for="title">
                            Title
                    </label>

                    <input class="border border-gray-400 p-2 w-full"
                            type="text" name="title" id="title" value="{{ old('title') }}" required>


                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                            for="description">
                            Description
                    </label>

                    <input class="border border-gray-400 p-2 w-full"
                            type="text" name="description" id="description" value="{{ old('description') }}" required>

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
                            type="text" name="client_name" id="client_name" value="{{ old('client_name') }}" required>


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
                            type="email" name="client_email" id="client_email" value="{{ old('client_email') }}" required>

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <div class="mb-6">
                    <label class="mb-2 uppercase font-bold text-xs text-gray-700"
                            for="technician">
                            Assign technician
                    </label>

                    <select class="border border-gray-400 p-2 w-full"
                            type="email" name="technician" id="technician" required>

                            @foreach ($technicians as $technician)
                                <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                            @endforeach
                    </select>
                </div>


                <div class="mb-6">
                    <button type="submit"
                            class="bg-blue-400 text-black rounded py-2 px-4 hover:bg-blue-500">
                            Submit
                    </button>
                </div>

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </form>
        </main>
    </section>
</x-app-layout>
