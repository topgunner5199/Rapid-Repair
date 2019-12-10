<?php
require("../private.php");

    if($_POST["packageName"] != ""){
         $query = " 
            UPDATE PACKAGES
            SET 
                PACKAGE_ID = :PACKAGE_ID,
                PACKAGE_NAME = :PACKAGE_NAME,
                PACKAGE_PRICE = :PACKAGE_PRICE
            WHERE PACKAGE_ID = ".$_POST['id']."
        "; 
        $query_params = array( 
                ':PACKAGE_ID' => $_POST['id'],
                ':PACKAGE_NAME' => $_POST['packageName'],
                ':PACKAGE_PRICE' => $_POST['packagePrice']
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        header('Location: http://rapidresponseauto.info/packages.php');
    }else if(isset($_GET['id'])){
         $query = " 
            SELECT PACKAGE_ID, PACKAGE_NAME AS 'Package Name', PACKAGE_PRICE as 'Package Price'
            FROM PACKAGES
            WHERE PACKAGE_ID = ".$_GET['id']."
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
<h1>Edit Package</h1>
<form action="" method="POST">
    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
    Package Name: <input name="packageName" type="text" value="<?php echo $rowResults['Package Name']; ?>" required><br>
    Part Price (Ex. 1.00): <input name="packagePrice" type="text" value="<?php echo $rowResults['Package Price']; ?>" pattern="^\d+(\.|\,)\d{2}$" required><br>

<div class="variableFields" id="Parts">
    Additional Parts: <input id="PartCounter" class="itemCount" type="number" min="0" max="10"/><br>
    <div class="fieldReplica"/>
</div>

<?php
        $query = " 
        SELECT P.PART_NAME, P.PART_ID, A.PACKAGE_PARTS_ID
        FROM PARTS P
        JOIN PACKAGE_PARTS A ON P.PART_ID = A.PART_ID
        WHERE A.PACKAGE_PARTS_ID = ".$rowResults['PACKAGE_ID']."
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
    while($row = $results->fetch()){
        
        $array[$count] = $row['PART_ID'];
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
              $("#Parts .fieldReplica").html("");
              var output = "";
              for(var i = 0; i < <?php echo $count; ?>; i++){
                output += "<input type='hidden' name='numParts' value='"+$(this).val()+"'/>";
                output += '<label>Part '+(i+1)+" Name: </label> <select class='combobox additionalparts' id='partname"+i+"' name='partname"+i+"' required>";
                output += $("#PartValues").html()+"</select><br>"; 
    
              }
              $("#Parts .fieldReplica").html($("#Parts .fieldReplica").html()+output);
              document.getElementById('PartCounter').value = <?php echo $count; ?>;
              for(var i = 0; i < <?php echo $count; ?>; i++){
                console.log('partname'+i);
                document.getElementById('partname'+i).value = items[i];
              }
            });
        </script>
        <?php
    }

    ?>
    
    <input type="submit" value="Save">
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