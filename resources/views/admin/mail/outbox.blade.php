@extends('layouts.admin')

@section('title', "Mail Outbox")
    
@section('content')
@include('admin.mail.tab')

<div class="bg-white shadow m-8 py-4">
    <div class="mx-8">
        @include('partials.flash_message')
    </div>
    
    <div id="RenderArea"></div>

    <div class="flex items-center gap-4 p-4 px-8">
        <div id="LoadingArea" class="hidden text-sm text-slate-600">Memuat...</div>
        <div class="flex grow"></div>
        <button class="bg-primary text-white text-sm rounded-lg font-medium p-3 px-5" id="LoadMore" onclick="fetchMails()">
            Lainnya
        </button>
    </div>
</div>
@endsection

@section('ModalArea')
@include('admin.mail.content')
@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/customParseFormat.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
<script>
    dayjs.extend(dayjs_plugin_customParseFormat);
    dayjs.extend(dayjs_plugin_relativeTime);
    let canNext = true;
    let page = 1;
    const LoadingArea = select("#LoadingArea");
    let MoreBtn = select("#LoadMore");

    const parseFromHeader = from => {
        if (!from || typeof from !== "string") {
            return { name: null, email: null };
        }

        const match = from.match(/^(?:"?([^"]*)"?\s)?<?([^<>]+)>?$/);

        if (!match) {
            return { name: null, email: null };
        }

        let name = match[1] ? match[1].trim() : null;
        const email = match[2] ? match[2].trim() : null;

        // 🔥 Fallback: use email username if name is null
        if (!name && email) {
            name = email.split('@')[0];
        }

        return { name, email };
    }

    function downloadAttachment(base64Data, filename, mimeType) {
        const byteCharacters = atob(base64Data);
        const byteNumbers = Array.from(byteCharacters, c => c.charCodeAt(0));
        const byteArray = new Uint8Array(byteNumbers);
        const blob = new Blob([byteArray], { type: mimeType });

        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        a.click();

        URL.revokeObjectURL(url); // cleanup
    }

    const expand = (msg) => {
        let headers = msg.headers;
        let bodies = msg.bodies;
        let from = parseFromHeader(headers.To);

        select("#MailContent #initial").innerHTML = Initial(from.name);
        select("#MailContent #from_name").innerHTML = from.name;
        select("#MailContent #from_email").innerHTML = from.email;
        select("#MailContent #body").innerHTML = bodies.html ?? bodies.plain;

        if (msg.attachments.length > 0) {
            select("#AttachmentsArea").classList.remove('hidden');
            select("#AttachmentsArea").innerHTML = "";
            msg.attachments.forEach((file, f) => {
                let attach = document.createElement('div');
                attach.classList.add('cursor-pointer', 'bg-slate-200', 'p-4', 'rounded-lg', 'flex', 'items-center', 'gap-4');
                attach.innerHTML = `<div class="w-10 h-10 rounded-lg bg-primary text-white text-[8px] font-bold flex items-center justify-center">${file.filename.split(".").pop().toUpperCase()}</div>
                <div class="flex flex-col gap-1 grow">
                    <div class="text-xs text-slate-700 font-medium">${file.filename}</div>
                    <div class="text-xs text-slate-500">${Math.floor(file.size / 1024)} KB</div>
                </div>`;
                attach.addEventListener("click", () => {
                    downloadAttachment(
                        file.data,      // base64 string from API
                        file.filename,  // "invoice.pdf"
                        file.mimeType   // "pdf" — see note below
                    );
                });

                select("#AttachmentsArea").appendChild(attach);
            })
        } else {
            select("#AttachmentsArea").classList.add('hidden');
        }

        toggleHidden("#MailContent");
    }

    const fetchMails = async () => {
        if (!canNext) return;

        LoadingArea.classList.remove('hidden');
        MoreBtn.classList.add('hidden');
        
        const response = await fetch(`/api/mail/outbox?page=${page}`);
        let res = await response.json();
        let messages = res.messages;

        LoadingArea.classList.add('hidden');

        messages.forEach(msg => {
            console.log(msg.bodies);
            
            let parsedTimestamp = dayjs(msg.headers.Date, "ddd, D MMM YYYY HH:mm:ss ZZ");
            let item = document.createElement("div");
            // <div class="item flex items-center gap-4 p-4 px-8 hover:bg-slate-200 cursor-pointer ">
            item.classList.add('item', 'flex', 'items-center', 'gap-4', 'p-4', 'px-8', 'hover:bg-slate-200', 'cursor-pointer');
            item.innerHTML = `<div class="w-10 h-10 flex items-center justify-center bg-primary rounded-full text-white font-bold">
                ${Initial(msg.headers.To)}
            </div>
            <div class="flex flex-col gap-1 grow">
                <div class="text-sm mobile:text-xs text-slate-700 font-medium">${msg.headers.Subject}</div>
                <div class="text-xs text-slate-500">${msg.bodies.plain?.substr(0, 100)}...</div>
            </div>
            <div class="text-xs text-slate-500">${parsedTimestamp.fromNow()}</div>`;
            item.addEventListener("click", () => {
                expand(msg);
            });
            select("#RenderArea").appendChild(item);
        })

        canNext = res.can_next;

        if (canNext) {
            MoreBtn.classList.remove('hidden');
            page += 1;
        } else {
            MoreBtn.classList.add('hidden');
        }
    }

    fetchMails();
</script>
@endsection