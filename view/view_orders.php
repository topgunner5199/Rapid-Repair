<?php
require("../private.php");

require("../restrict.php");
	if(isset($_GET['id'])){
		 $query = " 
            SELECT o.ORDER_ID AS ID, o.ORDER_DATE AS Order_Date,(p.UNIT_PRICE * od.PART_UNIT_SIZE)AS TOT_COST
            FROM ORDERS o,PARTS p, ORDER_DETAILS od
            WHERE o.ORDER_ID = ".$_GET['id']."
			AND od.ORDER_ID=o.ORDER_ID
			AND od.PART_ID=p.PART_ID
			
	
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
        $count=1;
       $rowResults = $results->fetch();

	}
	require("../header.php");
?>



<section class="view">
<h1>View Order</h1>

<h3>Order ID: <?php echo $rowResults['ID']; ?></h3>
<h3>Order Date: <?php echo $rowResults['Order_Date']; ?></h3>

<h2><br>Part Information:</h2> 
<?php
	
		 $query = " 
            SELECT od.Part_ID AS PART_ID,p.PART_NAME AS Part_Name, od.PART_COST,
			od.PART_UNIT_SIZE ,
			p.UNIT_PRICE AS Unit_Price, (p.UNIT_PRICE * od.PART_UNIT_SIZE)AS TOT_COST
            FROM ORDERS o, ORDER_DETAILS od, PARTS p
            WHERE o.ORDER_ID = ".$_GET['id']."
			AND o.ORDER_ID = od.ORDER_ID
			AND od.PART_ID = p.PART_ID
	
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
$count=1;
?>



<?php
$total = 0;
while($row = $results->fetch()){
    $total = $total + ($row['Unit_Price'] * $row['PART_UNIT_SIZE']);

?>

<h2><a href="http://rapidresponseauto.info/view/view_parts.php?id=<?php echo $row['PART_ID']; ?>">Part <?php echo $count; ?></a></h2>
<h3>Part ID: <? echo $row['PART_ID']; ?> </h3>
<h3>Part Name: <? echo $row['Part_Name']; ?> </h3>
<h3>Unit Price: <?php echo $row['Unit_Price']; ?></h3>
<h3>Quantity Ordered: <?php echo $row['PART_UNIT_SIZE']; ?></h3>

<?php
$count++;
}
?>
</br>
</br>
<h2>Order Cost: $<?php echo $total; ?></h2>












<?php
$count++;
?>


        

</section>



<?php

	require("../footer.php");

?>