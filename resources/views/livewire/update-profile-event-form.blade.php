<x-jet-form-section submit="saveEvent">

    <x-slot name="title">
        {{ __('Event Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update the event which you attempt now.') }}
    </x-slot>

    <x-slot name="form">

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="season_event" value="{{ __('Current Event / '). ($current_event == null ? '' : $current_event->event->name) /* . $current_event != null ? $current_event->event->name : '' */ }}" />
            <select id="season_event" name="season_event" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" wire:model="season_event">
                <option  value="0">Select an Event for Update</option>
                @foreach ($season_events as $event)
                    <option value="{{$event->id}}" {{ $event->id== auth()->user()->event_id ? 'selected' : '' }} >{{$event->event->name}}</option>
                @endforeach
            </select>
            @error('season_event') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" >
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
