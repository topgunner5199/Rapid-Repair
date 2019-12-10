<?php
require("../private.php");

	if($_POST["Promo_name"] != ""){
		
		 $query = " 
            INSERT INTO PROMOTIONS ( 
                PROMO_NAME,
                EXPIRATION,
                PROMO_TYPE
            ) VALUES ( 
            	:PROMO_NAME,
                :EXPIRATION,
                :PROMO_TYPE	
            ) 
        "; 
        $query_params = array( 
        		':PROMO_NAME' => $_POST['Promo_name'],
                ':EXPIRATION' => $_POST['Expiration'],
                ':PROMO_TYPE' => $_POST['Promo_type']
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        $id = $db->lastInsertId();

        for($i = 0; $i < $_POST['numParts']; $i++){
            $query = " 
                INSERT INTO PROMOTION_PARTS ( 
                    PROMO_PART_ID,
                    PART_ID,
                    DISCOUNT_DESC
                    
                ) VALUES ( 
                    :PROMO_PART_ID,
                    :PART_ID,
                    :DISCOUNT_DESC
                    
                ) 
            "; 
            $query_params = array( 
                    ':PROMO_PART_ID' => $id,
                    ':PART_ID' => $_POST['partname'.$i],
                    ':DISCOUNT_DESC' => $_POST['partDescription'.$i]
            );
             

                // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
        }

        for($i = 0; $i < $_POST['numPackages']; $i++){
            $query = " 
                INSERT INTO PROMOTION_PACKAGES ( 
                    PROMO_PACKAGE_ID,
                    PACKAGE_ID,
                    DISCOUNT_DESC
                    
                ) VALUES ( 
                    :PROMO_PACKAGE_ID,
                    :PACKAGE_ID,
                    :DISCOUNT_DESC
                    
                ) 
            "; 
            $query_params = array( 
                    ':PROMO_PACKAGE_ID' => $id,
                    ':PACKAGE_ID' => $_POST['packagename'.$i],
                    ':DISCOUNT_DESC' => $_POST['packageDescription'.$i]
            );
             

                // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
        }

        header('Location: http://rapidresponseauto.info/promotion.php');
	}
	require("../header.php");
?>



<section class="form">
<h1>Add Promotion</h1>
<form action="" method="POST">
	Promotion Name: <input name="Promo_name" type="text" required><br>
	Expiration: <input name="Expiration" type="date" required><br>
	Promotion Type: <input name="Promo_type" type="text" required><br>
	<div class="variableFields" id="PromoParts">
        Additional Parts: <input class="itemCount" type="number" min="0" max="10"/><br>
        <div class="fieldReplica"></div>
    </div>
    <div class="variableFields" id="Packages">
        Additional Packages: <input class="itemCount" type="number" min="0" max="10"/><br>
        <div class="fieldReplica"></div>
    </div>

	<input type="submit" value="Submit">
</form>

</section>

<select id="PartValues" style="display:none" name="partID" required>
  <option value="" disabled selected>Select an option</option>
    <?php
        $query = " 
        SELECT PART_ID, PART_NAME
        FROM PARTS
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
        <option value="<?php echo $row['PART_ID']; ?>"><?php echo $row['PART_NAME']; ?></option>
        <?php
    }
    ?>
</select>

<select id="PackageValues" style="display:none" name="packageID" required>
  <option value="" disabled selected>Select an option</option>
    <?php
        $query = " 
        SELECT PACKAGE_ID, PACKAGE_NAME
        FROM PACKAGES
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
        <option value="<?php echo $row['PACKAGE_ID']; ?>"><?php echo $row['PACKAGE_NAME']; ?></option>
        <?php
    }
    ?>
</select>



<?php

	require("../footer.php");

?>