<?php
    $id = $_GET['id'];

    require("../common.php");
         $query = " 
            UPDATE PACKAGES
            SET DELETED='YES'
            WHERE PACKAGE_ID = :ID
        "; 
        $query_params = array( 
                ':ID' => $id
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        header('Location: http://rapidresponseauto.info/packages.php');
?>