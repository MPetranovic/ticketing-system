@if (session()->has('success'))
<div x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 6000)"
        x-show="show"
        class="fixed bg-green-500 text-white py-2 px-4 rounded-xl bottom-3 right-3 text-sm">
        <p>{{ session('success') }}</p>
    </div>
@endif

@if (session()->has('info'))
<div x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 6000)"
        x-show="show"
        class="fixed bg-violet-400 text-white py-2 px-4 rounded-xl bottom-3 right-3 text-sm">
        <p>{{ session('info') }}</p>
    </div>
@endif

@if (session()->has('welcome'))
<div x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 6000)"
        x-show="show"
        class="fixed bg-sky-400 text-white py-2 px-4 rounded-xl bottom-3 right-3 text-sm">
        <p>{{ session('welcome') }}</p>
    </div>
@endif

@if (session()->has('warning'))
<div x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 6000)"
        x-show="show"
        class="fixed bg-red-400 text-white py-2 px-4 rounded-xl bottom-3 right-3 text-sm">
        <p>{{ session('warning') }}</p>
    </div>
@endif

{{--
@if ($message = session()->has('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif --}}
