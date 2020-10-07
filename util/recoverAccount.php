<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>CRC Workflows - Account Recovery</title>

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
    <form class="w3-padding w3-display-middle w3-light-grey w3-round-xlarge" style="width: 100%; max-width:330px;" method="POST">
      <div class="w3-center">
        <img src="../images/crc-logo(512x512).png" alt="Career Resource Center Logo" height="90">
        <?php 
            if(isset($_POST['send'])) {
                include_once('../backend/db_connector.php');
                include_once('../backend/util.php');

                $email = mysqli_escape_string($db_conn, $_POST['email']);
                $checksql = "SELECT * FROM f20_UserPass WHERE email = '$email'";
                $run = mysqli_query($db_conn, $checksql);
                if($run and mysqli_num_rows($run) == 1) {
                    sendEmail($email, "Internship Fieldwork Password Reset", "Password requested! Ignore if you did not make this request.");
                    header('Location: ./recoverAccount.php?request=true');
                }
                else{
                    echo '<div class="w3-panel w3-round w3-red">
                            <p>Recovery Failed. Email not found!<p>
                        </div>';
                }
            }
            if (isset($_GET['request']) and $_GET['request'] == 'true') { 
                echo '<div class="w3-panel w3-round w3-green">
                        <p>Recovery Success! Password reset was sent to your email.<p>
                    </div>';
                exit(header("refresh:5;url=../index.php"));
            } 
        ?>
        <h3>Please enter your email address</h3>
      </div>

      <div class="w3-center w3-padding">
        <label class="w3-left" for="inputEmail">Email:</label><br>
        <input type="email" class="w3-input" id="inputEmail" name="email" required autofocus>
      </div>

      <div class="w3-center">
        <br>
        <button class="w3-button w3-blue" name="send" type="submit">Send</button>
        <button type="button" class="w3-button w3-blue" onClick="window.location.href='../index.php';">Back</button>
        <p class="">&copy; Career Resource Center 2020</p>
      </div>
    </form>
  </div>
</body>
</html>