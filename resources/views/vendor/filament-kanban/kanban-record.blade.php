{{--<div--}}
{{--    id="{{ $record->getKey() }}"--}}
{{--    wire:click="recordClicked('{{ $record->getKey() }}', {{ @json_encode($record) }})"--}}
{{--    class="record bg-white dark:bg-gray-700 rounded-lg px-4 py-2 cursor-grab font-medium text-gray-600 dark:text-gray-200"--}}
{{--    @if($record->timestamps && now()->diffInSeconds($record->{$record::UPDATED_AT}) < 3)--}}
{{--        x-data--}}
{{--        x-init="--}}
{{--            $el.classList.add('animate-pulse-twice', 'bg-primary-100', 'dark:bg-primary-800')--}}
{{--            $el.classList.remove('bg-white', 'dark:bg-gray-700')--}}
{{--            setTimeout(() => {--}}
{{--                $el.classList.remove('bg-primary-100', 'dark:bg-primary-800')--}}
{{--                $el.classList.add('bg-white', 'dark:bg-gray-700')--}}
{{--            }, 3000)--}}
{{--        "--}}
{{--    @endif--}}
{{-->--}}
{{--    {{ $record->{static::$recordTitleAttribute} }}--}}
{{--</div>--}}

<div
        id="{{ $record->id }}"
        wire:click="recordClicked('{{ $record->id }}', {{ @json_encode($record) }})"
        class="record transition bg-white dark:bg-gray-700 rounded-lg px-4 py-2 cursor-grab font-medium text-gray-600 dark:text-gray-200"
        @if($record->just_updated)
            x-data
        x-init="
            $el.classList.add('animate-pulse-twice', 'bg-primary-100', 'dark:bg-primary-800')
            $el.classList.remove('bg-white', 'dark:bg-gray-700')
            setTimeout(() => {
                $el.classList.remove('bg-primary-100', 'dark:bg-primary-800')
                $el.classList.add('bg-white', 'dark:bg-gray-700')
            }, 3000)
        "
        @endif
>
    <div class="flex justify-between">
        <div>
            {{ $record->title }}

            @if ($record->urgent)
                <x-heroicon-s-star class="inline-block text-primary-500 w-4 h-4"/>
            @endif
        </div>

    </div>

    <div class="text-xs text-gray-400 border-l-4 pl-2 mt-2 mb-2">
        {{ $record->description }}
    </div>

    <div class="text-sm text-gray-500 border-l-4 pl-2 mt-2 mb-2">
        Vence él: {{ $record->formatted_due_date }}
    </div>

    <div class="mt-2 relative">
        <div class="absolute h-1 bg-primary-500 rounded-full" style="width: {{ $record->progress }}%"></div>
        <div class="h-1 bg-gray-200 rounded-full"></div>
    </div>
</div>