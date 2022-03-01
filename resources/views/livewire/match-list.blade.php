<div>
    @if (count($matches) == 0)
        <b class="text-red-500 px-4 py-4 font-bold">No Match Found</b>
    @else
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Match</th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Date Time</th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions</th>
                {{-- <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Role</th> --}}
                {{-- <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Actions</span>
                </th> --}}
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" >
            @foreach ($matches as $match)

            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{$match->match->match_number}}. {{$match->match->tournament_level}}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{$match->start_time}}</div>

                </td>

                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                    <a class="text-indigo-600 hover:text-indigo-900">See Teams</a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    @endif
</div>
