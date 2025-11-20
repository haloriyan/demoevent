@if ($errors->count() > 0)
    @foreach ($errors->all() as $err)
        <div class="bg-red-100 text-red-500 text-sm p-3 px-4 rounded-lg">
            {{ $err }}
        </div>
    @endforeach
@endif

@if ($message != null)
    <div class="bg-green-100 text-green-500 text-sm p-3 px-4 rounded-lg">
        {{ $message }}
    </div>
@endif