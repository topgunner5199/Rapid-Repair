<?php
    $id = $_GET['id'];

    require("../common.php");
         $query = " 
            UPDATE SERVICE
            SET DELETED='YES'
            WHERE SERVICE_ID = :ID
        "; 
        $query_params = array( 
                ':ID' => $id
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        header('Location: http://rapidresponseauto.info/transaction.php');
?>