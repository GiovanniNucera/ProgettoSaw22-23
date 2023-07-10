<?php
include("../connection.php");
session_start();
if ($_SESSION['admin'] !== true || !isset($_SESSION['admin'])) {
    header("location: ../loginform.php");
    exit();
}
$_SESSION['admin_navbar'] = true;
?>

<?php include("head_admin.php"); ?>
<title> Donations Area</title>
<?php include("navbar_admin.php"); ?>

<div style="margin: 50px;"></div>
<div class="contet2">
    <p> Donations area</p>
</div>
<div style="margin: 50px;"></div>
<div class="section">
    <div class="contet2">
        <p> Insert new project</p>
    </div>
    <div style="margin: 50px;"></div>
    <div class="row">
    <div class="center">
        <form action="insert_crowdfunding.php" method="POST" id="usrform">
            <button><input type="submit" value="Insert New Project"></button>
            <table id="insert" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Goal</th>
                        <th>Start date</th>
                        <th>Finish date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" id="name" name="name" placeholder="Project Name"></td>
                        <td><textarea rows="3" cols="40" form="usrform" id="description" name="description" placeholder="Project Description"></textarea> </td>
                        <td><input type="number" id="goal" name="goal" min="1" placeholder="1"></td>
                        <td><input type="datetime-local" id="date_1" name="date_1" value="<?php echo date("Y-m-d") . "T" . date("H:i") ?>" min="<?php echo date("Y-m-d") . "T" . date("H:i") ?>"></td>
                        <td><input type="datetime-local" id="date_2" name="date_2" min="<?php echo date("Y-m-d") . "T" . date("H:i") ?>"></td>
                    </tr>
                </tbody>
            </table>
        </form>
        </div>
    </div>
    
</div>
<div style="margin: 50px;"></div>
<div class="section">
    <div class="contet2">
        <p> Projects</p>
    </div>
    <div style="margin: 50px;"></div>
    <div class="row">
    <div class="center">
        <table id="donate" class="display" style="width: 100%">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Goal</th>
                    <th>Raised</th>
                    <th>Difference</th>
                    <th>Start date</th>
                    <th>Finish date</th>
                    <th>Remaining days</th>
                    <th>State</th>
                </tr>
            </thead>
        </table>
</div>
    </div>
</div>
    

<div class="section">
    <div class="contet2">
        <p> Donators</p>
    </div>
    <div style="margin: 50px;"></div>
    <div class="row">
    <div class="center">
        <table id="donators" class="display" style="width: 100%">
            <thead>
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Project name</th>
                    <th>Donations</th>
                </tr>
            </thead>
        </table>
    </div>
    </div>
</div>
<div style="margin: 50px;"></div>
</body>
</html>

<script src="script.js"></script>
