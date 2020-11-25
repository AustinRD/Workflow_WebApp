<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./components/userfunctions/workflows/workflows.php')
?>

<!-- Active Workflows -->
<div class="w3-container">
    <h5>Active Workflows</h5>
    <!-- Getting the current user's workflows from the database and printing them in a preview. -->
    <?php
        include_once('./backend/db_connector.php');
        $user = $_SESSION['user_id'];

        $sql = "SELECT * FROM f20_step_details_table
                    JOIN f20_app_details_table
                        ON f20_step_details_table.SID = f20_app_details_table.SID
                    JOIN f20_step_table
                        ON f20_app_details_table.SID = f20_step_table.SID
                    JOIN f20_app_table
                        ON f20_app_details_table.AID = f20_app_table.AID
                    JOIN f20_app_type_table
                        ON f20_app_table.ATID = f20_app_type_table.ATID
                    JOIN f20_app_status_table
                        ON f20_app_table.ASID = f20_app_status_table.ASID
                WHERE f20_step_details_table.UID = $user AND f20_app_table.ASID = 2";

        $query = mysqli_query($db_conn, $sql);
        $count = mysqli_num_rows($query);
        
        if($count > 0) {
            while($result = mysqli_fetch_array($query)) {
                $stepLocation = $result['location'];
                $rowNum = 1;

                echo('<div class="w3-row w3-card-4 w3-margin">'
                    .'<div class="w3-quarter w3-border" style="height: 90px; padding-left: 10px;">'
                    . '<p>Title: '
                    . $result['20']
                    . '<br>Priority: '
                    . $result['25'] 
                    . '<br>Status: '
                    . $result['28']
                    . '</p></div>');

                $workflowID = $result['AID'];

                echo('<div class="w3-half w3-padding w3-border" style="height: 90px;">');
                //The instructions field comes from the app_table and determines what order the
                //participants recieve the workflow in.
                $order = $result['21'];
                $order = explode("=>", $order);
                for($i = 0; $i < sizeof($order); ++$i) {
                    //When printing the workflow visualizer, the first thing to print is the skeleton.
                    if($i == 0) {
    ?>
                        <div class="circleList" id="circleList">
                            <div class="circle" id="participant<?php echo $i + 1; ?>"><strong><?php echo $i + 1; ?></strong></div>
                        </div>
                        <div class="labelList" id="labelList">
                            <div class="usertype"><?php echo $order[$i]; ?></div>
                        </div>
    <?php
                    }
                    //For the remaining participants in the visualizer we expand using DOM and JS.
                    else {
    ?>
                        <script>
                            document.getElementById('circleList').innerHTML += "<div class='line'></div><div class='circle' id='participant<?php echo $i + 1; ?>'><?php echo $i + 1; ?></div>";
                            document.getElementById('labelList').innerHTML += "<div class='spacer'></div><div id='labelContainer' class='userType'><?php echo $order[$i]; ?></div>";
                        </script>
    <?php
                    }
                }
                echo('</div>');

                //When the visualizer has loaded the sequence of users, we can change the color of each step based on it's completion status.
                $sql = "SELECT * FROM f20_app_details_table
                            JOIN f20_step_table
                                ON f20_app_details_table.SID = f20_step_table.SID
                            WHERE f20_app_details_table.AID = $workflowID";
                $query = mysqli_query($db_conn, $sql);
                
                while($row = mysqli_fetch_array($query)) {
                    //If the step's status is 1 (Approved) then the visualizer for that step should be lawngreen.
                    if($row['SSID'] == '1') {
                        echo("<script>
                            document.getElementById('participant" . $row['step_order'] . "').style.backgroundColor = 'lawngreen';
                        </script>");
                    }
                    //If the step's status is 2 (In-progress) then the visualizer for that step should be cyan.
                    else if($row['SSID'] == '2') {
                        echo("<script>
                            document.getElementById('participant" . $row['step_order'] . "').style.backgroundColor = 'cyan';
                        </script>");
                    }
                    //If the step's status is 3 (Rejected) then the visualizer for that step should be red.
                    else if($row['SSID'] == '3') {
                        echo("<script>
                            document.getElementById('participant" . $row['step_order'] . "').style.backgroundColor = 'red';
                        </script>");
                    }
                }
                echo('<div class="w3-quarter w3-center w3-padding-24 w3-border" style="height: 90px;">'
                    . '<form action="./dashboard.php?content=workflows&contentType=viewWorkflow" method="post" >'
                    . '<input type="hidden" name="stepLocation" value="'
                    . $stepLocation
                    . '"></input>'
                    . '<button class="w3-button w3-teal" type="submit">View</button>'
                    . '</div></div>');
            }
            ++$rowNum;
        }
        else {
            echo('<div class="w3-row w3-card-4 w3-margin w3-padding">'
                . '<p>No Workflows Found!</p></div>');
        }
    ?>
</div>