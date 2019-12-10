<?php

require("../private.php");

	if($_POST["make"] != ""){

		 $query = " 

            UPDATE VEHICLE

            SET 

				MAKE = :MAKE, 

                MODEL = :MODEL, 

                COLOR = :COLOR, 

                MILEAGE = :MILEAGE,

                YEAR = :YEAR,

                OIL_TYPE = :OIL_TYPE

            WHERE VEHICLE_ID = ".$_POST['id']."

        "; 

        $query_params = array(  

            	':MAKE' => $_POST['make'], 

                ':MODEL' => $_POST['model'], 

                ':COLOR' => $_POST['color'],

                ':MILEAGE' => $_POST['mileage'],

                ':YEAR' => $_POST['year'],

                ':OIL_TYPE' => $_POST['oil']

        ); 

         



            // Execute the query to create the user 

        $stmt = $db->prepare($query); 

        $result = $stmt->execute($query_params);

        header('Location: http://rapidresponseauto.info/vehicle.php');

	}else if(isset($_GET['id'])){

		 $query = " 

            SELECT  VEHICLE_ID AS 'ID',MAKE AS Make, MODEL AS 'Model', COLOR as Color, MILEAGE as Mileage, YEAR as Year, OIL_TYPE as 'Oil Type'

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

	require("../header.php");

?>







<section class="form">

<h1>Edit Vehicle</h1>

<form action="" method="POST">

	<input type="hidden" name="id" value="<?php echo $row['ID'];?>">

	Make: <input name="make" type="text" value="<?php echo $row['Make'];?> "required><br>

	Model: <input name="model" type="text" value="<?php echo $row['Model'];?> " required><br>

	Color: <input name="color" type="text" value="<?php echo $row['Color'];?> " required><br>

	Mileage: <input name="mileage" type="text" pattern="^([0-9]{1,6})$" value="<?php echo $row['Mileage']?> " required><br>

	Year: <input name="year"  type="text" pattern="^([0-9]{4})$" value="<?php echo $row['Year']?> " required><br>

	Oil Type (ex. 10W-40): <input name="oil" type="text" pattern="[0-9]{1,2}W-[0-9][0-9]" value="<?php echo $row['Oil Type']?> " required><br>

	<input type="submit" value="Save">

</form>



</section>







<?php



	require("../footer.php");



?>