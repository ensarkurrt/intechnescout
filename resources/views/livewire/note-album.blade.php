<div class="flex flex-wrap gap-4">
    @foreach ($photos as $photo)
        @livewire('note-photo', ['src' => $photo])
    @endforeach
</div>
