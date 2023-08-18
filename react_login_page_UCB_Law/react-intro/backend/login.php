<?php

    /** 
     * Standard HTTP headers for cross-communication between client and server.
     * Ignore for the purpose of this tutorial! :)
     */
    //This next line is bad for security
    //Why? Because our website will accept any other servers ACAO header regardless if it shares our site's origin header
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Content-Type: application/json; charset=UTF-8");

    //Not including Content-Type Causes the CORS error:
    //CORS or Cross Origin Resource Sharing is a protocol that allows a url to fetch data from another url. This is called a Cross origin Request
    //In this sites' case, we want to get data from the mockAPI housing all the user info, so we make a GET request. 


    //This attempt to communicate with the API url was previously being blocked by CORS policy
    //Normally this is due to the Access-Controll-Allow-Origin header returned from the Server not matching with the website's Origin header, so the url blocks the reqest
    //(Our origin matches our ACAO in this case)

    //In our case, since we are making a GET request, a preflight request occurs before the request is sent to the server
    //This is to check if the server allows the HTTP methods and headers in our request

    //Since we are making a GET request, our request has a content type header to tell the server about the data we're sending

    //In our original case, The Content type header was not allowed by the Access Controll in our Server (login.php), so below we just add the Content-type headers to
    //the list of headers we want to give access, and the preflight response goes though
    header("Access-Control-Allow-Headers: Content-type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    function debugToConsole($msg) {
            echo "<script>console.log(".json_encode($msg).")</script>";
    }

    /** 
     * Method to build return message.
     */
    function msg($success, $status, $message, $extra = []){
        return array_merge([
            'success' => $success,
            'status' => $status,
            'message' => $message
        ], $extra);
    }

    require __DIR__.'/call-api.php'; // import callAPI() method
    require __DIR__.'/classes/JwtHandler.php'; // import JwtHandler to encode data

    //Gets the userinfo from Login.js
    $data = json_decode(file_get_contents("php://input"),false); // decode input data
    $returnData = [];
    $mesage = "wrong foot oiut";
    if($_SERVER["REQUEST_METHOD"] != "POST"){ 
        
        $returnData = msg(0, 404, 'Page Not Found!'); // exception for non-POST requests
    }

    // Empty field check
    elseif(!isset($data->username) || !isset($data->password) || empty(trim($data->username)) || empty(trim($data->password))) { 
            $fields = ['fields' => ['username','password']];
            $returnData = [
                'success' => false,
                'message' => 'Please fill in all of the fields before signing in.',
                'token' => null,
                'status' => 'Please fill in all of the fields before signing in.', 
            ];
    } 

    else { 
        // Fetches and parse username and password
        $username = trim($data->username); 
        $password = trim($data->password);
        
        // Error printing if password length is less than 8
        if (strlen($password) < 8) { 
            $returnData = msg(0, 422, 'Your password must be at least 8 characters long!');
        } else { 
            $meal = 'Dumplings';
            $get_data = callAPI("GET", "https://6126bc4fc2e8920017bc0a07.mockapi.io/ReactIntro?username=".$username, false);
            $response = json_decode($get_data, true);
            //If the username is not in the records
            if($response == []) {
            $returnData = [
                'success' => false,
                'message' => 'Username or password is invalid',
                'token' => null,
                'status' => 'Username or password is invalid', 
            ];
            //If the username is invalid
            } elseif ($username != $response[0]['username']){ 
                $returnData = [
                    'success' => false,
                    'message' => 'Username or password is invalid',
                    'token' => null,
                    'status' => 'Username or password is invalid', 
                ];
            //If the password is valid
             } elseif ($password == $response[0]['password']){ 
                $jwt = new JwtHandler();
                $token = $jwt->_jwt_encode_data(
                    'http://localhost/apimock/',
                    array("user_id"=> $response[0]['id'])
                );
                $returnData = [
                    'success' => true,
                    'message' => 'You have succesfully logged in!',
                    'token' => $token,
                    'meal' => $meal,
                ];
            //If the password is invalid
            } else { 
                // TODO: Is this safe? Reflect why this might be a problem by yourself.
                $returnData = [
                    'success' => false,
                    'message' => 'Username or password is invalid',
                    //Change back to "Password is invalid"
                    'token' => null,
                    'status' => 'Username or password is invalid',    
                ];
                    //msg($response['password'], $password, 'Invalid password!');
                }

            // TODO: What if the username is invalid? 
            // YOUR CODE HERE, cannot put the code here because it doesn't make sense with the if, elseif, else loops
            
        }
    }
    

    echo json_encode($returnData);
?>