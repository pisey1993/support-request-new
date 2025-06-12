@extends('layouts.app')

@section('title', 'Create Support Request')

@section('content')
    <div class="container mx-auto my-8 max-w-4xl px-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Create New Support Request</h1>

        @if ($errors->any())
            <div class="mb-6 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md shadow-sm text-sm">
                <p class="font-bold mb-1">Oops! There were some errors:</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('support-requests.store') }}" method="POST"
              class="bg-white p-6 rounded-md shadow space-y-4 text-sm" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div style="display: none">
                    <label for="user_id" class="block font-medium mb-1">User ID <span class="text-red-600">*</span></label>
                    <input type="number" name="user_id" id="user_id" value="{{ Auth::id() }}"
                           class="w-full border border-gray-300 rounded px-3 py-1.5 focus:ring-blue-400 focus:ring-1"
                           required>
                </div>

                <div>
                    <label for="position" class="block font-medium mb-1">Position <span class="text-red-600">*</span></label>
                    <input type="text" name="position" id="position" value="{{ Auth::user()->position }}" hidden>
                    <input type="text" name="position_name"
                           value="{{ Auth::user()->positionRelation ? Auth::user()->positionRelation->positions_name : '' }}"
                           readonly
                           class="w-full border border-gray-300 rounded px-3 py-1.5 bg-gray-100 text-gray-700">
                </div>

                <div>
                    <label for="request_type" class="block font-medium mb-1">
                        Request Type <span class="text-red-600">*</span>
                    </label>
                    <select name="request_type" id="request_type" required
                            class="w-full border border-gray-300 rounded px-3 py-1.5">
                        <option value="">-- Select Request Type --</option>
                        <option value="Create System" {{ old('request_type') == 'Create System' ? 'selected' : '' }}>Create System</option>
                        <option value="Update System" {{ old('request_type') == 'Update System' ? 'selected' : '' }}>Update System</option>
                        <option value="Maintenance" {{ old('request_type') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="Maintenance" {{ old('request_type') == 'Maintenance' ? 'selected' : '' }}>Repair</option>
                    </select>
                </div>


                <div>
                    <label for="requester_name" class="block font-medium mb-1">
                        Requester Name <span class="text-red-600">*</span>
                    </label>
                    <select name="requester_name" id="requester_name" required
                            class="w-full border border-gray-300 rounded px-3 py-1.5">
                        <option value="" disabled {{ old('requester_name') ? '' : 'selected' }}>-- Select Requester --</option>

                        @foreach($users as $user)
                            <option value="{{ $user->name }}"
                                {{ (old('requester_name') ?? Auth::user()->name) == $user->name ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('requester_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label for="project_title" class="block font-medium mb-1">Project Title</label>
                    <input type="text" name="project_title" id="project_title" value="{{ old('project_title') }}"
                           class="w-full border border-gray-300 rounded px-3 py-1.5">
                </div>

                <div>
                    <label for="requested_date" class="block font-medium mb-1">Requested Date</label>
                    <input type="date" name="requested_date" id="requested_date"
                           value="{{ old('requested_date', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded px-3 py-1.5">
                </div>

                <div>
                    <label for="create_by" class="block font-medium mb-1">Created By</label>
                    <input type="text" name="create_by" id="create_by" value="{{ Auth::user()->name }}"
                           class="w-full border border-gray-300 rounded px-3 py-1.5 bg-gray-100" readonly>
                </div>

                <div>
                    <input type="number" name="requester_department" id="requester_department"
                           value="{{ Auth::user()->department_id }}" hidden>
                    <label class="block font-medium mb-1">Requester Department</label>
                    <input type="text" readonly
                           value="{{ optional(Auth::user()->department)->department_name }}"
                           class="w-full border border-gray-300 rounded px-3 py-1.5 bg-gray-100 text-gray-700">
                </div>
            </div>

            <div class="grid gap-4">
                <div>
                    <label for="purpose_of_project" class="block font-medium mb-1">Description</label>
                    <textarea name="purpose_of_project" id="purpose_of_project" rows="3"
                              class="w-full border border-gray-300 rounded px-3 py-1.5">{{ old('purpose_of_project') }}</textarea>
                </div>

                <div style="display: none">
                    <label for="description_of_problem" class="block font-medium mb-1">Description of Problem</label>
                    <textarea name="description_of_problem" id="description_of_problem" rows="3"
                              class="w-full border border-gray-300 rounded px-3 py-1.5">{{ old('description_of_problem') }}</textarea>
                </div>

                <div style="display: none">
                    <label for="design_detail" class="block font-medium mb-1">Design Detail</label>
                    <textarea name="design_detail" id="design_detail" rows="3"
                              class="w-full border border-gray-300 rounded px-3 py-1.5">{{ old('design_detail') }}</textarea>
                </div>
            </div>
            <div class="border border-gray-300 rounded-lg p-4">
                <h3 class="text-base font-semibold mb-4">Attachments</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="attachment-container">
                    <div id="group-1">
                        <label for="attachment1" class="block font-medium mb-1">Attachment 1</label>
                        <input type="file" name="attachment1" id="attachment1"
                               class="w-full border border-gray-300 rounded px-3 py-1.5"
                               onchange="showNextAttachment(2)">
                    </div>

                    <div id="group-2" class="hidden">
                        <label for="attachment2" class="block font-medium mb-1">Attachment 2</label>
                        <input type="file" name="attachment2" id="attachment2"
                               class="w-full border border-gray-300 rounded px-3 py-1.5"
                               onchange="showNextAttachment(3)">
                    </div>

                    <div id="group-3" class="hidden">
                        <label for="attachment3" class="block font-medium mb-1">Attachment 3</label>
                        <input type="file" name="attachment3" id="attachment3"
                               class="w-full border border-gray-300 rounded px-3 py-1.5"
                               onchange="showNextAttachment(4)">
                    </div>

                    <div id="group-4" class="hidden">
                        <label for="attachment4" class="block font-medium mb-1">Attachment 4</label>
                        <input type="file" name="attachment4" id="attachment4"
                               class="w-full border border-gray-300 rounded px-3 py-1.5"
                               onchange="showNextAttachment(5)">
                    </div>

                    <div id="group-5" class="hidden">
                        <label for="attachment5" class="block font-medium mb-1">Attachment 5</label>
                        <input type="file" name="attachment5" id="attachment5"
                               class="w-full border border-gray-300 rounded px-3 py-1.5">
                    </div>
                </div>
            </div>


            <div class="pt-6 flex justify-center gap-4">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700 transition">
                    Submit
                </button>
                <a href="{{ route('support-requests.index') }}"
                   class="px-6 py-2 border border-gray-300 text-sm text-gray-700 rounded hover:bg-gray-100 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>


    {{-- Load jQuery and Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <script>
        function showNextAttachment(nextId) {
            const currentInput = document.getElementById(`attachment${nextId - 1}`);
            const nextGroup = document.getElementById(`group-${nextId}`);

            if (currentInput && currentInput.files.length > 0 && nextGroup) {
                nextGroup.classList.remove('hidden');
            }
        }
        $(document).ready(function () {
            $('#requester_name').select2({
                placeholder: "Select or type requester",
                allowClear: true,
                tags: true, // This allows typing and adding new tags
                createTag: function (params) {
                    // Prevent adding tags that are empty or whitespace only
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true // add additional parameters
                    }
                }
            });
        });
    </script>
@endsection
