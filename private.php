<?php 

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: login.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to login.php"); 
    } 
     
    // Everything below this point in the file is secured by the login system 
     
    // We can display the user's username to them by reading it from the session array.  Remember that because 
    // a username is user submitted content we must use htmlentities on it before displaying it to the user. 

$query = " 
    SELECT PROMO_ID AS 'ID', PROMO_NAME AS 'Promo Name', EXPIRATION, PROMO_TYPE AS 'Promotion Type'
    FROM PROMOTIONS
    WHERE DELETED = 'NO'
"; 
try 
{ 
    // Execute the query against the database 
    $results = $db->query($query); 
} 
catch(PDOException $ex) 
{ 
    // Note: On a production website, you should not output $ex->getMessage(). 
    // It may provide an attacker with helpful information about your code.  
    die("Failed to run query: " . $ex->getMessage()); 
} 
while($row = $results->fetch()){
    if($row['EXPIRATION'] < date('Y-m-d')){
         $query = " 
            UPDATE PROMOTIONS
            SET DELETED = 'YES'
            WHERE PROMO_ID = :ID
        "; 
        $query_params = array( 
                ':ID' => $row['ID']
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
    }
}