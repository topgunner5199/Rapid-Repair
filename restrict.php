<?php
	if($_SESSION['user']['LEVEL_OF_ACCESS'] == "Employee"){
		die("You do not have permission to access this page.");
	}