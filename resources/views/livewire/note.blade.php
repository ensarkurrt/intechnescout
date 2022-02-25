
@push('custom-styles')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <link
        href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css"
        rel="stylesheet"
    />
    <link
        href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css"
        rel="stylesheet"
    />
    <style>
        .loader {
            border-top-color: #3498db;
            -webkit-animation: spinner 1.5s linear infinite;
            animation: spinner 1.5s linear infinite;
        }

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush
@push('header-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>
@endpush

@push('before-body-scripts')
    <!-- Load FilePond library -->

{{--     <script src="https://unpkg.com/filepond/dist/filepond.js"></script> --}}

    <!-- Turn all file input elements into ponds -->
    <script>
    FilePond.parse(document.body);
    </script>
@endpush

{{-- /*  files: [
    @foreach($shownPhotos as $photo)
    // add local photos to pond, but dont upload them
    {
        "source":'{{asset($photo)}}', // id on server
        "options":{
            "type":"local",
        }
    },

    @endforeach
] */ --}}
<div>




    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Robot Information</h3>
                    <p class="mt-1 text-sm text-gray-600">Fill it with your informations.</p>
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form wire:submit.prevent="saveNote" enctype="multipart/form-data">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">Photo</label>
                                        <div wire:ignore x-data>
                                            <input type="file"
                                                class="filepond"
                                                name="photos"
                                                id="photos"
                                                data-allow-reorder="true"
                                                data-max-file-size="2MB"
                                                wire:model="photos"
                                                x-ref="input"
                                                multiple>
                                                <script>
                                                    $(document).ready(function () {
                                                        document.querySelector('.filepond--credits').remove();
                                                    });
                                                    FilePond.registerPlugin(FilePondPluginFileValidateType);
                                                    FilePond.registerPlugin(FilePondPluginFileValidateSize);
                                                    FilePond.registerPlugin(FilePondPluginImagePreview);
                                                    FilePond.registerPlugin(FilePondPluginImageEdit);
                                                    FilePond.registerPlugin(FilePondPluginFilePoster);
                                                    const pond = FilePond.create(document.querySelector('input[id=\"photos\"]'), {
                                                        acceptedFileTypes: ['image/*'],
                                                        labelFileTypeNotAllowed: 'Please make sure to upload an image.',
                                                        fileValidateTypeLabelExpectedTypes: 'Expected types: {allTypes}',
                                                        fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
                                                            resolve(type);
                                                        }),
                                                        maxFileSize: '2MB',
                                                        labelMaxFileSizeExceeded: 'Image size is too big.',
                                                        labelFileProcessingError: (error) => {
                                                            return 'An error accurated.';
                                                        },
                                                        labelTapToUndo: 'tap to remove',
                                                        allowImagePreview:true,
                                                        files: [
                                                            @foreach($shownPhotos as $photo)
                                                            {
                                                                "source":'{{$photo}}',
                                                                "options":{
                                                                    "type":"limbo",
                                                                    "file": {
                                                                        "name": "{{$loop->index+1}}. Photo",
                                                                        "size": "{{Storage::disk('public')->size(str_replace('storage/', '', $photo))}}",
                                                                        "type": "image/png",
                                                                    },
                                                                    metadata: {
                                                                        poster: '{{asset($photo)}}',
                                                                    },
                                                                }
                                                            },
                                                            @endforeach
                                                        ]

                                                    });
                                                    FilePond.setOptions({
                                                        server: {
                                                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                                                            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                                                                @this.upload('photos', file, load, error, progress)
                                                            },
                                                            revert: (filename, load) => {
                                                                @this.removeUpload('photos', filename, load)
                                                            },
                                                        },

                                                    });

                                                    pond.onprocessfilerevert = (file) => {
                                                        pond.removeFile(file.id);
                                                    };
                                                    /* pond.onactivatefile = (file) => {
                                                        console.log({file});
                                                    } */


                                                </script>


                                        </div>
                                        @error('photos.*') <span class="text-red-500">{{ $message }}</span> @enderror
                                        {{-- <input type="text" name="first-name" id="first-name" autocomplete="given-name"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        --}}
                                    </div>
                            {{--     @else
                                    <div class="col-span-6 sm:col-span-3">
                                        <span class="text-red-500">If you want upload more photo, refresh the page.</span>
                                    </div>
                                @endif
    --}}
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="last-name" class="block text-sm font-medium text-gray-700">Weight</label>
                                    <input wire:model="weight" type="text"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('weight') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <label for="email-address" class="block text-sm font-medium text-gray-700">Height
                                    </label>
                                    <input wire:model="height" type="text"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('height') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="country" class="block text-sm font-medium text-gray-700">Climb Level</label>
                                    <select wire:model="climb_level"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>

                                    @error('climb_level') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="country" class="block text-sm font-medium text-gray-700">Shoot Level</label>
                                    <select wire:model="shoot_level"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>

                                    @error('shoot_level') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-6">
                                    <label for="street-address" class="block text-sm font-medium text-gray-700">Score Per
                                        Match</label>
                                    <input type="text" wire:model="score_per_match"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('score_per_match') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700">Others</label>
                                    <textarea wire:model="others" rows="3"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                        placeholder="Other details about the robot">{{$others}}</textarea>
                                    @error('others') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>

                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            {{-- <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button> --}}
                                <button wire:loading.attr="disabled" type="submit" class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-indigo-500 hover:bg-indigo-400 transition ease-in-out duration-150 cursor-not-allowed">
                                    <div wire:loading.remove>Save</div>
                                    <div wire:loading>Saving...</div>
                                </button>
                                {{-- <div wire:loading.remove class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">

                                </div> --}}

                              </div>

                        </div>

                    </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



