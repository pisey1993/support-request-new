@extends('layouts.app')

@section('title', 'Support Request Details')

@section('content')
    <div class="font-sans antialiased bg-gray-100 min-h-screen pt-4 px-4 sm:pt-6 sm:px-6 lg:pt-8 lg:px-8">
        <div class="container mx-auto max-w-7xl" id="captureContainer">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-6 text-center leading-tight">
                Support Request Details
            </h1>

            {{-- Main content div to be converted to PDF --}}
            <div id="supportRequestContent" class="bg-white shadow-xl rounded-2xl p-6 sm:p-8 lg:p-10 border border-gray-200">

                {{-- General Details Section --}}
                <div class="mb-10 pb-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"
                             class="mr-3 text-blue-600">
                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                        General Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6">
                        @php
                            // Get user object from users collection by user_id
                            $user = $users->firstWhere('id', $supportRequest->user_id);
                            $userName = $user?->name ?? 'Unknown User';

                            $department = $departments->firstWhere('id', $supportRequest->requester_department);
                            $departmentName = $department?->department_name ?? 'Unknown Department';

                            $position = $positions->firstWhere('id', $supportRequest->position);
                            $positionName = $position?->positions_name ?? 'Unknown Position';

                            $detailFields = [
                                [
                                    'label' => 'Requester Name',
                                    'value' => $supportRequest->requester_name,
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500">
                                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>'
                                ],
                                [
                                    'label' => 'User ID',
                                    'value' => $userName,
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-500">
                                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                                </svg>'
                                ],
                                [
                                    'label' => 'Position',
                                    'value' => $positionName,
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500">
                                                    <rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect>
                                                    <path d="M16 2V7"></path>
                                                    <path d="M8 2V7"></path>
                                                    <path d="M12 12h4"></path>
                                                    <path d="M12 16h4"></path>
                                                </svg>'
                                ],
                                [
                                    'label' => 'Requester Department',
                                    'value' => $departmentName,
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-500">
                                                    <path d="M12.586 1.586A2 2 0 0 0 11.172 1H4a2 2 0 0 0-2 2v7.586a2 2 0 0 0 .586 1.414L19 21.5l3.5-3.5L5.086 2.586A2 2 0 0 0 3.672 2H20a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2h-6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z"></path>
                                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                </svg>'
                                ],
                                [
                                    'label' => 'Ticket No',
                                    'value' => $supportRequest->ticket_no,
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-500">
                                                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                    <path d="M12 11h4"></path>
                                                    <path d="M12 16h4"></path>
                                                    <path d="M8 11h.01"></path>
                                                    <path d="M8 16h.01"></path>
                                                </svg>'
                                ],
                                [
                                    'label' => 'Request Type',
                                    'value' => $supportRequest->request_type,
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500">
                                                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                </svg>'
                                ],
                                [
                                    'label' => 'Project Title',
                                    'value' => $supportRequest->project_title,
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500">
                                                    <path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1.3.5 2.6 1.5 3.5.8.8 1.3 1.5 1.5 2.5"></path>
                                                    <path d="M9 18.5V18a3 3 0 0 1 6 0v.5"></path>
                                                    <path d="M7 20h10"></path>
                                                    <path d="M12 22v-2"></path>
                                                </svg>'
                                ],

                                [
                                    'label' => 'Requested Status',
                                    'value' => $supportRequest->requested_status,
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-cyan-600">
                                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                    <path d="m9 11 3 3L22 4"></path>
                                                </svg>'
                                ],
                                [
                                    'label' => 'HOD Approval (ID)',
                                    'value' => $supportRequest->HOD_Approval,
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-teal-500">
                                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>'
                                ],
                                [
                                    'label' => 'Created By',
                                    'value' => $supportRequest->create_by,
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-pink-500">
                                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>'
                                ],
                                [
                                    'label' => 'Requested Date',
                                    'value' => $supportRequest->requested_date?->format('d-M-Y') ?? 'N/A',
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                </svg>'
                                ],
                                [
                                    'label' => 'Expected Date',
                                    'value' => $supportRequest->dateline_to_be_expected?->format('d-M-Y') ?? 'N/A', // Add this line
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                    <path d="M12 16h.01"></path>
                                                    <path d="M16 16h.01"></path>
                                                </svg>'
                                ],
                                [
                                    'label' => 'Severity Level',
                                    'value' => $supportRequest->urgentCase,
                                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-700">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                                    <line x1="12" y1="8" x2="12" y2="8"></line>
                                                </svg>'
                                ],

                            ];
                        @endphp

                        @foreach ($detailFields as $field)
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-6 h-6" aria-hidden="true">{!! $field['icon'] !!}</div>
                                <span class="font-semibold text-sm text-gray-700">{{ $field['label'] }}:</span>
                                @if ($field['label'] === 'Urgent Case')
                                    <span
                                        class="text-sm font-bold {{ $field['value'] === 'Yes' ? 'text-rose-600' : 'text-green-600' }}">
                                        {{ $field['value'] }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-900">{{ $field['value'] }}</span>
                                @endif
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="space-y-6">
                    @php
                        $descriptionFields = [
                            ['label' => 'Severity Description', 'value' => $supportRequest->severity_description],
                        ];
                    @endphp

                    @foreach ($descriptionFields as $field)
                        @if (!empty($field['value']))
                            <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                                <h3 class="text-lg font-semibold text-gray-700 mb-3">
                                    {{ $field['label'] }}
                                </h3>
                                <ul class="list-disc list-inside text-gray-800 space-y-1 leading-relaxed">
                                    @foreach (explode("\n", $field['value']) as $line)
                                        @if (trim($line) !== '')
                                            <li>{{ $line }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Problem Description & Design Details Section --}}
                <div class="mb-10 pb-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="mr-3 text-emerald-600">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V6.5A2.5 2.5 0 0 0 17.5 4h-11A2.5 2.5 0 0 0 4 6.5v13Z"></path>
                        </svg>
                        Project Details & Description
                    </h2>
                    <div class="space-y-6">
                        @php
                            $descriptionFields = [
                                ['label' => 'Project Description', 'value' => $supportRequest->purpose_of_project],
                            ];
                        @endphp
                        @foreach ($descriptionFields as $field)
                            @if (!empty($field['value']))
                                <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-2">
                                        {{ $field['label'] }}
                                    </h3>
                                    <div class="text-gray-800 leading-relaxed prose prose-sm max-w-none">
                                        {!! $field['value'] !!}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>


                {{-- Attachments Section --}}
                @php
                    $attachments = [];
                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
                    for ($i = 1; $i <= 5; $i++) {
                        $field = "attachment{$i}";
                        $filePath = $supportRequest->$field ?? null;
                        if ($filePath) {
                            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($extension), $imageExtensions);
                            $attachments[] = [
                                'filePath' => $filePath,
                                'isImage' => $isImage,
                                'name' => "Attachment {$i}." . $extension,
                            ];
                        }
                    }
                @endphp

                @if (count($attachments) > 0)
                    <div class="mb-10">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round"
                                 strokeLinejoin="round" class="mr-3 text-purple-600">
                                <path
                                    d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07L9.5 5.5A3.5 3.5 0 0 0 5 9V9.5h.5A3.5 3.5 0 0 0 8 13v0A3.5 3.5 0 0 0 11.5 9H12v-.5a3.5 3.5 0 0 0-7-7"></path>
                            </svg>
                            Attachments
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($attachments as $attachment)
                                <div
                                    class="block bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-200 ease-in-out transform hover:-translate-y-1"
                                >
                                    @if ($attachment['isImage'])
                                        <img
                                            src="{{ asset($attachment['filePath']) }}"
                                            alt="{{ $attachment['name'] }}"
                                            class="w-full h-40 object-cover border-b border-gray-200"
                                            onerror="this.onerror=null; this.src='https://placehold.co/600x400/D1D5DB/4B5563?text=Image+Not+Found';"
                                        />
                                    @else
                                        <div class="flex items-center justify-center h-40 bg-gray-100 text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"
                                                 strokeLinecap="round" strokeLinejoin="round" class="mr-2">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                            </svg>
                                            <span class="font-semibold">{{ $attachment['name'] }}</span>
                                        </div>
                                    @endif
                                    <div class="p-4 flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700 truncate">
                                            {{ $attachment['name'] }}
                                        </span>
                                        @if ($attachment['isImage'])
                                            <a
                                                href="{{ asset($attachment['filePath']) }}"
                                                download="{{ $attachment['name'] }}"
                                                class="text-blue-600 hover:underline text-sm flex items-center"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" class="mr-1">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                </svg>
                                                Download
                                            </a>
                                        @else
                                            <a
                                                href="{{ asset($attachment['filePath']) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="text-blue-600 hover:underline text-sm flex items-center"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" class="mr-1">
                                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07L9.5 5.5A3.5 3.5 0 0 0 5 9V9.5h.5A3.5 3.5 0 0 0 8 13v0A3.5 3.5 0 0 0 11.5 9H12v-.5a3.5 3.5 0 0 0-7-7"></path>
                                                </svg>
                                                View/Download
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 justify-center mt-6">

                    {{-- New "Download Page as PDF" Button --}}
                    <button
                        id="downloadPdfButton"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-full shadow hover:bg-blue-700 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300"
                    >
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H5a2 2 0 01-2-2V6a2 2 0 012-2h7l4 4h3a2 2 0 012 2v7a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Page as PDF
                    </button>

                    @if (Auth::user()->department_id == 7)
                        <a
                            href="{{ route('support-requests.edit', $supportRequest->id) }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-yellow-500 text-white font-semibold rounded-full shadow hover:bg-yellow-600 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-300"
                        >
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z"/>
                            </svg>
                            Edit Request
                        </a>
                    @endif

                    <a
                        href="{{ route('support-requests.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-300 text-gray-800 font-semibold rounded-full shadow hover:bg-gray-400 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-300"
                    >
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Back to List
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Include html2pdf.js library --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.getElementById('downloadPdfButton').addEventListener('click', function () {
            const element = document.getElementById('captureContainer');

            html2canvas(element, {
                scale: 2,       // Increase scale for better quality
                useCORS: true,
                logging: false,
                scrollX: 0,
                scrollY: -window.scrollY,  // fix position if container is scrolled out of view
            }).then(function (canvas) {
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });

                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();

                // Calculate the height of the image to keep aspect ratio
                const imgWidth = pageWidth;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                // Add image to PDF
                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

                const fileName = 'Support_Request_' + '{{ $supportRequest->ticket_no ?? "Details" }}' + '.pdf';
                pdf.save(fileName);
            }).catch(function(err){
                console.error('Capture error:', err);
                alert('Failed to capture content. See console for details.');
            });
        });
    </script>




@endsection
