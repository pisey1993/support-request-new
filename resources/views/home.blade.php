@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Support Requests</h1>
            <a href="{{ route('support-requests.create') }}" class="btn btn-success">
                Create Request
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>Ticket No</th>
                    <th>Requester</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Requested Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($requests as $request)
                    <tr>
                        <td>{{ $request->ticket_no }}</td>
                        <td>{{ $request->requester_name }}</td>
                        <td>{{ $request->request_type }}</td>
                        <td>{{ $request->requested_status }}</td>
                        <td>{{ \Carbon\Carbon::parse($request->requested_date)->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('support-requests.show', $request->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('support-requests.edit', $request->id) }}" class="btn btn-primary btn-sm mx-1">Edit</a>
                            <form action="{{ route('support-requests.destroy', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted fst-italic py-4">No support requests found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $requests->links() }}
        </div>
    </div>
@endsection
