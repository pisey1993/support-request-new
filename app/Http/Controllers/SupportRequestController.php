<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\SupportRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Logged; // ✅ Add this at the top

// ✅ Add this line

class SupportRequestController extends Controller
{
    public function index()
    {
        $requests = SupportRequest::latest()->paginate(10);
        return view('support_requests.index', compact('requests'));
    }


    public function myRequests(Request $request)
    {
        $userId = auth()->id();
        $search = $request->input('search');

        $requests = SupportRequest::where('user_id', $userId)
            ->when($search, function ($query, $search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhere('project_title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

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
        if (!$request->has('no_telegram') || !$request->boolean('no_telegram')) {
            $this->sendTelegramNotification($supportRequest);
        }
        return redirect()->route('support-requests.show', $supportRequest->id)
            ->with('success', 'Request Created Successfully');
    }

    private function sendTelegramNotification(SupportRequest $supportRequest)
    {
        $chatId = $this->getTelegramChatIdByDepartment($supportRequest->requester_department);

        if (!$chatId) {
            return;
        }

        $baseUrl = config('app.url'); // Make sure APP_URL is set in .env
        $link = "{$baseUrl}/support-requests/{$supportRequest->id}";

        $message = "*New Support Request Created*\n\n"
            . "*Ticket ID:* {$supportRequest->id}\n"
            . "*Requester:* {$supportRequest->requester_name}\n"
            . "*Type:* {$supportRequest->request_type}\n"
            . "*Project:* {$supportRequest->project_title}\n"
            . "*Requested Date:* {$supportRequest->requested_date}\n"
            . "*Created By:* {$supportRequest->create_by}\n"
            . "*View:* [Click here to view request]({$link})";

        $this->notifyTelegram($message, $chatId);
    }

    private function sendTelegramNotificationUpdate(SupportRequest $supportRequest)
    {
        $chatId = $this->getTelegramChatIdByDepartment($supportRequest->requester_department);

        if (!$chatId) {
            return;
        }

        $baseUrl = config('app.url'); // Make sure APP_URL is set in .env
        $link = "{$baseUrl}/support-requests/{$supportRequest->id}";

        $message = "*New Support Request Created*\n\n"
            . "*Ticket ID:* {$supportRequest->id}\n"
            . "*Requester:* {$supportRequest->requester_name}\n"
            . "*Type:* {$supportRequest->request_type}\n"
            . "*Project:* {$supportRequest->project_title}\n"
            . "*Requested Date:* {$supportRequest->requested_date}\n"
            . "*Created By:* {$supportRequest->create_by}\n"
            . "*Date To Be Expected:* {$supportRequest->dateline_to_be_expected}\n"
            . "*Severity Level* {$supportRequest->urgentCase}\n"
            . "*View:* [Click here to view request]({$link})";

        $this->notifyTelegram($message, $chatId);
    }
    private function getTelegramChatIdByDepartment(int $departmentId): ?string
    {
        $chatIds = [
            1 => "-1001738293636",  // Claims
            2 => "-1001642640133",  // Sales
            3 => "-569432354",      // Finance (Account)
            4 => "-1001786199448",  // Underwriting
            5 => "-751150890",      // HR & Admin
            6 => null,              // Management (no chat ID)
            7 => "-1001478096510",  // IT
            8 => "-595831210",      // Internal Audit
            9 => "-981379607",      // Legal
        ];

        return $chatIds[$departmentId] ?? null;
    }

    private function notifyTelegram(string $message, string $chatId)
    {
        $token = env('TELEGRAM_BOT_TOKEN'); // Add your bot token to your .env file

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);

        // Optional: log response or errors
        if (!$response->successful()) {
            \Log::error('Telegram notification failed', [
                'response' => $response->body(),
                'chat_id' => $chatId,
            ]);
        }
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
        $supportRequest = SupportRequest::with('subTasks')->findOrFail($id);

        $users = User::all();
        $departments = Department::all();
        $positions = Position::all();

        $attachments = [];
        for ($i = 1; $i <= 5; $i++) {
            $attachmentField = "attachment{$i}";
            $filePath = $supportRequest->$attachmentField;

            if ($filePath) {
                $fileName = basename($filePath);
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);

                $attachments[] = [
                    'filePath' => $filePath,
                    'name' => $fileName,
                    'isImage' => $isImage,
                ];
            }
        }

        return view('support_requests.edit', compact('supportRequest', 'users', 'departments', 'positions', 'attachments'));
    }


    public function update(Request $request, SupportRequest $supportRequest)
    {
        // 📝 Log the old data as JSON
        Logged::create([
            'content' => json_encode($supportRequest->toArray(), JSON_PRETTY_PRINT),
        ]);

        $validated = $this->validateRequest($request);

        // Handle new uploaded files
        for ($i = 1; $i <= 5; $i++) {
            $field = "attachment{$i}";
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $uploadDir = 'attachments/' . $supportRequest->id;
                $file = $request->file($field);
                $extension = $file->getClientOriginalExtension();
                $uniqueName = uniqid("attach{$i}_") . '.' . $extension;

                // Store file (adjust storage as needed)
                $validated[$field] = $file->storeAs($uploadDir, $uniqueName, 'public_uploads');
            }
        }

        $supportRequest->update($validated);
        $this->sendTelegramNotificationUpdate($supportRequest);
        return redirect()->route('support-requests.show', $supportRequest->id)
            ->with('success', 'Request Updated');
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
            'urgentCase' => 'nullable|string|max:255', // Updated from urgentCase
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
            'severity_description' => 'nullable|string',
        ]);
    }
}
