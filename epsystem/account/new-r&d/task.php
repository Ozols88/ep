<?php
ob_start();
$page = "assignments";
include "../includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "../includes/header.php";

        if (!isset($_SESSION['new-taskpr']['stage'])) {
            if (isset($_SESSION['new-taskpr']['fields']['assignmentid'])) {
                $_SESSION['new-taskpr']['info']['assignment'] = Assignment::selectPresetByID($_SESSION['new-taskpr']['fields']['assignmentid'])['title'];
                $_SESSION['new-taskpr']['stage'] = '2';
                $_SESSION['new-taskpr']['info']['name'] = ""; // Info bar fix
            }
            else {
                $_SESSION['new-taskpr']['stage'] = '1';
                $_SESSION['new-taskpr']['info']['assignment'] = ""; // Info bar fix
            }
        }

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-taskpr']['stage'] == '1') {
                if (isset($_POST['none'])) {
                    $_SESSION['new-taskpr']['fields']['assignmentid'] = null;
                    $_SESSION['new-taskpr']['info']['assignment'] = "None";
                }
                elseif (isset($_POST['asg'])) {
                    $_SESSION['new-taskpr']['fields']['assignmentid'] = $_POST['asg'];
                    $_SESSION['new-taskpr']['info']['assignment'] = $_POST['asg-title'];
                    if (strlen($_SESSION['new-taskpr']['info']['assignment']) > InfobarCharLimit)
                        $_SESSION['new-taskpr']['info']['assignment'] = substr($_SESSION['new-taskpr']['info']['assignment'], 0, InfobarCharLimit) . "...";
                }
                $_SESSION['new-taskpr']['stage'] = '2';
                if (!isset($_SESSION['new-taskpr']['info']['name']))
                    $_SESSION['new-taskpr']['info']['name'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-taskpr']['stage'] == '2') {
                $_SESSION['new-taskpr']['fields']['name'] = $_POST['name'];
                $_SESSION['new-taskpr']['info']['name'] = $_POST['name'];
                if (strlen($_SESSION['new-taskpr']['info']['name']) > InfobarCharLimit)
                    $_SESSION['new-taskpr']['info']['name'] = substr($_SESSION['new-taskpr']['info']['name'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-taskpr']['stage'] = '3';
                if (!isset($_SESSION['new-taskpr']['info']['infopage']))
                    $_SESSION['new-taskpr']['info']['infopage'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-taskpr']['stage'] == '3') {
                if (isset($_POST['none'])) {
                    $_SESSION['new-taskpr']['fields']['infoid'] = null;
                    $_SESSION['new-taskpr']['info']['infopage'] = "None";

                    $_SESSION['new-taskpr']['stage'] = '4';
                    if (!isset($_SESSION['new-taskpr']['info']['time']))
                        $_SESSION['new-taskpr']['info']['time'] = ""; // Info bar fix
                }
                elseif (isset($_POST['info'])) {
                    $_SESSION['new-taskpr']['fields']['infoid'] = $_POST['info'];
                    $_SESSION['new-taskpr']['info']['infopage'] = $_POST['info-title'];
                    if (strlen($_SESSION['new-taskpr']['info']['infopage']) > InfobarCharLimit)
                        $_SESSION['new-taskpr']['info']['infopage'] = substr($_SESSION['new-taskpr']['info']['infopage'], 0, InfobarCharLimit) . "...";

                    $_SESSION['new-taskpr']['stage'] = '4';
                    if (!isset($_SESSION['new-taskpr']['info']['time']))
                        $_SESSION['new-taskpr']['info']['time'] = ""; // Info bar fix
                }
            }
            elseif ($_SESSION['new-taskpr']['stage'] == '4') {
                if (ctype_digit($_POST['sec']) && $_POST['sec'] <= 7200 && $_POST['sec'] >= 10) {
                    $time = gmdate("H:i:s", $_POST['sec']);
                    $_SESSION['new-taskpr']['fields']['estimated'] = $time;
                    $_SESSION['new-taskpr']['info']['time-sec'] = $_POST['sec'];
                    $_SESSION['new-taskpr']['info']['time'] = $time;

                    $_SESSION['new-taskpr']['stage'] = '5';
                    if (!isset($_SESSION['new-taskpr']['info']['description']))
                        $_SESSION['new-taskpr']['info']['description'] = ""; // Info bar fix
                }
            }
            elseif ($_SESSION['new-taskpr']['stage'] == '5') {
                $_SESSION['new-taskpr']['fields']['description'] = $_POST['description'];
                $_SESSION['new-taskpr']['info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-taskpr']['info']['description']) > InfobarCharLimit)
                    $_SESSION['new-taskpr']['info']['description'] = substr($_SESSION['new-taskpr']['info']['description'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-taskpr']['fields']['date_created'] = date("Y-m-d H-i-s");
                $presetID = Database::insert('preset-task', $_SESSION['new-taskpr']['fields'], true, false);
                $preset = Assignment::selectPresetByID($_SESSION['new-taskpr']['fields']['assignmentid']);
                Database::update('preset-assignment', $_SESSION['new-taskpr']['fields']['assignmentid'], ['date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], false);
                if (isset($_SESSION['edit-assignmentpr']['redirect'])) {
                    if ($_SESSION['edit-assignmentpr']['redirect'] == 1)
                        header('Location: ../r&d.php?a=' . $_SESSION['new-taskpr']['fields']['assignmentid'] . "&l1=tasks");
                    else
                        header('Location: ../r&d.php?a=' . $_SESSION['new-taskpr']['fields']['assignmentid'] . "&options&l1=edit&l2=tasks");
                }
                else
                    header('Location: ../r&d.php?t=' . $presetID . '&l1=overview');
                unset($_SESSION['new-taskpr']);
                unset($_SESSION['edit-assignmentpr']);
                exit();
            }

            if (empty($_SESSION['new-taskpr']['info']['name'])) $_SESSION['new-taskpr']['stage'] = '2';
            elseif (empty($_SESSION['new-taskpr']['info']['infopage'])) $_SESSION['new-taskpr']['stage'] = '3';
            elseif (empty($_SESSION['new-taskpr']['info']['time'])) $_SESSION['new-taskpr']['stage'] = '4';
            elseif (empty($_SESSION['new-taskpr']['info']['description'])) $_SESSION['new-taskpr']['stage'] = '5';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-taskpr']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-taskpr']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-taskpr']['stage'] = '3';
        if (isset($_POST['stage4'])) $_SESSION['new-taskpr']['stage'] = '4';
        if (isset($_POST['stage5'])) $_SESSION['new-taskpr']['stage'] = '5';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-taskpr']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-taskpr']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>New Task Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="none">
                    <input type="submit" name="submit" value="NONE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
            </div> <?php
            include_once "../includes/info-bar.php";
            $asgPresets = Assignment::selectPresets();
            $divisions = Assignment::selectDivisions();
            $departments = Assignment::selectDepartments(); ?>
            <form class="search-bar admin">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                       type="text" name="name" class="input-name" placeholder="Enter Assignment Preset Name" required style="width: calc(45% - 8px);">
                <div class="custom-select input-department" style="width: calc(15% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                            name="department" class="input-department" required>
                        <option value="">All Departments</option>
                        <option value="None">None</option> <?php
                        foreach ($departments as $depart) { ?>
                            <option value="<?php echo $depart['title']; ?>"><?php echo $depart['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
                <div class="custom-select input-division" style="width: calc(15% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                            name="division" class="input-division" required>
                        <option value="">All Divisions</option>
                        <option value="None">None</option> <?php
                        foreach ($divisions as $division) { ?>
                            <option value="<?php echo $division['title']; ?>"><?php echo $division['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
            </form>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 45%">Assignment Preset Name</div>
                    <div class="head admin" style="width: 15%">Department</div>
                    <div class="head admin" style="width: 15%">Division</div>
                    <div class="head admin tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                    <div class="head admin" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            if (is_array($asgPresets) && count($asgPresets) > 0) { ?>
                <div class="table admin"> <?php
                    foreach ($asgPresets as $preset) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                            <div class="cell name" style="width: 45%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                            <div class="cell department" style="width: 15%"><input type="submit" name="submit" value="<?php echo $preset['depart_title']; ?>" class="content"></div>
                            <div class="cell division" style="width: 15%"><input type="submit" name="submit" value="<?php echo $preset['div_title']; ?>" class="content"></div>
                            <div class="cell tasks" style="width: 10%"><input type="submit" name="submit" value="<?php echo $preset['task_count']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="asg" value="<?php echo $preset['id']; ?>">
                            <input type="hidden" name="asg-title" value="<?php echo $preset['title']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO PRESETS</div> <?php
            }
        }
        elseif ($_SESSION['new-taskpr']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>New Task Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="name" name="name" method="post" class="container-button">
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
                    <div class="head admin">Task Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="name" name="name" id="name" class="field admin" placeholder="Enter Task Name Here" value="<?php if (isset($_SESSION['new-taskpr']['fields']['name'])) echo htmlspecialchars($_SESSION['new-taskpr']['fields']['name']); ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }
        elseif ($_SESSION['new-taskpr']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>New Task Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="none">
                    <input type="submit" name="submit" value="NONE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
            </div> <?php
            include_once "../includes/info-bar.php";
            $presetInfoPages = Database::selectInfoPagePresets();
            $groups = Database::selectInfoPageGroups(); ?>
            <form class="search-bar admin">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                       type="text" name="name" class="input-name" placeholder="Enter Preset Name" required style="width: calc(20% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                       type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(50% - 8px);">
                <div class="custom-select input-group" style="width: calc(15% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'}, this)"
                            name="group" class="input-group" required>
                        <option value="">All Groups</option>
                        <option value="None">None</option> <?php
                        foreach ($groups as $group) { ?>
                            <option value="<?php echo $group['title']; ?>"><?php echo $group['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
            </form>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Project Link Preset Name</div>
                    <div class="head admin" style="width: 50%">Description</div>
                    <div class="head admin" style="width: 15%">Group</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            if (is_array($presetInfoPages) && count($presetInfoPages) > 0) { ?>
                <div class="table admin"> <?php
                    foreach ($presetInfoPages as $preset) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                            <div class="cell description" style="width: 50%"><input type="submit" name="submit" value="<?php echo $preset['description']; ?>" class="content"></div>
                            <div class="cell group" style="width: 15%"><input type="submit" name="submit" value="<?php echo $preset['group']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="info" value="<?php echo $preset['id']; ?>">
                            <input type="hidden" name="info-title" value="<?php echo $preset['title']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO PROJECT LINK PRESETS</div> <?php
            }
        }
        elseif ($_SESSION['new-taskpr']['stage'] == '4') { ?>
            <div class="head-up-display-bar">
                <span>New Task Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
                <form id="time" name="time" method="post" class="container-button">
                    <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension small admin"></div>
                <div class="header small">
                    <div class="head admin">Task Time</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <form class="row">
                    <input form="time" name="sec" type="number" min="10" max="7200" placeholder="Seconds" class="field admin" value="<?php if (isset($_SESSION['new-taskpr']['info']['time-sec'])) echo $_SESSION['new-taskpr']['info']['time-sec']; else echo "10"; ?>">
                </form>
            </div> <?php
        }
        elseif ($_SESSION['new-taskpr']['stage'] == '5') { ?>
            <div class="head-up-display-bar">
                <span>New Task Preset</span>
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
                <div class="header-extension large admin"></div>
                <div class="header large">
                    <div class="head admin">Task Description</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="test" name="description" id="description" class="field admin" placeholder="Enter Task Description Here" value="<?php if (isset($_SESSION['new-taskpr']['fields']['description'])) echo htmlspecialchars($_SESSION['new-taskpr']['fields']['description']); ?>">
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