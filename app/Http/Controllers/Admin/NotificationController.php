<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function send() { return view('admin.notifications.send'); }
    public function history() { return view('admin.notifications.history'); }
    public function emailTemplates()
    {
        $templates = [
            'email_template_welcome' => [
                'title' => 'Welcome Email',
                'subject' => 'Welcome to Uzazi Clinic - Your Journey to Better Health',
                'body' => 'Dear {patient_name},

Welcome to Uzazi Clinic! We are delighted to have you as part of our healthcare family.

Your Patient ID: {patient_ID}

At Uzazi Clinic, we are committed to providing you with exceptional healthcare services. Our team of experienced doctors and medical staff are here to ensure you receive the best possible care.

For any questions or assistance, please feel free to contact us:
Phone: +255 678 233 736
Email: info@uzaziclinic.co.tz

We look forward to serving you.

Best regards,
Uzazi Clinic Team',
                'description' => 'Sent to new patients upon registration.',
                'placeholders' => ['patient_name', 'patient_ID']
            ],
            'email_template_appointment_confirmation' => [
                'title' => 'Appointment Confirmation',
                'subject' => 'Appointment Confirmed - {appointment_date} at {appointment_time}',
                'body' => 'Dear {patient_name},

Your appointment has been successfully confirmed!

Appointment Details:
- Date: {appointment_date}
- Time: {appointment_time}
- Doctor: Dr. {doctor_name}
- Patient ID: {patient_ID}

Please arrive 15 minutes before your scheduled time. If you need to reschedule, please contact us at least 24 hours in advance.

For any questions, call us at: +255 678 233 736

We look forward to seeing you!

Best regards,
Uzazi Clinic Team',
                'description' => 'Sent after a successful appointment booking.',
                'placeholders' => ['patient_name', 'patient_ID', 'doctor_name', 'appointment_date', 'appointment_time']
            ],
            'email_template_appointment_reminder' => [
                'title' => 'Appointment Reminder',
                'subject' => 'Reminder: Your Appointment Tomorrow',
                'body' => 'Dear {patient_name},

This is a friendly reminder about your upcoming appointment tomorrow.

Appointment Details:
- Date: {appointment_date}
- Time: {appointment_time}
- Doctor: Dr. {doctor_name}
- Patient ID: {patient_ID}

Please remember to:
- Arrive 15 minutes early
- Bring your ID and any relevant medical documents
- Take any prescribed medications as usual

If you need to reschedule, please contact us immediately.

See you tomorrow!

Best regards,
Uzazi Clinic Team',
                'description' => 'Sent to remind patients about upcoming appointments.',
                'placeholders' => ['patient_name', 'patient_ID', 'doctor_name', 'appointment_date', 'appointment_time']
            ],
            'email_template_payment_confirmation' => [
                'title' => 'Payment Confirmation',
                'subject' => 'Payment Received - Receipt #{receipt_number}',
                'body' => 'Dear {patient_name},

Thank you for your payment!

Payment Details:
- Amount: TSh {amount}
- Receipt Number: {receipt_number}
- Patient ID: {patient_ID}
- Service: {service_name}
- Date: {payment_date}

Your payment has been successfully processed and recorded in our system.

For any questions about this payment, please contact our billing department.

Thank you for choosing Uzazi Clinic!

Best regards,
Uzazi Clinic Team',
                'description' => 'Sent when payment is confirmed.',
                'placeholders' => ['patient_name', 'patient_ID', 'amount', 'service_name', 'payment_date', 'receipt_number']
            ],
            'email_template_lab_results' => [
                'title' => 'Lab Results Ready',
                'subject' => 'Your Lab Results Are Ready',
                'body' => 'Dear {patient_name},

Your lab test results are now available.

Test Details:
- Test Name: {test_name}
- Test Date: {test_date}
- Patient ID: {patient_ID}

Please log in to your patient portal to view your detailed results, or visit the clinic to discuss them with your doctor.

If you have any questions, please contact us.

Best regards,
Uzazi Clinic Team',
                'description' => 'Sent when lab results are ready for patient review.',
                'placeholders' => ['patient_name', 'patient_ID', 'test_name', 'test_date']
            ],
        ];

        $emailTemplates = [];
        foreach ($templates as $key => $meta) {
            $emailTemplates[$key] = [
                'key' => $key,
                'title' => $meta['title'],
                'description' => $meta['description'],
                'placeholders' => $meta['placeholders'],
                'subject' => Setting::get($key . '_subject', $meta['subject']),
                'body' => Setting::get($key . '_body', $meta['body'])
            ];
        }

        return view('admin.notifications.email_templates', compact('emailTemplates'));
    }
    
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
                'default' => 'Habari [patient_name] (ID: [patient_ID]), umefanikiwa ku-book appointment tarehe [appointment_date] saa [appointment_time]. Fika mapema. Asante.',
                'description' => 'Sent automatically when an appointment is booked on the website or reception.',
                'placeholders' => ['patient_name', 'patient_ID', 'appointment_date', 'appointment_time']
            ],
            'sms_template_reminder' => [
                'title' => 'Appointment Reminder',
                'default' => 'Kumbuka [patient_name] (ID: [patient_ID]): Unakaribia appointment yako kesho tarehe [appointment_date] saa [appointment_time]. Fika mapema. Asante.',
                'description' => 'Sent to remind a patient about an upcoming appointment.',
                'placeholders' => ['patient_name', 'patient_ID', 'appointment_date', 'appointment_time']
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
                'description' => 'Sent when payment is confirmed for lab tests (Vipimo) or medicine (Dose).',
                'placeholders' => ['patient_name', 'patient_ID', 'amount']
            ],
            'sms_template_payment_with_appointment' => [
                'title' => 'Payment Done + Next Appointment (Main SMS)',
                'default' => 'Karibu Uzazi Clinic! [patient_name] (ID: [patient_ID]), malipo yako ya TSh [amount] yamepokelewa. Asante! Miadi yako inayofuata ni tarehe [next_appointment_date]. Fika mapema. Maswali: +255 678 233 736.',
                'description' => 'PRIMARY SMS — Sent automatically after a patient pays at reception. Includes welcome, payment confirmation, and next appointment date.',
                'placeholders' => ['patient_name', 'patient_ID', 'amount', 'next_appointment_date']
            ],
            'sms_template_lab_directions' => [
                'title' => 'Lab Directions (Send to Lab Section)',
                'default' => 'Habari [patient_name] ([queue_number]), tafadhali nenda Idara ya [lab_section] kwa vipimo vyako. Ukishamaliza rudi mapokezi. — Uzazi Clinic.',
                'description' => 'Sent when receptionist routes a patient to a specific lab section. Guides patient to the correct lab department.',
                'placeholders' => ['patient_name', 'queue_number', 'lab_section']
            ],
        ];

        $sampleData = [
            'patient_name' => 'John',
            'patient_ID' => 'UZC-001234',
            'doctor_name' => 'Mlay',
            'appointment_date' => '15/06/2026',
            'appointment_time' => '10:30 AM',
            'service_name' => 'General Checkup',
            'amount' => '25,000',
            'payment_date' => '01/06/2026',
            'receipt_number' => 'RCP-006789',
            'next_appointment_date' => '15/06/2026',
            'account_name' => 'Uzazi Clinic Account',
            'tigo_yas' => '0623123456',
            'tigo_pesa' => '0623123456',
            'mpesa' => '0712123456',
            'crdb_bank' => '0151234567890',
            'queue_number' => 'Q-042',
            'lab_section' => 'Hematology',
            'test_name' => 'Blood Count',
            'test_date' => '01/06/2026',
        ];

        $realTemplates = [];
        foreach ($templates as $key => $meta) {
            $value = Setting::get($key, $meta['default']);
            $renderedPreview = $value;
            foreach ($sampleData as $ph => $sample) {
                $renderedPreview = str_replace("[$ph]", $sample, $renderedPreview);
            }

            $realTemplates[$key] = [
                'key' => $key,
                'title' => $meta['title'],
                'description' => $meta['description'],
                'placeholders' => $meta['placeholders'],
                'default' => $meta['default'],
                'value' => $value,
                'enabled' => Setting::get($key . '_enabled', true),
                'sample' => $renderedPreview,
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

    public function resetSmsTemplate(Request $request)
    {
        $request->validate([
            'key' => 'required|string'
        ]);

        // Get the default value from the templates array
        $templates = [
            'sms_template_welcome' => [
                'default' => 'Karibu Uzazi Clinic! Asante kwa kujiunga nasi. Patient ID yako ni: [patient_ID]. Tuna furaha kukuhudumia. Kwa msaada piga simu: +255 678 233 736.',
            ],
            'sms_template_confirmation' => [
                'default' => 'Habari [patient_name] (ID: [patient_ID]), umefanikiwa ku-book appointment tarehe [appointment_date] saa [appointment_time]. Fika mapema. Asante.',
            ],
            'sms_template_reminder' => [
                'default' => 'Kumbuka [patient_name] (ID: [patient_ID]): Unakaribia appointment yako kesho tarehe [appointment_date] saa [appointment_time]. Fika mapema. Asante.',
            ],
            'sms_template_service_info' => [
                'default' => 'Asante kwa kuja Uzazi Clinic. Patient ID yako ni: [patient_ID]. Leo utapata huduma ya: [service_name]. Tuna furaha kukuhudumia.',
            ],
            'sms_template_payment_request' => [
                'default' => 'Asante [patient_name] (ID: [patient_ID]) kwa huduma ya [service_name]. Tafadhali lipa TSh [amount]. NAMBA ZA MALIPO: JINA: [account_name]. Tigo/Yas: [tigo_yas]. Mixx By Yas/Tigo Pesa: [tigo_pesa]. M-PESA: [mpesa]. CRDB BANK: [crdb_bank]. Ukishalipia Tuma majina Yako Na uthibitisho wa Muamala wako hapa Mpendwa.',
            ],
            'sms_template_payment_confirmation' => [
                'default' => 'Asante [patient_name] (ID: [patient_ID]). Malipo yako ya TSh [amount] yamepokelewa. Tunakushukuru kwa kutumia huduma zetu.',
            ],
            'sms_template_payment_with_appointment' => [
                'default' => 'Karibu Uzazi Clinic! [patient_name] (ID: [patient_ID]), malipo yako ya TSh [amount] yamepokelewa. Asante! Miadi yako inayofuata ni tarehe [next_appointment_date]. Fika mapema. Maswali: +255 678 233 736.',
            ],
            'sms_template_lab_directions' => [
                'default' => 'Habari [patient_name] ([queue_number]), tafadhali nende Idara ya [lab_section] kwa vipimo vyako. Ukishamaliza rudi mapokezi. — Uzazi Clinic.',
            ],
        ];

        if (isset($templates[$request->key])) {
            Setting::set($request->key, $templates[$request->key]['default'], 'sms');

            return response()->json([
                'success' => true,
                'message' => 'SMS Template reset to default successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Template not found'
        ], 404);
    }

    public function toggleSmsTemplate(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'enabled' => 'required|boolean'
        ]);

        Setting::set($request->key . '_enabled', $request->enabled, 'sms');

        return response()->json([
            'success' => true,
            'message' => $request->enabled ? 'SMS Template enabled successfully!' : 'SMS Template disabled successfully!'
        ]);
    }

    public function updateEmailTemplate(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'subject' => 'required|string|max:255',
            'body' => 'required|string'
        ]);

        Setting::set($request->key . '_subject', $request->subject, 'email');
        Setting::set($request->key . '_body', $request->body, 'email');

        return response()->json([
            'success' => true,
            'message' => 'Email Template updated successfully!'
        ]);
    }
}
