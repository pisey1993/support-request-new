<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\SupportRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SupportRequestController extends Controller
{
    public function index()
    {
        $requests = SupportRequest::latest()->paginate(10);
        return view('support_requests.index', compact('requests'));
    }

    public function create()
    {
        $users = User::all();
        return view('support_requests.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $validated['user_id'] = auth()->id();

        // Create record first WITHOUT attachment fields
        $supportRequest = SupportRequest::create($validated);

        // Define upload directory using the new record's ID
        $uploadDir = public_path('attachments/' . $supportRequest->id);
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $updatedFields = [];

        // Upload files to folder named by record ID
        for ($i = 1; $i <= 5; $i++) {
            $field = "attachment{$i}";
            if ($request->hasFile($field)) {
                $file = $request->file($field);

                if ($file->isValid()) {
                    $extension = $file->getClientOriginalExtension();
                    $uniqueName = uniqid("attach{$i}_") . '.' . $extension;

                    $destination = $uploadDir . DIRECTORY_SEPARATOR . $uniqueName;

                    // Move file using raw PHP
                    if (move_uploaded_file($file->getPathname(), $destination)) {
                        // Save relative path for DB update
                        $updatedFields[$field] = 'attachments/' . $supportRequest->id . '/' . $uniqueName;
                    }
                }
            }
        }

        // Update the record with attachment paths
        if (!empty($updatedFields)) {
            $supportRequest->update($updatedFields);
        }

        return redirect()->route('support-requests.show', $supportRequest->id)
            ->with('success', 'Request Created Successfully');
    }

    public function show(SupportRequest $supportRequest)
    {
        // Fetch all data
        $users = User::all();
        $positions = Position::all();
        $departments = Department::all(); // In case you also need department

        return view('support_requests.show', compact('supportRequest', 'users', 'departments', 'positions'));
    }

    public function edit($id)
    {
        $supportRequest = SupportRequest::findOrFail($id);
        $users = User::all();
        $departments = Department::all();
        $positions = Position::all();

        // --- Start of Fix ---
        $attachments = [];
        // Loop through the possible attachment fields on the support request
        for ($i = 1; $i <= 5; $i++) {
            $attachmentField = "attachment{$i}";
            $filePath = $supportRequest->$attachmentField; // Get the file path from the model

            if ($filePath) { // Check if a path exists for this attachment field
                $fileName = basename($filePath); // Extract file name from path
                $extension = pathinfo($fileName, PATHINFO_EXTENSION); // Get file extension

                // Determine if it's an image based on common image extensions
                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);

                $attachments[] = [
                    'filePath' => $filePath,
                    'name' => $fileName,
                    'isImage' => $isImage,
                ];
            }
        }
        // --- End of Fix ---

        // Pass the attachments array to the view
        return view('support_requests.edit', compact('supportRequest', 'users', 'departments', 'positions', 'attachments'));
    }

    public function update(Request $request, SupportRequest $supportRequest)
    {
        $validated = $this->validateRequest($request);

        // Handle new uploaded files
        for ($i = 1; $i <= 5; $i++) {
            $field = "attachment{$i}";
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                // Ensure the upload directory exists for this support request ID
                $uploadDir = 'attachments/' . $supportRequest->id;
                $file = $request->file($field);
                $extension = $file->getClientOriginalExtension();
                $uniqueName = uniqid("attach{$i}_") . '.' . $extension; // Generate unique name

                // Store with unique name inside the specific request's folder
                $validated[$field] = $file->storeAs($uploadDir, $uniqueName, 'public_uploads'); // Use 'public_uploads' disk if configured or adjust as needed
                // If you used public_path() in `store`, ensure `storeAs` also targets public.
                // Or use Laravel's Storage facade for better handling if you're not already.
                // For direct public path storage, you might do:
                // $file->move(public_path($uploadDir), $uniqueName);
                // $validated[$field] = $uploadDir . '/' . $uniqueName;
            }
        }

        $supportRequest->update($validated);

        return redirect()->route('support-requests.index')->with('success', 'Request Updated');
    }

    public function destroy(SupportRequest $supportRequest)
    {
        $supportRequest->delete();
        return redirect()->route('support-requests.index')->with('success', 'Request Deleted');
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'user_id' => 'required|integer',
            'position' => 'required|string|max:255',
            'ticket_no' => 'nullable|string|max:255',
            'request_type' => 'nullable|string|max:255',
            'requester_name' => 'nullable|string|max:255',
            'project_title' => 'nullable|string|max:255',
            'urgent_case_level' => 'nullable|string|max:255', // Updated from urgentCase
            'purpose_of_project' => 'nullable|string',
            'description_of_problem' => 'nullable|string',
            'dateline_to_be_expected' => 'nullable|date',
            'requested_date' => 'nullable|date',
            'requested_status' => 'nullable|string|max:255',
            'create_by' => 'nullable|string|max:255',
            'design_detail' => 'nullable|string',
            'Actual_completed_date' => 'nullable|date',
            'HOD_Approval' => 'nullable|integer',
            'requester_department' => 'nullable|integer',

            // Attachment validation (optional but secure)
            'attachment1' => 'nullable|file|max:10240', // 10MB max
            'attachment2' => 'nullable|file|max:10240',
            'attachment3' => 'nullable|file|max:10240',
            'attachment4' => 'nullable|file|max:10240',
            'attachment5' => 'nullable|file|max:10240',
        ]);
    }
}
