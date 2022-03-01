<!-- This example requires Tailwind CSS v2.0+ -->
<div>
    <div class="flex flex-col">


        <div class="py-3 sm:px-6 px-2">
            <div class="px-4 sm:px-0">
                <div class="xl:w-96">
                    @livewire('teams-select-options', ['teams' => $teams, 'teamNumber' => $teamNumber])
                </div>
            </div>
        </div>
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">


                <div class="shadow overflow-x-auto border-b border-gray-200 sm:rounded-lg mb-5 mx-5">
                    @livewire('match-list', ['teamId' => $teamId])
                </div>
            </div>
        </div>
    </div>
</div>
