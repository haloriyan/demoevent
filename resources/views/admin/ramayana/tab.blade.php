@php
    $route = Route::currentRouteName();
@endphp

<div class="flex items-center gap-8 p-4 px-10 bg-white">
    <a href="{{ route('admin.ramayana.index') }}" class="text-sm {{ $route == 'admin.ramayana.index' ? 'text-primary font-medium' : 'text-slate-600' }}">
        Transaksi
    </a>
    <a href="{{ route('admin.ramayana.settings') }}" class="text-sm {{ $route == 'admin.ramayana.settings' ? 'text-primary font-medium' : 'text-slate-600' }}">
        Pengaturan
    </a>
    <div class="flex grow"></div>
    @if ($route == 'admin.ramayana.index')
        <a href="?download=1" class="flex items-center gap-2 font-medium text-sm text-white bg-green-500 rounded-lg p-2 px-3 cursor-pointer hover:bg-green-600">
            <ion-icon name="download-outline" class="text-lg"></ion-icon>
            Excel
        </a>
    @endif
</div>