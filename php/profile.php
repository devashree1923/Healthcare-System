<?php
session_start();
require_once "config.php";
$username = $name = $dob = $gender = $age = $phone = $weight = $height = $bg= $pincode = $city = $food = $password = "";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    echo $_SESSION["username"];
    $sql="SELECT * from users where username = ?";
    if ($stmt=mysqli_prepare($link,$sql))
    {
        $username=$_SESSION["username"];
        mysqli_stmt_bind_param($stmt,"s",$username);
        if(mysqli_stmt_execute($stmt))
        {
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt)==1)
            {
                mysqli_stmt_bind_result($stmt, $name, $dob, $gender, $age, $phone, $weight, $height, $bg, $pincode, $city, $food, $username, $password);
                mysqli_stmt_fetch($stmt);
            }
        }
    }
}
else{
    header("location: ../index.html");
    exit;
}
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <title>Document</title> -->
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');
            *{
                font-family: "Poppins", sans-serif;
            }
            body {
                font: 14px sans-serif;
                background: url("https://i0.wp.com/css-tricks.com/wp-content/uploads/2020/04/diagonal-split-1.png?fit=1200%2C600&ssl=1") no-repeat center/ cover fixed;
                color: #FFFFFF;
                font-size: 20px;
                
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
            
            .name{
                margin-top: 80px;
                font-size: 60px;

            }
            .dob, .gender, .age, .phone, .weight, .height, .bg, .pincode, .city, .food, .username, .password{
                margin-top:30px;
            }
            .labs{
                Font-size: 15px;
            }
            hr{
                width: 400px;
                border: solid #FFFFFF;
                border-width: 1px;
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
          <a href="logout.php">LOGOUT</a>
      </div>
    </div>
        <center>
            <u><div class="name">
            <?php echo $name;?>
        </div></u>
        
        <div class="dob">
        <div class = "labs">
            <hr>
                <u>Date-of-Birth</u>
            </div>
            <?php echo $dob;?>
        </div>
        <div class="gender">
        <div class = "labs">
            <hr>
                <u>Gender</u>
            </div>
            <?php echo $gender;?>
        </div>
        <div class="age">
        <div class = "labs">
            <hr>
                <u>Age</u>
            </div>
            <?php echo $age;?>
        </div>
        <div class="phone">
        <div class = "labs">
            <hr>
                <u>Phone No.</u>
            </div>
            <?php echo $phone;?>
        </div>
        <div class="weight">
        <div class = "labs">
            <hr>
               <u>Weight</u>
            </div>
            <?php echo $weight;?>
        </div>
        <div class="height">
        <div class = "labs">
            <hr>
                <u>Height</u>
            </div>
            <?php echo $height;?>
        </div>
        <div class="bg">
        <div class = "labs">
            <hr>
                <u>Blood Group</u>
            </div>
            <?php echo $bg;?>
        </div>
        <div class="pincode">
        <div class = "labs">
            <hr>
                <u>Pincode</u>
            </div>
            <?php echo $pincode;?>
        </div>
        <div class="city">
        <div class = "labs">
            <hr>
                <u>City</u>
            </div>
            <?php echo $city;?>
        </div>
        <div class="food">
            <hr><br>
            <?php echo $food;?>
        </div>
        <div class="username">
        <div class = "labs">
            <hr>
                Nick-Name
            </div>
            <?php echo $username;?>
        </div>
        </center>
        
    </body> 
</html>