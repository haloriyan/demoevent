<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="DetailPeserta">
    <form action="#" method="GET" class="bg-white shadow-lg rounded-lg p-10 w-5/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        <div class="flex items-center gap-4 mb-2">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Detail Peserta</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#DetailPeserta')"></ion-icon>
        </div>

        <div class="flex items-center gap-2 mb-4">
            <div id="personal" class="DetailTab flex items-center gap-1 rounded-full cursor-pointer border border-primary text-xs p-2 px-4" onclick="openDetailSection('personal')">
                Personal
            </div>
            <div id="transaction" class="DetailTab flex items-center gap-1 rounded-full cursor-pointer border border-primary text-xs p-2 px-4" onclick="openDetailSection('transaction')">
                Transaksi
            </div>
            <div id="ticket" class="DetailTab flex items-center gap-1 rounded-full cursor-pointer border border-primary text-xs p-2 px-4" onclick="openDetailSection('ticket')">
                Tiket
            </div>
        </div>

        <section id="personal">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500 italic">NAMA</div>
                    <div class="text-slate-700 font-medium" id="name"></div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500 italic">INSTANSI</div>
                    <div class="text-slate-700 font-medium" id="instansi"></div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500 italic">EMAIL</div>
                    <div class="text-slate-700 font-medium" id="email"></div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500 italic">NO. TELEPON</div>
                    <div class="text-slate-700 font-medium" id="whatsapp"></div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500 italic">NIK</div>
                    <div class="text-slate-700 font-medium" id="nik"></div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500 italic">WAKTU PENDAFTARAN</div>
                    <div class="text-slate-700 font-medium" id="created_at"></div>
                </div>
            </div>
        </section>
        <section id="transaction" class="flex flex-col gap-4">
            <div class="flex items-center gap-4">
                <div class="text-xs text-slate-500 flex grow">Status Pembayaran</div>
                <div class="font-medium p-1 px-3 rounded-lg" id="payment_status"></div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-xs text-slate-500 flex grow">Nominal Pembayaran</div>
                <div id="payment_amount" class="font-medium text-primary"></div>
            </div>

            <div id="payment_evidence_area">
                <div class="text-xs text-slate-500">Bukti Transfer Pembayaran (Manual)</div>
                <div id="payment_evidence"></div>
            </div>
        </section>

        <section id="ticket" class="flex flex-col gap-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500 italic">TIKET</div>
                    <div class="text-slate-700 font-medium" id="ticket_name"></div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500 italic">KATEGORI</div>
                    <div class="text-slate-700 font-medium" id="ticket_category"></div>
                </div>
            </div>

            <div id="workshops_area" class="flex flex-col gap-1">
                <div class="h-4"></div>
                <div class="text-xs text-slate-500 italic">WORKSHOP</div>
                <div id="workshops" class="flex flex-col gap-4"></div>
            </div>
        </section>

    </form>
</div>