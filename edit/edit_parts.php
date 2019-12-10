<?php
require("../private.php");
	if($_POST["pname"] != ""){
		 $query = " 
            UPDATE PARTS
            SET 
                PART_ID = :PART_ID,
				PART_NAME = :PART_NAME,
				PART_PRICE = :PART_PRICE,
				UNIT_PRICE = :UNIT_PRICE,
                SUP_ID = :SUP_ID,
				PART_DESC = :PART_DESC,
				QUANTITY = :QUANTITY,
				UNIT_SIZE = :UNIT_SIZE,
				QUANTITY_MIN = :QUANTITY_MIN,
				QUANTITY_MAX = :QUANTITY_MAX
            WHERE PART_ID = ".$_POST['id']."
        "; 
        $query_params = array( 
        		':PART_ID' => $_POST['id'],
            	':PART_NAME' => $_POST['pname'], 
                ':PART_PRICE' => $_POST['partprice'], 
                ':UNIT_PRICE' => $_POST['unitprice'],
                ':SUP_ID' => $_POST['SUP_ID'],
                ':PART_DESC' => $_POST['description'],
                ':QUANTITY' => $_POST['quantity'],
                ':UNIT_SIZE' => $_POST['size'],
                ':QUANTITY_MIN' => $_POST['min'],
                ':QUANTITY_MAX' => $_POST['max']
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        header('Location: http://rapidresponseauto.info/parts.php');
	}else if(isset($_GET['id'])){
		 $query = " 
            SELECT PART_ID AS ID, PART_NAME AS 'Part Name', PART_PRICE as 'Part Price', UNIT_PRICE as 'Unit Price', SUP_ID, PART_DESC as 'Part Description', QUANTITY as Quantity, UNIT_SIZE as 'Unit Size', QUANTITY_MIN as 'Quantity Minimum', QUANTITY_MAX as 'Quantity Max'
            FROM PARTS
            WHERE PART_ID = ".$_GET['id']."
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

        $rowResults = $results->fetch();

	}
	require("../header.php");
?>



<section class="form">
<h1>Edit Parts</h1>
<form action="" method="POST">
	<input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
	Part Name: <input name="pname" type="text" value="<?php echo $rowResults['Part Name']; ?>" required><br>
	Part Price (Ex. 1.00): <input name="partprice" type="text" value="<?php echo $rowResults['Part Price']; ?>" pattern="^\d+(\.|\,)\d{2}$" required><br>
	Unit Price (Ex. 1.00): <input name="unitprice" type="text" value="<?php echo $rowResults['Unit Price']; ?>" pattern="^\d+(\.|\,)\d{2}$" required><br>
    <label>Supplier: </label>
      <select id="supID" class="combobox" name="SUP_ID" required>
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
      <script>
        $(document).ready(function(){
            document.getElementById('supID').value = "<?php echo $rowResults['SUP_ID']; ?>";
        });
    </script>
	Part Description: <input name="description" type="text" value="<?php echo $rowResults['Part Description']; ?>" required><br>
	Quantity: <input name="quantity" type="text" value="<?php echo $rowResults['Quantity']; ?>" required><br>
	Unit Size: <input name="size" type="text" value="<?php echo $rowResults['Unit Size']; ?>" required><br>
	Quantity Minimum: <input name="min" type="text" value="<?php echo $rowResults['Quantity Minimum']; ?>" required><br>
	Quantity Maximum: <input name="max" type="text" value="<?php echo $rowResults['Quantity Max']; ?>" required><br>
	<input type="submit" value="Save">
</form>

</section>



<?php

	require("../footer.php");

?>