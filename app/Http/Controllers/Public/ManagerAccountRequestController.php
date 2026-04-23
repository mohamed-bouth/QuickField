<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ManagerAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManagerAccountRequestController extends Controller
{
    public function landing(Request $request)
    {
        $statusLookup = null;

        if ($request->filled('request_code')) {
            $statusLookup = $this->findByCode($request->input('request_code'));
        }

        return view('welcome', compact('statusLookup'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email', 'unique:manager_account_requests,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $managerRequest = ManagerAccountRequest::create([
            'request_code' => $this->generateRequestCode(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'status' => 'pending',
        ]);

        return redirect()->route('manager-requests.landing', [
            'request_code' => $managerRequest->request_code,
        ])->with('success', 'Request submitted. Save your code to track activation status.');
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'request_code' => ['required', 'string', 'max:24'],
        ]);

        return redirect()->route('manager-requests.landing', [
            'request_code' => strtoupper(trim($validated['request_code'])),
        ]);
    }

    private function generateRequestCode(): string
    {
        do {
            $code = 'MGR-' . strtoupper(Str::random(8));
        } while (ManagerAccountRequest::where('request_code', $code)->exists());

        return $code;
    }

    private function findByCode(string $code): ?ManagerAccountRequest
    {
        return ManagerAccountRequest::with('user')
            ->where('request_code', strtoupper(trim($code)))
            ->first();
    }
}
