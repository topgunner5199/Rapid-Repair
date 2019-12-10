<?php
require("../private.php");
    

    if($_POST["custID"] != ""){
        $query = " 
            SELECT PACKAGE_ID
            FROM SERVICE
            ORDER BY PACKAGE_ID DESC LIMIT 1
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

         $query = " 
            INSERT INTO SERVICE ( 
                CUST_ID, 
                EMP_ID, 
                PROMO_ID, 
                SERVICE_TIME,
                SERVICE_DATE,
                SERVICE_TOTAL_COST,
                PACKAGE_ID
                
            ) VALUES ( 
                :CUST_ID, 
                :EMP_ID, 
                :PROMO_ID, 
                :SERVICE_TIME,
                :SERVICE_DATE,
                :SERVICE_TOTAL_COST,
                :PACKAGE_ID
                
            ) 
        "; 
        $query_params = array( 
                ':CUST_ID' => $_POST['custID'], 
                ':EMP_ID' => $_POST['empID'], 
                ':PROMO_ID' => $_POST['promoID'], 
                ':SERVICE_TIME' => $_POST['serviceTime'],
                ':SERVICE_DATE' => $_POST['serviceDate'],
                ':SERVICE_TOTAL_COST' => $_POST['totalCost'], 
                ':PACKAGE_ID' => $_POST['packageID']
                
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        $id = $db->lastInsertId();

        for($i = 0; $i < $_POST['numParts']; $i++){
            $query = " 
                INSERT INTO ADDITIONAL_PARTS ( 
                    ADDITIONAL_PARTS_ID,
                    PART_ID
                    
                ) VALUES ( 
                    :ADDITIONAL_PARTS_ID,
                    :PART_ID
                    
                ) 
            "; 
            $query_params = array( 
                    ':ADDITIONAL_PARTS_ID' => $id,
                    ':PART_ID' => $_POST['partname'.$i]
            ); 
             

                // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
        }


        header('Location: http://rapidresponseauto.info/transaction.php');
    }
    require("../header.php");
?>



<section class="form">
<h1>Add Transaction</h1>
<form action="" method="POST" name="form">
    <input type="hidden" name="custID" value="<?php echo $_GET['custid']; ?>"/>
      <label>Customer: </label>
      <select class="combobox" name="custID" required>
          <option value="" disabled selected>Select an option</option>
            <?php
                $query = " 
                SELECT CUST_ID, CUST_TITLE, CUST_FNAME, CUST_LNAME
                FROM CUSTOMER
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
                <option value="<?php echo $row['CUST_ID']; ?>"><?php echo $row['CUST_TITLE']. " " . $row['CUST_FNAME'] . " " . $row['CUST_LNAME']; ?></option>
                <?php
            }
            ?>
      </select>
      <br>

      <label>Employee: </label>
      <select class="combobox" name="empID" required>
          <option value="" disabled selected>Select an option</option>
            <?php
                $query = " 
                SELECT EMP_ID, EMP_FNAME, EMP_LNAME
                FROM EMPLOYEE
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
                <option value="<?php echo $row['EMP_ID']; ?>"><?php echo $row['EMP_FNAME'] . " " . $row['EMP_LNAME']; ?></option>
                <?php
            }
            ?>
      </select>
      <br>

      <label>Promotion: </label>
      <select class="combobox" name="promoID">
          <option value="" disabled selected>Select an option</option>
            <?php
                $query = " 
                SELECT PROMO_NAME, PROMO_ID
                FROM PROMOTIONS
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
                <option value="<?php echo $row['PROMO_ID']; ?>"><?php echo $row['PROMO_NAME']; ?></option>
                <?php
            }
            ?>
      </select>
      <br>
      <label>Package: </label>
      <select id="PackageValues" name="packageID">
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
      <br>

    Service Time: <input name="serviceTime" type="time" required><br>
    Service Date: <input name="serviceDate" type="date" required><br>
    Service Total Cost: <input name="totalCost" type="text" required><br>


   <div class="variableFields" id="Parts">
        Additional Parts: <input class="itemCount" type="number" min="0" max="10" placeholder="0"/><br>
        <div class="fieldReplica">
            
        </div>
    </div>
    
        
    
    <input type="submit" value="Submit">
</form>

</section>


      <select id="PartValues" style="display:none" name="custID" required>
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