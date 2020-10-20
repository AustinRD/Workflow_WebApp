<!-- Dashboard Header -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i>  Records and Registration Dashboard</b></h5>
</header>

<!-- Action Panel -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
    <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <h4>Messages</h4>
    </div>
    </div>
    <div class="w3-quarter" onClick="location.href = './dashboard.php?content=search'">
    <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-search w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <h4>Search</h4>
    </div>
    </div>
    <div class="w3-quarter" onClick="location.href = './dashboard.php?content=create'">
    <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-plus w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <h4>Create</h4>
    </div>
    </div>
    <div class="w3-quarter" onClick="location.href = './dashboard.php?content=files'">
    <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-clear"></div>
        <h4>Files</h4>
    </div>
    </div>
</div>

<!-- Feed -->
<div class="w3-panel">
    <h5>Feed</h5>
    <table class="w3-table w3-striped w3-white">
        <tr>
        <td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
        <td>New workflow request from Jared Huberman.</td>
        <td><i>5 mins</i></td>
    </tr>
    <tr>
        <td><i class="fa fa-user w3-text-yellow w3-large"></i></td>
        <td>New Connection from Dr. Pham</td>
        <td><i>10 mins</i></td>
    </tr>
    <tr>
        <td><i class="fa fa-bell w3-text-red w3-large"></i></td>
        <td>Urgent Message from Dept. Chair Easwaran</td>
        <td><i>15 mins</i></td>
    </tr>
    <tr>
        <td><i class="fa fa-comment w3-text-blue w3-large"></i></td>
        <td>New message from Austin DiLeonardo.</td>
        <td><i>25 mins</i></td>
    </tr>
    <tr>
        <td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
        <td>New workflow request from Brandon Turner.</td>
        <td><i>39 mins</i></td>
    </tr>
    </table>
</div>