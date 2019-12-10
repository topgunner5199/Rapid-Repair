<?php
require("../private.php");
require("../header.php");
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		 $query = " 
            SELECT PACKAGE_NAME AS 'Package Name', PACKAGE_ID AS 'Package ID', PACKAGE_PRICE AS 'Package Price'
            FROM  PACKAGES
            WHERE PACKAGE_ID = '$id'
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

<h1>View Package</h1>
<h3>Package ID: <?php echo $row['Package ID']; ?></h3>
<h3>Package Name: <?php echo $row['Package Name']; ?></h3>
<h3>Package Price: <?php echo $row['Package Price']; ?></h3>

<?php
$query = "SELECT PS.PART_ID AS 'Part ID', PS.PART_NAME AS 'Part Name',	PS.PART_PRICE AS 'Part Price'
			FROM PACKAGE_PARTS PP, PARTS PS, PACKAGES P
            WHERE P.PACKAGE_ID = '$id'
			AND P.PACKAGE_ID = PP.PACKAGE_PARTS_ID
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
