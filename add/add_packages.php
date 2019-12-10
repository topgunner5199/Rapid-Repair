<?php
    require("../private.php");


	if($_POST["packageName"] != ""){

         $query = " 
            INSERT INTO PACKAGES ( 
                PACKAGE_NAME, 
                PACKAGE_PRICE
                
            ) VALUES ( 
                :PACKAGE_NAME, 
                :PACKAGE_PRICE
                
            ) 
        "; 
        $query_params = array( 
                ':PACKAGE_NAME' => $_POST['packageName'], 
                ':PACKAGE_PRICE' => $_POST['packagePrice']
                
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        $id = $db->lastInsertId();

        for($i = 0; $i < $_POST['numParts']; $i++){
            $query = " 
                INSERT INTO PACKAGE_PARTS ( 
                    PACKAGE_PARTS_ID,
                    PART_ID
                    
                ) VALUES ( 
                    :PACKAGE_PARTS_ID,
                    :PART_ID
                    
                ) 
            "; 
            $query_params = array( 
                    ':PACKAGE_PARTS_ID' => $id,
                    ':PART_ID' => $_POST['partname'.$i]
            );
             

                // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
        }


        header('Location: http://rapidresponseauto.info/packages.php');
    }
	   require("../header.php");
?>

<section class="form">
<h1>Add Package</h1>
<form action="" method="POST">
	Package Name: <input name="packageName" type="text" required><br>
	Package Price (Ex. 1.00): <input name="packagePrice" type="text" required><br>
	


<div class="variableFields" id="Parts">
        Additional Parts: <input class="itemCount" type="number" min="0" max="10"/><br>
        <div class="fieldReplica"/>
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

<?php

	require("../footer.php");

?>

