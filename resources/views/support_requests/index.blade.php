@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="w-full my-12 overflow-x-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 px-4">
            <h1 class="text-2xl font-bold text-gray-900">Support Requests</h1>
            <div class="flex gap-3">
                <a href="{{ route('support-requests.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md text-lg font-semibold transition">
                    <i class="bi bi-plus-circle mr-2" aria-hidden="true"></i>Create Request
                </a>
                <a href="{{ route('support-requests.myrequest') }}"
                   class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg shadow-md text-lg font-semibold transition">
                    <i class="bi bi-eye-fill mr-2" aria-hidden="true"></i>View Your Ticket
                </a>
            </div>
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('support-requests.myrequest') }}" class="mb-6 flex items-center gap-3 px-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="px-4 py-2 w-64 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Search by ticket no or project title...">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow text-sm font-medium">
                Search
            </button>
        </form>

        <!-- Table -->
        <div class="rounded-lg shadow-sm border border-gray-200 mx-4">
            <table class="w-full divide-y divide-gray-200 table-auto text-sm">
                <thead class="bg-gray-100 text-gray-500 uppercase text-xs tracking-wider select-none">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">Ticket No</th>
                    <th class="px-4 py-3 text-left font-medium">Requester</th>
                    <th class="px-4 py-3 text-left font-medium">Project Title</th>
                    <th class="px-4 py-3 text-left font-medium">Type</th>
                    <th class="px-4 py-3 text-left font-medium">Status</th>
                    <th class="px-4 py-3 text-left font-medium">Requested Date</th>
                    <th class="px-4 py-3 text-center font-medium">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($requests as $request)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold text-blue-600 whitespace-nowrap">{{ $request->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $request->requester_name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $request->project_title }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $request->request_type }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $statusClass = match($request->requested_status) {
                                    'Open' => 'bg-green-100 text-green-800',
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'Closed' => 'bg-gray-200 text-gray-600',
                                    'Done' => 'bg-green-100 text-green-800',
                                    default => 'bg-blue-100 text-blue-800',
                                };
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                    {{ $request->requested_status }}
                                </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($request->requested_date)->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <!-- View Button -->
                                <a href="{{ route('support-requests.show', $request->id) }}"
                                   class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded shadow-sm">
                                    <i class="bi bi-eye mr-1"></i> View
                                </a>

                            @if (Auth::user()->department_id == 7)
                                <!-- Edit Button -->
                                    <a href="{{ route('support-requests.edit', $request->id) }}"
                                       class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded shadow-sm">
                                        <i class="bi bi-pencil mr-1"></i> Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('support-requests.destroy', $request->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this request?');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded shadow-sm">
                                            <i class="bi bi-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-400 italic py-8">
                            No support requests found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $requests->withQueryString()->links() }}
        </div>
    </div>
@endsection
