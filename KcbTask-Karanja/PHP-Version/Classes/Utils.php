<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author KARANJA
 */
class Utils {

    //put your code here
    public static function logThis($LEVEL, $logThis) {

        $logFile = "";
        $logLevel = "";
        switch ($LEVEL) {
            case "INFO":
                $logFile = "/var/www/logs/mpesa/info.log";
                $logLevel = "INFO";
                break;
            case "ERROR":
                $logFile = "/var/www/logs/mpesa/error.log";
                $logLevel = "ERROR";
                break;
            case "DEBUG":
                $logFile = "/var/www/logs/mpesa/debug.log";
                $logLevel = "DEBUG";
                break;
            default :
                $logFile = "/var/www/logs/mpesa/info.log";
                $logLevel = "DEFAULT";
        }

        $e = new Exception();
        $trace = $e->getTrace();
//position 0 would be the line that called this function so we ignore it
        $last_call = isset($trace[1]) ? $trace[1] : array();
        $lineArr = $trace[0];


        $function = isset($last_call['function']) ? $last_call['function'] . "()|" : "";
        $line = isset($lineArr['line']) ? $lineArr['line'] . "|" : "";
        $file = isset($lineArr['file']) ? $lineArr['file'] . "|" : "";

        $remote_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] . "|" : "";
        $date = date("Y-m-d H:i:s");
        $string = $date . "|$logLevel|$file$function$remote_ip$line" . $logThis . "\n";
        file_put_contents($logFile, $string, FILE_APPEND);
    }

    function makeMPESA_B2CRequest() {

        $status = 0;
        $response = array();
        $data = array();

        try {


            $AccessToken = self::GenerateAccessToken($B2C_ConsumerKey, $B2C_ConsumerSecret);

            if (!empty($AccessToken)) {
                $endPoint = 'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';

                $curl_post_data = array(
                    "InitiatorName" => $B2C_Initiator,
                    "SecurityCredential" => $initiatorSecurityCredential,
                    "CommandID" => "BusinessPayment",
                    "Amount" => str_replace(".00", "", $Amount),
                    "PartyA" => $BusinessShortCode,
                    "PartyB" => $PhoneNumber,
                    "Remarks" => "Disbursement",
                    "QueueTimeOutURL" => $TimeoutCallBackURL,
                    "ResultURL" => $CallBackURL,
                    "Occassion" => $pkID
                );

                try {

                    self::logThis("INFO", "PARAMS---" . print_r($curl_post_data, true));

                    $data_string = json_encode($curl_post_data);

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $endPoint);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Bearer ' . $AccessToken . ''));
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                    $curl_response = curl_exec($curl);

                    self::logThis("INFO", "B2C RESPONSE---" . print_r($curl_response, true));

                    $responseArray = json_decode($curl_response, true);

                    

            } catch (Exception $ex) {

            self::logThis("INFO", "Error " . $ex->getMessage());
        }
    
        }
}
    