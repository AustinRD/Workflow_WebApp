<?php
  //Starting a session.
  if(!isset($_SESSION)) {
    session_start();
  }
  //If the user is already signed in we redirect to the dashboard.
  if(isset($_SESSION['user_type'])){
    header("Location: ./dashboard.php");
  }
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>CRC Workflows - Sign In</title>

  <!-- w3.css framework used for the styling of our application-->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- font used in the template -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <!-- icons from fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}

    body {
      background-image: url(https://upload.wikimedia.org/wikipedia/commons/thumb/0/01/Crater_Lake_winter_pano2.jpg/1920px-Crater_Lake_winter_pano2.jpg);
      background-size: cover;
      background-attachment: fixed;
      background-position: center top;
    }
</style>

<body class="w3-container">
  <div class="">
    <form method="POST" class="w3-padding w3-display-middle w3-light-grey w3-round-xlarge" style="width: 100%; max-width:330px;">
      <div class="w3-center">
        <img src="images/crc-logo(512x512).png" alt="Career Resource Center Logo" height="90">
        <?php
          //Validate user sign in if form was submitted.
          if(isset($_POST['submit'])) {
            include_once('./backend/db_connector.php');
            include_once('./backend/util.php');

            //Get the input from the sign in form.
            $username = mysqli_real_escape_string($db_conn, $_POST['username']);
            $password = mysqli_real_escape_string($db_conn, $_POST['password']);
          
            //Check if any results match in the database.
            $sql = "SELECT * FROM `f20_user_table` WHERE user_login_name = '$username' AND user_password = '$password'";
            $result = mysqli_query($db_conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $count = mysqli_num_rows($result);

            
            if ($count == 1) {
				      $_SESSION['user_id'] = $row['UID'];
              $_SESSION['user_type'] = $row['URID'];
              $_SESSION['user_email'] = $row['user_email'];
              $_SESSION['user_name'] = $row['user_name'];
              $_SESSION['timestamp'] = time();
              $_SESSION['token'] = bin2hex(random_bytes(32));
              //If the user is found and the password is correct
              //  then print a success message and redirect
              echo '<div class="w3-panel w3-round w3-green">
                      <p>Sign In Success:<br> Redirecting.</p>
                    </div>';
              exit(header("refresh:1;url=./dashboard.php?content=home"));
            } 
            else {
              //The username was not found or password didn't match
              //  then print an error message.
              echo '<div class="w3-panel w3-round w3-red">
                      <p>Sign In Failed:<br> Invalid Username or Password!</p>
                    </div>';
            }
          }
        ?>
        <h3>Please Sign In</h3>
      </div>
      
      <div class="w3-center w3-padding">
        <label class="w3-left" for="inputUsername">Username:</label><br>
        <input type="username" class="w3-input" id="inputUsername" name="username" required autofocus><br>
        <label class="w3-left" for="inputPassword">Password:</label><br>
        <input type="password" class="w3-input" id="inputPassword" name="password" required>
      </div>

      <div class = "w3-center">
        <br>
        <a href="./util/recoverAccount.php">Click here to recover password</a><br><br>
        <button class="w3-button w3-blue" name="submit" type="submit">Sign in</button></center>
        <p>&copy; Career Resource Center 2020</p>
      </div>
    </form>
  </div>
  
</body>
</html>