<?php
require("private.php");
	require("header.php");
    $table = 'parts';
    if($_POST['mode'] == "search"){
        $query = " 
            SELECT PART_ID AS ID, PART_NAME AS 'Part Name', PART_PRICE as 'Part Price', UNIT_PRICE as 'Unit Price', SUP_ID as 'Supplier ID', PART_DESC as 'Part Description', QUANTITY as Quantity, UNIT_SIZE as 'Unit Size', QUANTITY_MIN as 'Quantity Minimum', QUANTITY_MAX as 'Quantity Max'
            FROM PARTS
            WHERE ".$_POST['field']." LIKE '%".$_POST['query']."%'
            AND DELETED = 'NO'
        "; 
    }else if($_GET['mode'] == "sort"){
        $query = " 
            SELECT PART_ID AS ID, PART_NAME AS 'Part Name', PART_PRICE as 'Part Price', UNIT_PRICE as 'Unit Price', SUP_ID as 'Supplier ID', PART_DESC as 'Part Description', QUANTITY as Quantity, UNIT_SIZE as 'Unit Size', QUANTITY_MIN as 'Quantity Minimum', QUANTITY_MAX as 'Quantity Max'
            FROM PARTS
            WHERE DELETED = 'NO'
            ORDER BY ".$_GET['field']." ".$_GET['sortMode']."
            ";
    }else{
        $query = " 
            SELECT PART_ID AS ID, PART_NAME AS 'Part Name', PART_PRICE as 'Part Price', UNIT_PRICE as 'Unit Price', SUP_ID as 'Supplier ID', PART_DESC as 'Part Description', QUANTITY as Quantity, UNIT_SIZE as 'Unit Size', QUANTITY_MIN as 'Quantity Minimum', QUANTITY_MAX as 'Quantity Max'
            FROM PARTS
            WHERE DELETED = 'NO'
        "; 
    }
         
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
         
    $q = $db->prepare("DESCRIBE PARTS");
    $q->execute();
    $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);

?>



<section class="table">

	<h1>Parts</h1>
    <a href="http://rapidresponseauto.info/add/add_<?php echo $table?>.php"><button>Add Parts</button></a>
	<form action="" method="POST">
        <input type="hidden" name="mode" value="search"/>
        <div class="search">
            <select name="field" id="SearchField" required>
                <option value="" disabled selected>Select an option</option>
                <?php 
                    $header = array();
                    $i = 0;
                    while($results->getColumnMeta($i)){
                        $meta = $results->getColumnMeta($i);
                        $header[] = $meta['name'];
                        echo "<option name='searchID' value='".$table_fields[$i]."'>".$meta['name']."</option>"; 
                        $i++;

                    } 
                    ?>
            </select>
            <script>
                $(document).ready(function(){
                    document.getElementById('SearchField').value = "<?php echo $_POST['field']; ?>";
                });
            </script>
            <input type ="text" name="query" value="<?php echo $_POST['query']; ?>" required/>
            <input type="submit" value="Search"/>
        </div>
    </form>
    <?php
        if($_POST['mode'] == "search"){
            ?>
            <h3><a href="http://www.rapidresponseauto.info/<?php echo $table; ?>.php">Go Back</a></h3>
            <?php
        }
     ?>

	<br/>

	<br/>

    <?php include('table_generator.php');?>


</section>



<?php

	require("footer.php");

?>