@php
    $route = Route::currentRouteName();
@endphp

<div class="flex items-center gap-8 p-4 px-10 bg-white">
    <a href="{{ route('admin.checkin.registrasi') }}" class="text-sm {{ $route == 'admin.checkin.registrasi' ? 'text-primary font-medium' : 'text-slate-600' }}">
        Registrasi
    </a>
    <a href="{{ route('admin.checkin.booth') }}" class="text-sm {{ $route == 'admin.checkin.booth' ? 'text-primary font-medium' : 'text-slate-600' }}">
        Booth
    </a>
    <div class="flex grow"></div>
    @if ($route == 'admin.checkin.booth')
        <select name="booth_id" id="booth_id" class="text-xs text-slate-600 border rounded-lg outline-0 px-4 h-10" onchange="addFilter('booth_id', this.value)">
            <option value="">Semua Booth</option>
            @foreach ($booths as $boo)
                <option value="{{ $boo->id }}" {{ $request->booth_id == $boo->id ? "selected='selected'" : "" }}>{{ $boo->name }}</option>
            @endforeach
        </select>
    @endif
    <a href="?download=1" class="flex items-center gap-2 font-medium text-sm text-white bg-green-500 rounded-lg p-2 px-3">
        <ion-icon name="download-outline" class="text-lg"></ion-icon>
        Excel
    </a>
</div>