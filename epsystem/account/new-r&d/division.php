<?php
ob_start();
$page = "r&d";
include "../includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "../includes/header.php";

        if (!isset($_SESSION['new-division']))
            $_SESSION['new-division']['stage'] = '1';
        if (!isset($_SESSION['new-division']['info']['department']))
            $_SESSION['new-division']['info']['department'] = ""; // Info bar fix

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-division']['stage'] == '1') {
                if (isset($_POST['depart'])) {
                    $_SESSION['new-division']['fields']['departid'] = $_POST['depart'];
                    $_SESSION['new-division']['info']['department'] = Assignment::selectDepartmentByID($_POST['depart'])['title'];
                    if (strlen($_SESSION['new-division']['info']['department']) > InfobarCharLimit)
                        $_SESSION['new-division']['info']['department'] = substr($_SESSION['new-division']['info']['department'], 0, InfobarCharLimit) . "...";
                }
                else {
                    $_SESSION['new-division']['fields']['departid'] = null;
                    $_SESSION['new-division']['info']['department'] = "None";
                }

                $_SESSION['new-division']['stage'] = '2';
                if (!isset($_SESSION['new-division']['info']['title']))
                    $_SESSION['new-division']['info']['title'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-division']['stage'] == '2') {
                $_SESSION['new-division']['fields']['title'] = $_POST['title'];
                $_SESSION['new-division']['info']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-division']['info']['title']) > InfobarCharLimit)
                    $_SESSION['new-division']['info']['title'] = substr($_SESSION['new-division']['info']['title'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-division']['stage'] = '3';
                if (!isset($_SESSION['new-division']['info']['description']))
                    $_SESSION['new-division']['info']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-division']['stage'] == '3') {
                $_SESSION['new-division']['fields']['description'] = $_POST['description'];
                $_SESSION['new-division']['info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-division']['info']['description']) > InfobarCharLimit)
                    $_SESSION['new-division']['info']['description'] = substr($_SESSION['new-division']['info']['description'], 0, InfobarCharLimit) . "...";

                $divisionID = Database::insert('division', $_SESSION['new-division']['fields'], true, false);
                header('Location: ../r&d.php?d=' . $divisionID . '&l1=overview');
                unset($_SESSION['new-division']);
                exit();
            }

            if (empty($_SESSION['new-division']['info']['type'])) $_SESSION['new-division']['stage'] = '1';
            if (empty($_SESSION['new-division']['info']['title'])) $_SESSION['new-division']['stage'] = '2';
            else $_SESSION['new-division']['stage'] = '3';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-division']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-division']['stage'] = '2';
        if (isset($_POST['stage2'])) $_SESSION['new-division']['stage'] = '3';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-division']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-division']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>+ New Division: Select Department</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="none">
                    <input type="submit" name="submit" value="None" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php";
            $departments = Assignment::selectDepartments(); ?>
            <form class="search-bar admin">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="name" class="input-name" placeholder="Enter Department Name" required style="width: calc(20% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
            </form>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Department Name</div>
                    <div class="head admin" style="width: 65%">Department Description</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            if (isset($departments)) { ?>
                <div class="table admin"> <?php
                    foreach ($departments as $depart) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%02d', $depart['id']); ?>" class="content"></div>
                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $depart['title']; ?>" class="content"></div>
                            <div class="cell description" style="width: 65%"><input type="submit" name="submit" value="<?php echo $depart['description']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="depart" value="<?php echo $depart['id']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO DEPARTMENTS</div> <?php
            }
        }
        elseif ($_SESSION['new-division']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>+ New Division: Enter Name</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="title" name="title" method="post" class="container-button">
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
                    <div class="head admin">Division Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="title" name="title" id="title" class="field admin" placeholder="Enter Division Name Here" maxlength="50" value="<?php if (isset($_SESSION['new-division']['fields']['title'])) echo $_SESSION['new-division']['fields']['title']; ?>">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-division']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>+ New Division: Enter Description</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="description" name="description" method="post" class="container-button">
                    <input type="submit" name="submit" value="Save" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension large admin"></div>
                <div class="header large">
                    <div class="head admin">Division Description</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="description" name="description" id="description" class="field admin" placeholder="Enter Division Description Here" maxlength="200" value="<?php if (isset($_SESSION['new-division']['fields']['description'])) echo $_SESSION['new-division']['fields']['description']; ?>">
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