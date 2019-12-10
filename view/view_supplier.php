<?php
require("../private.php");
require("../header.php");
	if(isset($_GET['id'])){
		 $query = " 
            SELECT SUP_ID AS ID, SUP_NAME AS Name, SUP_ADDRESS as Address, SUP_CITY as City, SUP_STATE as State, SUP_ZIP as ZIP, SUP_EMAIL as Email, SUP_PHONE as Phone, SUP_FAX AS Fax, SUP_CONTACT_NAME AS 'Contact Name', SUP_CONTACT_TITLE AS Title, SUP_WEBSITE AS Website
            FROM SUPPLIER
            WHERE SUP_ID = ".$_GET['id']."
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
<h1>View Supplier</h1>

<h3>Supplier Name: <?php echo $row['Name']; ?></h3>
<h3>Address: <?php echo $row['Address']; ?></h3>
<h3>City: <?php echo $row['City']; ?></h3>
<h3>State: <?php echo $row['State']; ?></h3>
<h3>ZIP: <?php echo $row['ZIP']; ?></h3>
<h3>Email: <?php echo $row['Email'];?></h3>
<h3>Phone: <?php echo $row['Phone']; ?></h3>
<h3>Fax: <?php echo $row['Fax']; ?></h3>
<h3>Contact Name: <?php echo $row['Contact Name']; ?></h3>
<h3>Contact Title: <?php echo $row['Title']; ?></h3>
<h3>Website: <?php echo $row['Website']; ?></h3>

<?php

?>

</section>



<?php

	require("../footer.php");

?>