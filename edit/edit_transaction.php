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
        if($row['PACKAGE_ID'] != ""){
            $additionalID = 1;
        } else{
            $additionalID =  $row['PACKAGE_ID'] + 1;
        }

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
                    ':ADDITIONAL_PARTS_ID' => $additionalID,
                    ':PART_ID' => $_POST['partname'.$i]
            ); 
             

                // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
        }


        header('Location: http://rapidresponseauto.info/transaction.php');
    }else if(isset($_GET['id'])){
         $query = " 
            SELECT SERVICE_ID, CUST_ID, EMP_ID, PROMO_ID, SERVICE_TIME, SERVICE_DATE, SERVICE_TOTAL_COST, PACKAGE_ID
            FROM SERVICE
            WHERE SERVICE_ID = ".$_GET['id']."
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
<h1>Edit Transaction</h1>
<form action="" method="POST" name="form">
    <input type="hidden" name="custID" value="<?php echo $_GET['custid']; ?>"/>
      <label>Customer: </label>
      <select id="custID" class="combobox" name="custID" required>
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

      <script>
        $(document).ready(function(){
            document.getElementById('custID').value = "<?php echo $rowResults['CUST_ID']; ?>";
        });
    </script>

      <label>Employee: </label>
      <select id="empID" class="combobox" name="empID" required>
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
      <script>
        $(document).ready(function(){
            document.getElementById('empID').value = "<?php echo $rowResults['EMP_ID']; ?>";
        });
    </script>
      <br>

      <label>Promotion: </label>
      <select id="promoID" class="combobox" name="promoID" required>
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

      <script>
        $(document).ready(function(){
            document.getElementById('promoID').value = "<?php echo $rowResults['PROMO_ID']; ?>";
        });
    </script>
          
      <br>
      <label>Package</label>
      <select id="packageID" id="PackageValues" name="packageID" required>
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

      <script>
        $(document).ready(function(){
            document.getElementById('packageID').value = "<?php echo $rowResults['PACKAGE_ID']; ?>";
        });
    </script>

      <br>

    Service Time: <input name="serviceTime" type="time" required value="<?php echo $rowResults['SERVICE_TIME']; ?>"><br>
    Service Date: <input name="serviceDate" type="date" required value="<?php echo $rowResults['SERVICE_DATE']; ?>"><br>
    Service Total Cost: <input name="totalCost" type="text" required value="<?php echo $rowResults['SERVICE_TOTAL_COST']; ?>"><br>


   <div class="variableFields" id="Parts">
        Additional Parts: <input id="PartCounter" class="itemCount" type="number" min="0" max="10" placeholder="0"/><br>
        <div class="fieldReplica">
            
        </div>
    </div>
    <?php
                $query = " 
                SELECT P.PART_NAME, P.PART_ID, A.ADDITIONAL_PARTS_ID
                FROM PARTS P
                JOIN ADDITIONAL_PARTS A ON P.PART_ID = A.PART_ID
                WHERE A.ADDITIONAL_PARTS_ID = ".$rowResults['SERVICE_ID']."
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