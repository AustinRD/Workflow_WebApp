<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/search/search.php')
?>
<div id="stepSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='.'">Add Step</button>
    <h5>Steps</h5>
    <br>
    <table id="workflowTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th>Step Number</th>
            <th>Title</th>
            <th>File</th>
            <th>Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_app_template_details_table 
                        JOIN f20_step_template_table
                            ON f20_app_template_details_table.STPID = f20_step_template_table.STPID";
            $query = mysqli_query($db_conn, $sql);
            
            while ($row = mysqli_fetch_array($query)) {
                $stepNumber = $row['step_order'];
                $title = $row['title'];
                $file = $row['location'];
        ?>
        <tr>
            <td><?php echo $stepNumber; ?></td>
            <td><?php echo $title; ?></td>
            <td><?php echo $file; ?></td>
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