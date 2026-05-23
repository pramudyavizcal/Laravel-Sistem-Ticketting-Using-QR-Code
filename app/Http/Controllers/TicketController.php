<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    public function show(string $ticketCode)
    {
        $attendee = Attendee::where('ticket_code', $ticketCode)
            ->with('event')
            ->firstOrFail();

        // Generate SVG format — tidak butuh imagick/GD khusus
        $qrCode = QrCode::format('svg')
            ->size(250)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($ticketCode);

        return view('ticket.show', compact('attendee', 'qrCode'));
    }
}
