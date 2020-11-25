<?php
    //Resuming the session.
    if(!isset($_SESSION)) { 
        session_start(); 
    }
    //User has not signed in.
    if(!isset($_SESSION['user_type'])) {
        header('Location: ./index.php');
    }
?>

<html>
    <head>
        <title>Dashboard</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Using w3.css for easy to use css framework -->
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <!-- Using font-awesome CDN for icons, if icons ever break update this link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- The workflows page requires the custom styles for the status bar -->
        <link rel="stylesheet" href="css/workflowProgress.css">
    </head>
    
    <style>
        html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
    </style>

    <body class="w3-light-grey">
        <!-- Header Component -->
        <?php include_once('./components/header.php'); ?>
        <!-- Sidebar/Navigation Component -->
        <?php include_once('./components/sidebar.php'); ?>
        
        <!-- !PAGE CONTENT! -->
        <div class="w3-main" style="margin-left:300px;margin-top:43px;">
            <!-- A file that handles displaying the appropriate content 
                based on the user permission and get requests -->
            <?php include_once('./backend/contentRouter.php'); ?>

            <!-- Footer Component -->
            <?php include_once('./components/footer.php'); ?>
        </div>
        <!-- End page content -->
    </body>
</html>

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
<script>
    function search(tableID, inputID) {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(inputID);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableID);
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            //the for loop searches all columns and the break statement is executed when a match is found.
            for(j = 0; j < table.rows[0].cells.length; ++j)
            {
                td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    } 
                    else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    }
</script>