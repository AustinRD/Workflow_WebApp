<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/search/search.php')
?>

<!-- Workflow Search -->
<div id="workflowSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='.'">Start Workflow</button>
    <h5>Workflow Template Search</h5>
    <p>You may search by ID</p>
    <input id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')"></input>
    <table id="workflowTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
            $sql = "SELECT * FROM f20_app_template_table AS t1
                        JOIN f20_template_status_table AS t2
                            ON t1.TSID = t2.TSID";
            $query = mysqli_query($db_conn, $sql);
            
            while ($row = mysqli_fetch_array($query)) {
                $ATPID = $row['ATPID'];
                $title = $row['2'];
                $status = $row['5'];
        ?>
        <tr>
            <td><?php echo $title; ?></td>
            <td><?php echo $status; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=workflowTemplate">
                    <input type="hidden" name="appTemplateID" value="<?php echo $ATPID; ?>">
                    <button type="submit" name="viewWorkflow" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>