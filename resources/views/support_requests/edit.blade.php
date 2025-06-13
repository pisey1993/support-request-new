@extends('layouts.app')

@section('title', 'Edit Support Request')

@section('content')
    {{-- Load Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configure Tailwind to use Inter font
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <div class="w-full min-h-screen bg-gray-100 flex flex-col items-center py-12 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-6xl mx-auto">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-6 text-center">Edit Support Request</h1>
            <p class="text-center text-gray-600 mb-8">Update the details for your support request and track its
                progress.</p>

            @if ($errors->any())
                <div class="mb-8 bg-red-50 border-l-4 border-red-500 text-red-800 p-5 rounded-lg">
                    <div class="font-bold text-lg mb-3">Whoops! There were some errors:</div>
                    <ul class="list-disc list-inside text-base space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex justify-start mb-8">
                <a href="/support-requests"
                   class="inline-flex items-center px-6 py-2 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414L7.5 9.086 5.707 7.293a1 1 0 00-1.414 1.414l2.5 2.5a1 1 0 001.414 0l4-4z"
                              clip-rule="evenodd"/>
                    </svg>
                    Back to Support Requests
                </a>
            </div>

            <form action="{{ route('support-requests.update', $supportRequest->id) }}" method="POST"
                  class="space-y-8">
                @csrf
                @method('PUT')

                {{-- Hidden User ID field --}}
                <input type="hidden" name="user_id" value="{{ old('user_id', $supportRequest->user_id) }}">
                {{-- Hidden Created By field --}}
                <input type="hidden" name="create_by" value="{{ old('create_by', $supportRequest->create_by) }}">
                {{-- Hidden HOD Approval field --}}
                <input type="hidden" name="HOD_Approval"
                       value="{{ old('HOD_Approval', $supportRequest->HOD_Approval) }}">
                {{-- Hidden Requester Department field --}}
                <input type="hidden" name="requester_department"
                       value="{{ old('requester_department', $supportRequest->requester_department) }}">
                {{-- Hidden Description of Problem field (using for Description) --}}
                <input type="hidden" name="description_of_problem"
                       value="{{ old('description_of_problem', $supportRequest->description_of_problem) }}">


                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Position field --}}
                    <div>
                        <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">Position <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="position" id="position"
                               value="{{ old('position', $supportRequest->position) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out"
                               required>
                    </div>

                    {{-- Ticket No field --}}
                    <div>
                        <label for="ticket_no" class="block text-sm font-semibold text-gray-700 mb-2">Ticket No <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="ticket_no" id="ticket_no"
                               value="{{ old('ticket_no', $supportRequest->id) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out"
                               required>
                    </div>

                    {{-- Request Type dropdown --}}
                    <div>
                        <label for="request_type" class="block text-sm font-semibold text-gray-700 mb-2">Request Type
                            <span class="text-red-600">*</span></label>
                        <select name="request_type" id="request_type"
                                class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out"
                                required>
                            <option value="">-- Select Request Type --</option>
                            @php
                                $requestTypes = ['Repair', 'Create System', 'Update System', 'Maintenance'];
                            @endphp
                            @foreach ($requestTypes as $type)
                                <option
                                    value="{{ $type }}" {{ old('request_type', $supportRequest->request_type) === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Requester Name field --}}
                    <div>
                        <label for="requester_name" class="block text-sm font-semibold text-gray-700 mb-2">Requester
                            Name
                            <span class="text-red-600">*</span></label>
                        <input type="text" name="requester_name" id="requester_name"
                               value="{{ old('requester_name', $supportRequest->requester_name) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out"
                               required>
                    </div>

                    {{-- Project Title field --}}
                    <div>
                        <label for="project_title" class="block text-sm font-semibold text-gray-700 mb-2">Project
                            Title</label>
                        <input type="text" name="project_title" id="project_title"
                               value="{{ old('project_title', $supportRequest->project_title) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
                    </div>

                    {{-- Urgent Case Level dropdown (Severity Level) --}}
                    <div>
                        <label for="urgentCase" class="block text-sm font-semibold text-gray-700 mb-2">Severity Level
                            <span class="text-red-600">*</span></label>
                        <select name="urgentCase" id="urgentCase"
                                class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out"
                                required>
                            <option value="">-- Select Severity Level --</option>
                            {{-- Options dynamically loaded by JavaScript --}}
                        </select>
                    </div>

                    {{-- Requested Date field --}}
                    <div>
                        <label for="requested_date" class="block text-sm font-semibold text-gray-700 mb-2">Requested
                            Date</label>
                        <input type="date" name="requested_date" id="requested_date"
                               value="{{ old('requested_date', $supportRequest->requested_date?->format('Y-m-d')) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
                    </div>

                    {{-- Dateline to be Expected field (read-only, calculated) --}}
                    <div>
                        <label for="dateline_to_be_expected" class="block text-sm font-semibold text-gray-700 mb-2">Dateline
                            to be Expected</label>
                        <input type="text" name="dateline_to_be_expected" id="dateline_to_be_expected"
                               value="{{ old('dateline_to_be_expected', $supportRequest->dateline_to_be_expected?->format('Y-m-d')) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 bg-gray-100 cursor-not-allowed text-gray-700"
                               readonly>
                    </div>

                    {{-- Requester Department field (read-only display) --}}
                    <div>
                        <label for="requester_department_display"
                               class="block text-sm font-semibold text-gray-700 mb-2">Requester
                            Department</label>
                        <input type="text" id="requester_department_display" readonly
                               value="{{ optional(Auth::user()->department)->department_name }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 bg-gray-100 text-gray-700 cursor-not-allowed">
                    </div>

                    {{-- Requested Status field (now a select dropdown) --}}
                    <div>
                        <label for="requested_status" class="block text-sm font-semibold text-gray-700 mb-2">Requested
                            Status</label>
                        <select name="requested_status" id="requested_status"
                                class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
                            <option
                                value="Pending" {{ old('requested_status', $supportRequest->requested_status) == 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option
                                value="Progress" {{ old('requested_status', $supportRequest->requested_status) == 'Progress' ? 'selected' : '' }}>
                                Progress
                            </option>
                            <option
                                value="UAT" {{ old('requested_status', $supportRequest->requested_status) == 'UAT' ? 'selected' : '' }}>
                                UAT
                            </option>
                            <option
                                value="Resolved" {{ old('requested_status', $supportRequest->requested_status) == 'Resolved' ? 'selected' : '' }}>
                                Resolved
                            </option>
                        </select>
                    </div>

                    {{-- Actual Completed Date field --}}
                    <div>
                        <label for="Actual_completed_date" class="block text-sm font-semibold text-gray-700 mb-2">Actual
                            Completed Date</label>
                        <input type="date" name="Actual_completed_date" id="Actual_completed_date"
                               value="{{ old('Actual_completed_date', $supportRequest->Actual_completed_date?->format('Y-m-d')) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
                    </div>

                    {{-- Description field (full width) --}}
                    <div class="lg:col-span-3">
                        <label for="purpose_of_project"
                               class="block text-sm font-semibold text-gray-700 mb-2">Description <span
                                class="text-red-600">*</span></label>
                        <textarea name="purpose_of_project" id="purpose_of_project" rows="4"
                                  class="w-full border-gray-300 rounded-lg shadow-sm text-base px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out"
                                  required>{{ old('purpose_of_project', $supportRequest->purpose_of_project) }}</textarea>

                        {{-- Form Submission Buttons --}}
                        <div class="pt-6 flex justify-end space-x-3">
                            <button type="submit"
                                    class="inline-flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path
                                        d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h-1v5.586l-1.293-1.293z"/>
                                    <path d="M9 2a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V3a1 1 0 00-1-1H9z"/>
                                </svg>
                                Update
                            </button>

                            <a href="{{ route('support-requests.index') }}"
                               class="inline-flex items-center px-5 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-300 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Cancel
                            </a>
                        </div>
                    </div>


                    {{-- Dynamic Task Details display --}}
                    <div class="lg:col-span-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Task Details based on
                            Severity</label>
                        <div id="taskDetails"
                             class="hidden bg-blue-50 border border-blue-200 text-blue-800 rounded-lg p-5 shadow-inner text-base space-y-2">
                            <div><strong>Description:</strong> <span id="taskDescription" class="font-normal"></span>
                            </div>
                            <div><strong>Resolution Time:</strong> <span id="taskResolutionTime"
                                                                         class="font-normal"></span></div>
                            <div><strong>Expected Completion Date:</strong> <span id="taskCompletionDate"
                                                                                  class="font-normal"></span></div>
                            <div><strong>Notes:</strong> <span id="taskNotes" class="font-normal"></span></div>
                        </div>

                        <textarea name="severity_description" id="taskDetailsSummary" style="display: none"></textarea>

                    </div>
                </div>

                {{-- Attachments Display --}}
                <div class="mt-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Attachments</h2>
                    @if (count($attachments) > 0) {{-- Changed to count($attachments) for plain array --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($attachments as $attachment)
                            <a
                                href="{{ asset($attachment['filePath']) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="block bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-200 ease-in-out transform hover:-translate-y-1 group"
                            >
                                @if ($attachment['isImage'])
                                    <img
                                        src="{{ asset($attachment['filePath']) }}"
                                        alt="{{ $attachment['name'] }}"
                                        class="w-full h-40 object-cover border-b border-gray-200 group-hover:scale-105 transition-transform duration-300"
                                        onerror="this.onerror=null; this.src='https://placehold.co/600x400/E5E7EB/4B5563?text=Image+Not+Found&font=roboto';"
                                    />
                                @else
                                    <div class="flex items-center justify-center h-40 bg-gray-50 text-gray-600 p-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mr-3"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span
                                            class="font-semibold text-lg text-center truncate">{{ $attachment['name'] }}</span>
                                    </div>
                                @endif
                                <div class="p-4 flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700 truncate">
                                            {{ $attachment['name'] }}
                                        </span>
                                    <span
                                        class="text-blue-600 hover:text-blue-800 text-sm ml-2 flex-shrink-0 font-medium">View/Download</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    @else
                        <p class="text-gray-500 text-center py-4 border border-gray-200 rounded-lg bg-gray-50">No
                            attachments found for this request.</p>
                    @endif
                </div>


            </form>

            <hr class="my-12 border-gray-200">

            <!-- Sub Tasks Section -->
            <div class="mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Progress Updates</h2>
                    <button type="button"
                            class="inline-flex items-center px-6 py-2 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                            id="openSubTaskModal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Add Progress Update
                    </button>
                </div>

                @if(!empty($supportRequest->subTasks) && $supportRequest->subTasks->count())
                    <div class="overflow-x-auto shadow-md rounded-lg">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider">
                            <tr>
                                <th class="px-5 py-3 text-left font-semibold">Ticket No</th>
                                <th class="px-5 py-3 text-left font-semibold">Date</th>
                                <th class="px-5 py-3 text-left font-semibold">Description</th>
                            </tr>
                            </thead>
                            <tbody class="text-base text-gray-800 divide-y divide-gray-200">
                            @foreach($supportRequest->subTasks->sortByDesc('date') as $task) {{-- Sort by date descending --}}
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-5 py-3">{{ $task->support_request_id }}</td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($task->date)->format('Y-m-d H:i A') }}</td>
                                <td class="px-5 py-3">{{ $task->description }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-6 border border-gray-200 rounded-lg bg-gray-50">No progress
                        updates found for this request. Click "Add Progress Update" to add one.</p>
                @endif
            </div>

            <!-- Modal for Adding Sub Task -->
            <div id="subTaskModal"
                 class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden p-4">
                <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl animate-fade-in-up">
                    <form
                        action="{{ route('support-requests.sub-tasks.store', ['supportRequest' => $supportRequest->id]) }}"
                        method="POST">
                        @csrf
                        <div
                            class="px-6 py-4 border-b flex justify-between items-center bg-blue-600 text-white rounded-t-xl">
                            <h5 class="text-xl font-semibold">Add Progress Update</h5>
                            <button type="button" id="closeSubTaskModal"
                                    class="text-white text-3xl font-bold leading-none hover:text-gray-200 transition-colors duration-200">
                                &times;
                            </button>
                        </div>
                        <div class="px-6 py-6 space-y-5">
                            <input type="hidden" name="support_request_id" value="{{ $supportRequest->id }}">
                            <input type="hidden" name="ticket_no" value="{{ $supportRequest->id }}">

                            <div>
                                <label for="modal_date" class="block text-sm font-semibold text-gray-700 mb-2">Date &
                                    Time</label>
                                <input type="datetime-local" name="date" id="modal_date"
                                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5"
                                       required>
                            </div>

                            <div>
                                <label for="modal_description"
                                       class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea name="description" id="modal_description" rows="4"
                                          class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base px-4 py-2.5"
                                          placeholder="Enter details of the progress update..." required></textarea>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-xl">
                            <button type="button" id="cancelSubTaskModal"
                                    class="inline-flex items-center px-6 py-2.5 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-300 ease-in-out">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Save Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

    {{-- JavaScript for dynamic task details and date calculation --}}
    @php
        // Define the task data structure based on the new table
        $tasksData = [
            'Repair' => [
                'Low' => [
                    'description' => 'Minor hardware repair or part replacement (e.g., keyboard, adapter)',
                    'resolution_time_text' => 'Within 2 working days',
                    'notes' => 'Internal fixes, minimal interruption',
                    'resolution_days' => 2,
                ],
                'Medium' => [
                    'description' => 'Hardware issue needing testing or diagnosis by third party',
                    'resolution_time_text' => 'Within 7 working days',
                    'notes' => 'May require vendor involvement',
                    'resolution_days' => 7,
                ],
                'High' => [
                    'description' => 'Major hardware failure or installation (e.g., Laptop, server, motherboard)',
                    'resolution_time_text' => 'Within 15 working days',
                    'notes' => 'Involves procurement and external technicians',
                    'resolution_days' => 15,
                ],
            ],
            'Create System' => [
                'Low' => [
                    'description' => 'Basic system setup or new feature addition',
                    'resolution_time_text' => 'Within 5 working days',
                    'notes' => 'Minor development tasks',
                    'resolution_days' => 5,
                ],
                'Medium' => [
                    'description' => 'Core module development or third-party integration',
                    'resolution_time_text' => 'Within 15 working days',
                    'notes' => 'Needs coordinated development',
                    'resolution_days' => 15,
                ],
                'High' => [
                    'description' => 'Full new system or platform development',
                    'resolution_time_text' => 'Within 40 working days',
                    'notes' => 'Treated as a large project',
                    'resolution_days' => 40,
                ],
            ],
            'Update System' => [
                'Low' => [
                    'description' => 'UI tweaks or small bug fixes',
                    'resolution_time_text' => 'Within 3 working days',
                    'notes' => 'Routine improvements',
                    'resolution_days' => 3,
                ],
                'Medium' => [
                    'description' => 'Functional upgrades or backend improvements',
                    'resolution_time_text' => 'Within 10 working days',
                    'notes' => 'Moderate changes',
                    'resolution_days' => 10,
                ],
                'High' => [
                    'description' => 'Architecture changes or major version upgrade',
                    'resolution_time_text' => 'Within 25 working days',
                    'notes' => 'Includes testing and staging',
                    'resolution_days' => 25,
                ],
            ],
            'Maintenance' => [
                'Low' => [
                    'description' => 'Simple fixes: laptop, PC, WiFi, printer issues',
                    'resolution_time_text' => 'Within 3 hours',
                    'notes' => 'Usually same-day resolution',
                    'resolution_days' => 1, // Adjusted for date calculation: next working day
                ],
                'Medium' => [
                    'description' => 'Hardware issues needing deeper troubleshooting',
                    'resolution_time_text' => 'Within 5 hours',
                    'notes' => 'May require temporary workaround',
                    'resolution_days' => 1, // Adjusted for date calculation: next working day
                ],
                'High' => [
                    'description' => 'Network installation, OS setup, or large device setup',
                    'resolution_time_text' => 'Within 3 working days',
                    'notes' => 'Often requires multiple staff or vendor',
                    'resolution_days' => 3,
                ],
            ],
        ];
    @endphp

    <script>


        const openModalBtn = document.getElementById('openSubTaskModal');
        const closeModalBtn = document.getElementById('closeSubTaskModal');
        const cancelModalBtn = document.getElementById('cancelSubTaskModal');
        const modal = document.getElementById('subTaskModal');

        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeModalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        cancelModalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Optional: Close modal if user clicks outside the modal content
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });


        (() => {
            // Task data as defined in PHP, passed to JavaScript
            const tasksData = @json($tasksData);

            // Get references to the select and display elements
            const requestTypeSelect = document.getElementById('request_type');
            const urgentCaseLevelSelect = document.getElementById('urgentCase');
            const detailsDiv = document.getElementById('taskDetails');
            const descEl = document.getElementById('taskDescription');
            const resolutionTimeEl = document.getElementById('taskResolutionTime');
            const completionDateEl = document.getElementById('taskCompletionDate');
            const notesEl = document.getElementById('taskNotes');
            const datelineInput = document.getElementById('dateline_to_be_expected');
            const requestedDateInput = document.getElementById('requested_date'); // Get requested date input

            // Store initial values for proper pre-selection
            const initialRequestType = "{{ old('request_type', $supportRequest->request_type) }}";
            const initialUrgentCaseLevel = "{{ old('urgentCase', $supportRequest->urgentCase) }}";
            // Use existing requested_date for initial calculation if available
            const initialRequestedDateDB = "{{ $supportRequest->requested_date?->format('Y-m-d') }}";
            const initialCreatedAtDB = "{{ $supportRequest->created_at?->format('Y-m-d') }}";


            /**
             * Calculates a future date by adding a specified number of working days
             * (excluding weekends) to a start date.
             * @param {Date} startDate - The initial date.
             * @param {number} workdays - The number of working days to add.
             * @returns {Date} The calculated future date.
             */
            function calculateWorkdaysFrom(startDate, workdays) {
                let date = new Date(startDate);
                let added = 0;
                while (added < workdays) {
                    date.setDate(date.getDate() + 1); // Move to the next day
                    // Check if the current day is not Saturday (6) or Sunday (0)
                    if (date.getDay() !== 0 && date.getDay() !== 6) {
                        added++; // Only count weekdays
                    }
                }
                return date;
            }

            /**
             * Populates the urgentCase dropdown based on the selected request type.
             */
            function updateUrgentCaseOptions() {
                const selectedRequestType = requestTypeSelect.value;
                urgentCaseLevelSelect.innerHTML = '<option value="">-- Select Severity Level --</option>'; // Clear existing options

                if (selectedRequestType && tasksData[selectedRequestType]) {
                    const urgentLevels = Object.keys(tasksData[selectedRequestType]);
                    urgentLevels.forEach(level => {
                        const option = document.createElement('option');
                        option.value = level;
                        option.textContent = level;
                        // Set selected if it matches the initial/old value
                        if (level === initialUrgentCaseLevel) {
                            option.selected = true;
                        }
                        urgentCaseLevelSelect.appendChild(option);
                    });
                }
                // After updating options, also update the task details
                updateTaskDetails();
            }

            /**
             * Displays the detailed information for the selected task type and urgent case level.
             */
            function updateTaskDetails() {
                const selectedRequestType = requestTypeSelect.value;
                const selectedUrgentCaseLevel = urgentCaseLevelSelect.value;

                if (selectedRequestType && selectedUrgentCaseLevel && tasksData[selectedRequestType] && tasksData[selectedRequestType][selectedUrgentCaseLevel]) {
                    const task = tasksData[selectedRequestType][selectedUrgentCaseLevel];
                    detailsDiv.classList.remove('hidden');
                    descEl.textContent = task.description;
                    resolutionTimeEl.textContent = task.resolution_time_text;
                    notesEl.textContent = task.notes;

                    // Determine the start date for calculation:
                    // 1. Prefer the current value in the 'requested_date' input.
                    // 2. If 'requested_date' input is empty, use the requested_date from the DB.
                    // 3. If both are empty, use the created_at date from the DB.
                    let startDateForCalculation;
                    if (requestedDateInput.value) {
                        startDateForCalculation = new Date(requestedDateInput.value);
                    } else if (initialRequestedDateDB) {
                        startDateForCalculation = new Date(initialRequestedDateDB);
                    } else {
                        startDateForCalculation = new Date(initialCreatedAtDB);
                    }


                    // Calculate expected completion date
                    const resolutionDays = task.resolution_days;
                    const completionDate = calculateWorkdaysFrom(startDateForCalculation, resolutionDays);
                    completionDateEl.textContent = completionDate.toISOString().split('T')[0]; // Format to YYYY-MM-DD
                    datelineInput.value = completionDate.toISOString().split('T')[0]; // Update the input field

                } else {
                    detailsDiv.classList.add('hidden'); // Hide details if no valid selection
                    descEl.textContent = '';
                    resolutionTimeEl.textContent = '';
                    completionDateEl.textContent = '';
                    notesEl.textContent = '';
                    datelineInput.value = ''; // Clear dateline input
                }
            }

            // Event Listeners
            requestTypeSelect.addEventListener('change', updateUrgentCaseOptions);
            urgentCaseLevelSelect.addEventListener('change', updateTaskDetails);
            requestedDateInput.addEventListener('change', updateTaskDetails); // Listen for changes on requested_date

            // Initialize on page load:
            // 1. Populate urgent case levels based on the pre-selected request type (if any)
            updateUrgentCaseOptions();
            // 2. Explicitly call updateTaskDetails to set the initial values based on current data
            //    This is important for when the page loads with existing data.
            updateTaskDetails();
        })();


        function updateTaskDetailsSummary() {
            const taskDetailsDiv = document.getElementById('taskDetails');
            const textarea = document.getElementById('taskDetailsSummary');

            if (!taskDetailsDiv || !textarea) return;

            // Only run if #taskDetails is visible (not hidden)
            const isVisible = window.getComputedStyle(taskDetailsDiv).display !== 'none';
            if (!isVisible) return;

            const description = document.getElementById('taskDescription')?.textContent.trim();
            const resolutionTime = document.getElementById('taskResolutionTime')?.textContent.trim();
            const completionDate = document.getElementById('taskCompletionDate')?.textContent.trim();
            const notes = document.getElementById('taskNotes')?.textContent.trim();

            const formattedText =
                `Description: ${description}\n` +
                `Resolution Time: ${resolutionTime}\n` +
                `Expected Completion Date: ${completionDate}\n` +
                `Notes: ${notes}`;

            textarea.value = formattedText;
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Watch for visibility and content changes using MutationObserver
            const taskDetailsDiv = document.getElementById('taskDetails');

            if (taskDetailsDiv) {
                const observer = new MutationObserver(() => {
                    updateTaskDetailsSummary();
                });

                observer.observe(taskDetailsDiv, {
                    childList: true,
                    subtree: true,
                    characterData: true,
                    attributes: true
                });

                // Also update periodically just in case (as fallback)
                setInterval(updateTaskDetailsSummary, 1000);
            }
        });

    </script>
@endsection
