<!DOCTYPE html>
<html>

<head>
	<title>Insert Page </title>
</head>

<body>
		<?php
		$conn = mysqli_connect("localhost", "root", "", "db");

		if($conn === false){
			die("ERROR: Could not connect. "
				. mysqli_connect_error());
		}
		
		$first_name = $_REQUEST['first_name'];
		$gender = $_REQUEST['gender'];
		$address = $_REQUEST['address'];
		$email = $_REQUEST['email'];
        $cardno = $_REQUEST['cardno'];
        $phoneno = $_REQUEST['phoneno'];
        $dob = $_REQUEST['dob'];

		$sql = "INSERT INTO carddetails VALUES ('$first_name','$email','$phoneno','$cardno','$dob')";
		
		if(mysqli_query($conn, $sql)){
			echo "<h3>data stored in a database successfully."

				echo nl2br("\n$first_name\n $email\n "
                . "$phoneno\n $cardno\n $dob");
		} else{
			echo "ERROR: Sorry $sql. "
				. mysqli_error($conn);
		}

		mysqli_close($conn);
		?>
</body>

</html>
