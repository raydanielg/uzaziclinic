<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SmsTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            'sms_template_welcome' => [
                'value' => 'Karibu Uzazi Clinic! Asante kwa kujiunga nasi. Patient ID yako ni: [patient_ID]. Tuna furaha kukuhudumia. Kwa msaada piga simu: +255 678 233 736.',
                'group' => 'sms'
            ],
            'sms_template_confirmation' => [
                'value' => 'Habari [patient_name] (ID: [patient_ID]), umefanikiwa ku-book appointment tarehe [appointment_date] saa [appointment_time]. Fika mapema. Asante.',
                'group' => 'sms'
            ],
            'sms_template_reminder' => [
                'value' => 'Kumbuka [patient_name] (ID: [patient_ID]): Unakaribia appointment yako kesho tarehe [appointment_date] saa [appointment_time]. Fika mapema. Asante.',
                'group' => 'sms'
            ],
            'sms_template_service_info' => [
                'value' => 'Asante kwa kuja Uzazi Clinic. Patient ID yako ni: [patient_ID]. Leo utapata huduma ya: [service_name]. Tuna furaha kukuhudumia.',
                'group' => 'sms'
            ],
            'sms_template_payment_request' => [
                'value' => 'Asante [patient_name] (ID: [patient_ID]) kwa huduma ya [service_name]. Tafadhali lipa TSh [amount]. NAMBA ZA MALIPO: JINA: [account_name]. Tigo/Yas: [tigo_yas]. Mixx By Yas/Tigo Pesa: [tigo_pesa]. M-PESA: [mpesa]. CRDB BANK: [crdb_bank]. Ukishalipia Tuma majina Yako Na uthibitisho wa Muamala wako hapa Mpendwa.',
                'group' => 'sms'
            ],
            'sms_template_payment_confirmation' => [
                'value' => 'Asante [patient_name] (ID: [patient_ID]). Malipo yako ya TSh [amount] yamepokelewa. Tunakushukuru kwa kutumia huduma zetu.',
                'group' => 'sms'
            ],
            'sms_template_payment_with_appointment' => [
                'value' => 'Karibu Uzazi Clinic! [patient_name] (ID: [patient_ID]), malipo yako ya TSh [amount] yamepokelewa. Asante! Miadi yako inayofuata ni tarehe [next_appointment_date]. Fika mapema. Maswali: +255 678 233 736.',
                'group' => 'sms'
            ],
            'sms_template_lab_directions' => [
                'value' => 'Habari [patient_name] ([queue_number]), tafadhali nenda Idara ya [lab_section] kwa vipimo vyako. Ukishamaliza rudi mapokezi. — Uzazi Clinic.',
                'group' => 'sms'
            ],
        ];

        foreach ($templates as $key => $data) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'group' => $data['group']
                ]
            );
        }
    }
}
