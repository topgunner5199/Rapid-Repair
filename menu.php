<?php
if($_SESSION['user']['LEVEL_OF_ACCESS'] == "Manager") {
?>
 <ul> 

	<li>
		<h5><a href="<?php echo $web_root; ?>index.php">Home</a></h5>
	</li>

	<li>
		<h5><a href="<?php echo $web_root; ?>customer.php">Customers</a></h5>
		<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_customer.php">Add Customer</a></li>
		</ul>
	</li>

	<li><h5><a href="<?php echo $web_root; ?>employee.php">Employees</a></h5>
		<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_employee.php">Add Employee</a></li>
		</ul>
	</li>

	<li><h5><a href="<?php echo $web_root; ?>supplier.php">Suppliers</a></h5>
		<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_supplier.php">Add Supplier</a></li>
		</ul>
	</li>

	<li><h5><a href="<?php echo $web_root; ?>parts.php">Parts</a></h5>
		<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_parts.php">Add Part</a></li>
		</ul>
	</li>

	<li><h5><a href="<?php echo $web_root; ?>promotion.php">Promotions</a></h5>
		<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_promotion.php">Add Promotion</a></li>
		</ul>
	</li>

	<li><h5><a href="<?php echo $web_root; ?>vehicle.php">Vehicles</a></h5></li>

	<li><h5><a href="<?php echo $web_root; ?>orders.php">Orders</a></h5></li>

	<li><h5><a href="<?php echo $web_root; ?>transaction.php">Transactions</a></h5>
		<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_transaction.php">Add Transaction</a></li>
		</ul>
	</li>

	<li><h5><a href="<?php echo $web_root; ?>packages.php">Packages</a></h5>
	<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_packages.php">Add Package</a></li>
		</ul></li>

	<li>
		<h5><a href="<?php echo $web_root; ?>logout.php">Log Out</a></h5>
	</li>

 </ul>

 <?php }else if($_SESSION['user']['LEVEL_OF_ACCESS'] == "Employee"){
 	?>
 <ul> 

	<li>
		<h5><a href="<?php echo $web_root; ?>index.php">Home</a></h5>
	</li>

	<li>
		<h5><a href="<?php echo $web_root; ?>customer.php">Customers</a></h5>
		<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_customer.php">Add Customer</a></li>
		</ul>
	</li>

	<li><h5><a href="<?php echo $web_root; ?>supplier.php">Suppliers</a></h5>
		<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_supplier.php">Add Supplier</a></li>
		</ul>
	</li>

	<li><h5><a href="<?php echo $web_root; ?>parts.php">Parts</a></h5>
		<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_parts.php">Add Part</a></li>
		</ul>
	</li>

	<li><h5><a href="<?php echo $web_root; ?>promotion.php">Promotions</a></h5>
	</li>

	<li><h5><a href="<?php echo $web_root; ?>vehicle.php">Vehicles</a></h5></li>

	<li><h5><a href="<?php echo $web_root; ?>transaction.php">Transactions</a></h5>
		<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_transaction.php">Add Transaction</a></li>
		</ul>
	</li>

	<li><h5><a href="<?php echo $web_root; ?>packages.php">Packages</a></h5>
	<ul class="submenu">
			<li><a href="<?php echo $web_root; ?>/add/add_packages.php">Add Package</a></li>
		</ul></li>

	<li>
		<h5><a href="<?php echo $web_root; ?>logout.php">Log Out</a></h5>
	</li>

 </ul>
 	<?php
 } ?>