<?php
    $id = $_GET['id'];

    require("../common.php");
         $query = " 
            DELETE FROM SERVICE
            WHERE SERVICE_ID = :ID
        "; 
        $query_params = array( 
                ':ID' => $id
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        header('Location: http://rapidresponseauto.info/orders.php');
?>