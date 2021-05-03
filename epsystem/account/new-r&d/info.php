<?php
ob_start();
$page = "r&d";
include "../includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "../includes/header.php";

        if (!isset($_SESSION['new-infopage']))
            $_SESSION['new-infopage']['stage'] = '1';
        if (!isset($_SESSION['new-infopage']['info']['group']))
            $_SESSION['new-infopage']['info']['group'] = ""; // Info bar fix

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-infopage']['stage'] == '1') {
                if (isset($_POST['group'])) {
                    $_SESSION['new-infopage']['fields']['groupid'] = $_POST['group'];
                    $_SESSION['new-infopage']['info']['group'] = Database::selectInfoPageGroup($_POST['group'])['title'];
                    if (strlen($_SESSION['new-infopage']['info']['group']) > InfobarCharLimit)
                        $_SESSION['new-infopage']['info']['group'] = substr($_SESSION['new-infopage']['info']['group'], 0, InfobarCharLimit) . "...";
                }
                else {
                    $_SESSION['new-infopage']['fields']['groupid'] = null;
                    $_SESSION['new-infopage']['info']['group'] = "None";
                }
                $_SESSION['new-infopage']['stage'] = '2';
                if (!isset($_SESSION['new-infopage']['info']['title']))
                    $_SESSION['new-infopage']['info']['title'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-infopage']['stage'] == '2') {
                $_SESSION['new-infopage']['fields']['title'] = $_POST['title'];
                $_SESSION['new-infopage']['info']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-infopage']['info']['title']) > InfobarCharLimit)
                    $_SESSION['new-infopage']['info']['title'] = substr($_SESSION['new-infopage']['info']['title'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-infopage']['stage'] = '3';
                if (!isset($_SESSION['new-infopage']['info']['description']))
                    $_SESSION['new-infopage']['info']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-infopage']['stage'] == '3') {
                $_SESSION['new-infopage']['fields']['description'] = $_POST['description'];
                $_SESSION['new-infopage']['info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-infopage']['info']['description']) > InfobarCharLimit)
                    $_SESSION['new-infopage']['info']['description'] = substr($_SESSION['new-infopage']['info']['description'], 0, InfobarCharLimit) . "...";

                $presetID = Database::insert('preset-infopage', $_SESSION['new-infopage']['fields'], true, false);
                // From new task preset
                if (isset($_SESSION['new-taskpr']['new-infopage'])) {
                    if ($_SESSION['new-taskpr']['infopages'] == "")
                        $_SESSION['new-taskpr']['infopages'] = null;
                    $_SESSION['new-taskpr']['infopages'][$presetID] = Database::selectInfoPagePreset($presetID);
                    unset($_SESSION['new-infopage']);
                    unset($_SESSION['new-taskpr']['add-info-page']);
                    unset($_SESSION['new-taskpr']['new-infopage']);
                    header('Location: task.php');
                    exit();
                }
                // From edit task info pages
                elseif (isset($_SESSION['new-infopage']['taskid'])) {
                    Database::insert('preset-task_infopage', ['taskid' => $_SESSION['new-infopage']['taskid'], 'infoid' => $presetID], false, false);
                    header('Location: ../r&d.php?t=' . $_SESSION['new-infopage']['taskid'] . '&options&l1=edit&l2=info');
                    unset($_SESSION['new-infopage']);
                    unset($_SESSION['edit-taskpr']);
                    exit();
                }
                // From new infopage preset
                else {
                    unset($_SESSION['new-infopage']);
                    header('Location: ../r&d.php?i=' . $presetID . '&l1=overview');
                    exit();
                }
            }

            if (empty($_SESSION['new-infopage']['info']['group'])) $_SESSION['new-infopage']['stage'] = '1';
            elseif (empty($_SESSION['new-infopage']['info']['title'])) $_SESSION['new-infopage']['stage'] = '2';
            else $_SESSION['new-infopage']['stage'] = '3';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-infopage']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-infopage']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-infopage']['stage'] = '3';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-infopage']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-infopage']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>+ New Info Preset: Choose Group</span>
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
            $groups = Database::selectInfoPageGroups();
            include_once "../includes/info-bar.php"; ?>
            <form class="search-bar admin">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="name" class="input-name" placeholder="Enter Group Name" required style="width: calc(20% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
            </form>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Info Group Name</div>
                    <div class="head admin" style="width: 65%">Description</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            if ($groups) {?>
                <div class="table admin"> <?php
                    foreach ($groups as $group) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $group['id']); ?>" class="content"></div>
                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $group['title']; ?>" class="content"></div>
                            <div class="cell description" style="width: 65%"><input type="submit" name="submit" value="<?php echo $group['description']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="group" value="<?php echo $group['id']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO GROUPS</div> <?php
            }
        }
        elseif ($_SESSION['new-infopage']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>+ New Info Preset: Enter Name</span>
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
                    <div class="head admin">Info Preset Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="title" name="title" id="title" class="field admin" placeholder="Enter Info Preset Name Here" maxlength="50" value="<?php if (isset($_SESSION['new-infopage']['fields']['title'])) echo $_SESSION['new-infopage']['fields']['title']; ?>">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-infopage']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>+ New Info Preset: Enter Description</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="description" name="description" method="post" class="container-button">
                    <input type="submit" name="submit" value="Save" class="button admin-menu" maxlength="200">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension large admin"></div>
                <div class="header large">
                    <div class="head admin">Info Preset Description</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="description" name="description" id="description" class="field admin" placeholder="Enter Info Preset Description Here" value="<?php if (isset($_SESSION['new-infopage']['fields']['description'])) echo $_SESSION['new-infopage']['fields']['description']; ?>">
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