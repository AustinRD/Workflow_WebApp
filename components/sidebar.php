<?php include_once('./backend/config.php'); ?>


<nav class="w3-sidebar w3-collapse w3-white" style="z-index:3;width:300px;" id="mySidebar"><br>
  <!-- Sidebar Header -->
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="./images/w3avatar.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <br><strong><?php echo("User's Name"); ?></strong></span><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="./settings.php" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>

  <!-- Sidebar Content-->
  
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="./dashboard.php?content=home" id="homeBar" class="w3-bar-item w3-button w3-padding"><i class="fa fa-home fa-fw"></i>  Home</a>
    
    <?php
      //Displaying the search option for all users except employer and student.
      if(!($_SESSION['user_type'] == $GLOBALS['student_type']) && !($_SESSION['user_type'] == $GLOBALS['employer_type'])) {
          echo("<a href='./dashboard.php?content=search' id='searchBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-search fa-fw'></i>  Search</a>");
      }
      //Displaying the create option for all users except employer and student.
      if(!($_SESSION['user_type'] == $GLOBALS['student_type']) && !($_SESSION['user_type'] == $GLOBALS['employer_type'])) {
          echo("<a href='./dashboard.php?content=create' id='createBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-plus fa-fw'></i>  Create</a>");
      }
      //Displaying the workflows option for all users except admin.
      if(!($_SESSION['user_type'] == $GLOBALS['admin_type'])) {
        echo("<a href='./dashboard.php?content=workflows' id='workflowsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-share-alt fa-fw'></i>  Workflows</a>");
      }
    ?>
      
    <a href='./dashboard.php?content=messages' id='messagesBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-comment fa-fw'></i>  Messages</a>
    <a href='./dashboard.php?content=history' id='historyBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-history fa-fw'></i>  History</a>
    <a href='./dashboard.php?content=files' id='filesBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-files-o fa-fw'></i>  Files</a>
    <a href='./dashboard.php?content=settings' id='settingsBar' class='w3-bar-item w3-button w3-padding'><i class='fa fa-cog fa-fw'></i>  Settings</a>
    <a href='./util/logout.php' class='w3-bar-item w3-button w3-padding'><i class='fa fa-sign-out fa-fw'></i>  Sign-Out</a><br><br>
  </div>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<script>
    //Highlighting the active sidebar option.
    var tempURL = window.location.href;
    tempURL = tempURL.split("=");

    if(tempURL[1] == "home")
    {
        document.getElementById('homeBar').className += " w3-blue";
    }
    else if(tempURL[1] == "files")
    {
        document.getElementById('filesBar').className += " w3-blue";
    }
    else if(tempURL[1] == "workflows")
    {
        document.getElementById('workflowsBar').className += " w3-blue";
    }
    else if(tempURL[1] == "history")
    {
        document.getElementById('historyBar').className += " w3-blue";
    }
    else if(tempURL[1] == "settings")
    {
        document.getElementById('settingsBar').className += " w3-blue";
    }
    else if(tempURL[1] == "search" || tempURL[1] == "view&contentType" || tempURL[1] == "search&contentType")
    {
        document.getElementById('searchBar').className += " w3-blue";
    }
    else if(tempURL[1] == "create" || tempURL[1] == "create&contentType")
    {
        document.getElementById('createBar').className += " w3-blue";
    }

    // Get the Sidebar
    var mySidebar = document.getElementById("mySidebar");

    // Get the DIV with overlay effect
    var overlayBg = document.getElementById("myOverlay");

    // Toggle between showing and hiding the sidebar, and add overlay effect
    function w3_open() {
      if (mySidebar.style.display === 'block') {
          mySidebar.style.display = 'none';
          overlayBg.style.display = "none";
      } else {
          mySidebar.style.display = 'block';
          overlayBg.style.display = "block";
      }
    }

    // Close the sidebar with the close button
    function w3_close() {
      mySidebar.style.display = "none";
      overlayBg.style.display = "none";
    }
</script>
