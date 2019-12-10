<?php
    $id = $_GET['id'];

    require("../common.php");
        $query = " 
            DELETE FROM CUSTOMER_VEHICLES
            WHERE VEHICLE_ID = :ID
        "; 
        $query_params = array( 
                ':ID' => $id
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
         $query = " 
            DELETE FROM VEHICLE
            WHERE VEHICLE_ID = :ID
        "; 
        $query_params = array( 
                ':ID' => $id
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        header('Location: http://rapidresponseauto.info/vehicles.php');
?>