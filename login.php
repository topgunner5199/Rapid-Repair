<?php 

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
     
// Get the full URL of the current page
function current_page_url(){
    $page_url   = 'http';
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
        $page_url .= 's';
    }
    return $page_url.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
}

/* (Assuming session already started) */
if(isset($_SESSION['referrer'])){
    // Get existing referrer
    $referrer   = $_SESSION['referrer'];

} elseif(isset($_SERVER['HTTP_REFERER'])){
    // Use given referrer
    $referrer   = $_SERVER['HTTP_REFERER'];

} else {
    // No referrer
}

// Save current page as next page's referrer
$_SESSION['referrer']   = current_page_url();
     
    // This variable will be used to re-display the user's username to them in the 
    // login form if they fail to enter the correct password.  It is initialized here 
    // to an empty value, which will be shown if the user has not submitted the form. 
    $submitted_username = ''; 
     
    // This if statement checks to determine whether the login form has been submitted 
    // If it has, then the login code is run, otherwise the form is displayed 
    if(!empty($_POST)) 
    { 
        // This query retreives the user's information from the database using 
        // their username. 
        $query = " 
            SELECT 
                EMP_USERNAME, 
                EMP_PASSWORD, 
                LEVEL_OF_ACCESS,
                EMP_SALT
            FROM EMPLOYEE 
            WHERE 
                EMP_USERNAME = :EMP_USERNAME
        "; 
         
        // The parameter values 
        $query_params = array( 
            ':EMP_USERNAME' => $_POST['username']
        ); 
         
        try 
        { 
            // Execute the query against the database 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // This variable tells us whether the user has successfully logged in or not. 
        // We initialize it to false, assuming they have not. 
        // If we determine that they have entered the right details, then we switch it to true. 
        $login_ok = false; 
         
        // Retrieve the user data from the database.  If $row is false, then the username 
        // they entered is not registered. 
        $row = $stmt->fetch();
        if($row) 
        { 
            // Using the password submitted by the user and the salt stored in the database, 
            // we now check to see whether the passwords match by hashing the submitted password 
            // and comparing it to the hashed version already stored in the database. 
            $check_password = hash('sha256', $_POST['password'] . $row['EMP_SALT']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['EMP_SALT']); 
            } 
             
            if($check_password === $row['EMP_PASSWORD']) 
            { 
                // If they do, then we flip this to true 
                $login_ok = true; 
            } 
        }
         
        // If the user logged in successfully, then we send them to the private members-only page 
        // Otherwise, we display a login failed message and show the login form again 
        if($login_ok) 
        { 
            // Here I am preparing to store the $row array into the $_SESSION by 
            // removing the salt and password values from it.  Although $_SESSION is 
            // stored on the server-side, there is no reason to store sensitive values 
            // in it unless you have to.  Thus, it is best practice to remove these 
            // sensitive values first. 
            unset($row['EMP_SALT']); 
            unset($row['EMP_PASSWORD']); 
             
            // This stores the user's data into the session at the index 'user'. 
            // We will check this index on the private members-only page to determine whether 
            // or not the user is logged in.  We can also use it to retrieve 
            // the user's details. 
            $_SESSION['user'] = $row; 
            // Redirect the user to the private members-only page. 
            header("Location: index.php"); 
            die("Redirecting to: index.php"); 
        } 
        else 
        { 
            // Tell the user they failed 
            //print("Login Failed."); 
            $error = "Login Failed.";
             
            // Show them their username again so all they have to do is enter a new 
            // password.  The use of htmlentities prevents XSS attacks.  You should 
            // always use htmlentities on user submitted values before displaying them 
            // to any users (including the user that submitted them).  For more information: 
            // http://en.wikipedia.org/wiki/XSS_attack 
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
    } 
     
?> 

<!DOCTYPE html>

<html>

 <head>

  <meta charset="UTF-8">

  <title>Rapid Response Auto Service</title>

  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="lib/css/style.css">

  <script src="lib/js/main.js"></script>

  

 </head>

 <body>

	<div id="Wrapper">

		<header>

			<img id="Logo" src="assets/logo.png">

			

			<div class="clear"></div>

		</header>


<section id="LogIn">
	<h1>Log In</h1>
	<p style="color:red; background-color:white;border-radius:15px;"><?php echo $error;?></p>
	<form action="" method="post">
		<p>UserName: <input type="text" name="username" value="<?php echo $submitted_username; ?>"/></p>
		<p>Password: <input type="password" name="password" /></p>
		<input type="submit" value="Log In"/>
	</form>
</section>


<?php

	require("footer.php");

?>