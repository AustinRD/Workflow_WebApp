<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/search/search.php')
?>
<div id="stepSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='.'">Add Step</button>
    <h5>Step Template Search</h5>
    <p>You may search by any field in the table.</p>
    <input id="stepTemplateInput" type="text" onkeyup="search('stepTemplateTable', 'stepTemplateInput')"></input>
    <br>
    <table id="stepTemplateTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th>Workflow Title</th>
            <th>Step Number</th>
            <th>Title</th>
            <th>File</th>
            <th>Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_step_template_table
                        JOIN f20_app_template_details_table
                            ON f20_step_template_table.STPID = f20_app_template_details_table.STPID
                        JOIN f20_app_template_table
                            ON f20_app_template_details_table.ATPID = f20_app_template_table.ATPID";
            $query = mysqli_query($db_conn, $sql);
            
            while ($row = mysqli_fetch_array($query)) {
                $stepTemplateID = $row['STPID'];
                $appTitle = $row['10'];
                $stepNumber = $row['step_order'];
                $title = $row['2'];
                $file = $row['location'];
        ?>
        <tr>
            <td><?php echo $appTitle; ?></td>
            <td><?php echo $stepNumber; ?></td>
            <td><?php echo $title; ?></td>
            <td><?php echo $file; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=stepTemplate">
                    <input type="hidden" name="stepTemplateID" value="<?php echo $stepTemplateID;?>">
                    <button type="submit" name="viewStepTemplate" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>