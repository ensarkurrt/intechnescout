<!-- This example requires Tailwind CSS v2.0+ -->
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mx-5 mb-5">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Photo</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>

                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($teams as $team)

                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @livewire('team-photo',['teamNumber'=> $team->team->number])
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><a href="{{route('note-detail',['teamId'=>$team->team->number])}}">{{$team->team->name}}<b>#{{$team->team->number}}</b></a></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <b class="text-sm text-{{$team->team->isInspected ? 'green' : 'red'}}-500">
                                    {{$team->team->isInspected ? 'Inspected' : 'Not
                                    Inspected'}}</b>
                            </td>
                            {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Admin</td>
                            --}}
                            <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                <input type="hidden" class="bg-green-500"/>
                                <input type="hidden" class="bg-red-500"/>
                                @if ($team->team->isInspected)
                                <a href="{{route('note-detail',['teamId'=>$team->team->number])}}"
                                    class="text-white font-bold hover:text-gray-500"><button class="bg-green-500 rounded-lg px-2 py-1">Show Inspect</button></a>
                                @else
                                <a href="{{route('note-detail',['teamId'=>$team->team->number])}}"
                                    class="text-white font-bold hover:text-gray-500"><button class="bg-red-500 rounded-lg px-2 py-1">Create Inspect</button></a>
                                @endif
                                {{-- <a href="{{route('note-detail',['teamId'=>$team->team->number])}}"
                                    class="text-white font-bold hover:text-gray-500"><button class="bg-{{$team->team->isInspected ? 'green' : 'red'}}-500 rounded-lg px-2 py-1">{{$team->team->isInspected ? 'Show' : 'Create'}} Inspect</button></a> --}}
                            </td>
                        </tr>
                        @endforeach
                        <!-- More people... -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
