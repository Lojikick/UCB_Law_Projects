<?php
   header("Access-Control-Allow-Origin: *");
   /** 
    * Helper function to call the API 
    *
    * $method: Type of request (GET, POST, PATCH etc.)
    * $url: URL of API 
    * $data: Data to be sent in the case of POST/PUT request.  
    */
    function callAPI($method, $url, $data) {
      
      $curl = curl_init();
      
      switch ($method) {
         case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
               curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
         case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
               curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
         default:
            if ($data)
               $url = sprintf("%s?%s", $url, http_build_query($data));
      }

      // Config for the request — ignore for the purpose of this tutorial! :)
      curl_setopt($curl, CURLOPT_URL, $url);
      
      // Headers needed for Mock API authentication
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
         'APIKEY: 111111111111111111111',
         'Content-Type: application/json',
      ));
      
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

      // Making the call and fetching the result
      $result = curl_exec($curl);
      
      if(!$result) {
         die("Connection Failure");
      }
      
      curl_close($curl);
      return $result;
   }




 ?>