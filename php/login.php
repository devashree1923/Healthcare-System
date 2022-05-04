<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_username = $username;

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: ../index.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- <link rel="stylesheet" href="bootstrap.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <style>
        .logo{
            color:#F9B208;
            
            
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
            background-color: #1B1A17;
            
        }

        .nav .links a{
            margin-right: 25px;
            font-size: 16px;
            font-weight: 600;
            color: #EEEEEE;
        }

        .nav .links .mainlink{
            color: #EEEEEE;
        }

        .nav h4{
            font-size: 22px;
            font-weight: bold;
            margin-left: 25px;
        }


        body{
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Jost', sans-serif;
            background: url("https://i0.wp.com/css-tricks.com/wp-content/uploads/2020/04/diagonal-split-1.png?fit=1200%2C600&ssl=1") no-repeat center/ cover;

        }
        .main{
            width: 350px;
            height: 500px;
            background: red;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 5px 20px 50px #000;
            background: url("https://i0.wp.com/css-tricks.com/wp-content/uploads/2020/04/diagonal-split-1.png?fit=1200%2C600&ssl=1") no-repeat center/ cover;

        }
        #chk{
            display: none;
        }
        .signup{
            position: relative;
            width:100%;
            height: 100%;
        }
        label{
            color: #fff;
            font-size: 2.3em;
            justify-content: center;
            display: flex;
            margin: 60px;
            font-weight: bold;
            cursor: pointer;
            transition: .5s ease-in-out;
        }
        input{
            width: 60%;
            height: 20px;
            background: #e0dede;
            justify-content: center;
            display: flex;
            margin: 20px auto;
            padding: 10px;
            border: none;
            outline: none;
            border-radius: 5px;
        }
        button{
            width: 60%;
            height: 40px;
            margin: 10px auto;
            justify-content: center;
            display: block;
            color: #fff;
            background: #573b8a;
            font-size: 1em;
            font-weight: bold;
            margin-top: 20px;
            outline: none;
            border: none;
            border-radius: 5px;
            transition: .2s ease-in;
            cursor: pointer;
        }
        button:hover{
            background: #6d44b8;
        }
        .login{
            height: 460px;
            background: #eee;
            border-radius: 60% / 10%;
            transform: translateY(-180px);
            transition: .8s ease-in-out;
        }
        .login label{
            color: #573b8a;
            transform: scale(.6);
        }

        #chk:checked ~ .login{
            transform: translateY(-500px);
        }
        #chk:checked ~ .login label{
            transform: scale(1);	
        }
        #chk:checked ~ .signup label{
            transform: scale(.6);
        }
        .end{
            padding-bottom: 100%;
            border-radius: 20px;
        }
        p{
            color: #FFF;
            
        }
        a{
            color: white;
        }
        #sub{
            height:50px;
        }
        #drop{
            margin-top: 40px;
            padding-top: 15px;
            font-size: 20px;
            margin-left: 130px;
            color: black;
        }
        #dont{
            margin-left: 30px;
        }
        
    </style>
</head>
<body>
    <div class="main">
    <div class="nav">
      <div class="logo">
          <h4>NutriHelp.</h4>
      </div>
      <div class="links">
          <!-- <a href="#" class="mainlink"></a>
          <a href="#"></a>
          <a href="#"></a>
          <a href="#">SIGN UP</a>
          <a href="#"></a> -->
        </div>
        </div>
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class="signup">
        
        

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="chk" aria-hidden="true">Login</label>
                
                <input type="text" name="username" placeholder="User Name" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            
                <input type="password" name="password" placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                <input type="submit" class="btn btn-primary" value="Login" id="sub">
                <p id="dont">Don't have an account? <a href="register.php">Sign up now</a>.</p>
            <div class="end">
                <p id="drop"><a href="../index.php">Go Back </a></p>
            </div>
                
            </div>
            <
            
        </form>
    </div>
</body>
</html>