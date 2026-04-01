@php
    $route = Route::currentRouteName();
@endphp

<div class="flex items-center gap-8 p-4 px-10 bg-white">
    <a href="{{ route('admin.mail.inbox') }}" class="text-sm {{ $route == 'admin.mail.inbox' ? 'text-primary font-medium' : 'text-slate-600' }}">
        Inbox
    </a>
    <a href="{{ route('admin.mail.outbox') }}" class="text-sm {{ $route == 'admin.mail.outbox' ? 'text-primary font-medium' : 'text-slate-600' }}">
        Outbox
    </a>
    <div class="flex grow"></div>
    @if ($route != "admin.mail.compose")
        <a href="{{ route('admin.mail.compose') }}" class="flex items-center gap-2 font-medium text-sm text-white bg-primary rounded-lg p-2 px-3">
            <ion-icon name="create-outline" class="text-lg"></ion-icon>
            Tulis
        </a>
    @endif
</div>