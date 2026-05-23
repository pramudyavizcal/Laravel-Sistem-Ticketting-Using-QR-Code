<?php

namespace App\Services;

use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class XenditService
{
    protected $invoiceApi;

    public function __construct()
    {
        Configuration::setXenditKey(config('services.xendit.key'));
        $this->invoiceApi = new InvoiceApi();
    }

    public function createInvoice($externalId, $amount, $email, $description, $successUrl, $failureUrl)
    {
        $createInvoiceRequest = new CreateInvoiceRequest([
            'external_id' => $externalId,
            'description' => $description,
            'amount' => (float) $amount,
            'payer_email' => $email,
            'invoice_duration' => 86400, // 24 hours
            'success_redirect_url' => $successUrl,
            'failure_redirect_url' => $failureUrl,
            'currency' => 'IDR',
        ]);

        try {
            return $this->invoiceApi->createInvoice($createInvoiceRequest);
        } catch (\Xendit\XenditSdkException $e) {
            \Log::error('Xendit Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
