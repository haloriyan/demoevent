<footer id="footer" class="border-t">
    <div class="p-20 flex gap-10">
        <div class="flex flex-col gap-2 w-5/12">
            <a href="#">
                <img src="/images/logo.png" alt="Footer logo" class="h-16">
            </a>
            <h3 class="text-2xl text-slate-800 font-bold mt-8">{{ env('EVENT_NAME') }}</h3>
            <div class="text-sm text-slate-500">{{ env('EVENT_DATES') }}</div>
            <div class="text-sm text-slate-500">{{ env('EVENT_PLACE') }}</div>
        </div>
        <div class="flex flex-col gap-4 grow basis-32">
            <h3 class="text-lg text-slate-700 font-medium mb-4">Pages</h3>
            <a href="/" class="text-sm text-slate-500 hover:underline">
                Home
            </a>
            <a href="{{ route('program') }}" class="text-sm text-slate-500 hover:underline">
                Programs
            </a>
            <a href="{{ route('eposter') }}" class="text-sm text-slate-500 hover:underline">
                E-Poster
            </a>
            <a href="{{ route('contact') }}" class="text-sm text-slate-500 hover:underline">
                Contact Us
            </a>
        </div>
        <div class="flex flex-col gap-4 grow basis-32">
            <h3 class="text-lg text-slate-700 font-medium mb-4">Contact</h3>
            <a href="#" class="flex items-center gap-4">
                <div class="w-10 h-10 flex items-center justify-center border rounded-lg">
                    <ion-icon name="mail-outline" class="text-lg text-slate-700"></ion-icon>
                </div>
                <div class="text-sm text-slate-500">halo@pitperabdinasarelc2026.com</div>
            </a>
            <a href="#" class="flex items-center gap-4">
                <div class="w-10 h-10 flex items-center justify-center border rounded-lg">
                    <ion-icon name="logo-whatsapp" class="text-lg text-slate-700"></ion-icon>
                </div>
                <div class="text-sm text-slate-500">+62 812 3456 7890</div>
            </a>
        </div>
    </div>
</footer>