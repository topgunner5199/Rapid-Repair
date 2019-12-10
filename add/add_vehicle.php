<?php
require("../private.php");

	if($_POST["MAKE"] != ""){
		 $query = " 
            INSERT INTO VEHICLE ( 
                MAKE, 
                MODEL, 
                COLOR, 
                MILEAGE,
                YEAR,
                OIL_TYPE
                
            ) VALUES ( 
            	:MAKE,
                :MODEL, 
                :COLOR, 
                :MILEAGE,
                :YEAR,
                :OIL_TYPE
             	
            ) 
        "; 
        $query_params = array( 
				':MAKE' => $_POST['MAKE'],
            	':MODEL' => $_POST['MODEL'], 
                ':COLOR' => $_POST['COLOR'], 
                ':MILEAGE' => $_POST['MILEAGE'],
                ':YEAR' => $_POST['YEAR'],
                ':OIL_TYPE' => $_POST['OIL_TYPE']
               	
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        $id = $db->lastInsertId();

        $query = " 
            INSERT INTO CUSTOMER_VEHICLES ( 
                CUST_ID, 
                VEHICLE_ID
                
            ) VALUES ( 
                :CUST_ID,
                :VEHICLE_ID
                
            ) 
        "; 
        $query_params = array( 
                ':CUST_ID' => $_POST['custID'],
                ':VEHICLE_ID' => $id
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);


        header('Location: http://rapidresponseauto.info/vehicle.php');
	}
	require("../header.php");
?>



<section class="form">
<h1>Add Vehicle</h1>
<form action="" method="POST">
    <input type="hidden" name="custID" value="<?php echo $_GET['custid']; ?>"/>
	
	Make: <input name="MAKE" type="text" required><br>
	Model: <input name="MODEL" type="text" required><br>
	Color: <input name="COLOR" type="text" required><br>
	Mileage: <input name="MILEAGE" type="text" pattern="^([0-9]{1,6})$" required><br>
	Year: <input name="YEAR"  type="text" pattern="^([0-9]{4})$" required><br>
	Oil Type (ex. 10W-40): <input name="OIL_TYPE" type="text" pattern="[0-9]{1,2}W-[0-9][0-9]" required><br>
		
	
	<input type="submit" value="Submit">
</form>

</section>



<?php

	require("../footer.php");

?>