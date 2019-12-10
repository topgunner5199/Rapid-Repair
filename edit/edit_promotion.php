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
    } else if(isset($_GET['id'])){
        $query = " 
            SELECT PROMO_NAME, EXPIRATION, PROMO_TYPE, PROMO_ID
            FROM PROMOTIONS
            WHERE PROMO_ID = ".$_GET['id']."
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
<h1>Edit Promotion</h1>
<form action="" method="POST">
    Promotion Name: <input name="Promo_name" type="text" value="<?php echo $rowResults['PROMO_NAME'] ?>" required><br>
    Expiration: <input name="Expiration" type="date"  value="<?php echo $rowResults['EXPIRATION'] ?>" required><br>
    Promotion Type: <input name="Promo_type" type="text"  value="<?php echo $rowResults['PROMO_TYPE'] ?>" required><br>
    <div class="variableFields" id="PromoParts">
        Additional Parts: <input id="PartCounter" class="itemCount" type="number" min="0" max="10"/><br>
        <div class="fieldReplica"></div>
    </div>
    <div class="variableFields" id="Packages">
        Additional Packages: <input id="PackageCounter" class="itemCount" type="number" min="0" max="10"/><br>
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

<?php
        $query = " 
        SELECT P.PART_NAME, P.PART_ID, A.PROMO_PART_ID, A.DISCOUNT_DESC
        FROM PARTS P
        JOIN PROMOTION_PARTS A ON P.PART_ID = A.PART_ID
        WHERE A.PROMO_PART_ID = ".$rowResults['PROMO_ID']."
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
    $count = 0;
    $array = array();
    $desc = array();
    while($row = $results->fetch()){
        
        $array[$count] = $row['PART_ID'];
        $desc[$count] = $row['DISCOUNT_DESC'];
        $count++;
    }

    if($count > 0){
        ?>
        <script>
            $(document).ready(function(){
              var items = [
                <?php for($i = 0; $i < $count; $i++){
                    echo '"'.$array[$i].'",';
                } ?>
              ];

              var desc = [
                <?php for($i = 0; $i < $count; $i++){
                    echo '"'.$desc[$i].'",';
                } ?>
              ];
              $("#PromoParts .fieldReplica").html("");
              var output = "";
              for(var i = 0; i < <?php echo $count; ?>; i++){
                output += "<input type='hidden' name='numParts' value='"+$(this).val()+"'/>";
                output += '<label>Part '+(i+1)+" Name: </label> <select class='combobox additionalparts' id='partname"+i+"' name='partname"+i+"' required>";
                output += $("#PartValues").html()+"</select><br><label>Part Discount "+(i+1)+" Description</label><input type='text' id='partDescription"+i+"' name='partDescription"+i+"'/><br>"; 

              }
              $("#PromoParts .fieldReplica").html($("#PromoParts .fieldReplica").html()+output);
              document.getElementById('PartCounter').value = <?php echo $count; ?>;
              for(var i = 0; i < <?php echo $count; ?>; i++){
                console.log('partname'+i);
                document.getElementById('partname'+i).value = items[i];
                document.getElementById('partDescription'+i).value = desc[i];
              }
            });
        </script>
        <?php
    }

    ?>


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
        $query = " 
        SELECT P.PACKAGE_NAME, P.PACKAGE_ID, A.PROMO_PACKAGE_ID, A.DISCOUNT_DESC
        FROM PACKAGES P
        JOIN PROMOTION_PACKAGES A ON P.PACKAGE_ID = A.PACKAGE_ID
        WHERE A.PROMO_PACKAGE_ID = ".$rowResults['PROMO_ID']."
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
    $count = 0;
    $array = array();
    $desc = array();
    while($row = $results->fetch()){
        
        $array[$count] = $row['PACKAGE_ID'];
        $desc[$count] = $row['DISCOUNT_DESC'];
        $count++;
    }
    echo $count;
    if($count > 0){
        ?>
        <script>
            $(document).ready(function(){
              var items = [
                <?php for($i = 0; $i < $count; $i++){
                    echo '"'.$array[$i].'",';
                } ?>
              ];

              var desc = [
                <?php for($i = 0; $i < $count; $i++){
                    echo '"'.$desc[$i].'",';
                } ?>
              ];
              $("#Packages .fieldReplica").html("");
              var output = "";
              for(var i = 0; i < <?php echo $count; ?>; i++){
                output += "<input type='hidden' name='numParts' value='"+$(this).val()+"'/>";
                output += '<label>Package '+(i+1)+" Name: </label> <select class='combobox additionalpackages' id='packagename"+i+"' name='packagename"+i+"' required>";
                output += $("#PackageValues").html()+"</select><br><label>Package Discount "+(i+1)+" Description</label><input type='text' id='packageDescription"+i+"' name='packageDescription"+i+"'/><br>"; 

              }
              $("#Packages .fieldReplica").html($("#Packages .fieldReplica").html()+output);
              document.getElementById('PackageCounter').value = <?php echo $count; ?>;
              for(var i = 0; i < <?php echo $count; ?>; i++){
                console.log('packagename'+i);
                document.getElementById('packagename'+i).value = items[i];
                document.getElementById('packageDescription'+i).value = desc[i];
              }
            });
        </script>
        <?php
    }

    ?>



<?php

    require("../footer.php");

?>