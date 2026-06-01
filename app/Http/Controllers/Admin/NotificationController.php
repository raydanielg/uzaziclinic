<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function send() { return view('admin.notifications.send'); }
    public function history() { return view('admin.notifications.history'); }
    public function emailTemplates() { return view('admin.notifications.email_templates'); }
    
    public function smsTemplates()
    {
        $templates = [
            'sms_template_welcome' => [
                'title' => 'Welcome Message (New Patient)',
                'default' => 'Karibu Uzazi Clinic! Asante kwa kujiunga nasi. Patient ID yako ni: [patient_ID]. Tuna furaha kukuhudumia. Kwa msaada piga simu: +255 678 233 736.',
                'description' => 'Sent automatically when a new patient profile is created in the system.',
                'placeholders' => ['patient_name', 'patient_ID']
            ],
            'sms_template_confirmation' => [
                'title' => 'Appointment Confirmation',
                'default' => 'Habari [patient_name] (ID: [patient_ID]), umefanikiwa ku-book appointment na Dr. [doctor_name] kwa tarehe [appointment_date] saa [appointment_time]. Tafadhali fika mapema. Asante.',
                'description' => 'Sent automatically when an appointment is booked on the website or reception.',
                'placeholders' => ['patient_name', 'patient_ID', 'doctor_name', 'appointment_date', 'appointment_time']
            ],
            'sms_template_reminder' => [
                'title' => 'Appointment Reminder',
                'default' => 'Kumbuka [patient_name] (ID: [patient_ID]): Unakaribia appointment yako na Dr. [doctor_name] kesho tarehe [appointment_date] saa [appointment_time]. Tafadhali fika mapema. Asante.',
                'description' => 'Sent to remind a patient about an upcoming appointment.',
                'placeholders' => ['patient_name', 'patient_ID', 'doctor_name', 'appointment_date', 'appointment_time']
            ],
            'sms_template_service_info' => [
                'title' => 'Service Info (Returning Patient)',
                'default' => 'Asante kwa kuja Uzazi Clinic. Patient ID yako ni: [patient_ID]. Leo utapata huduma ya: [service_name]. Tuna furaha kukuhudumia.',
                'description' => 'Sent when a patient checks in for a specific service.',
                'placeholders' => ['patient_ID', 'service_name']
            ],
            'sms_template_payment_request' => [
                'title' => 'Payment Request & Instructions',
                'default' => 'Asante [patient_name] (ID: [patient_ID]) kwa huduma ya [service_name]. Tafadhali lipa TSh [amount]. NAMBA ZA MALIPO: JINA: [account_name]. Tigo/Yas: [tigo_yas]. Mixx By Yas/Tigo Pesa: [tigo_pesa]. M-PESA: [mpesa]. CRDB BANK: [crdb_bank]. Ukishalipia Tuma majina Yako Na uthibitisho wa Muamala wako hapa Mpendwa.',
                'description' => 'Sent to request payment with dynamic clinic mobile money/bank credentials.',
                'placeholders' => ['patient_name', 'patient_ID', 'amount', 'service_name', 'account_name', 'tigo_yas', 'tigo_pesa', 'mpesa', 'crdb_bank']
            ],
            'sms_template_payment_confirmation' => [
                'title' => 'Payment Confirmation (Receipt)',
                'default' => 'Asante [patient_name] (ID: [patient_ID]). Malipo yako ya TSh [amount] yamepokelewa. Tunakushukuru kwa kutumia huduma zetu.',
                'description' => 'Sent when payment is confirmed (no next appointment scheduled).',
                'placeholders' => ['patient_name', 'patient_ID', 'amount']
            ],
            'sms_template_payment_with_appointment' => [
                'title' => 'Payment Done + Next Appointment (Main SMS)',
                'default' => 'Karibu Uzazi Clinic! [patient_name] (ID: [patient_ID]), malipo yako ya TSh [amount] yamepokelewa. Asante! Miadi yako inayofuata ni tarehe [next_appointment_date] na Dr. [doctor_name]. Tafadhali fika mapema. Maswali: +255 678 233 736.',
                'description' => 'PRIMARY SMS — Sent automatically after a patient pays at reception. Includes welcome, payment confirmation, and next appointment date.',
                'placeholders' => ['patient_name', 'patient_ID', 'amount', 'doctor_name', 'next_appointment_date']
            ],
            'sms_template_lab_directions' => [
                'title' => 'Lab Directions (Send to Lab Section)',
                'default' => 'Habari [patient_name] ([queue_number]), tafadhali nenda Idara ya [lab_section] kwa vipimo vyako. Ukishamaliza rudi mapokezi. — Uzazi Clinic.',
                'description' => 'Sent when receptionist routes a patient to a specific lab section. Guides patient to the correct lab department.',
                'placeholders' => ['patient_name', 'queue_number', 'lab_section']
            ],
        ];

        $realTemplates = [];
        foreach ($templates as $key => $meta) {
            $realTemplates[$key] = [
                'key' => $key,
                'title' => $meta['title'],
                'description' => $meta['description'],
                'placeholders' => $meta['placeholders'],
                'default' => $meta['default'],
                'value' => Setting::get($key, $meta['default'])
            ];
        }

        return view('admin.notifications.sms_templates', compact('realTemplates'));
    }

    public function updateSmsTemplate(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'required|string|max:1000'
        ]);

        Setting::set($request->key, $request->value, 'sms');

        return response()->json([
            'success' => true,
            'message' => 'SMS Template updated successfully!'
        ]);
    }
}
