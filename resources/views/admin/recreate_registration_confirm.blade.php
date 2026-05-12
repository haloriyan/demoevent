@extends('layouts.admin')

@section('title', "Konfirmasi Recreate Registrasi")

@section('content')
<div class="p-8 flex flex-col gap-6 max-w-2xl">
    <div>
        <a href="{{ route('admin.recreate-registration') }}" class="text-sm text-indigo-600 hover:underline flex items-center gap-1">
            <ion-icon name="arrow-back-outline"></ion-icon>
            Kembali ke pencarian
        </a>
        <h1 class="text-2xl font-bold text-slate-800 mt-3">Konfirmasi Recreate Registrasi</h1>
        <p class="text-sm text-slate-500 mt-1">Periksa detail berikut sebelum melanjutkan. Proses ini akan membuat invoice DOKU baru dan mengirim ulang email notifikasi ke peserta.</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm divide-y divide-slate-100">
        <div class="px-6 py-4">
            <div class="text-xs text-slate-400 uppercase font-semibold tracking-wide mb-3">Data Peserta</div>
            <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                <div>
                    <dt class="text-slate-400">Nama</dt>
                    <dd class="font-medium text-slate-800">{{ $transaction->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Email</dt>
                    <dd class="text-slate-700">{{ $transaction->user->email }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">WhatsApp</dt>
                    <dd class="text-slate-700">{{ $transaction->user->whatsapp ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Instansi</dt>
                    <dd class="text-slate-700">{{ $transaction->user->instansi ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="px-6 py-4">
            <div class="text-xs text-slate-400 uppercase font-semibold tracking-wide mb-3">Data Transaksi</div>
            <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                <div>
                    <dt class="text-slate-400">No. Transaksi</dt>
                    <dd class="font-mono text-slate-700">#{{ $transaction->id }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Invoice</dt>
                    <dd class="font-mono text-slate-700">{{ $transaction->invoice_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Tiket</dt>
                    <dd class="text-slate-700">{{ $transaction->ticket?->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Jumlah</dt>
                    <dd class="text-slate-700">Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400">Status Saat Ini</dt>
                    <dd>
                        @php
                            $colors = ['PENDING'=>'yellow','PAID'=>'green','EXPIRED'=>'red','CANCELLED'=>'red'];
                            $c = $colors[$transaction->payment_status] ?? 'slate';
                        @endphp
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold bg-{{ $c }}-100 text-{{ $c }}-700">
                            {{ $transaction->payment_status }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-400">Expired At</dt>
                    <dd class="text-slate-700">{{ $transaction->expired_at ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="px-6 py-4 bg-amber-50">
            <div class="flex gap-3 text-sm text-amber-800">
                <ion-icon name="warning-outline" class="text-xl flex-shrink-0 mt-0.5"></ion-icon>
                <div>
                    <div class="font-semibold">Yang akan terjadi setelah konfirmasi:</div>
                    <ul class="mt-1 list-disc list-inside space-y-0.5 text-amber-700">
                        <li>Invoice DOKU baru akan dibuat (invoice lama tidak dapat digunakan)</li>
                        <li>Status transaksi akan diubah kembali ke <strong>PENDING</strong></li>
                        <li>Waktu kadaluarsa akan diperbarui</li>
                        <li>Email notifikasi pendaftaran dikirim ulang ke <strong>{{ $transaction->user->email }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.recreate-registration.execute', $transaction->id) }}">
        @csrf
        <div class="flex gap-3">
            <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700">
                Ya, Recreate Sekarang
            </button>
            <a href="{{ route('admin.recreate-registration') }}"
               class="px-6 py-3 bg-white border text-slate-600 text-sm font-semibold rounded-lg hover:bg-slate-50">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
