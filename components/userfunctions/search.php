<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        header('Location: ./index.php');
    }
    //User is not an admin.
    if(!($_SESSION['user_type'] == 'admin')){
        header('Location: ./index.php');
    }
    include_once('./backend/util.php');
    include_once('./backend/db_connector.php');
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-search"></i>  Admin Search Tool</b></h5>
</header>

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onclick="openSearch('workflowSearch');">
    <div class="w3-container w3-blue w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Workflow</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="openSearch('departmentSearch');">
    <div class="w3-container w3-blue w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Deparment</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="openSearch('courseSearch');">
    <div class="w3-container w3-blue w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-book w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Course</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="openSearch('userSearch');">
    <div class="w3-container w3-blue w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>User</h5></div>
    </div>
    </div>
</div>

<!-- Workflow Search -->
<div id="workflowSearch" class="w3-card-4 w3-padding w3-margin" style="display: none;">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='.'">Start Workflow</button>
    <h5>Workflow Search</h5>
    <p>You may search by ID</p>
    <input id="workflowInput" type="text" onkeyup="search('workflowTable', 'workflowInput')"></input>
    <table id="workflowTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th>Initiator Email</th>
            <th>Course</th>
            <th>Semester</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php
            $sql = "SELECT f20_application_info.student_email, concat(f20_application_info.semester, ' ', f20_application_info.year) 
            AS semyear, concat(f20_application_info.dept_code, ' ', course_number) 
            AS Course, f20_application_info.instructor_email, assigned_to, f20_application_info.fw_id 
            FROM f20_application_info INNER JOIN f20_application_util ON f20_application_info.fw_id = f20_application_util.fw_id";

            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_array($query)) {
                $initEmail = $row['student_email'];
                $course = $row['Course'];
                $semester = $row['semyear'];
                $status = $row['assigned_to'];
                $wfID = $row['fw_id'];
        ?>
        <tr>
            <td><?php echo $initEmail; ?></td>
            <td><?php echo $course; ?></td>
            <td><?php echo $semester; ?></td>
            <td><?php echo $status; ?></td>
            <td>
                <button class="w3-button w3-green">Edit</button>
                <button class="w3-button w3-red" onclick="removeEntry('workflow', '<?php echo $wfID ?>')">Remove</button>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- Department Search -->
<div id="departmentSearch" class="w3-card-4 w3-padding w3-margin" style="display: none;">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create'">Create Department</button>
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
                <button class="w3-button w3-green">Edit</button>
                <button class="w3-button w3-red" onclick="removeEntry('department', '<?php echo $code ?>')">Remove</button>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- Course Search -->
<div id="courseSearch" class="w3-card-4 w3-padding w3-margin" style="display: none;">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create'">Create Course</button>
    <h5>Course Search</h5>
    <p>You may search by Course Number or Department</p>
    <input type="text" id="courseInput" onkeyup="search('courseTable', 'courseInput')"></input>
    <table id="courseTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class="w3-center">Department</th>
            <th class="w3-center">Course Number</th>
            <th class="w3-center">Actions </th>
        </tr>
        <?php
            $sql = "SELECT * FROM f20_course_numbers";
            $query = mysqli_query($db_conn, $sql);
            while ($row = mysqli_fetch_assoc($query)) {
                $dept = $row['dept_code'];
                $number = $row['course_number'];
                $id = $row['id'];
                
        ?>
        <tr>
            <td><?php echo $dept; ?></td>
            <td><?php echo $number; ?></td>
            <td>
                <button class="w3-button w3-green">Edit</button>
                <button type="button" class="w3-button w3-red" onclick="removeEntry('course', '<?php echo $dept . ' ' . $number ?>')">Remove</button>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- User Search -->
<div id="userSearch" class="w3-card-4 w3-padding w3-margin" style="display: none;">
    <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./dashboard.php?content=create'">Create User</button>
    <h5>User Search</h5>
    <p>You may search by ID or Email</p>
    <input type="text" id="userInput" onkeyup="search('userTable', 'userInput')"></input>
    <table id="userTable" class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
        <tr>
            <th class="w3-center">Name</th>
            <th class="w3-center">Email</th>
            <th class="w3-center">Account Type</th>
            <th class="w3-center">Last Login</th>
            <th class="w3-center">Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM " . $GLOBALS['accounts'];
            $query = mysqli_query($db_conn, $sql);
            $rowNum = 1;
            while ($row = mysqli_fetch_assoc($query)) {
                $userEmail = $row['email'];
                $userType = $row['profile_type'];
                $lastAccess = $row['last_access'];
        ?>
        <tr>
            <td><?php echo " " ?></td>
            <td><?php echo $userEmail; ?></td>
            <td><?php echo $userType; ?></td>
            <td><?php echo $lastAccess; ?></td>
            <td>
                <form method="post" action="./dashboard.php?content=view&contentType=user">
                    <input type="hidden" name="userEmail" value="<?php echo $userEmail;?>">
                    <button type="submit" name="viewUser" class="w3-button w3-blue">View</button>
                </form>
            </td>
        </tr>
        <?php $rowNum++; } ?>
    </table>
</div>

<!-- Table Pagination Script -->
<script>

    //Default value for rows per page.
    var perPage = 5;

    //Main function for creating pagnation, called on page load.
    function genTables() {
        var tables = document.querySelectorAll(".pagination");
        for (var i = 0; i < tables.length; i++) {
            perPage = parseInt(tables[i].dataset.pagecount);
            createFooters(tables[i]);
            createTableMeta(tables[i]);
            loadTable(tables[i]);
        }
    }

    //Function for the selected (current) table.
    function loadTable(table) {
        if (table.querySelector('th'))
            var startIndex = 1;
        else
            var startIndex = 0;

        var start = (parseInt(table.dataset.currentpage) * table.dataset.pagecount) + startIndex;
        var end = start + parseInt(table.dataset.pagecount);
        var rows = table.rows;

        for (var x = startIndex; x < rows.length - 1; x++) {
            if (x < start || x >= end)
                rows[x].style.display = "none";
            else
                rows[x].style.display = "table-row";
        }
    }

    //Function for tracking the current table page.
    function createTableMeta(table) {
        table.dataset.currentpage = "0";
    }

    //Function for attaching the pagination footer to the current table.
    function createFooters(table) {
        var hasHeader = false;
        var rows = table.rows.length;

        if (table.querySelector('th'))
            hasHeader = true;
        if (hasHeader)
            rows = rows - 1;

        var numPages = rows / perPage;
        var pager = document.createElement("div");
        
        if (numPages % 1 > 0)
            numPages = Math.floor(numPages) + 1;

        pager.className = "pager";
        for (var i = 0; i < numPages ; i++) {
            var page = document.createElement("button");
            page.innerHTML = i + 1;
            page.className = "pager-item";
            page.dataset.index = i;

            if (i == 0)
                page.classList.add("selected");

            page.addEventListener('click', function() {
                var parent = this.parentNode;
                var items = parent.querySelectorAll(".pager-item");
                for (var x = 0; x < items.length; x++) {
                    items[x].classList.remove("selected");
                }
                this.classList.add('selected');
                table.dataset.currentpage = this.dataset.index;
                loadTable(table);
            });
            pager.appendChild(page);
        }

        //Creating a footer to hold the "pager" and adding it to the table.
        var footer = table.createTFoot();
        var row = footer.insertRow(0);
        var cell = row.insertCell(0);
        cell.classList.add("w3-center");
        cell.setAttribute("colspan", table.rows[0].cells.length)
        cell.appendChild(pager);
    }

    //Event listener for when the page loads.
    window.addEventListener('load', function() {
        genTables();
    });
</script>

<!-- Table Filter/Search Script -->
<!-- Need to enable search on more than just the first column.-->
<script>
    function search(tableID, inputID) {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(inputID);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableID);
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            //Modify search function to check more than just the first column.
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } 
                else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<!-- Showing/Hiding Tables for Searching -->
<!-- A later version of this application will use PHP to load the specific search
    rather than pre-loading the tables.-->
<script>
    function openSearch(searchID)
    {
        closeSearch('workflowSearch');
        closeSearch('departmentSearch');
        closeSearch('courseSearch');
        closeSearch('userSearch');
        document.getElementById(searchID).style.display = "block";
    }
    function closeSearch(searchID)
    {
        document.getElementById(searchID).style.display = "none";
    }
</script>