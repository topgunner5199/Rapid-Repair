<?php
    require("private.php");
	require("header.php");
    require("restrict.php");
    $table = 'orders';
	
	if($_POST['mode'] == "search"){
        $query = " 
            SELECT ORDER_ID AS ID, ORDER_DATE as 'Order Date', ORDER_TOTAL_COST as Cost
            FROM ORDERS O 
            WHERE ".$_POST['field']." LIKE '%".$_POST['query']."%'
        ";
	}else if($_GET['mode'] == "sort"){
        $query = " 
            SELECT ORDER_ID AS ID, ORDER_DATE as 'Order Date', ORDER_TOTAL_COST as Cost
            FROM ORDERS O
            ORDER BY ".$_GET['field']." ".$_GET['sortMode']."
        "; 
    }else{
    $query = " 
             SELECT ORDER_ID AS ID, ORDER_DATE as 'Order Date', ORDER_TOTAL_COST as Cost
            FROM ORDERS O
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
         
    $q = $db->prepare("DESCRIBE ORDERS");
    $q->execute();
    $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);

?>



<section class="table">

	<h1>Orders</h1>
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

    <?php include('order_table_generator.php');?>


</section>



<?php

	require("footer.php");

?>