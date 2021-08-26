<?php
ob_start();
$page = "r&d";
include "../includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "../includes/header.php";

        if (!isset($_SESSION['new-assignmentpr']))
            $_SESSION['new-assignmentpr']['stage'] = '1';
        if (!isset($_SESSION['new-assignmentpr']['info']['division']))
            $_SESSION['new-assignmentpr']['info']['division'] = ""; // Info bar fix

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-assignmentpr']['stage'] == '1') {
                if (isset($_POST['division'])) {
                    $_SESSION['new-assignmentpr']['fields']['divisionid'] = $_POST['division'];
                    $_SESSION['new-assignmentpr']['info']['division'] = Assignment::selectDivisionByID($_POST['division'])['title'];
                    if (strlen($_SESSION['new-assignmentpr']['info']['division']) > InfobarCharLimit)
                        $_SESSION['new-assignmentpr']['info']['division'] = substr($_SESSION['new-assignmentpr']['info']['division'], 0, InfobarCharLimit) . "...";
                }
                else {
                    $_SESSION['new-assignmentpr']['fields']['divisionid'] = null;
                    $_SESSION['new-assignmentpr']['info']['division'] = "None";
                }

                $_SESSION['new-assignmentpr']['stage'] = '2';
                if (!isset($_SESSION['new-assignmentpr']['info']['title']))
                    $_SESSION['new-assignmentpr']['info']['title'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-assignmentpr']['stage'] == '2') {
                $_SESSION['new-assignmentpr']['fields']['title'] = $_POST['title'];
                $_SESSION['new-assignmentpr']['info']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-assignmentpr']['info']['title']) > InfobarCharLimit)
                    $_SESSION['new-assignmentpr']['info']['title'] = substr($_SESSION['new-assignmentpr']['info']['title'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-assignmentpr']['stage'] = '3';
                if (!isset($_SESSION['new-assignmentpr']['info']['objective']))
                    $_SESSION['new-assignmentpr']['info']['objective'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-assignmentpr']['stage'] == '3') {
                $_SESSION['new-assignmentpr']['fields']['objective'] = $_POST['objective'];
                $_SESSION['new-assignmentpr']['info']['objective'] = $_POST['objective'];
                if (strlen($_SESSION['new-assignmentpr']['info']['objective']) > InfobarCharLimit)
                    $_SESSION['new-assignmentpr']['info']['objective'] = substr($_SESSION['new-assignmentpr']['info']['objective'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-assignmentpr']['fields']['date_created'] = date("Y-m-d H-i-s");
                $asgPresetID = Database::insert('preset-assignment', $_SESSION['new-assignmentpr']['fields'], true, false);
                unset($_SESSION['new-assignmentpr']);
                header('Location: ../r&d.php?a=' . $asgPresetID . "&l1=overview");
                exit();
            }

            if (empty($_SESSION['new-assignmentpr']['info']['division'])) $_SESSION['new-assignmentpr']['stage'] = '1';
            elseif (empty($_SESSION['new-assignmentpr']['info']['title'])) $_SESSION['new-assignmentpr']['stage'] = '2';
            else $_SESSION['new-assignmentpr']['stage'] = '3';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-assignmentpr']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-assignmentpr']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-assignmentpr']['stage'] = '3';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-assignmentpr']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-assignmentpr']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>New Assignment Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="none">
                    <input type="submit" name="submit" value="NONE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php";
            $divisions = Assignment::selectDivisions();
            $departments = Assignment::selectDepartments(); ?>
            <form class="search-bar admin">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="name" class="input-name" placeholder="Enter Division Name" required style="width: calc(20% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
            </form>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Division Name</div>
                    <div class="head admin" style="width: 65%">Division Description</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            if (isset($divisions)) { ?>
                <div class="table admin"> <?php
                    foreach ($divisions as $division) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $division['id']); ?>" class="content"></div>
                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $division['title']; ?>" class="content"></div>
                            <div class="cell description" style="width: 65%"><input type="submit" name="submit" value="<?php echo $division['description']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="division" value="<?php echo $division['id']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO DIVISIONS</div> <?php
            }
        }
        elseif ($_SESSION['new-assignmentpr']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>New Assignment Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="test" name="test" method="post" class="container-button">
                    <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension small admin"></div>
                <div class="header small">
                    <div class="head admin">Preset Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="test" name="title" id="title" class="field admin" placeholder="Enter Preset Name Here" value="<?php if (isset($_SESSION['new-assignmentpr']['fields']['title'])) echo htmlspecialchars($_SESSION['new-assignmentpr']['fields']['title']); ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }
        elseif ($_SESSION['new-assignmentpr']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>New Assignment Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="test" name="test" method="post" class="container-button">
                    <input type="submit" name="submit" value="Save" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension medium admin"></div>
                <div class="header medium">
                    <div class="head admin">Assignment Objective</div>
                </div>
                <div class="header-extension medium admin"></div>
            </div>
            </div>
            <div class="table medium">
                <div class="row">
                    <input form="test" name="objective" id="objective" class="field admin" placeholder="Enter Assignment Objective Here" value="<?php if (isset($_SESSION['new-assignmentpr']['fields']['objective'])) echo htmlspecialchars($_SESSION['new-assignmentpr']['fields']['objective']); ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }

        require_once "../includes/footer.php";

    }
    else {
        header('Location: ../error.php');
    }
}
else require_once "../login.php";