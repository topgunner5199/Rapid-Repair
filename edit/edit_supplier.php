<?php
require("../private.php");
	if($_POST["name"] != ""){
		 $query = " 
            UPDATE SUPPLIER
            SET 
				SUP_NAME = :SUP_NAME,
				SUP_ADDRESS = :SUP_ADDRESS,
				SUP_CITY = :SUP_CITY,
				SUP_STATE =  :SUP_STATE,
				SUP_ZIP = :SUP_ZIP, 
				SUP_EMAIL = :SUP_EMAIL,
				SUP_PHONE = :SUP_PHONE,
				SUP_FAX = :SUP_FAX, 
				SUP_CONTACT_NAME =  :SUP_CONTACT_NAME,
				SUP_CONTACT_TITLE =  :SUP_CONTACT_TITLE, 
				SUP_WEBSITE = :SUP_WEBSITE					
            WHERE SUP_ID = ".$_POST['id']."
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
	}else if(isset($_GET['id'])){
		 $query = " 
            SELECT SUP_ID AS ID, SUP_NAME AS Name, SUP_ADDRESS as Address, SUP_CITY as City, SUP_STATE as State, SUP_ZIP as ZIP, SUP_EMAIL as Email, SUP_PHONE as Phone, SUP_FAX AS Fax, SUP_CONTACT_NAME AS 'Contact Name', SUP_CONTACT_TITLE AS Title, SUP_WEBSITE AS Website
            FROM SUPPLIER
            WHERE SUP_ID = ".$_GET['id']."
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
<h1>Edit Supplier</h1>
<form action="" method="POST">
	<input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
	Supplier Name: <input name="name" type="text" value="<?php echo $row['Name']; ?>" required><br>
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
	ZIP: <input name="zip" type="text" pattern="(\d{5}([\-]\d{4})?)" value="<?php echo $row['ZIP']; ?>"  required><br>
	Email: <input name="email" type="email" value="<?php echo $row['Email']; ?>"  required><br>
	Phone (Ex. 123-456-7890): <input name="phone" type="tel" pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$" value="<?php echo $row['Phone']; ?>"  required><br>
	Fax (Ex. 123-456-7890): <input name="fax" type="tel" pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$" value="<?php echo $row['Fax']; ?>"  ><br>
	Contact Name: <input name="cname" type="text" value="<?php echo $row['Contact Name']; ?>"  ><br>
	Contact Title: <select name="title" >
		<option value="" disabled selected>Select an option</option>
		<option <?php if($row['Title'] == "Mr."){echo "selected";} ?>>Mr.</option>
		<option<?php if($row['Title'] == "Mrs."){echo "selected";} ?>>Mrs.</option>
		<option<?php if($row['Title'] == "Ms."){echo "selected";} ?>>Ms.</option>
	</select><br>
	Website: <input name="website" type="text" value="<?php echo $row['Website']; ?>"  ><br>
	<input type="submit" value="Save">
</form>

</section>



<?php

	require("../footer.php");

?>