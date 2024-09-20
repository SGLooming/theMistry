<?php

namespace App\Traits;

trait SendSms {

    
     public function otpmsg($otpval, $user_phone) {

        $field = array(
            "sender_id" => env('FAST_TO_SMS_SENDER_ID'),
            "language" => 'english',
            "route" => env('FAST_TO_SMS_ROUTE'),
            "numbers" => $user_phone,
            "message" => $otpval,
            "variables" => "{#AA#}",
            "variables_values" => $otpval
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('FAST_TO_SMS_CURLOPT_URL'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($field),
            CURLOPT_HTTPHEADER => array(
                "authorization: ".env('FAST_TO_SMS_AUTHORIZATION')."",
                "cache-control: no-cache",
                "accept: */*",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ['error' => true, 'response' => $err];
        } else {
            return ['error' => false, 'response' => $response];
        }
    }
}