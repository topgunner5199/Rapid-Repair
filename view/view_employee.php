<?php
require("../private.php");
require("../header.php");
	if(isset($_GET['id'])){
		 $query = " 
            SELECT EMP_FNAME as 'First Name', EMP_LNAME AS 'Last Name', EMP_STATUS, EMP_USERNAME, LEVEL_OF_ACCESS
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
	
?>



<section class="view">
<h1>View Employee</h1>

<h3>First Name: <?php echo $row['First Name']; ?></h3>
<h3>Last Name: <?php echo $row['Last Name']; ?></h3>
<h3>Status: <?php echo $row['EMP_STATUS']; ?></h3>
<h3>Username: <?php echo $row['EMP_USERNAME']; ?></h3>
<h3>Level of Access: <?php echo $row['LEVEL_OF_ACCESS']; ?></h3>


</section>



<?php

	require("../footer.php");

?>