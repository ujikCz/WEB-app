<?php
    /*
    *   HEADER
    */
    session_start();
    function post($para){
        return htmlspecialchars($_POST[$para]);
    }
    function sess($para){
        return htmlspecialchars($_SESSION[$para]);
    }
    function server($para){
        return $_SERVER[$para];
    }
?>

<?php  
    /*
    *   FACEBOOK LOGIN
    */ 
    if(server('REQUEST_METHOD') == "POST"){
        if(post('fbauth')){

            include 'hybridauth/src/autoload.php';

    
            $config = [

                'callback' => 'http://lms.skolazdola.cz/oauthlogin.php',
                //napr.
    
                //Facebook application credentials
                'keys' => [
                    'id'     => '654859905057374', //Required: your Facebook application id
                    'secret' => '443d829867600cd0c56d9637bc44b1e5'  //Required: your Facebook application secret 
                ]
            ];
    
            try {
                //Instantiate Facebook's adapter directly
                $adapter = new Hybridauth\Provider\Facebook($config);
    
                //Attempt to authenticate the user with Facebook
                $adapter->authenticate();
    
                //Returns a boolean of whether the user is connected with Facebook
                $isConnected = $adapter->isConnected();
     
                //Retrieve the user's profile
                $userProfile = $adapter->getUserProfile();
    
                //Inspect profile's public attributes
                var_dump($userProfile);
    
                //Disconnect the adapter 
                $adapter->disconnect();
            }
            catch(\Exception $e){
                echo 'Oops, we ran into an issue! ' . $e->getMessage();
            }
        }
    }
?>
<html>
    <head>
    
    </head>
    <body>
    <form action="<?php echo htmlspecialchars(server("PHP_SELF")); ?>" class="" method="post">
        <input type="submit" name="fbauth" value="facebook">
    </form>
    </body>
</html>
