<?php

use App\Models\Etemplate;
use App\Models\GeneralSettings;
use App\Models\User;
use App\Models\SmsRoute;
use Illuminate\Support\Str;
use Carbon\Carbon;

if (!function_exists('send_email')) {

    function send_email($to, $name, $subject, $message)
    {
        $temp = Etemplate::first();
        $gnl = GeneralSettings::first();
        $template = $temp->emessage;
        $from = $temp->esender;
        if ($gnl->email_notification == 1) {
            // $headers = "From: $gnl->sitename <$from> \r\n";
            // $headers .= "Reply-To: $gnl->sitename <$from> \r\n";
            // $headers .= "MIME-Version: 1.0\r\n";
            // $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            // $mm = str_replace("{{name}}", $name, $template);
            // $message = str_replace("{{message}}", $message, $mm);

            // @mail($to, $subject, $message, $headers);
            $details = [
                'title' => $name,
                'body' => $message,
                'subject' => $subject
            ];
            \Mail::to($to)->send(new \App\Mail\GiftbillsMail($details));

        }
    }
}


if (!function_exists('send_sms')) {

    function send_sms($to, $message)
    {
        $temp = Etemplate::first();
        $api = $temp->smsapi;
        $gnl = GeneralSettings::first();
        if ($gnl->sms_notification == 1) {
            $sendtext = urlencode($message);
            $appi = $temp->smsapi;
            $appi = str_replace("{{number}}", $to, $appi);
            $appi = str_replace("{{message}}", $sendtext, $appi);
        }
    }
}


if (!function_exists('send_bulk_sms')) {

    function send_bulk_sms($route, $sender, $recipient, $message)
    {
        $temp = SmsRoute::where('id',$route)->first();
        $api = $temp->route;
        $gnl = GeneralSettings::first();
        if ($gnl->allow_sms == 1) {
            $sendtext = urlencode($message);
            $appi = $temp->route;
            $appi = str_replace("@@recipient@@", $recipient, $appi);
            $appi = str_replace("@@sender@@", $sender, $appi);
            $appi = str_replace("@@message@@", $sendtext, $appi);
            $result = @file_get_contents($appi);
        }
    }
}


if (!function_exists('notify')) {
    function notify($user, $subject, $message)
    {
        send_email($user->email, $user->fname, $subject, $message);
        send_sms($user->mobile, strip_tags($message));
    }
}


if (!function_exists('send_email_verification')) {
    function send_email_verification($to, $name, $subject, $message)
    {
        $temp = Etemplate::first();
        $gnl = GeneralSettings::first();
        $template = $temp->emessage;
        $from = $temp->esender;

        $headers = "From: $gnl->sitename <$from> \r\n";
        $headers .= "Reply-To: $gnl->sitename <$from> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $mm = str_replace("{{name}}", $name, $template);
        $message = str_replace("{{message}}", $message, $mm);

        @mail($to, $subject, $message, $headers);
    }
}


if (!function_exists('send_contact')) {

    function send_contact($from, $name, $subject, $message)
    {
        $temp = Etemplate::first();
        $to = $temp->esender;

        $headers = "From: $name <$from> \r\n";
        $headers .= "Reply-To: $name <$from> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $mm = "Hi Sir," . "<br><br>";
        $thanks = "Thanks, <br> <strong>$name</strong>";
        $message = $mm . $message . $thanks;

        @mail($to, $subject, $message, $headers);

    }
}


if (!function_exists('removeDup')) {

    function removeDup($recis){
        $value = "";

        foreach ($recis as $recidup){
            if(!str_contains($value, $recidup)){
                $value.=$recidup.",";
            }
        }

        return $value;
    }
}

if (!function_exists('generateApiKey')) {

    function generateApiKey(){
        $rend = strtoupper(Str::random(31));
            $check = User::where('api_key', $rend)->first();

        if($check == true){
            $rend = generateApiKey();
        }
        return $rend;
    }
}

if (!function_exists('generateEncrypt')) {

    function generateEncrypt(){
        $rend = strtoupper(Str::random(12)) . Carbon::now()->timestamp;
            $check = User::where('encrypt', $rend)->first();

        if($check == true){
            $rend = generateEncrypt();
        }
        return $rend;
    }
}

if (!function_exists('get_between_data')) {

    function get_between_data($string, $start, $end){
        $pos_string = stripos($string, $start);
        $substr_data = substr($string, $pos_string);
        $string_two = substr($substr_data, strlen($start));
        $second_pos = stripos($string_two, $end);
        $string_three = substr($string_two, 0, $second_pos);
        // remove whitespaces from result
        $result_unit = trim($string_three);
        // return result_unit
        return $result_unit;
    }
}
