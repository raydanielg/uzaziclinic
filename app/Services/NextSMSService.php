<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NextSMSService
{
    protected $from;
    protected $username;
    protected $password;
    protected $url;

    public function __construct()
    {
        $this->from = env('NEXTSMS_FROM', 'UZAZICLINIC');
        $this->username = env('NEXTSMS_USERNAME');
        $this->password = env('NEXTSMS_PASSWORD');
        $this->url = env('NEXTSMS_URL', 'https://messaging-service.co.tz/api/sms/v1/text/single');
    }

    /**
     * Send SMS to a single recipient
     */
    public function send($to, $message)
    {
        try {
            // Format phone number - ensure it starts with 255
            $to = $this->formatPhoneNumber($to);

            // Prepare basic auth credentials
            $credentials = base64_encode($this->username . ':' . $this->password);

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $credentials,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->withoutVerifying()->post($this->url, [
                'from' => $this->from,
                'to' => $to,
                'text' => $message,
            ]);

            if ($response->successful()) {
                Log::info('SMS sent successfully', [
                    'to' => $to,
                    'message' => substr($message, 0, 50) . '...',
                    'response' => $response->json(),
                ]);
                return [
                    'success' => true,
                    'message' => 'SMS sent successfully',
                    'data' => $response->json(),
                ];
            } else {
                Log::error('SMS sending failed', [
                    'to' => $to,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
                return [
                    'success' => false,
                    'message' => 'SMS sending failed: ' . $response->body(),
                ];
            }
        } catch (\Exception $e) {
            Log::error('SMS service error', [
                'error' => $e->getMessage(),
                'to' => $to,
            ]);
            return [
                'success' => false,
                'message' => 'SMS service error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Send welcome SMS to new patient
     */
    public function sendWelcomeMessage($phone, $patientName, $patientId)
    {
        $message = "Karibu Uzazi Clinic! Asante kwa kujiunga nasi. Patient ID yako ni: PT-{$patientId}. Tuna furaha kukuhudumia. Kwa msaada piga simu: 255XXXXXXXX.";
        return $this->send($phone, $message);
    }

    /**
     * Send appointment confirmation SMS
     */
    public function sendAppointmentConfirmation($phone, $patientName, $patientId, $doctorName, $appointmentDate, $appointmentTime)
    {
        $message = "Habari {$patientName} (ID: PT-{$patientId}), umefanikiwa ku-book appointment na Dr. {$doctorName} kwa tarehe {$appointmentDate} saa {$appointmentTime}. Tafadhali fika mapema. Asante.";
        return $this->send($phone, $message);
    }

    /**
     * Send appointment reminder SMS
     */
    public function sendAppointmentReminder($phone, $patientName, $patientId, $doctorName, $appointmentDate, $appointmentTime)
    {
        $message = "Kumbuka {$patientName} (ID: PT-{$patientId}): Unakaribia appointment yako na Dr. {$doctorName} kesho tarehe {$appointmentDate} saa {$appointmentTime}. Tafadhali fika mapema. Asante.";
        return $this->send($phone, $message);
    }

    /**
     * Send service information SMS (for returning patients)
     */
    public function sendServiceInfo($phone, $serviceName, $patientId)
    {
        $message = "Asante kwa kuja Uzazi Clinic. Patient ID yako ni: PT-{$patientId}. Leo utapata huduma ya: {$serviceName}. Tuna furaha kukuhudumia.";
        return $this->send($phone, $message);
    }

    /**
     * Send payment request SMS
     */
    public function sendPaymentRequest($phone, $patientName, $patientId, $amount, $serviceName)
    {
        $accountName = env('PAYMENT_ACCOUNT_NAME', 'Issa Rashid Paulo');
        $tigoYas = env('PAYMENT_TIGO_YAS', '15329940');
        $tigoPesa = env('PAYMENT_TIGO_PESA', '0678233736');
        $mpesa = env('PAYMENT_MPESA', '0767825843');
        $crdbBank = env('PAYMENT_CRDB_BANK', '0152537335900');
        $whatsappNumber = env('PAYMENT_WHATSAPP_NUMBER', '255712345678');

        $message = "Asante {$patientName} (ID: PT-{$patientId}) kwa huduma ya {$serviceName}. Tafadhali lipa TSh {$amount}. NAMBA ZA MALIPO: JINA: {$accountName}. Tigo/Yas: {$tigoYas}. Mixx By Yas/Tigo Pesa: {$tigoPesa}. M-PESA: {$mpesa}. CRDB BANK: {$crdbBank}. Ukishalipia Tuma majina Yako Na uthibitisho wa Muamala wako hapa Mpendwa.";

        return $this->send($phone, $message);
    }

    /**
     * Send payment confirmation SMS
     */
    public function sendPaymentConfirmation($phone, $patientName, $patientId, $amount)
    {
        $message = "Asante {$patientName} (ID: PT-{$patientId}). Malipo yako ya TSh {$amount} yamepokelewa. Tunakushukuru kwa kutumia huduma zetu.";

        return $this->send($phone, $message);
    }

    /**
     * Format phone number to ensure it starts with 255
     */
    protected function formatPhoneNumber($phone)
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If starts with 0, replace with 255
        if (str_starts_with($phone, '0')) {
            $phone = '255' . substr($phone, 1);
        }

        // If starts with +, remove it
        if (str_starts_with($phone, '+')) {
            $phone = substr($phone, 1);
        }

        // If doesn't start with 255, add it
        if (!str_starts_with($phone, '255')) {
            $phone = '255' . $phone;
        }

        return $phone;
    }
}
