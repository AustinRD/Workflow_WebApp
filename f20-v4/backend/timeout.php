<?php

/**
 * This forces a logout after a curtain amount of time. Alternatively this time 900 = 15 mins can be implemented to 
 * set force logout on the admin end so that they can control this. But this was never implemented.
 */

if(time() - $_SESSION['timestamp'] > 900) { //subtract new timestamp from the old one
    redirect("inactive");
  } else {
    $_SESSION['timestamp'] = time(); //set new timestamp
  }

?>