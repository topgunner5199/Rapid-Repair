<?php
require("../private.php");
require("../header.php");
if(isset($_GET['id'])){
		 $query = " 
            SELECT S.SERVICE_ID AS id,C.CUST_ID, C.CUST_TITLE AS CUST_TITLE,C.CUST_FNAME AS CUST_FNAME,
			C.CUST_LNAME AS CUST_LNAME,E.EMP_ID,E.EMP_FNAME AS EMP_FNAME, E.EMP_LNAME AS EMP_LNAME,S.SERVICE_TIME AS SERV_TIME,
			S.SERVICE_DATE AS SERV_DATE, S.SERVICE_TOTAL_COST AS TOT_COST
			
			FROM SERVICE S, CUSTOMER C, EMPLOYEE E,  ADDITIONAL_PARTS AP
            WHERE S.SERVICE_ID = ".$_GET['id']."
			AND S.EMP_ID=E.EMP_ID
			AND S.CUST_ID=C.CUST_ID
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

        
?>



<section class="view">
<h1>View Transaction</h1>
<?php print_r($row); ?>

<h3>Transaction ID: <?php echo $rowResults['id']; ?></h3>

<h3>Customer Name: <a href="http://rapidresponseauto.info/view/view_customer.php?id=<?php echo $rowResults['CUST_ID']; ?>"><?php echo $rowResults['CUST_TITLE']." ".$rowResults['CUST_FNAME']." ".$row['CUST_LNAME']; ?> </a></h3>
<h3>Employee Name: <a href="http://rapidresponseauto.info/view/view_employee.php?id=<?php echo $rowResults['EMP_ID']; ?>"><?php echo $rowResults['EMP_FNAME']. " " .$rowResults['EMP_LNAME']; ?></a></h3>

<?php
	$query = " 
            SELECT 
			PR.PROMO_ID, PR.PROMO_NAME
			
			FROM SERVICE S, PROMOTIONS PR
            WHERE S.SERVICE_ID = ".$_GET['id']."
			AND S.PROMO_ID=PR.PROMO_ID
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
        if($row){
?>
<h3>Promotion ID: <a href="http://rapidresponseauto.info/view/view_promotion.php?id=<?php echo $row['PROMO_ID']; ?>"> <?php echo $row['PROMO_ID'];?></a> </h3>
<?php } ?>

<?php
	$query = " 
            SELECT PA.PACKAGE_ID , PA.PACKAGE_NAME
			
			FROM SERVICE S, PACKAGES PA
            WHERE S.SERVICE_ID = ".$_GET['id']."
			AND PA.PACKAGE_ID=S.PACKAGE_ID
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
        if($row){
?>

<h3>Package ID: <a href="http://rapidresponseauto.info/view/view_packages.php?id=<?php echo $row['PACKAGE_ID']; ?>"><?php echo $row['PACKAGE_ID']; ?></a></h3>
<?php } ?>
<h3>Service Time: <?php echo $rowResults['SERV_TIME']; ?></h3>
<h3>Service Date: <?php echo $rowResults['SERV_DATE']; ?></h3>
<h3>Total Cost: $ <? echo $rowResults['TOT_COST']; ?> </h3>

<?php
$query = "SELECT PS.PART_ID AS 'Part ID', PS.PART_NAME AS 'Part Name',	PS.PART_PRICE AS 'Part Price'
			FROM ADDITIONAL_PARTS PP, PARTS PS, SERVICE S
            WHERE S.SERVICE_ID = '".$rowResults["id"]."'
			AND S.SERVICE_ID = PP.ADDITIONAL_PARTS_ID
			AND PP.PART_ID = PS.PART_ID
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
        $count = 1;
        while($row = $results->fetch()){
        	?>
        		<div class="parts">
        			<h2><a href="http://rapidresponseauto.info/view/view_parts.php?id=<?php echo $row['Part ID']; ?>">Part <?php echo $count; ?></a></h2>
					<h3>Part ID: <?php echo $row['Part ID']; ?></h3>
					<h3>Part Name: <?php echo $row['Part Name']; ?></h3>
					<h3>Part Price: <?php echo $row['Part Price']; ?></h3>
        		</div>
        	<?php
        	$count++;
        }
?>







</section>



<?php

	require("../footer.php");

?>