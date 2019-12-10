<?php
require("../private.php");
	if($_POST["fName"] != ""){
		 $query = " 
            UPDATE CUSTOMER
            SET 
                CUST_TITLE = :CUST_TITLE, 
                CUST_FNAME = :CUST_FNAME, 
                CUST_LNAME = :CUST_LNAME, 
                CUST_PHONE = :CUST_PHONE,
                CUST_STREET = :CUST_STREET,
                CUST_CITY = :CUST_CITY,
                CUST_STATE = :CUST_STATE,
                CUST_ZIP = :CUST_ZIP,
                CUST_EMAIL = :CUST_EMAIL
            WHERE CUST_ID = ".$_POST['id']."
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
                ':CUST_EMAIL' => $_POST['email']
        ); 
         

            // Execute the query to create the user 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params);
        header('Location: http://rapidresponseauto.info/customer.php');
	}else if(isset($_GET['id'])){
		 $query = " 
            SELECT CUST_TITLE AS 'Title', CUST_FNAME as 'First Name', CUST_LNAME as 'Last Name', CUST_PHONE ,CUST_STREET as Address, CUST_CITY as City, CUST_STATE as State, CUST_EMAIL as Email,CUST_ZIP as ZIP, CUST_LAST_VISIT AS 'Last Visit', CUST_DATE_ADDED AS 'Date Added'
            FROM CUSTOMER
            WHERE CUST_ID = ".$_GET['id']."
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
	require("../header.php");
?>



<section class="form">
<h1>Edit Customer</h1>
<form action="" method="POST">
	<input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
	Title: <select name="title"  required>
		<option <?php if($row['Title'] == "Mr."){echo "selected";} ?>>Mr.</option>
		<option<?php if($row['Title'] == "Mrs."){echo "selected";} ?>>Mrs.</option>
		<option<?php if($row['Title'] == "Ms."){echo "selected";} ?>>Ms.</option>
	</select><br>
	First Name: <input name="fName" type="text" value="<?php echo $row['First Name']; ?>" required><br>
	Last Name: <input name="lName" type="text" value="<?php echo $row['Last Name']; ?>" required><br>
	Phone (Ex. 123-456-7890): <input name="phone" type="tel" pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$" value="<?php echo $row['CUST_PHONE']; ?>" required><br>
	Address: <input name="address" type="text" value="<?php echo $row['Address']; ?>" required><br>
	City: <input name="city" type="text" value="<?php echo $row['City']; ?>" required><br>
	State: <select id="state" name="state" required>
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
	<script>
		$(document).ready(function(){
			document.getElementById('state').value = "<?php echo $row['State']; ?>";
		});
	</script>
	ZIP: <input name="zip" type="text" pattern="(\d{5}([\-]\d{4})?)" value="<?php echo $row['ZIP']; ?>" required><br>
	Email: <input name="email" type="text" value="<?php echo $row['Email']; ?>" required><br>
	<input type="submit" value="Save">
</form>

</section>



<?php

	require("../footer.php");

?>