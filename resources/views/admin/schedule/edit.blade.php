@php
    use Carbon\Carbon;
@endphp

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="EditSchedule">
    <form method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">{{ __('organizer.edit') }} {{ __('organizer.schedule') }}</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#EditSchedule')"></ion-icon>
        </div>

        <div class="group border focus-within:border-primary rounded-lg p-2 relative">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">{{ __('organizer.title') }}</label>
            <input type="text" name="title" id="title" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ old('title') }}" required />
        </div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">{{ __('organizer.description') }}</label>
            <textarea name="description" id="description" class="w-full h-20 pt-6 outline-none bg-transparent text-sm text-slate-700" rows="10">{{ old('description') }}</textarea>
        </div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">{{ __('organizer.date') }}</label>
            <select name="date" id="date" class="w-full h-14 pt-4 outline-0 cursor-pointer text-sm text-slate-600">
                @foreach ($availableDates as $date)
                    <option value="{{ $date }}">{{ Carbon::parse($date)->isoFormat('DD MMMM YYYY') }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#EditSchedule')">{{ __('organizer.cancel') }}</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">{{ __('organizer.submit') }}</button>
        </div>
    </form>
</div>