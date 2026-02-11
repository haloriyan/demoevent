@extends('layouts.auth_booth')

@section('title', "Login Booth")
    
@section('content')
@extends('layouts.auth')

@section('title', "Login Administrator")
    
@section('content')

<form action="#" method="POST" class="p-8 bg-white rounded-lg border-[0.1px] border-[#eeeeee] flex flex-col gap-4">
    @csrf

    <div class="flex flex-col gap-2">
        <div class="text-xs">Username</div>
        <input type="text" name="username" class="w-full h-12 border outline-0 px-4 text-sm text-slate-600 rounded-lg" value="oncomedica" required>
    </div>

    <div class="flex flex-col gap-2">
        <div class="text-xs">Password</div>
        <input type="text" name="password" class="w-full h-12 border outline-0 px-4 text-sm text-slate-600 rounded-lg" value="123456" required>
    </div>

    @include('partials.flash_message')

    <button class="w-full h-14 rounded-lg text-sm text-white font-medium bg-blue-950 mt-4">
        Login
    </button>
</form>

@endsection
@endsection