@extends('layouts.booth')

@section('Profile Booth')
    
@section('content')
<div class="flex items-center gap-4">
    <div class="flex flex-col gap-1 grow">
        <div class="text-xl text-slate-700 font-medium">Profil</div>
    </div>
    <a href="#" class="bg-red-100 text-red-500 text-sm font-medium p-3 px-6 rounded-full flex items-center gap-3">
        <ion-icon name="log-out-outline" class="text-xl"></ion-icon>
        <span class="mobile:hidden">Logout</span>
    </a>
</div>
@endsection