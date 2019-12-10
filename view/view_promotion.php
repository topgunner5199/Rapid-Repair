<?php
require("../private.php");
require("../header.php");
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		 $query = " 
            SELECT PROMO_ID AS 'Promotion ID', EXPIRATION as 'Expiration', PROMO_TYPE as 'Promotion Type', PROMO_NAME AS 'Promotion Name'
            FROM PROMOTIONS
            WHERE PROMO_ID = '$id'
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

	}
	
?>
<section class="view">
<h1>View Promotion</h1>

<h3>Promotion ID: <?php echo $row['Promotion ID']; ?></h3>
<h3>Promotion Name: <?php echo $row['Promotion Name']; ?></h3>
<h3>Promotion Expiration: <?php echo $row['Expiration']; ?></h3>
<h3>Promotion Type: <?php echo $row['Promotion Type']; ?></h3>

<?php
$query = "SELECT PS.PART_ID AS 'Part ID', PS.PART_NAME AS 'Part Name',  PS.PART_PRICE AS 'Part Price', PP.DISCOUNT_DESC AS 'Desc'
            FROM PROMOTION_PARTS PP, PARTS PS, PROMOTIONS P
            WHERE P.PROMO_ID = '$id'
            AND P.PROMO_ID = PP.PROMO_PART_ID
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
                    <h3>Description: <?php echo $row['Desc']; ?></h3>
                </div>
            <?php
            $count++;
        }
?>

<?php
$query = "SELECT PA.PACKAGE_ID AS 'Package ID', PA.PACKAGE_NAME AS 'Name', 		PP.DISCOUNT_DESC AS 'Desc'
			FROM PROMOTIONS P, PROMOTION_PACKAGES PP, PACKAGES PA
            WHERE  P.PROMO_ID = '$id'
			AND P.PROMO_ID = PP.PROMO_PACKAGE_ID
			AND PP.PACKAGE_ID = PA.PACKAGE_ID 
		  ";
        try 
        { 
            // Execute the query against the database 
            $results = $db->query($query); 
			//echo $id;
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
        		<div class="packages">
        			<h2><a href="http://rapidresponseauto.info/view/view_packages.php?id=<?php echo $row['Package ID']; ?>">Package <?php echo $count; ?></a></h2>
					<h3>Package ID: <?php echo $row['Package ID']; ?></h3>
					<h3>Package Name: <?php echo $row['Name']; ?></h3>
					<h3>Description: <?php echo $row['Desc']; ?></h3>
        		</div>
        	<?php
        	$count++;
        }
?>
</section>




<?php

	require("../footer.php");

?>