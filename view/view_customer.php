<?php
require("../private.php");
require("../header.php");
	if(isset($_GET['id'])){
		 $query = " 
            SELECT CUST_TITLE AS 'Title', CUST_FNAME as 'First Name', CUST_LNAME as 'Last Name', CUST_PHONE, CUST_EMAIL ,CUST_STREET as Address, CUST_CITY as City, CUST_STATE as State, CUST_EMAIL as Email,CUST_ZIP as ZIP, CUST_LAST_VISIT AS 'Last Visit', CUST_DATE_ADDED AS 'Date Added'
            FROM CUSTOMER
            WHERE CUST_ID = ".$_GET['id']."
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
<h1>View Customer</h1>

<h3>Title: <?php echo $row['Title']; ?></h3>
<h3>First Name: <?php echo $row['First Name']; ?></h3>
<h3>Last Name: <?php echo $row['Last Name']; ?></h3>
<h3>Phone: <?php echo $row['CUST_PHONE']; ?></h3>
<h3>Email: <a href="mailto:<?php echo $row['CUST_EMAIL']; ?>"><?php echo $row['CUST_EMAIL']; ?></a></h3>
<h3>Address: <?php echo $row['Address']; ?></h3>
<h3>City: <?php echo $row['City']; ?></h3>
<h3>State: <?php echo $row['State']; ?></h3>
<h3>ZIP: <?php echo $row['ZIP']; ?></h3>
<h3>Last Visit: <?php echo $row['Last Visit']; ?></h3>
<h3>Date Added: <?php echo $row['Date Added']; ?></h3>

<?php
$query = "SELECT MAKE, MODEL, YEAR, v.VEHICLE_ID FROM VEHICLE v
			JOIN CUSTOMER_VEHICLES cv ON v.VEHICLE_ID = cv.VEHICLE_ID
			JOIN CUSTOMER c ON cv.CUST_ID = c.CUST_ID
			WHERE c.CUST_ID = ".$_GET['id']; 
         
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
        $count = 1;
        while($row = $results->fetch()){
        	?>
        		<div class="vehicle">
        			<h2><a href="http://rapidresponseauto.info/view/view_vehicle.php?id=<?php echo $row['VEHICLE_ID']; ?>">Vehicle <?php echo $count; ?></a></h2>
        			<h3>Year: <? echo $row['YEAR']; ?> </h3> 
        			<h3>Make: <? echo $row['MAKE']; ?> </h3> 
        			<h3>Model: <? echo $row['MODEL']; ?> </h3> 
        		</div>
        	<?php
        	$count++;
        }
?>

<a href="http://rapidresponseauto.info/add/add_vehicle.php?custid=<?php echo $_GET['id']; ?>"><button>Add Vehicle</button></a>

</section>



<?php

	require("../footer.php");

?>