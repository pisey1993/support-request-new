@extends('layouts.app')

@section('title', 'Edit Support Request')

@section('content')
    {{-- Load Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="w-full my-12 px-4 sm:px-6 lg:px-8 font-sans"> {{-- Changed to w-full for fluid width, added responsive padding and font-sans for Inter font --}}
        <div class="bg-white rounded-xl shadow-lg p-8 w-full mx-auto"> {{-- Changed from max-w-4xl to w-full, kept mx-auto for centering --}}
            <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">Edit Support Request</h1>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-md">
                    <div class="font-bold mb-2">Whoops! There were some errors:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Back Button (added a margin-top for spacing) --}}
            <a href="/support-requests" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out mt-4"> Back </a>

            <form action="{{ route('support-requests.update', $supportRequest->id) }}" method="POST" class="space-y-6 mt-6"> {{-- Added mt-6 for spacing from the Back button --}}
                @csrf
                @method('PUT')

                {{-- Hidden User ID field --}}
                <div style="display: none">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User ID</label>
                    <input type="number" name="user_id" id="user_id" value="{{ old('user_id', $supportRequest->user_id) }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Position field --}}
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position <span class="text-red-600">*</span></label>
                        <input type="text" name="position" id="position" value="{{ old('position', $supportRequest->position) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out" required>
                    </div>

                    {{-- Ticket No field (Corrected value to $supportRequest->ticket_no) --}}
                    <div>
                        <label for="ticket_no" class="block text-sm font-medium text-gray-700 mb-1">Ticket No <span class="text-red-600">*</span></label>
                        <input type="text" name="ticket_no" id="ticket_no" value="{{ old('ticket_no', $supportRequest->id) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out" required>
                    </div>

                    {{-- Request Type dropdown --}}
                    <div>
                        <label for="request_type" class="block text-sm font-medium text-gray-700 mb-1">Request Type <span class="text-red-600">*</span></label>
                        <select name="request_type" id="request_type"
                                class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out" required>
                            <option value="">-- Select Request Type --</option>
                            @php
                                $requestTypes = ['Repair', 'Create System', 'Update System', 'Maintenance'];
                            @endphp
                            @foreach ($requestTypes as $type)
                                <option value="{{ $type }}" {{ old('request_type', $supportRequest->request_type) === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Requester Name field --}}
                    <div>
                        <label for="requester_name" class="block text-sm font-medium text-gray-700 mb-1">Requester Name <span class="text-red-600">*</span></label>
                        <input type="text" name="requester_name" id="requester_name" value="{{ old('requester_name', $supportRequest->requester_name) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out" required>
                    </div>

                    {{-- Project Title field --}}
                    <div>
                        <label for="project_title" class="block text-sm font-medium text-gray-700 mb-1">Project Title</label>
                        <input type="text" name="project_title" id="project_title" value="{{ old('project_title', $supportRequest->project_title) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
                    </div>

                    {{-- Urgent Case Level dropdown --}}
                    <div>
                        <label for="urgent_case_level" class="block text-sm font-medium text-gray-700 mb-1">Severity Level <span class="text-red-600">*</span></label>
                        <select name="urgent_case_level" id="urgent_case_level"
                                class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out" required>
                            <option value="">-- Select Severity Level --</option>
                            {{-- Options dynamically loaded by JavaScript --}}
                        </select>
                    </div>

                    {{-- Dynamic Task Details display --}}
                    <div class="md:col-span-2"> {{-- Span full width on medium and larger screens --}}
                        <label class="block text-sm font-medium text-gray-700 mb-1">Task Details</label>
                        <div id="taskDetails" class="hidden bg-blue-50 border border-blue-200 text-blue-800 rounded-lg p-4 shadow-inner text-sm space-y-1">
                            <div><strong>Description:</strong> <span id="taskDescription"></span></div>
                            <div><strong>Resolution Time:</strong> <span id="taskResolutionTime"></span></div>
                            <div><strong>Expected Completion Date:</strong> <span id="taskCompletionDate"></span></div>
                            <div><strong>Notes:</strong> <span id="taskNotes"></span></div>
                        </div>
                    </div>

                    {{-- Dateline to be Expected field (read-only, calculated) --}}
                    <div>
                        <label for="dateline_to_be_expected" class="block text-sm font-medium text-gray-700 mb-1">Dateline to be Expected</label>
                        <input type="date" name="dateline_to_be_expected" id="dateline_to_be_expected"
                               value="{{ old('dateline_to_be_expected', $supportRequest->dateline_to_be_expected?->format('Y-m-d')) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    {{-- Requested Date field --}}
                    <div>
                        <label for="requested_date" class="block text-sm font-medium text-gray-700 mb-1">Requested Date</label>
                        <input type="date" name="requested_date" id="requested_date"
                               value="{{ old('requested_date', $supportRequest->requested_date?->format('Y-m-d')) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
                    </div>

                    {{-- Requested Status field (now a select dropdown) --}}
                    <div>
                        <label for="requested_status" class="block text-sm font-medium text-gray-700 mb-1">Requested Status</label>
                        <select name="requested_status" id="requested_status"
                                class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
                            <option value="Pending" {{ old('requested_status', $supportRequest->requested_status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Progress" {{ old('requested_status', $supportRequest->requested_status) == 'Progress' ? 'selected' : '' }}>Progress</option>
                            <option value="UAT" {{ old('requested_status', $supportRequest->requested_status) == 'UAT' ? 'selected' : '' }}>UAT</option>
                            <option value="Resolved" {{ old('requested_status', $supportRequest->requested_status) == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>

                    {{-- Hidden Created By field --}}
                    <div style="display: none">
                        <label for="create_by" class="block text-sm font-medium text-gray-700 mb-1">Created By</label>
                        <input type="text" name="create_by" id="create_by"
                               value="{{ old('create_by', $supportRequest->create_by) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2">
                    </div>

                    {{-- Hidden HOD Approval field --}}
                    <div style="display: none">
                        <label for="HOD_Approval" class="block text-sm font-medium text-gray-700 mb-1">HOD Approval (ID)</label>
                        <input type="number" name="HOD_Approval" id="HOD_Approval"
                               value="{{ old('HOD_Approval', $supportRequest->HOD_Approval) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2">
                    </div>

                    {{-- Requester Department field (read-only) --}}
                    <div>
                        <label for="requester_department" class="block text-sm font-medium text-gray-700 mb-1">Requester Department</label>
                        <input style="display: none" type="number" name="requester_department" id="requester_department"
                               value="{{ old('requester_department', $supportRequest->requester_department) }}">
                        <input type="text" readonly
                               value="{{ optional(Auth::user()->department)->department_name }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 bg-gray-100 text-gray-700 cursor-not-allowed">
                    </div>
                </div>

                {{-- Description field --}}
                <div class="col-span-full">
                    <label for="purpose_of_project" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="purpose_of_project" id="purpose_of_project" rows="3"
                              class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">{{ old('purpose_of_project', $supportRequest->purpose_of_project) }}</textarea>
                </div>

                {{-- Hidden Description of Problem field --}}
                <div style="display: none">
                    <label for="description_of_problem" class="block text-sm font-medium text-gray-700 mb-1">Description of Problem</label>
                    <textarea name="description_of_problem" id="description_of_problem" rows="3"
                              class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2">{{ old('description_of_problem', $supportRequest->description_of_problem) }}</textarea>
                </div>

                {{-- Actual Completed Date field --}}
                <div>
                    <label for="Actual_completed_date" class="block text-sm font-medium text-gray-700 mb-1">Actual Completed Date</label>
                    <input type="date" name="Actual_completed_date" id="Actual_completed_date"
                           value="{{ old('Actual_completed_date', $supportRequest->Actual_completed_date?->format('Y-m-d')) }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
                </div>

                {{-- Attachments Display --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($attachments as $attachment)
                        <a
                            href="{{ asset($attachment['filePath']) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="block bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-200 ease-in-out transform hover:-translate-y-1"
                        >
                            @if ($attachment['isImage'])
                                <img
                                    src="{{ asset($attachment['filePath']) }}"
                                    alt="{{ $attachment['name'] }}"
                                    class="w-full h-40 object-cover border-b border-gray-200"
                                    onerror="this.onerror=null; this.src='https://placehold.co/600x400/D1D5DB/4B5563?text=Image+Not+Found';" {{-- Updated placeholder text --}}
                                />
                            @else
                                <div class="flex items-center justify-center h-40 bg-gray-100 text-gray-600 p-4"> {{-- Added padding for icon and text --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"
                                         strokeLinecap="round" strokeLinejoin="round" class="flex-shrink-0 mr-2"> {{-- flex-shrink-0 to prevent icon from shrinking --}}
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    <span class="font-semibold text-center truncate">{{ $attachment['name'] }}</span> {{-- Added truncate for long file names --}}
                                </div>
                            @endif
                            <div class="p-4 flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700 truncate">
                                    {{ $attachment['name'] }}
                                </span>
                                <span class="text-blue-600 hover:underline text-sm ml-2 flex-shrink-0">View/Download</span> {{-- flex-shrink-0 for "View/Download" --}}
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Form Submission Buttons --}}
                <div class="pt-6 flex justify-end space-x-4">
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                        Update Request
                    </button>
                    <a href="{{ route('support-requests.index') }}"
                       class="inline-flex justify-center py-2 px-6 border border-gray-300 shadow-sm text-sm font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-300 ease-in-out">
                        Cancel
                    </a>
                </div>
            </form>
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
        (() => {
            // Task data as defined in PHP, passed to JavaScript
            const tasksData = @json($tasksData);
            // Get the original creation date of the support request
            const createdAt = new Date(@json($supportRequest->created_at));
            // Get references to the select and display elements
            const requestTypeSelect = document.getElementById('request_type');
            const urgentCaseLevelSelect = document.getElementById('urgent_case_level');
            const detailsDiv = document.getElementById('taskDetails');
            const descEl = document.getElementById('taskDescription');
            const resolutionTimeEl = document.getElementById('taskResolutionTime');
            const completionDateEl = document.getElementById('taskCompletionDate');
            const notesEl = document.getElementById('taskNotes');
            const datelineInput = document.getElementById('dateline_to_be_expected');

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
             * Populates the urgent_case_level dropdown based on the selected request type.
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
                        // Set selected if it matches the old value from the supportRequest object
                        if (level === "{{ old('urgent_case_level', $supportRequest->urgent_case_level) }}") {
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

                    // Calculate expected completion date
                    const resolutionDays = task.resolution_days;
                    const completionDate = calculateWorkdaysFrom(createdAt, resolutionDays);
                    completionDateEl.textContent = completionDate.toISOString().split('T')[0]; // Format to YYYY-MM-DD
                    datelineInput.value = completionDate.toISOString().split('T')[0]; // Update the hidden input field

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

            // Initialize on page load:
            // 1. Populate urgent case levels based on the pre-selected request type (if any)
            updateUrgentCaseOptions();
            // 2. Display task details based on pre-selected request type and urgent case level (if any)
            //    This is called implicitly by updateUrgentCaseOptions, but an explicit call
            //    can be added if there are scenarios where only urgentCaseLevel might be pre-filled
            //    without requestType triggering updateUrgentCaseOptions initially.
            //    However, since urgentCaseLevel is dependent, updateUrgentCaseOptions should handle it.
            //    So, no need for an extra updateTaskDetails() call here.
        })();
    </script>
@endsection
