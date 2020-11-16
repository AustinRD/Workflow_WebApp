<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/search/search.php')
?>

<!-- Workflow Search -->
<div id="workflowSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='.'">Start Workflow</button>
    <h5>Workflow Search</h5>
    <p>You may search by ID</p>
    <input id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')"></input>
    <table id="workflowTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Status</th>
            <th>Created</th>
            <th>Deadline</th>
            <th>Action</th>
        </tr>

        <?php
            $sql = "SELECT * FROM f20_step_table
                        JOIN f20_step_type_table
                            ON f20_step_table.STID = f20_step_type_table.STID
                        JOIN f20_step_status_table
                            ON f20_step_table.SSID = f20_step_status_table.SSID";

            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_array($query)) {
                $title = $row['4'];
                $type = $row['10'];
                $status = $row['13'];
                $created = $row['created'];
                $deadline = $row['deadline'];
        ?>
        <tr>
            <td><?php echo $title; ?></td>
            <td><?php echo $type; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $created; ?></td>
            <td><?php echo $deadline; ?></td>

            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=workflow">
                    <input type="hidden" name="workflowID" value="<?php echo $wfID;?>">
                    <button type="submit" name="viewWorkflow" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>