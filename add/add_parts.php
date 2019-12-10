<?php
require("../private.php");

	if($_POST["PART_NAME"] != ""){
		//Query to database for parts. Returns parts info
		 $query = " 
            INSERT INTO PARTS ( 
                PART_ID,
				PART_NAME,
				PART_PRICE,
				UNIT_PRICE,
				SUP_ID,
				PART_DESC,
				QUANTITY,
				UNIT_SIZE,
				QUANTITY_MIN,
				QUANTITY_MAX
				
            ) VALUES ( 
            	:PART_ID,
				:PART_NAME,
				:PART_PRICE,
				:UNIT_PRICE,
				:SUP_ID,
				:PART_DESC,
				:QUANTITY,
				:UNIT_SIZE,
				:QUANTITY_MIN,
				:QUANTITY_MAX	
            ) 
        "; 
        $query_params = array( 
        		':PART_ID' => $_POST['PART_ID'],
            	':PART_NAME' => $_POST['PART_NAME'], 
                ':PART_PRICE' => $_POST['PART_PRICE'], 
                ':UNIT_PRICE' => $_POST['UNIT_PRICE'],
                ':SUP_ID' => $_POST['SUP_ID'],
                ':PART_DESC' => $_POST['PART_DESC'],
                ':QUANTITY' => $_POST['QUANTITY'],
                ':UNIT_SIZE' => $_POST['UNIT_SIZE'],
                ':QUANTITY_MIN' => $_POST['QUANTITY_MIN'],
                ':QUANTITY_MAX' => $_POST['QUANTITY_MAX']
                
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        header('Location: http://rapidresponseauto.info/parts.php');
	}
	require("../header.php");
?>



<section class="form">
<h1>Add Part</h1>
<form action="" method="POST">
	
	Part Name: <input name="PART_NAME" type="text" required><br>
	Part Price (Ex. 1.00): <input name="PART_PRICE" type="text" pattern="^\d+(\.|\,)\d{2}$" required><br>
	Unit Price (Ex. 1.00): <input name="UNIT_PRICE" type="text" pattern="^\d+(\.|\,)\d{2}$" required><br>
	<label>Supplier: </label>
      <select class="combobox" name="SUP_ID" required>
          <option value="" disabled selected>Select an option</option>
            <?php
                $query = " 
                SELECT SUP_ID, SUP_NAME
                FROM SUPPLIER
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
                ?>
                <option value="<?php echo $row['SUP_ID']; ?>"><?php echo $row['SUP_NAME']; ?></option>
                <?php
            }
            ?>
      </select>
      <br>
	Part Description: <input name="PART_DESC" type="text" required><br>
	Quantity: <input name="QUANTITY" type="text" required><br>
	Unit Size: <input name="UNIT_SIZE" type="text" required><br>
	Quantity Minimum: <input name="QUANTITY_MIN" type="text" required><br>
	Quantity Maximum: <input name="QUANTITY_MAX" type="text" required><br>

	
	<input type="submit" value="Submit">
</form>

</section>



<?php

	require("../footer.php");

?>?>