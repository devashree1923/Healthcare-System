<?php

require_once "config.php";


$username = $gender = $bg = $city = $dob = $food = $phoneno = $email = $name = "";
$username_err = $password_err = $confirm_password_err = $email_err = $dob_err = $phoneno_err = $weight_err = $height_err = $bg_err = $pin_err = $city_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        // Prepare a select statement
        $sql = "SELECT username FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        //need to check
        if (empty($password_err) && ($password !== $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    //Validate Age
    if ($_POST["age"]<12 || $_POST["age"]>120)
    {
        $age_err="Please enter a valid age";
    }
    if ($_POST["phone"]<1000000000 || $_POST["phone"]>9999999999)
    {
        $phoneno_err="Please enter a valid phone no";
    }
    if (!$_POST["weight"]>10 || !$_POST["weight"]>650)
    {
        $weight_err="Please enter a valid weight";
    }
    if (!$_POST["height"]>10 || !$_POST["height"]>650)
    {
        $height_err="Please enter a valid height";
    }
    $bg=trim($_POST["bg"]);
    if($bg != "A+" && $bg != "A-" && $bg != "B+" && $bg != "B-" && $bg != "O+" && $bg != "O-" && $bg != "AB+" && $bg != "AB-")
    {
        $bg_err="Please enter a valid Blood Group";
    }
    if($_POST["pin"]<100000 || $_POST["pin"]>999999)
    {
        $pin_err="Please enter a valid pincode";
    }
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($dob_err) && empty($phoneno_err) && empty($age_err) && empty($bg_err)) 
    {
        $sql = "INSERT INTO users (name, DOB, Gender, Age, PhoneNo, Weight, Height, BloodGroup, Pincode, City, food_preference, username, password)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {

            $param_username = $username;
            $name = $_POST["name"];
            $param_name = $name;
            $param_gender= $_POST["gender"];
            $param_age=$_POST["age"];
            $param_Phoneno=$_POST["phone"];
            $param_weight=$_POST["weight"];
            $param_height=$_POST["height"];
            $param_bloodgroup=$bg;
            $param_pincode=$_POST["pin"];
            $param_city=$_POST["city"];
            $param_food=$_POST["food"];
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_dob = $_POST["dob"];
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssidddsissss", $param_name, $param_dob, $param_gender, $param_age, $param_Phoneno, $param_weight, $param_height, $param_bloodgroup, $param_pincode, $param_city, $param_food,  $param_username, $param_password);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }


        // Close connection
        mysqli_close($link);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="bootstrap.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');
        *{
            font-family: "Poppins", sans-serif;
        }
        .nav{
            position: fixed;
            z-index: 1000;
            top: 0;
            right: 0;
            left: 0;
            height: 80px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px 0 25px;
            background-color: #1B1A17
            
        }
        .logo{
            color:#F9B208;
            
            
        }
        .nav .links a{
            margin-right: 25px;
            font-size: 16px;
            font-weight: 600;
            color: #DDDDDD;
        }

        .nav .links .mainlink{
            color: #EEEEEE;
        }

        .nav h4{
            font-size: 22px;
            font-weight: bold;
            margin-left: 25px;
        }

        body {
            font: 14px sans-serif;
            background: url("https://i0.wp.com/css-tricks.com/wp-content/uploads/2020/04/diagonal-split-1.png?fit=1200%2C600&ssl=1") no-repeat center/ cover fixed;

        }
        .wrapper{
            color: #FFFFFF;
            width: 360px;
            padding: 20px;
            border-radius: 30px;
            margin: 50px;
            margin-top: 100px;
            
        }
        

        .form-group {
            height: 100px;
        }
        label{
            font-size: 20px;
            margin: 10px;
        }
    </style>
</head>

<body>
    <div class="nav">
      <div class="logo">
          <h4>NutriHelp.</h4>
      </div>
      <div class="links">
          <a href="../index.php" class="mainlink">HOME</a>
          <a href="login.php">LOGIN</a>
      </div>
    </div>
    <center>
        <div class="wrapper">
            <h2>Medical Form</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Name </label>  <input type="text" name="name" placeholder="Enter Your Name" class="form-control" value="<?php echo $name; ?>" required autocomplete="true">
                </div>
                <div class="form-group">
                    <label>Date of Birth </label> <input type="date" required name="dob" class="form-control <?php echo (!empty($dob_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dob; ?>">
                    <span class="invalid-feedback"><?php echo $dob_err; ?></span>
                </div>

                <div class="form-group">
                    <label>Gender </label><br>
                    <label>Male </label><input name="gender" required type="radio" id="gender" value="male" <?php echo ($gender == 'male') ?  "checked" : "";  ?> />
                    <label>Female </label><input name="gender" type="radio" id="gender" value="female" <?php echo ($gender == 'female') ?  "checked" : "";  ?> />
                    <span class="invalid-feedback"><?php echo $gender_err; ?></span>
                </div>

                <div class="form-group">
                    <label>Age </label> <input type="number" name="age" required class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>" required>
                    <span class="invalid-feedback"><?php echo $age_err; ?></span>
                </div>
                <div class="form-group">

                    <div class="form-group">
                        <label>Phone No. </label> <input type="number" required name="phone" class="form-control <?php echo (!empty($phoneno_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phoneno; ?>" required>
                        <span class="invalid-feedback"><?php echo $phoneno_err; ?></span>
                    </div>
                    <div class="form-group">

                        <label>Weight (in KGs)</label> <input type="number" required step="any" name="weight" class="form-control <?php echo (!empty($weight_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $weight; ?>" required>
                        <span class="invalid-feedback"><?php echo $weight_err; ?></span>
                    </div>
                    <div class="form-group">

                        <label>Height (in cms) </label> <input type="number" required name="height" step="any" class="form-control <?php echo (!empty($height_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $height; ?>" required>
                        <span class="invalid-feedback"><?php echo $height_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Blood Group </label> <input type="text" name="bg" class="form-control <?php echo (!empty($bg_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $bg; ?>" required>
                        <span class="invalid-feedback"><?php echo $bg_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Pincode </label> <input type="number" name="pin" class="form-control <?php echo (!empty($pin_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pin; ?>" required>
                        <span class="invalid-feedback"><?php echo $pin_err; ?></span>
                    </div>
                        <div class="form-group">

                            <div class="form-group">
                                <label>City </label> <input type= "text" name="city" required class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>">
                                <span class="invalid-feedback"><?php echo $city_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label>Food Preferences </label><br>
                                <label>Veg </label><input name="food" type="radio" required id="food" value="veg" <?php echo ($food == 'veg') ?  "checked" : "";  ?> />
                                <label>Non-Veg </label><input name="food" type="radio" id="food" value="nonveg" <?php echo ($food == 'nonveg') ?  "checked" : "";  ?> />
                                <span class="invalid-feedback"><?php echo $gender_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>E-mail </label><input type="email" name="email" required class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Username </label> <input type="text" name="username" required placeholder="Create your Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Password </label> <input type="password" name="password" required placeholder="Enter Your Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group">

                            <label>Confirm Password </label> <input type="password" name="confirm_password" required placeholder="Confirm Your Password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" style="background-color: #EE5007; border: transparent" class="btn btn-primary" value="Submit">
                                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                            </div>
                            <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>
    </center>
</body>

</html>
