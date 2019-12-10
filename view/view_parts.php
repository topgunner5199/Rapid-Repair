<?php
require("../private.php");
require("../header.php");
	if(isset($_GET['id'])){
		 $query = " 
            SELECT PART_ID AS 'Part ID', PART_NAME AS 'Part Name', PART_PRICE AS 'Part Price', UNIT_PRICE AS 'Unit Price', SUP_ID AS 'Supplier ID', PART_DESC AS 'Part Description', QUANTITY AS 'Quantity', UNIT_SIZE AS 'Unit Size', QUANTITY_MIN AS 'Quantity Minimum', QUANTITY_MAX AS 'Quantity Maximum'
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

        $row = $results->fetch();
// *************STOPPED ENTERING DATA HERE!*************
	}
	
?>



<section class="view">
<h1>View Part</h1>

<h3>Part ID: <?php echo $row['Part ID']; ?></h3>
<h3>Name: <?php echo $row['Part Name']; ?></h3>
<h3>Part Price: $<?php echo $row['Part Price']; ?></h3>
<h3>Unit Price: $<?php echo $row['Unit Price']; ?></h3>
<h3>Part Description: <?php echo $row['Part Description']; ?></h3>
<h3>Quantity in stock: <?php echo $row['Quantity']; ?></h3>
<h3>Unit Size: <?php echo $row['Unit Size']; ?></h3>
<h3>Minimum Quantity Allowed in stock: <?php echo $row['Quantity Minimum']; ?></h3>
<h3>Maximum Quantity Allowed in stock: <?php echo $row['Quantity Maximum']; ?></h3>


<?php

$query = "SELECT s.SUP_ID, SUP_NAME, SUP_CONTACT_TITLE,SUP_CONTACT_NAME, SUP_PHONE
			FROM SUPPLIER s, PARTS p
			WHERE p.SUP_ID=s.SUP_ID AND
			 s.SUP_ID = '".$row['Supplier ID']."'"; 
         
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
        $count = 1;
       $row = $results->fetch()
        	?>
        		<div class="Supplier">
        			<h2><a href="http://rapidresponseauto.info/view/view_supplier.php?id=<?php echo $row['SUP_ID']; ?>">Supplier</a></h2>
        			<h3>Supplier ID: <? echo $row['SUP_ID']; ?> </h3> 
        			<h3>Supplier Name: <? echo $row['SUP_NAME']; ?> </h3> 
        			<h3>Supplier Contact Title: <? echo $row['SUP_CONTACT_TITLE']; ?> </h3> 
					<h3>Supplier Contact name: <? echo $row ['SUP_CONTACT_NAME']; ?> </h3>
        		</div>
        	<?php
        	$count++;
        
?>



</section>



<?php

	require("../footer.php");

?>