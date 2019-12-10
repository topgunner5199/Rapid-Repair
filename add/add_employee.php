<?php
require("../private.php");

require("../restrict.php");
	if($_POST["fName"] != ""){
		 $query = " 
            INSERT INTO EMPLOYEE ( 
                EMP_FNAME, 
                EMP_LNAME, 
                EMP_STATUS,
                EMP_USERNAME,
                EMP_PASSWORD,
                LEVEL_OF_ACCESS,
                EMP_HIRE_DATE,
                EMP_SALT
            ) VALUES ( 
            	:EMP_FNAME, 
                :EMP_LNAME, 
                :EMP_STATUS,
                :EMP_USERNAME,
                :EMP_PASSWORD,
                :LEVEL_OF_ACCESS,
                :EMP_HIRE_DATE,
                :EMP_SALT
            ) 
        "; 

        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
         
        // This hashes the password with the salt so that it can be stored securely 
        // in your database.  The output of this next statement is a 64 byte hex 
        // string representing the 32 byte sha256 hash of the password.  The original 
        // password cannot be recovered from the hash.  For more information: 
        // http://en.wikipedia.org/wiki/Cryptographic_hash_function 
        $password = hash('sha256', $_POST['password'] . $salt); 
         
        // Next we hash the hash value 65536 more times.  The purpose of this is to 
        // protect against brute force attacks.  Now an attacker must compute the hash 65537 
        // times for each guess they make against a password, whereas if the password 
        // were hashed only once the attacker would have been able to make 65537 different  
        // guesses in the same amount of time instead of only one. 
        for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        } 

        $query_params = array( 
        		':EMP_FNAME'=>$_POST['fName'], 
                ':EMP_LNAME' => $_POST['lName'], 
                ':EMP_STATUS' => $_POST['status'],
                ':EMP_USERNAME' => $_POST['username'],
                ':EMP_PASSWORD' => $password,
                ':LEVEL_OF_ACCESS' => $_POST['level'],
                ':EMP_HIRE_DATE' => date('Y/m/d'),
                ':EMP_SALT' => $salt	
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        header('Location: http://rapidresponseauto.info/employee.php');
	}
	require("../header.php");
?>



<section class="form">
<h1>Add Employee</h1>
<form action="" method="POST">
	Level of Access: <select name="level" required>
		<option value="" disabled selected>Select an option</option>
		<option>Manager</option>
		<option>Employee</option>
	</select><br>
	First Name: <input name="fName" type="text" required><br>
	Last Name: <input name="lName" type="text" required><br>
	Employee Status: <select name="status" required>
		<option value="" disabled selected>Select an option</option>
		<option>Part Time</option>
		<option>Full Time</option>
	</select><br>
	Username: <input name="username" type="text" required><br>
	Password: <input name="password" type="password" required><br>
	<input type="submit" value="Submit">
</form>

</section>



<?php

	require("../footer.php");

?>