<?php

class Wallet {

    public function addCard($cardId, $customerId) {

        $addressArray = Array( 
                "Customer" => $customerId,
                "Line1" => "600 Ellis Street", 
                "City" => "San Francisco",
                "State" => "CA", 
                "Country" => "USA", 
                "Zip" => "94109");

        $cardholderArray = Array( 
                "FirstName" => "Herb",
                "LastName" => "Caen");

        $cardArray = Array(
                "Tender" => "CreditCard", // "CreditCard" | "ECheck"
                "Customer" => $customerId, // Customer ID generated by PayFabric
                "Account" => "4032030806166550", // Credit card number.
                "ExpDate" => "0719", // MMYY format.
                "CardHolder" => $cardholderArray, 
                "Billto" => $addressArray);

        // Convert the data to JSON.
        $json = json_encode($cardArray, TRUE);

        // Setup the HTTP request.
        $httpUrl = "https://sandbox.payfabric.com/rest/v1/api/wallet/create";
        $httpHeader = Array(
                "Content-Type: application/json",
                "authorization: " . DEVICE_ID . "|" . DEVICE_PASSWORD);        
        $curlOptions = Array(CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_POSTFIELDS => $json,
                CURLOPT_HTTPHEADER => $httpHeader);

        // Execute the HTTP request.
        $curlHandle = curl_init($httpUrl);
        curl_setopt_array($curlHandle, $curlOptions);
        $httpResponseBody = curl_exec($curlHandle);
        $httpResponseCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);

        if ($httpResponseCode >= 300) {
            // Handle errors.
        }          

        // Convert the JSON into a multi-dimensional array.
        $responseArray = json_decode($httpResponseBody, TRUE);

        // Output the results of the request.
        var_dump($responseArray);

        return $responseArray;        

    }

}



