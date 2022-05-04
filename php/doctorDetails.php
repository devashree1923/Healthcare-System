<?php
// Include config file
require_once "config.php";
$pincode="";
$doc_array=array();
$min=100;
$temp_id="";
$temp_name="";
$temp_address="";
$temp_pin="";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if pincode is empty
    if(empty(trim($_POST["pincode"]))){
        $pincode_err = "Please enter pincode.";
    } else{
        $pincode = trim($_POST["pincode"]);
    }
    if(empty($pincode_err))
    {
        $sql = "SELECT * from doctordetails";

        if($stmt=mysqli_prepare($link, $sql))
        {
            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt)>0)
                {
                    mysqli_stmt_bind_result($stmt, $id, $name, $pin, $address, $specialize);
                    while(mysqli_stmt_fetch($stmt))
                    {
                        if(abs($pin-$pincode)<$min)
                        {    
                            array_push($doc_array, array($id,$name,$pin,$address,$specialize,abs($pin-$pincode)));
                        }
                        
                    }
                    for($i=0;$i<count($doc_array);$i++)
                    {
                        for ($j=$i+1;$j<count($doc_array);$j++)
                        {
                            $idiff=abs($doc_array[$i][2]-$pincode);
                            $jdiff=abs($doc_array[$j][2]-$pincode);
                            if($idiff>$jdiff)
                            {
                                $temp=$doc_array[$i];
                                $doc_array[$i]=$doc_array[$j];
                                $doc_array[$j]=$temp;
                            }
                        }
                    }
                    
                }
            }
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FindYourDoctor</title>
    <link rel="stylesheet" href="bootstrap.css">
    <style>
        .logo{
            color:#F9B208;
            text-align: center;
            
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
        .wrapper{
            padding:100px;
            
        }
        body{
            margin: 0;
            padding: 0;
            background: #FF8C32;
            height: 100vh;
            background: url("https://i0.wp.com/css-tricks.com/wp-content/uploads/2020/04/diagonal-split-1.png?fit=1200%2C600&ssl=1") no-repeat center/ cover fixed;
            overflow-vertical:scroll;


        }
        input{
            width:200px;
        }
        .res{
            color:#FFFFFF;
            font-size: 18px;
        }
        hr{
            width:100px;
        }

        tr{
            padding: 5px;

        }
        thead{
            font-size: 22px;
            border-bottom: solid 5px;
        }
        td{
            padding:15px;
        }
    </style>
</head>
<body>
<div class="nav">
      <div class="logo">
          <h4>NutriHelp.</h4>
      </div>
      <div class="links">
          <a href="#" class="mainlink">HOME</a>
          <a href="php/profile.php">PROFILE</a>
          <a href="#">FEATURE</a>
          <!-- <a href="#">SIGN UP</a> -->
          <a href="php/logout.php">LOGOUT</a>
      </div>
  </div>
    <div class="wrapper">
    
        <h2>Find Doctors near you</h2><br><br>
        <p style="color:white">Please fill in your PINCODE to search for doctors near you.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">    
            <div class="form-group">
                <input type="number" name="pincode" class="form-control" style="margin-right:1000px;" placeholder="PINCODE">
            </div>
            <br><br>
            <div class="form-group"> 
                <input type="submit" class="btn btn-primary" value="Submit" style="background-color: #111111; border:transparent;">
            </div>
        </form>
    </div>
    <center>
    <div class="res">
    
    <?php
    echo "<h3>Finding doctors near you :)</h3><br><br>";
    echo "<table>";
    echo "<thead>";
    echo "<td style='width: 30px;'> ID: </td>";
    echo "<td> Name: </td>";
    echo "<td> Pincode: </td>";
    echo "<td> Address: </td>";
    echo "<td> Specialization: </td>";
    echo "</thead>";
    foreach($doc_array as $arr)
    {   
        echo "<tr>";
        echo "<td>". $arr[0] ."</td>";
        echo "<td>" . $arr[1] ."</td>";
        echo "<td>" . $arr[2] ."</td>";
        echo "<td>" . $arr[3] ."</td>";
        echo "<td>" . $arr[4] ."</td>";
        echo "</tr>";

    }
    echo "</table>";;
    ?>

    </div>
    </center>
    
    
</body>
</html>


