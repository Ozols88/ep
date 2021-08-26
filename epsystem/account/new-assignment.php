<?php
$page = "assignments";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "includes/header.php";

        if (!isset($_SESSION['new-assignment'])) {
            $_SESSION['new-assignment']['stage'] = '1c';
            $_SESSION['new-assignment']['info']['objective'] = ""; // Info bar fix
        }

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-assignment']['stage'] == '1c') {
                $_SESSION['new-assignment']['fields']['objective'] = $_POST['objective'];
                $_SESSION['new-assignment']['info']['objective'] = $_POST['objective'];
                if (strlen($_SESSION['new-assignment']['info']['objective']) > InfobarCharLimit)
                    $_SESSION['new-assignment']['info']['objective'] = substr($_SESSION['new-assignment']['info']['objective'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-assignment']['fields']['title'] = 'Custom Assignment';
                $_SESSION['new-assignment']['fields']['projectid'] = $_GET['p'];
                $_SESSION['new-assignment']['fields']['divisionid'] = '0';
                $asgID = Assignment::insert('assignment', $_SESSION['new-assignment']['fields'], true, false);

                $fieldsStatus = [
                    'assignmentid' => $asgID,
                    'status1' => 1,
                    'status2' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id
                ];
                // Insert to `status_assignment` table and save ID of the new record
                $statusID = Assignment::insert('status_assignment', $fieldsStatus, true, false);
                // Update `assignment` table record with saved ID status
                Assignment::update('assignment', $asgID, ["statusid" => $statusID], false);

                Project::projectStatusChanger($_SESSION['new-assignment']['fields']['projectid'], $account->id);

                header('Location: projects.php?p=' . $_SESSION['new-assignment']['fields']['projectid'] . '&l1=assignments&l2=pending');
                unset($_SESSION['new-assignment']);
                exit();
            }

            if (empty($_SESSION['new-assignment']['info']['objective'])) $_SESSION['new-assignment']['stage'] = '1c';
        }
        if (isset($_POST['stage1c'])) $_SESSION['new-assignment']['stage'] = '1c';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-assignment']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-assignment']['stage'] == '1c') { ?>
            <div class="head-up-display-bar">
                <span>New Custom Assignment</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="objective" name="objective" method="post" class="container-button">
                    <input type="submit" name="submit" value="Create Assignment" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension medium admin"></div>
                <div class="header medium">
                    <div class="head admin">Custom Assignment Objective</div>
                </div>
                <div class="header-extension medium admin"></div>
            </div>
            </div>
            <div class="table medium">
                <div class="row">
                    <input form="objective" name="objective" id="objective" class="field admin" placeholder="Enter Custom Assignment Objective Here" maxlength="100" value="<?php if (isset($_SESSION['new-assignment']['fields']['objective'])) echo htmlspecialchars($_SESSION['new-assignment']['fields']['objective']); ?>">
                </div>
            </div> <?php
        }

        require_once "includes/footer.php";

    }
    else
        header('Location: error.php');
}
else require_once "login.php";