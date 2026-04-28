<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Reservation;

class QRScanController extends Controller
{

    public function index()
    {
        return view('admin.qr-scan.index');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'qr_code_hash' => 'required|string'
        ]);

        $ticket = Ticket::where('qr_code_hash', $request->qr_code_hash)->first();

        if (!$ticket) {
            return back()->with('error', 'their no Code like this in the system!');
        }


        if ($ticket->scan_status === 'scanned') {
            return back()->with('error', 'the ticket has aready scanned!');
        }

        return redirect()->route('admin.scan-ticket.details', $ticket->qr_code_hash);
    }

    public function showDetails($hash)
    {
        $ticket = Ticket::with(['payment.reservation.user', 'payment.reservation.field'])
                        ->where('qr_code_hash', $hash)
                        ->firstOrFail();

        return view('admin.qr-scan.details', compact('ticket'));
    }

    public function confirm($hash)
    {
        $ticket = Ticket::with('payment.reservation')->where('qr_code_hash', $hash)->firstOrFail();

        $ticket->update([
            'scan_status' => 'scanned'
        ]);
        $ticket->payment->update([
            'status' => 'finished'
        ]);
        $ticket->payment->reservation->update([
            'status' => 'completed'
        ]);

        return redirect()->route('admin.scan-ticket.index')->with('success', 'the Reservation Completed with success.');
    }
}