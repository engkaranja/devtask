<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'Classes/Config.php';
include 'Classes/Utils.php';

//Make sure that it is a POST request.
if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) {
    echo "Request method must be POST!";
    exit;
    //throw new Exception('Request method must be POST!');
}

//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if (strcasecmp($contentType, 'application/json') != 0) {
    echo "Content type must be: application/json";
    exit;
    // throw new Exception('Content type must be: application/json');
}

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

//Attempt to decode the incoming RAW post data from JSON.
$decoded = json_decode($content, true);

//If json_decode failed, the JSON is invalid.
if (!is_array($decoded)) {
    echo "Received content contained invalid JSON!";
    throw new Exception('Received content contained invalid JSON!');
}

//echo json_encode($decoded);


Utils::logThis("INFO", "Json Request:: " . $content);

Utils::logThis("INFO", "Params => " . print_r($decoded, true));


if (count($decoded) == 0) {
    echo "Failed. Parameters are missing";
    http_response_code(500);
    exit;
}
/*
{
    "header": {
        "messageID": "12345666",
        "featureCode": "201",
        "featureName": "FinancialTransactions",
        "serviceCode": "2001",
        "serviceName": "FundsTransfer",
        "serviceSubCategory":"Account",
        "minorServiceVersion": "1.0",
        "channelCode": "01",
        "channelName": "atm",
        "routeCode": "01",  
        "timeStamp": "22222",
        "serviceMode": "sync",  
        "subscribeEvents": "1",
        "callBackURL": ""  
    },
   "requestPayload": {
     
      "transactionInfo": {
         "companyCode": "KE0010001",
         "transactionType": "Payment Notification",
         "creditAccountNumber": "",
"credintMobileNumber":"",
         "transactionAmount": "",
         "transactionReference": "",
         "currencyCode": "",
          "amountCurrency": "",
          "dateTime": "",
          "dateString": "",
      }
   }
}
 * 
 * 
 *  */
$messageID = $decoded['header']['messageID'];

$response =  '{
    "header": {
        "messageID": '.$messageID.',
        "conversationID": "123123131312",
        "targetSystemID": "123123131312",
        "routeCode": "01",  
        "statusCode":"0",
        "statusDescription":"Success",
        "statusMessage":"TRANACTION FOR TYPE ACZW SUCCESSFUL"
     },
   "responsePayload": {       
      "transactionInfo": {
         "transactionId": "FT20114XHFQF",
         "falconBalance":"10.00"
      }
   }
}';

echo $response;



