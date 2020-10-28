<!--

-->

<?php
    include_once('./backend/config.php');
    include_once('./backend/db_connector.php');
    //Loading the page title and action buttons.
    include_once('./components/userfunctions/search/search.php')
?>

<!-- Department Search -->
<div id="departmentSearch" class="w3-card-4 w3-padding w3-margin">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create&contentType=department'">Create Department</button>
    <h5>Department Search</h5>
    <p>You may search by Department Name or Abbreviation</p>
    <input id="departmentInput" type="text" onkeyup="search('departmentTable', 'departmentInput')"></input>
    <table id="departmentTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class="w3-center">Department</th>
            <th>Name</th>
            <th>Chair Email</th>
            <th>Dean Email</th>
            <th>Secretary Email</th>
            <th>Actions</th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_academic_dept_info";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $code = $row['dept_code'];
                $name = $row["dept_name"];
                $chair = $row['chair_email'];
                $dean = $row['dean_email'];
                $secretary = $row['secretary_email'];
        ?>
        <tr>
            <td class="w3-center"><?php echo $code; ?></td>
            <td><?php echo $name; ?></td>
            <td><?php echo $chair; ?></td>
            <td><?php echo $dean; ?></td>
            <td><?php echo $secretary; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=department">
                    <input type="hidden" name="department" value="<?php echo $code;?>">
                    <button type="submit" name="viewDepartment" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>