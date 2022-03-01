<div>
    <label for="team" class="control-label">Filter by Team</label>
       <select wire:model="teamNumber" name="team" id="team" class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example" >
            <option value="0" {{$teamNumber == 0 ? 'selected' : ''}}>Select Team</option>
            @foreach ($teams as $team)
            <option value="{{ $team->team->number }}" {{$teamNumber == $team->team->number ? 'selected' : '' }} >{{ $team->team->name }}</option>
            @endforeach
        </select>
</div>
