<!--
    This file is for the creation of workflows work may be needed:
    1. Organization.
    2. May need database work.
-->

<?php
    if (isset($_POST['workflowCreate'])) {
        include_once('./backend/config.php');
        include_once('./backend/db_connector.php');

        //Needs Implementation

        //Database insert success
        if (mysqli_errno($db_conn) == 0) {
            echo("<div class='w3-panel w3-margin w3-green'><p>Course Successfully Created.</p></div>");
        } 
        //Database detected duplicate entry
        else if (mysqli_errno($db_conn) == 1062) {  
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Course - Duplicate Found.</p></div>");
        }
        else {
            echo("<div class='w3-panel w3-margin w3-red'><p>Failed to Create Course.</p></div>");

        }
    }
?>

<!-- Content Title -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-plus"></i>  Admin Create Tool</b></h5>
</header>

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=workflow'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Workflow</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=department'">
    <div class="w3-container w3-teal w3-padding-16 w3-border ">
        <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Deparment</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=course'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-book w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>Course</h5></div>
    </div>
    </div>
    <div class="w3-quarter" onclick="window.location.href='./dashboard.php?content=create&contentType=user'">
    <div class="w3-container w3-teal w3-padding-16 w3-border">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"><h5>User</h5></div>
    </div>
    </div>
</div>

<!-- Create Workflow -->
<div id="workflowForm" class="w3-card-4 w3-padding w3-margin" style="display: block;">
    <h5>Create Workflow</h5>
    <p>You can create a custom workflow here.</p>
    <form method="post">
        <label for="workflowTitle">Workflow Title</label>
        <input class="w3-input" type="text" name="workflowTitle"></input>
    
        <?php
            $userLabels = array('Records & Registration', 'Career Resource Center', 'Dean', 'Chair', 'Secretary', 'Student', 'Employer', 'Faculty [Advisor/Instructor]');
            $userTypes = array('recreg', 'crc', 'dean', 'chair', 'secretary', 'student', 'employer', 'faculty');
        ?>
        <h2>Participant List</h2>
        <p>Drag and Drop participants to their appropriate order</p>

        <?php
            $length = count($userTypes);
            for ($i=0; $i < $length; $i++) {
        ?>
            <label for=""><?php echo $userLabels[$i]; ?></label>
            <div id='labelCont<?php echo $i; ?>' class='labelContainer' ondrop='drop(event)' ondragover='allowDrop(event)'>
                <strong id='label<?php echo $i; ?>' draggable='true' ondragstart='drag(event)'><?php echo $userTypes[$i]; ?></strong>
            </div>
        <?php
            }
        ?>
        
        <!-- Workflow visualizer -->
        <h2>Workflow Order</h2>
        <p>Click the circle with a "+" to add another participant.</p>
        <div class="w3-padding w3-border">
            <div id="circleList" class="circleList">
                <div class="circle" onclick="addParticipant()">+</div>
            </div>
            <div id="labelList" class="labelList">
                <div id="labelContainer" class="userType" style="border: 1px solid black;"></div>
            </div>
        </div>
        <br>
        <button type="button" class="w3-button w3-teal" name="createWorkflow">Create Workflow</button>
    </form>
</div>


<!-- Script for enabling drag and drop-->
<script>
    function allowDrop(event) {
        event.preventDefault();
    }
    function drag(event) {
        event.dataTransfer.setData("text", event.target.id);
    }
    function drop(event) {
        event.preventDefault();
        var data = event.dataTransfer.getData("text");
        event.target.appendChild(document.getElementById(data));

        //Removing fixed-size box from the visualizer (may need work - doesn't reset if the user changes position).
        document.getElementById(event.target.id).style.border = "none";
    }
</script>

<!-- Script for adding more participants to the workflow. -->
<script> 
    function addParticipant()
    {
        //Find how many participants there are.
        numParticipants = Math.ceil(document.getElementById('circleList').children.length/2);

        if(numParticipants < 9) {
            //Add a line, circle, and label.
            document.getElementById('circleList').innerHTML += "<div class='line'></div><div class='circle'>" + numParticipants + "</div>";
            document.getElementById('labelList').innerHTML += "<div class='spacer'></div><div id='labelContainer" + numParticipants + " ' class='userType' style='border: 1px solid black;' ondrop='drop(event)' ondragover='allowDrop(event)'></div>";
        
            //Participant list is full
            if(numParticipants == 8)
            {
                //Remove the + circle
                circleList = document.getElementById('circleList');
                circleList.removeChild(circleList.children[0]);
                circleList.removeChild(circleList.children[0]);
                //Remove the label from the + circle
                labelList = document.getElementById('labelList');
                labelList.removeChild(labelList.children[0]);
                labelList.removeChild(labelList.children[0]);
            }
        }
    }
</script>