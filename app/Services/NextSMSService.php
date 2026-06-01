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
     * Helper to replace placeholders in templates
     */
    private function replacePlaceholders($template, $data)
    {
        $search = [];
        $replace = [];
        foreach ($data as $key => $value) {
            $search[] = '[' . $key . ']';
            $search[] = '[' . strtoupper($key) . ']';
            $search[] = '[' . strtolower($key) . ']';
            $search[] = '{' . $key . '}';
            $search[] = '{' . strtoupper($key) . '}';
            $search[] = '{' . strtolower($key) . '}';
            
            $replace[] = $value;
            $replace[] = $value;
            $replace[] = $value;
            $replace[] = $value;
            $replace[] = $value;
            $replace[] = $value;
        }
        return str_replace($search, $replace, $template);
    }

    /**
     * Send welcome SMS to new patient
     */
    public function sendWelcomeMessage($phone, $patientName, $patientId)
    {
        $template = \App\Models\Setting::get('sms_template_welcome', "Karibu Uzazi Clinic! Asante kwa kujiunga nasi. Patient ID yako ni: [patient_ID]. Tuna furaha kukuhudumia. Kwa msaada piga simu: +255 678 233 736.");
        
        $message = $this->replacePlaceholders($template, [
            'patient_name' => $patientName,
            'patient_id' => "PT-{$patientId}",
        ]);
        
        return $this->send($phone, $message);
    }

    /**
     * Send appointment confirmation SMS
     */
    public function sendAppointmentConfirmation($phone, $patientName, $patientId, $doctorName, $appointmentDate, $appointmentTime)
    {
        $template = \App\Models\Setting::get('sms_template_confirmation', "Habari [patient_name] (ID: [patient_ID]), umefanikiwa ku-book appointment na Dr. [doctor_name] kwa tarehe [appointment_date] saa [appointment_time]. Tafadhali fika mapema. Asante.");
        
        $message = $this->replacePlaceholders($template, [
            'patient_name' => $patientName,
            'patient_id' => "PT-{$patientId}",
            'doctor_name' => $doctorName,
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
        ]);
        
        return $this->send($phone, $message);
    }

    /**
     * Send appointment reminder SMS
     */
    public function sendAppointmentReminder($phone, $patientName, $patientId, $doctorName, $appointmentDate, $appointmentTime)
    {
        $template = \App\Models\Setting::get('sms_template_reminder', "Kumbuka [patient_name] (ID: [patient_ID]): Unakaribia appointment yako na Dr. [doctor_name] kesho tarehe [appointment_date] saa [appointment_time]. Tafadhali fika mapema. Asante.");
        
        $message = $this->replacePlaceholders($template, [
            'patient_name' => $patientName,
            'patient_id' => "PT-{$patientId}",
            'doctor_name' => $doctorName,
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
        ]);
        
        return $this->send($phone, $message);
    }

    /**
     * Send service information SMS (for returning patients)
     */
    public function sendServiceInfo($phone, $serviceName, $patientId)
    {
        $template = \App\Models\Setting::get('sms_template_service_info', "Asante kwa kuja Uzazi Clinic. Patient ID yako ni: [patient_ID]. Leo utapata huduma ya: [service_name]. Tuna furaha kukuhudumia.");
        
        $message = $this->replacePlaceholders($template, [
            'patient_id' => "PT-{$patientId}",
            'service_name' => $serviceName,
        ]);
        
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

        $template = \App\Models\Setting::get('sms_template_payment_request', "Asante [patient_name] (ID: [patient_ID]) kwa huduma ya [service_name]. Tafadhali lipa TSh [amount]. NAMBA ZA MALIPO: JINA: [account_name]. Tigo/Yas: [tigo_yas]. Mixx By Yas/Tigo Pesa: [tigo_pesa]. M-PESA: [mpesa]. CRDB BANK: [crdb_bank]. Ukishalipia Tuma majina Yako Na uthibitisho wa Muamala wako hapa Mpendwa.");

        $message = $this->replacePlaceholders($template, [
            'patient_name' => $patientName,
            'patient_id' => "PT-{$patientId}",
            'amount' => number_format($amount),
            'service_name' => $serviceName,
            'account_name' => $accountName,
            'tigo_yas' => $tigoYas,
            'tigo_pesa' => $tigoPesa,
            'mpesa' => $mpesa,
            'crdb_bank' => $crdbBank,
        ]);

        return $this->send($phone, $message);
    }

    /**
     * Send payment confirmation SMS
     */
    public function sendPaymentConfirmation($phone, $patientName, $patientId, $amount)
    {
        $template = \App\Models\Setting::get('sms_template_payment_confirmation', "Asante [patient_name] (ID: [patient_ID]). Malipo yako ya TSh [amount] yamepokelewa. Tunakushukuru kwa kutumia huduma zetu.");

        $message = $this->replacePlaceholders($template, [
            'patient_name' => $patientName,
            'patient_id' => "PT-{$patientId}",
            'amount' => number_format($amount),
        ]);

        return $this->send($phone, $message);
    }

    /**
     * Send lab section directions to patient via SMS
     */
    public function sendLabDirections($phone, $patientName, $labSection, $queueNumber)
    {
        $template = \App\Models\Setting::get(
            'sms_template_lab_directions',
            "Habari [patient_name] ([queue_number]), tafadhali nenda Idara ya [lab_section] kwa vipimo vyako. Ukishamaliza rudi mapokezi. — Uzazi Clinic."
        );

        $message = $this->replacePlaceholders($template, [
            'patient_name' => $patientName,
            'lab_section'  => $labSection,
            'queue_number' => $queueNumber ?? 'N/A',
        ]);

        return $this->send($phone, $message);
    }

    /**
     * Send combined payment confirmation + next appointment SMS
     * This is the PRIMARY SMS sent after a patient pays at reception
     */
    public function sendPaymentWithAppointment($phone, $patientName, $patientId, $amount, $doctorName, $nextAppointmentDate)
    {
        $template = \App\Models\Setting::get(
            'sms_template_payment_with_appointment',
            "Karibu Uzazi Clinic! [patient_name] (ID: [patient_ID]), malipo yako ya TSh [amount] yamepokelewa. Asante! Miadi yako inayofuata ni tarehe [next_appointment_date] na Dr. [doctor_name]. Tafadhali fika mapema. Maswali: +255 678 233 736."
        );

        $message = $this->replacePlaceholders($template, [
            'patient_name'          => $patientName,
            'patient_id'            => "PT-{$patientId}",
            'amount'                => $amount,
            'doctor_name'           => $doctorName,
            'next_appointment_date' => $nextAppointmentDate,
        ]);

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
