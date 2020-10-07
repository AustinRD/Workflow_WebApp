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

<html>
<head>
    <title>Student Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>

<body class="w3-light-grey">
    <?php include_once('./components/header.php'); ?>
    <?php include_once('./components/sidebar.php'); ?>
    
    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
        <header class="w3-container" style="padding-top:22px">
            <h5><b><i class="fa fa-search"></i>  Admin Search Tool</b></h5>
        </header>
        <!-- Action Panel -->
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-quarter">
            <div class="w3-container w3-blue w3-padding-16 w3-border">
                <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                <div class="w3-clear"><h5>Workflow</h5></div>
            </div>
            </div>
            <div class="w3-quarter">
            <div class="w3-container w3-blue w3-padding-16 w3-border ">
                <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
                <div class="w3-clear"><h5>Deparment</h5></div>
            </div>
            </div>
            <div class="w3-quarter">
            <div class="w3-container w3-blue w3-padding-16 w3-border">
                <div class="w3-left"><i class="fa fa-book w3-xxxlarge"></i></div>
                <div class="w3-clear"><h5>Course</h5></div>
            </div>
            </div>
            <div class="w3-quarter">
            <div class="w3-container w3-blue w3-padding-16 w3-border">
                <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                <div class="w3-clear"><h5>User</h5></div>
            </div>
            </div>
        </div>

        <!-- Workflow Search -->
        <div class="w3-card-4 w3-padding w3-margin">
            <h5>Workflow Search</h5>
            <p>You may search by ID</p>
            <form method="post">
                <input type="text"></input>
                <button type="submit" name="workflowSearch">Search</button>
            </form>    
        </div>

        <!-- Department Search -->
        <div class="w3-card-4 w3-padding w3-margin">
            <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./createdepartment.php'">Create Department</button>
            <h5>Department Search</h5>
            <p>You may search by Department Name or Abbreviation</p>
            <form method="post">
                <input type="text"></input>
                <button type="submit" name="departmentSearch">Search</button>
            </form>
            <table class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
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
                    $run = mysqli_query($db_conn, $sql);
                    while ($row = mysqli_fetch_assoc($run)) {  //for each row
                        $code = $row['dept_code'];
                        $name = $row["dept_name"];
                        $chair = $row['chair_email'];
                        $dean = $row['dean_email'];
                        $secretary = $row['secretary_email'];
                        $modify = null;
                ?>
                <tr>
                    <td class="w3-center"><?php echo $code; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $chair; ?></td>
                    <td><?php echo $dean; ?></td>
                    <td><?php echo $secretary; ?></td>
                    <td><a class="w3-button" href="./editdepartment.php?department=<?php echo $code; ?>">Edit</a></button></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Course Search -->
        <div class="w3-card-4 w3-padding w3-margin">
            <button class="w3-button w3-right w3-blue" type="button" onclick="window.location.href='./createcourse.php'">Create Course</button>
            <h5>Course Search</h5>
            <p>You may search by Course Number or Department</p>
            <form method="post">
                <input type="text"></input>
                <button type="submit" name="courseSearch">Search</button>
            </form>
            <table class="pagination w3-table-all w3-responsive" data-pagecount="8" style="max-width:fit-content;">
                <tr>
                    <th class="w3-center">Department</th>
                    <th class="w3-center">Course Number</th>
                    <th class="w3-center">Actions </th>
                </tr>
                <?php
                    $sql = "SELECT * FROM f20_course_numbers";
                    $run = mysqli_query($db_conn, $sql);
                    while ($row = mysqli_fetch_assoc($run)) {
                        $dept = $row['dept_code'];
                        $number = $row["course_number"];
                        $id = $row['id'];
                        $modify = null;
                ?>
                <tr>
                    <td><?php echo $dept; ?></td>
                    <td><?php echo $number; ?></td>
                    <td><a class="w3-button" href="./editcourse.php?department=<?php echo $dept; ?>&course=<?php echo $number; ?>">Edit</a></button></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <!-- User Search -->
        <div class="w3-card-4 w3-padding w3-margin">
            <h5>User Search</h5>
            <p>You may search by ID or Email</p>
            <form method="post">
                <input type="text"></input>
                <button type="submit" name="userSearch">Search</button>
            </form>   
        </div>

        <?php include_once('./components/footer.php'); ?>
    </div>
    <!-- End page content -->
</body>
</html>

<script>
    var perPage = 5;

    function genTables() {
        var tables = document.querySelectorAll(".pagination");
        for (var i = 0; i < tables.length; i++) {
            perPage = parseInt(tables[i].dataset.pagecount);
            createFooters(tables[i]);
            createTableMeta(tables[i]);
            loadTable(tables[i]);
        }
    }

    // based on current page, only show the elements in that range
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

    function createTableMeta(table) {
        table.dataset.currentpage = "0";
    }

    function createFooters(table) {
        var hasHeader = false;
        if (table.querySelector('th'))
            hasHeader = true;

        var rows = table.rows.length;

        if (hasHeader)
            rows = rows - 1;

        var numPages = rows / perPage;
        
        var pager = document.createElement("div");
        
        // add an extra page, if we're 
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

        // insert page at the top of the table
        var footer = table.createTFoot();
        var row = footer.insertRow(0);
        var cell = row.insertCell(0);
        cell.classList.add("w3-center");
        cell.setAttribute("colspan", table.rows[0].cells.length)
        cell.appendChild(pager);
        
    }

    window.addEventListener('load', function() {
        genTables();
    });
</script>