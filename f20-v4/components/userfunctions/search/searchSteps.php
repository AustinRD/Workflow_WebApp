<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/search/search.php')
?>

<div id="stepSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='.'">Add Step</button>
    <h5>Step Search</h5>
    <p>You may search by any field in the table.</p>
    <input id="stepInput" type="text" onkeyup="search('stepTable', 'stepInput')"></input>
    <table id="stepTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th>Title</th>
            <th>Priority</th>
            <th>Assigned User</th>
            <th>Status</th>
            <th>Deadline</th>
            <th>Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_step_table
                        JOIN f20_step_type_table
                            ON f20_step_table.STID = f20_step_type_table.STID
                        JOIN f20_step_status_table
                            ON f20_step_table.SSID = f20_step_status_table.SSID
                        JOIN f20_step_details_table
                            ON f20_step_table.SID = f20_step_details_table.SID
                        JOIN f20_user_table
                            ON f20_step_details_table.UID = f20_user_table.UID";
            $query = mysqli_query($db_conn, $sql);
            
            while ($row = mysqli_fetch_array($query)) {
                $stepID = $row['SID'];
                $title = $row['4'];
                $priority = $row['10'];
                $assignedUser = $row['user_name'] . " (" . $row['user_email'] . ")";
                $status = $row['13'];
                $deadline = $row['deadline'];
        ?>
        <tr>
            <td><?php echo $title; ?></td>
            <td><?php echo $priority; ?></td>
            <td><?php echo $assignedUser; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $deadline; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=step">
                    <input type="hidden" name="stepID" value="<?php echo $stepID;?>">
                    <button type="submit" name="viewStep" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>