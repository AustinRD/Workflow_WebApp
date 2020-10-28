<?php
    //Loads the action bar so the user can navigate between pages.
    include_once('./components/userfunctions/workflows/workflows.php')
?>

<!-- New Workflows -->
<div class="w3-container">
    <h5>New Workflows</h5>
    <ul class="w3-ul w3-card-4 w3-white">
    <?php
        $user_email = $_SESSION['user_email'];
        $sql = "SELECT * FROM f20_application_info WHERE student_email = '$user_email'";
        $query = mysqli_query($db_conn, $sql);

        if ($query) {
            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                echo('<li class="w3-padding-16">Type: '
                        . $row['project_name']
                    . '</li>');
            }
        }
        else {
            echo('<li class="w3-padding-16">
                <span class="w3-xlarge">No workflows found.</span>
            </li>');
        }
    ?>
    </ul>
</div>