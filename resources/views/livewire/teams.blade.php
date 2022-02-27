<!-- This example requires Tailwind CSS v2.0+ -->
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
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
                                Number</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            {{-- <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role</th> --}}
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($teams as $team)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">

                                    @livewire('team-photo',['teamNumber'=> $team->number])
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><a href="{{route('note-detail',['teamId'=>$team->number])}}">{{$team->name}}</a></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><a href="{{route('note-detail',['teamId'=>$team->number])}}"><b>#</b>{{$team->number}}</a></div>
                                {{-- <div class="text-sm text-gray-500">Optimization</div> --}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <b class="text-sm text-{{$team->isInspected ? 'green' : 'red'}}-500">
                                    {{$team->isInspected ? 'Inspected' : 'Not
                                    Inspected'}}</b>
                            </td>
                            {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Admin</td>
                            --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{route('note-detail',['teamId'=>$team->number])}}"
                                    class="text-indigo-600 hover:text-indigo-900">Inspect</a>
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
