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
<script>
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

    const expand = (msg) => {
        let headers = msg.headers;
        let bodies = msg.bodies;
        let from = parseFromHeader(headers.To);
        console.log(msg);

        select("#MailContent #initial").innerHTML = Initial(from.name);
        select("#MailContent #from_name").innerHTML = from.name;
        select("#MailContent #from_email").innerHTML = from.email;
        select("#MailContent #body").innerHTML = bodies.html ?? bodies.text;

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
            let item = document.createElement("div");
            // <div class="item flex items-center gap-4 p-4 px-8 hover:bg-slate-200 cursor-pointer ">
            item.classList.add('item', 'flex', 'items-center', 'gap-4', 'p-4', 'px-8', 'hover:bg-slate-200', 'cursor-pointer');
            item.innerHTML = `<div class="w-10 h-10 flex items-center justify-center bg-primary rounded-full text-white font-bold">
                ${Initial(msg.headers.To)}
            </div>
            <div class="flex flex-col gap-1 grow">
                <div class="text-sm text-slate-700 font-medium">${msg.headers.Subject}</div>
                <div class="text-xs text-slate-500">${msg.bodies.text}</div>
            </div>
            <div class="text-xs text-slate-500">${msg.headers.Date.substr(0, 100)}...</div>`;
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