<?php
require("../restrict.php");
require("../private.php");


	if($_POST["fName"] != ""){
		 $query = " 
            UPDATE EMPLOYEE 
            SET
                EMP_FNAME = :EMP_FNAME, 
                EMP_LNAME = :EMP_LNAME, 
                EMP_STATUS = :EMP_STATUS,
                EMP_USERNAME = :EMP_USERNAME,
                EMP_PASSWORD = :EMP_PASSWORD,
                LEVEL_OF_ACCESS = :LEVEL_OF_ACCESS,
                EMP_SALT = :EMP_SALT
            WHERE EMP_ID = ".$_POST['id']."
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
                ':EMP_SALT' => $salt	
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        header('Location: http://rapidresponseauto.info/employee.php');
	}else if(isset($_GET['id'])){
        $query = " 
            SELECT LEVEL_OF_ACCESS as 'Level of Access', EMP_FNAME as 'First Name', EMP_LNAME as 'Last Name', EMP_STATUS as Status, EMP_USERNAME as Username
            FROM EMPLOYEE
            WHERE EMP_ID = ".$_GET['id']."
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

        $row = $results->fetch();
    }
	require("../header.php");
?>



<section class="form">
<h1>Edit Employee</h1>
<form action="" method="POST">
    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
	Level of Access: <select name="level" required>
		<option value="" disabled selected>Select an option</option>
		<option <?php if($row['Level of Access'] == "Manager"){echo "selected";} ?>>Manager</option>
		<option <?php if($row['Level of Access'] == "Employee"){echo "selected";} ?>>Employee</option>
	</select><br>
	First Name: <input name="fName" type="text" value="<?php echo $row['First Name']; ?>" required><br>
	Last Name: <input name="lName" type="text" value="<?php echo $row['Last Name']; ?>" required><br>
	Employee Status: <select name="status" required>
		<option value="" disabled selected>Select an option</option>
		<option <?php if($row['Status'] == "Part Time"){echo "selected";} ?>>Part Time</option>
		<option <?php if($row['Status'] == "Full Time"){echo "selected";} ?>>Full Time</option>
	</select><br>
	Username: <input name="username" type="text" value="<?php echo $row['Username']; ?>" required><br>
	Password: <input name="password" type="password" required><br>
	<input type="submit" value="Submit">
</form>

</section>



<?php

	require("../footer.php");

?>