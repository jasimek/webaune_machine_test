<?php

namespace App\Console\Commands;

use App\Models\Audit;
use App\Models\QualityIndicator;
use App\Notifications\EmailNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:frequency-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send frequency emails';

    public function handle()
    {
        $this->sendQualityIndicatorFrequencyMails();
        $this->sendAuditMail();
    }

    public function sendQualityIndicatorFrequencyMails()
    {
        $quality_indicators = QualityIndicator::get();
        foreach ($quality_indicators as $quality_indicator) {
            if ($quality_indicator->frequency->name == "Daily") {
                foreach ($quality_indicator->users as $user) {
                    $data = [
                        "subject" => 'Avenue Healthcare',
                        "greeting" => 'Hi ' . $user->full_name . ',',
                        'body' => 'New <b>' . $quality_indicator->name . '</b> Indicator has raised , Please check.',
                        'thanks' => 'Thank you this is from avenue healthcare',
                        'actionText' => 'View My Indicators',
                        'actionURL' => route('indicators:my-indicators.index'),
                    ];
                    $data['lines'] =
                        '<ul>
                                    <li>Frequency : ' . $quality_indicator->frequency->name . '</li>
                                    <li>Indicator Name : ' . $quality_indicator->name . '</li>
                                    <li>Starting Time : ' . Carbon::parse($quality_indicator->frequency->frequencyDetail->starting_time)->format('g:i a') . '</li>
                                    <li>Ending Time : ' . Carbon::parse($quality_indicator->frequency->frequencyDetail->ending_time)->format('g:i a') . '</li>
                                </ul>';
                    Notification::send($user, new EmailNotification($data));
                }
            } else if ($quality_indicator->frequency->name == "Weekly") {
                if (strtolower(Carbon::now()->format('l')) == $quality_indicator->frequency->frequencyDetail->day) {
                    foreach ($quality_indicator->users as $user) {
                        $data = [
                            "subject" => 'Avenue Healthcare',
                            "greeting" => 'Hi ' . $user->full_name . ',',
                            'body' => 'New <b>' . $quality_indicator->name . '</b> Indicator has raised , Please check.',
                            'thanks' => 'Thank you this is from avenue healthcare',
                            'actionText' => 'View My Indicators',
                            'actionURL' => route('indicators:my-indicators.index'),
                        ];
                        $data['lines'] =
                            '<ul>
                            <li>Frequency : ' . $quality_indicator->frequency->name . '</li>
                            <li>Indicator Name : ' . $quality_indicator->name . '</li>
                            <li>Day : ' . $quality_indicator->frequency->frequencyDetail->day . '</li>
                            <li>Starting Time : ' . Carbon::parse($quality_indicator->frequency->frequencyDetail->starting_time)->format('g:i a') . '</li>
                            <li>Ending Time : ' . Carbon::parse($quality_indicator->frequency->frequencyDetail->ending_time)->format('g:i a') . '</li>
                        </ul>';
                        Notification::send($user, new EmailNotification($data));
                    }
                }
            } else if ($quality_indicator->frequency->name == "Quarterly") {
                foreach ($quality_indicator->frequency->frequencyDetail->FrequencyQuarterDetails as $frequency_quarter_detail) {;
                    if (Carbon::parse($frequency_quarter_detail->date)->format('m-d') == Carbon::now()->format('m-d')) {
                        foreach ($quality_indicator->users as $user) {
                            $data = [
                                "subject" => 'Avenue Healthcare',
                                "greeting" => 'Hi ' . $user->full_name . ',',
                                'body' => 'New <b>' . $quality_indicator->name . '</b> Indicator has raised , Please check.',
                                'thanks' => 'Thank you this is from avenue healthcare',
                                'actionText' => 'View My Indicators',
                                'actionURL' => route('indicators:my-indicators.index'),
                            ];

                            $data['lines'] =
                                '<ul>
                            <li>Frequency : ' . $quality_indicator->frequency->name . '</li>
                            <li>Indicator Name : ' . $quality_indicator->name . '</li>
                            <li>Day : ' . Carbon::parse($frequency_quarter_detail->date)->format('l') . '</li>
                            <li>Starting Time : ' . Carbon::parse($frequency_quarter_detail->starting_time)->format('g:i a') . '</li>
                            <li>Ending Time : ' . Carbon::parse($frequency_quarter_detail->ending_time)->format('g:i a') . '</li>
                        </ul>';
                            Notification::send($user, new EmailNotification($data));
                        }
                    }
                }
            } else if ($quality_indicator->frequency->name == "Anually") {
                if (Carbon::parse($quality_indicator->frequency->frequencyDetail->annual_date)->format('l') == Carbon::now()->format('l')) {
                    foreach ($quality_indicator->users as $user) {
                        $data = [
                            "subject" => 'Avenue Healthcare',
                            "greeting" => 'Hi ' . $user->full_name . ',',
                            'body' => 'New <b>' . $quality_indicator->name . '</b> Indicator has raised , Please check.',
                            'thanks' => 'Thank you this is from avenue healthcare',
                            'actionText' => 'View My Indicators',
                            'actionURL' => route('indicators:my-indicators.index'),
                        ];
                        $data['lines'] =
                            '<ul>
                            <li>Frequency : ' . $quality_indicator->frequency->name . '</li>
                            <li>Indicator Name : ' . $quality_indicator->name . '</li>
                            <li>Day : ' . $quality_indicator->frequency->frequencyDetail->day . '</li>
                            <li>Starting Time : ' . Carbon::parse($quality_indicator->frequency->frequencyDetail->starting_time)->format('g:i a') . '</li>
                            <li>Ending Time : ' . Carbon::parse($quality_indicator->frequency->frequencyDetail->ending_time)->format('g:i a') . '</li>
                        </ul>';
                        Notification::send($user, new EmailNotification($data));
                    }
                }
            } else if ($quality_indicator->frequency->name == "Monthly") {
                if (Carbon::parse($quality_indicator->frequency->frequencyDetail->annual_date)->format('l') == Carbon::now()->format('l')) {
                    foreach ($quality_indicator->users as $user) {
                        $data = [
                            "subject" => 'Avenue Healthcare',
                            "greeting" => 'Hi ' . $user->full_name . ',',
                            'body' => 'New <b>' . $quality_indicator->name . '</b> Indicator has raised , Please check.',
                            'thanks' => 'Thank you this is from avenue healthcare',
                            'actionText' => 'View My Indicators',
                            'actionURL' => route('indicators:my-indicators.index'),
                        ];
                        $data['lines'] =
                            '<ul>
                            <li>Frequency : ' . $quality_indicator->frequency->name . '</li>
                            <li>Indicator Name : ' . $quality_indicator->name . '</li>
                            <li>Day : ' . $quality_indicator->frequency->frequencyDetail->day . '</li>
                            <li>Starting Time : ' . Carbon::parse($quality_indicator->frequency->frequencyDetail->starting_time)->format('g:i a') . '</li>
                            <li>Ending Time : ' . Carbon::parse($quality_indicator->frequency->frequencyDetail->ending_time)->format('g:i a') . '</li>
                        </ul>';
                        Notification::send($user, new EmailNotification($data));
                    }
                }
            }
        }
    }

    public function sendAuditMail()
    {

        $audits  = Audit::get();
        foreach ($audits as $audit) {
            if ($audit->starting_date == Carbon::today()->format('Y-m-d')) {

                $data = [
                    "subject" => 'Avenue Healthcare',
                    "greeting" => 'Hi ' . $audit->auditeeUser->full_name . ',',
                    'body' => 'New Audit Based on <b>' . $audit->qualityStandard->name . '</b> Quality Standard has raised , Please check.',
                    'thanks' => 'Thank you this is from avenue healthcare',
                    'actionText' => 'View My Audits',
                    'actionURL' => route('audit:carry-out-audit', [$audit]),
                ];

                if ($audit->is_standard) {
                    $data['lines'] =
                        '<ul>
            <li>Start Date : ' . $audit->starting_date . '</li>
            <li>End Date : ' . $audit->ending_date . '</li>';
                    foreach ($audit->auditStandardsElements as $audit_standard_element) {
                        Log::info($audit->chapter);
                        $data['lines'] = $data['lines'] . '<li>Audit Standard : ' . $audit_standard_element->auditStandard->chapter . '</li>';
                    }
                    $data['lines'] = $data['lines'] . '<li>Starting Day : ' . Carbon::parse($audit->starting_date)->format('l') . '</li>
            <li>Ending Day : ' .  Carbon::parse($audit->ending_date)->format('l') . '</li>
        </ul>';
                } else if (!$audit->is_standard) {

                    $data['lines'] =
                        '<ul>
        <li>Start Date : ' . $audit->starting_date . '</li>
        <li>End Date : ' . $audit->ending_date . '</li>';
                    foreach ($audit->auditStandardsElements as $audit_standard_element) {
                        $data['lines'] = $data['lines'] . '<li>Audit Element : ' . $audit_standard_element->auditElement->name . '</li>';
                    }
                    $data['lines'] = $data['lines'] . '<li>Starting Day : ' . Carbon::parse($audit->starting_date)->format('l') . '</li>
        <li>Ending Day : ' .  Carbon::parse($audit->ending_date)->format('l') . '</li>
    </ul>';
                }

                Notification::send($audit->auditeeUser, new EmailNotification($data));
            }
        }
    }
}
