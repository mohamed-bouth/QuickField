<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagerAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerAccountRequestController extends Controller
{
    public function index(Request $request)
    {
        $allowedStatuses = ['pending', 'approved', 'rejected'];
        $selectedStatus = $request->input('status');

        $requests = ManagerAccountRequest::with(['user', 'reviewer'])
            ->when(in_array($selectedStatus, $allowedStatuses, true), function ($query) use ($selectedStatus) {
                $query->where('status', $selectedStatus);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.manager-requests.index', compact('requests', 'allowedStatuses', 'selectedStatus'));
    }

    public function approve(Request $request, ManagerAccountRequest $managerRequest)
    {
        if ($managerRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be approved.');
        }

        DB::transaction(function () use ($request, $managerRequest) {
            $user = User::create([
                'name' => $managerRequest->name,
                'email' => $managerRequest->email,
                'phone' => $managerRequest->phone,
                'password' => $managerRequest->password,
                'status' => 'active',
            ]);

            $user->assignRole('field_manager');

            $managerRequest->update([
                'status' => 'approved',
                'user_id' => $user->id,
                'reviewed_by' => $request->user()->id,
                'rejection_reason' => null,
                'processed_at' => now(),
            ]);
        });

        return back()->with('success', 'Manager account request approved and account created.');
    }

    public function reject(Request $request, ManagerAccountRequest $managerRequest)
    {
        if ($managerRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be rejected.');
        }

        $validated = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $managerRequest->update([
            'status' => 'rejected',
            'reviewed_by' => $request->user()->id,
            'rejection_reason' => $validated['rejection_reason'] ?? null,
            'processed_at' => now(),
        ]);

        return back()->with('success', 'Manager account request rejected.');
    }
}
