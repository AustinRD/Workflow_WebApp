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
            <th>Workflow</th>
            <th>Step</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php
            $sql = "SELECT * FROM f20_app_template_table
                        JOIN f20_app_template_details_table
                            ON f20_app_template_table.ATPID = f20_app_template_details_table.ATPID
                        JOIN f20_step_template_table
                            ON f20_app_template_details_table.STPID = f20_step_template_table.STPID
                        JOIN f20_template_status_table
                            ON f20_step_template_table.TSID = f20_template_status_table.TSID";


            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_array($query)) {
                $workflow = $row['2'];
                $stepTitle = $row['9'];
                $status = $row['13'];
        ?>
        <tr>
            <td><?php echo $workflow; ?></td>
            <td><?php echo $stepTitle; ?></td>
            <td><?php echo $status; ?></td>
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