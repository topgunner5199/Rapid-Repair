<?php
require("../private.php");

	if($_POST["name"] != ""){
		 $query = " 
            INSERT INTO SUPPLIER ( 
				SUP_NAME,
				SUP_ADDRESS,
				SUP_CITY,
				SUP_STATE, 
				SUP_ZIP, 
				SUP_EMAIL, 
				SUP_PHONE,
				SUP_FAX, 
				SUP_CONTACT_NAME, 
				SUP_CONTACT_TITLE, 
				SUP_WEBSITE
            ) VALUES ( 
				:SUP_NAME,
				:SUP_ADDRESS,
				:SUP_CITY,
				:SUP_STATE, 
				:SUP_ZIP, 
				:SUP_EMAIL, 
				:SUP_PHONE,
				:SUP_FAX, 
				:SUP_CONTACT_NAME, 
				:SUP_CONTACT_TITLE, 
				:SUP_WEBSITE	
            ) 
        "; 
        $query_params = array( 
            	':SUP_NAME' => $_POST['name'], 
                ':SUP_ADDRESS' => $_POST['address'], 
                ':SUP_CITY' => $_POST['city'],
                ':SUP_STATE' => $_POST['state'],
                ':SUP_ZIP' => $_POST['zip'],
                ':SUP_EMAIL' => $_POST['email'],
                ':SUP_PHONE' => $_POST['phone'],
                ':SUP_FAX' => $_POST['fax'],
                ':SUP_CONTACT_NAME' => $_POST['cname'],
                ':SUP_CONTACT_TITLE' => $_POST['title'],
                ':SUP_WEBSITE' => $_POST['website']	
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        header('Location: http://rapidresponseauto.info/supplier.php');
	}
	require("../header.php");
?>



<section class="form">
<h1>Add Supplier</h1>
<form action="" method="POST">
	Supplier Name: <input name="name" type="text" required><br>
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
	Phone (Ex. 123-456-7890): <input name="phone" type="tel" pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$" required><br>
	Fax (Ex. 123-456-7890): <input name="fax" type="tel" pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$" ><br>
	Contact Name: <input name="cname" type="text" ><br>
	Contact Title: <select name="title" >
		<option value="" disabled selected>Select an option</option>
		<option>Mr.</option>
		<option>Mrs.</option>
		<option>Ms.</option>
	</select><br>
	Website: <input name="website" type="text" ><br>
	
	<input type="submit" value="Submit">
</form>

</section>



<?php

	require("../footer.php");

?>