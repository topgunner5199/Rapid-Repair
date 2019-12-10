<?php
require("../private.php");
require("../header.php");
	if(isset($_GET['id'])){
		 $query = " 
            SELECT VEHICLE_ID AS 'Vehicle ID', MAKE as 'Make', MODEL as 'Model', COLOR as 'Color' ,MILEAGE as 'Mileage', YEAR as 'Year', OIL_TYPE as 'Oil Type'
            FROM VEHICLE
            WHERE VEHICLE_ID = ".$_GET['id']."
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
<h1>View Vehicle</h1>

<h3>Vehicle ID: <?php echo $row['Vehicle ID']; ?></h3>
<h3>Make: <?php echo $row['Make']; ?></h3>
<h3>Model: <?php echo $row['Model']; ?></h3>
<h3>Color: <?php echo $row['Color']; ?></h3>
<h3>Mileage: <?php echo $row['Mileage']; ?></h3>
<h3>Year: <?php echo $row['Year']; ?></h3>
<h3>Oil Type: <?php echo $row['Oil Type']; ?></h3>



<?php

$query = "SELECT c.CUST_ID, CUST_FNAME, CUST_LNAME
			FROM CUSTOMER c
			JOIN CUSTOMER_VEHICLES cv ON c.CUST_ID = cv.CUST_ID
			JOIN VEHICLE v ON cv.VEHICLE_ID = v.VEHICLE_ID
			WHERE v.VEHICLE_ID = ".$_GET['id']; 
         
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
        			<h2><a href="http://rapidresponseauto.info/view/view_customer.php?id=<?php echo $row['CUST_ID']; ?>">Customer</a></h2>
        			<h3>Customer ID: <? echo $row['CUST_ID']; ?> </h3> 
        			<h3>First Name: <? echo $row['CUST_FNAME']; ?> </h3> 
        			<h3>Last Name: <? echo $row['CUST_LNAME']; ?> </h3> 
        		</div>
        	<?php
        }
?>



</section>



<?php

	require("../footer.php");

?>