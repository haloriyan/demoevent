<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="CreateAdmin">
    <form action="{{ route('admin.admins.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-5/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Tambah Admin</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#CreateAdmin')"></ion-icon>
        </div>

        <div>
            <div class="text-xs text-slate-500 mb-2">Nama</div>
            <input type="text" name="name" id="name" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('name') }}" required>
        </div>
        <div>
            <div class="text-xs text-slate-500 mb-2">Email</div>
            <input type="email" name="email" id="email" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('email') }}" required>
        </div>
        <div>
            <div class="text-xs text-slate-500 mb-2">Password</div>
            <input type="password" name="password" id="password" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('password') }}" required>
        </div>

        <div class="flex flex-wrap gap-4">
            @foreach ($roles as $r => $role)
                <div class="cursor-pointer rounded-lg border shadow p-4 flex flex-col grow basis-96 gap-2 RoleItem {{ $r == 'admin' ? 'border-primary' : '' }}" id="{{ $r }}" onclick="chooseRole('#CreateAdmin', '{{ $r }}')">
                    <h4 class="text-base text-slate-600 font-medium">{{ ucwords($r) }}</h4>
                    <div class="text-xs text-slate-500">{{ $role }}</div>
                </div>
            @endforeach
        </div>
        <input type="hidden" name="role" id="role" value="admin">

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#CreateAdmin')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Tambahkan</button>
        </div>
    </form>
</div>