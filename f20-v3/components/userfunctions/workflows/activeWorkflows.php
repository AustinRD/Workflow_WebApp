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
        $user_email = $_SESSION['user_email'];
        $sql = "SELECT * FROM f20_application_info WHERE student_email = '$user_email'";
        $query = mysqli_query($db_conn, $sql);

        if ($query) {
            $rowNum = 1;
            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                $utilsql = "SELECT * FROM `f20_application_util` WHERE `fw_id` ='" . $row['fw_id'] . "'";
                $utilquery = mysqli_query($db_conn, $utilsql);
                if ($utilquery)
                {
                    $utilrow = mysqli_fetch_array($utilquery, MYSQLI_ASSOC);
                    $assignedTo = $utilrow['assigned_to'];
                    $status = $utilrow['progress'];
                    if($status == -1) {
                        $status = "Not started.";
                    }
                    else {
                        $status = "Active";
                    }
                }

                echo('<div class="w3-row w3-card-4 w3-margin">'
                    .'<div class="w3-quarter w3-border" style="height: 90px; padding-left: 10px;">'
                    . '<p>Type: '
                    . $row['project_name']
                    . '<br>Semester: '
                    . $row['semester'] . ' '
                    . $row['year'])
                    . '<br>Status: '
                    . $status
                    . '</p></div>';
        ?>
                <!-- Workflow visualizer -->
                <div class="w3-half w3-padding w3-border" style="height: 90px;">
                    <div class="circleList">
                        <div class="circle" id='student<?php echo $rowNum ?>'><strong>1</strong></div>
                        <div class="line"></div>
                        <div class="circle" id='instructor<?php echo $rowNum ?>'><strong>2</strong></div>
                        <div class="line"></div>
                        <div class="circle" id='secretary<?php echo $rowNum ?>'><strong>3</strong></div>
                        <div class="line"></div>
                        <div class="circle" id='chair<?php echo $rowNum ?>'><strong>4</strong></div>
                        <div class="line"></div>
                        <div class="circle" id='employer<?php echo $rowNum ?>'><strong>5</strong></div>
                        <div class="line"></div>
                        <div class="circle" id='dean<?php echo $rowNum ?>'><strong>6</strong></div>
                    </div>
                    <div class="labelList">
                        <div class="usertype">Student</div>
                        <div class="spacer"></div>
                        <div class="usertype">Instructor</div>
                        <div class="spacer"></div>
                        <div class="usertype">Secretary</div>
                        <div class="spacer"></div>
                        <div class="usertype">Chair</div>
                        <div class="spacer"></div>
                        <div class="usertype">Employer</div>
                        <div class="spacer"></div>
                        <div class="usertype">Dean</div>
                    </div>
                </div>
                <script>
                    document.getElementById('<?php echo $assignedTo . $rowNum ?>').style.backgroundColor = "cyan";
                </script>
        <?php
                if($status == "Not started.") {
                    echo('<div class="w3-quarter w3-center w3-padding-24 w3-border" style="height: 90px;">'
                        . '<form action="./dashboard.php?content=startInternApp" method="post" >'
                        . '<input type="hidden" name="wfID" value="'
                        . $row['fw_id']
                        . '"></input>'
                        . '<button class="w3-button w3-teal" type="submit">Start</button>'
                        . '</div></div>');
                }
                else {
                    echo('<div class="w3-quarter w3-center w3-padding-24 w3-border" style="height: 90px;">'
                        . '<form action="./dashboard.php?content=viewWorkflow" method="post" >'
                        . '<input type="hidden" name="wfID" value="'
                        . $row['fw_id']
                        . '"></input>'
                        . '<button class="w3-button w3-teal" type="submit">View</button>'
                        . '</div></div>');
                }
                ++$rowNum;
            }
        }
        else {
            echo('<div class="w3-row w3-card-4 w3-margin">'
                . '<p>No Workflows Found!</p></div>');
        }
    ?>
</div>