<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/search/search.php');
?>

<!-- Workflow Search -->
<div id="workflowSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=app'">Start Workflow</button>
    <h5>Workflow Search</h5>
    <p>You may search by any field in the table.</p>
    <input id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')"></input>
    <table id="workflowTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th>Title</th>
            <th>Initiator</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Created</th>
            <th>Deadline</th>
            <th>Actions</th>
        </tr>

        <?php
            $sql = "SELECT * FROM f20_app_table
                        JOIN f20_app_type_table
                            ON f20_app_table.ATID = f20_app_type_table.ATID
                        JOIN f20_app_status_table
                            ON f20_app_table.ASID = f20_app_status_table.ASID
                        JOIN f20_user_table
                            ON f20_app_table.UID = f20_user_table.UID";

            $query = mysqli_query($db_conn, $sql);
            
            while ($row = mysqli_fetch_array($query)) {
                $workflowID = $row['AID'];
                $owner = $row['user_name'] . " (" . $row['user_email'] . ")";
                $title = $row['4'];
                $priority = $row['9'];
                $status = $row['12'];
                $created = $row['created'];
                $deadline = $row['deadline'];
        ?>
        <tr>
            <td><?php echo $title; ?></td>
            <td><?php echo $owner; ?></td>
            <td><?php echo $priority; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $created; ?></td>
            <td><?php echo $deadline; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=workflow">
                    <input type="hidden" name="workflowID" value="<?php echo $workflowID;?>">
                    <button type="submit" name="viewWorkflow" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>