<?php
require("../private.php");

	if($_POST["fName"] != ""){
		 $query = " 
            INSERT INTO CUSTOMER ( 
                CUST_TITLE, 
                CUST_FNAME, 
                CUST_LNAME, 
                CUST_PHONE,
                CUST_STREET,
                CUST_CITY,
                CUST_STATE,
                CUST_ZIP,
                CUST_EMAIL,
                CUST_LAST_VISIT,
                CUST_DATE_ADDED
            ) VALUES ( 
            	:CUST_TITLE,
                :CUST_FNAME, 
                :CUST_LNAME, 
                :CUST_PHONE,
                :CUST_STREET,
                :CUST_CITY,
                :CUST_STATE,
                :CUST_ZIP,
                :CUST_EMAIL,
                :CUST_LAST_VISIT,
                :CUST_DATE_ADDED	
            ) 
        "; 
        $query_params = array( 
        		':CUST_TITLE' => $_POST['title'],
            	':CUST_FNAME' => $_POST['fName'], 
                ':CUST_LNAME' => $_POST['lName'], 
                ':CUST_PHONE' => $_POST['phone'],
                ':CUST_STREET' => $_POST['address'],
                ':CUST_CITY' => $_POST['city'],
                ':CUST_STATE' => $_POST['state'],
                ':CUST_ZIP' => $_POST['zip'],
                ':CUST_EMAIL' => $_POST['email'],
                ':CUST_LAST_VISIT' => date('Y/m/d'),
                ':CUST_DATE_ADDED' => date('Y/m/d')	
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
        $id = $db->lastInsertId();
        header('Location: http://rapidresponseauto.info/view/view_customer.php?id='.$id);
	}
	require("../header.php");
?>



<section class="form">
<h1>Add Customer</h1>
<form action="" method="POST">
	Title: <select name="title" required>
		<option value="" disabled selected>Select an option</option>
		<option>Mr.</option>
		<option>Mrs.</option>
		<option>Ms.</option>
	</select><br>
	First Name: <input name="fName" type="text" required><br>
	Last Name: <input name="lName" type="text" required><br>
	Phone (Ex. 123-456-7890): <input name="phone" type="tel" pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$" required><br>
	Address: <input name="address" type="text" required><br>
	City: <input name="city" type="text" required><br>
	State: <select name="state" required>
		<option value="" disabled selected>Select your option</option>
		<option>Alabama</option>
		<option>Alaska</option>
		<option>Arizona</option>
		<option>Arkansas</option>
		<option>California</option>
		<option>Colorado</option>
		<option>Connecticut</option>
		<option>Delaware</option>
		<option>Florida</option>
		<option>Georgia</option>
		<option>Hawaii</option>
		<option>Idaho</option>
		<option>Illinois</option>
		<option>Indiana</option>
		<option>Iowa</option>
		<option>Kansas</option>
		<option>Kentucky</option>
		<option>Louisiana</option>
		<option>Maine</option>
		<option>Maryland</option>
		<option>Massachusetts</option>
		<option>Michigan</option>
		<option>Minnesota</option>
		<option>Mississippi</option>
		<option>Missouri</option>
		<option>Montana</option>
		<option>Nebraska</option>
		<option>Nevada</option>
		<option>New Hampshire</option>
		<option>New Jersey</option>
		<option>New Mexico</option>
		<option>New York</option>
		<option>North Carolina</option>
		<option>North Dakota</option>
		<option>Ohio</option>
		<option>Oklahoma</option>
		<option>Oregon</option>
		<option>Pennsylvania</option>
		<option>Rhode Island</option>
		<option>South Carolina</option>
		<option>South Dakota</option>
		<option>Tennessee</option>
		<option>Texas</option>
		<option>Utah</option>
		<option>Vermont</option>
		<option>Virginia</option>
		<option>Washington</option>
		<option>West Virginia</option>
		<option>Wisconsin</option>
		<option>Wyoming</option>

	</select><br>
	ZIP: <input name="zip" type="text" pattern="(\d{5}([\-]\d{4})?)" required><br>
	Email: <input name="email" type="email" required><br>
	<input type="submit" value="Submit">
</form>
    <?php
        if($_POST['mode'] == "submit"){
            ?>
            <h3><a href="http://rapidresponseauto.info/view/view_customer.php?id=" + "$CUST_ID"></a></h3>
            <?php
        }
     ?>
</section>



<?php

	require("../footer.php");

?>