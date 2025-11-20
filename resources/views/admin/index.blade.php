@extends('layouts.admin')

@section('title', "Administrator")
    
@section('content')

@php
    $roles = [
        'admin' => 'Akses ke Semua Fitur',
        'panitia' => "Lihat laporan, kirim broadcast",
        'frontliner' => "Absensi / Registrasi peserta"
    ];
@endphp

<div class="p-8 flex flex-col gap-6">
    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-4">
        <form class="border rounded-lg flex items-center grow px-4">
            <input type="text" name="q" class="w-full h-14 text-sm text-slate-500 outline-0" placeholder="Cari...">
            <button class="flex items-center">
                <ion-icon name="search-outline"></ion-icon>
            </button>
        </form>

        <button class="bg-primary text-white text-sm font-medium h-14 px-8 rounded-lg flex items-center gap-2" onclick="toggleHidden('#CreateAdmin')">
            <ion-icon name="add-outline" class="text-xl"></ion-icon>
            Admin
        </button>
    </div>

    <div class="flex items-center gap-1 mt-2">
        <div class="p-3 px-5 rounded-full text-sm cursor-pointer {{ $request->role == '' ? 'bg-primary text-white font-medium' : 'text-primary' }}" onclick="addFilter('role', null)">
            Semua
        </div>
        @foreach ($roles as $r => $role)
            <div class="p-3 px-5 rounded-full text-sm cursor-pointer {{ $request->role == $r ? 'bg-primary text-white font-medium' : 'text-primary' }}" onclick="addFilter('role', '{{ $r }}')">
                {{ ucwords($r) }}
            </div>
        @endforeach
    </div>

    @include('partials.flash_message')

    <div class="overflow-x-auto scrollbar-hide bg-white p-4 shadow-sm rounded-lg">
        <table class=" w-full table-auto border-collapse">
            <thead>
                <tr class="text-left">
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium uppercase tracking-wider border-b border-slate-400">User</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium uppercase tracking-wider border-b border-slate-400">Email</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium uppercase tracking-wider border-b border-slate-400">Role</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium uppercase tracking-wider border-b border-slate-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($admins as $adm)
                    <tr class="hover:bg-slate-200 transition-colors">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-sky-400 flex items-center justify-center text-white font-semibold">
                                    {{ initial($adm->name) }}
                                </div>
                                <div>
                                    <div class="font-medium text-sm text-slate-700">{{ $adm->name }}</div>
                                    {{-- <div class="text-xs text-slate-400">Product & Dev</div> --}}
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-sm text-slate-500">{{ $adm->email }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="bg-primary-transparent text-primary text-xs border border-primary p-1 px-3 rounded-full">{{ strtoupper($adm->role) }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.admins.update', $adm->id) }}" class="p-2 px-3 rounded bg-green-500 text-white flex items-center gap-2 text-xs font-medium" onclick="EditAdmin(event, '{{ $adm }}')">
                                    <ion-icon name="create-outline"></ion-icon>
                                    Edit
                                </a>
                                @if ($adm->id != $me->id)
                                    <a href="{{ route('admin.admins.delete', $adm->id) }}" class="p-2 px-3 rounded bg-red-500 text-white flex items-center gap-2 text-xs font-medium" onclick="DeleteAdmin(event, '{{ $adm }}')">
                                        <ion-icon name="trash-outline"></ion-icon>
                                        Hapus
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('ModalArea')

@include('admin.create')
@include('admin.delete')
@include('admin.edit')

@endsection

@section('javascript')
<script>
    // toggleHidden("#CreateAdmin");

    const chooseRole = (prefix, role) => {
        select(`${prefix} #role`).value = role;
        selectAll(`${prefix} .RoleItem`).forEach(item => item.classList.remove('border-primary'))
        select(`${prefix} #${role}`).classList.add('border-primary');
    }

    const DeleteAdmin = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#DeleteAdmin form").setAttribute('action', link.href);
        select("#DeleteAdmin #name").innerHTML = data.name;
        toggleHidden("#DeleteAdmin");
    }
    const EditAdmin = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;
        select("#EditAdmin form").setAttribute('action', link.href);

        select("#EditAdmin #name").value = data.name;
        select("#EditAdmin #email").value = data.email;
        select("#EditAdmin #role").value = data.role;
        chooseRole("#EditAdmin", data.role);
        toggleHidden("#EditAdmin");
    }
</script>
@endsection