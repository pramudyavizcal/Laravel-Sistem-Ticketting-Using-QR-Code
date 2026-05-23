<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Mail\TicketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handleInvoice(Request $request)
    {
        $callbackToken = config('services.xendit.callback_token');
        $headerToken = $request->header('x-callback-token');

        if ($callbackToken && $headerToken !== $callbackToken) {
            Log::warning('Xendit Webhook: Invalid callback token');
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $data = $request->all();
        $externalId = $data['external_id'];
        $status = $data['status'];

        Log::info('Xendit Webhook received: ' . $externalId . ' - ' . $status);

        if ($status === 'PAID' || $status === 'SETTLED') {
            $attendee = Attendee::where('ticket_code', $externalId)->first();

            if ($attendee) {
                if ($attendee->payment_status !== 'paid') {
                    $attendee->update([
                        'payment_status' => 'paid',
                        'registration_status' => 'approved',
                        'admin_note' => 'Paid via Xendit (' . ($data['payment_method'] ?? 'Online') . ')',
                    ]);

                    // Send Ticket Email
                    if ($attendee->email) {
                        try {
                            Mail::to($attendee->email)->send(new TicketMail($attendee));
                        } catch (\Exception $e) {
                            Log::error('Xendit Webhook: Mail error - ' . $e->getMessage());
                        }
                    }
                }
                return response()->json(['message' => 'Success'], 200);
            }

            Log::warning('Xendit Webhook Attendee not found: ' . $externalId);
        }

        return response()->json(['message' => 'Processed'], 200);
    }
}
