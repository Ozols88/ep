<?php
$page = "projects";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "includes/header.php";

        if (!isset($_SESSION['new-project'])) {
            $_SESSION['new-project']['stage'] = '1';
            $_SESSION['new-project']['info']['product'] = ""; // Info bar fix
        }

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-project']['stage'] == '1') {
                if (isset($_POST['product'])) {
                    $_SESSION['new-project']['fields']['productid'] = $_POST['product'];
                    $_SESSION['new-project']['info']['product'] = Project::selectProductByID($_POST['product'])['title'];
                    if (strlen($_SESSION['new-project']['info']['product']) > InfobarCharLimit)
                        $_SESSION['new-project']['info']['product'] = substr($_SESSION['new-project']['info']['product'], 0, InfobarCharLimit) . "...";

                    // reset preset
                    unset($_SESSION['new-project']['fields']['presetid']);
                    unset($_SESSION['new-project']['info']['preset']);

                    $_SESSION['new-project']['stage'] = '2';
                    if (!isset($_SESSION['new-project']['info']['preset']))
                        $_SESSION['new-project']['info']['preset'] = ""; // Info bar fix
                }
                else {
                    $_SESSION['new-project']['fields']['productid'] = null;
                    $_SESSION['new-project']['info']['product'] = "None";
                    $_SESSION['new-project']['fields']['presetid'] = null;
                    $_SESSION['new-project']['info']['preset'] = "None";

                    $_SESSION['new-project']['stage'] = '3';
                    if (!isset($_SESSION['new-project']['info']['title']))
                        $_SESSION['new-project']['info']['title'] = ""; // Info bar fix
                }

                // reset assignments if product changed
                unset($_SESSION['new-project']['assignments']);
                unset($_SESSION['new-project']['assignmentPresets']);
            }
            elseif ($_SESSION['new-project']['stage'] == '2') {
                // reset assignment list after this stage
                unset($_SESSION['new-project']['assignments']);
                $_SESSION['num']['new-project'] = 1;

                if (isset($_POST['preset'])) {
                    $_SESSION['new-project']['fields']['presetid'] = $_POST['preset'];
                    $_SESSION['new-project']['info']['preset'] = Project::selectPresetByID($_POST['preset'])['title'];
                    if (strlen($_SESSION['new-project']['info']['preset']) > InfobarCharLimit)
                        $_SESSION['new-project']['info']['preset'] = substr($_SESSION['new-project']['info']['preset'], 0, InfobarCharLimit) . "...";

                    // Select assignment presets
                    $presets = Assignment::selectAssignmentPresetsByProjectPreset($_SESSION['new-project']['fields']['presetid']);
                    if ($presets)
                        foreach ($presets as $preset) {
                            $_SESSION['new-project']['assignments'][$_SESSION['num']['new-project']] = $preset;
                            $_SESSION['new-project']['assignments'][$_SESSION['num']['new-project']]['fields']['title'] = $preset['title'];
                            $_SESSION['new-project']['assignments'][$_SESSION['num']['new-project']]['fields']['presetid'] = $preset['assignmentid'];
                            $_SESSION['new-project']['assignments'][$_SESSION['num']['new-project']]['fields']['divisionid'] = $preset['div_id'];
                            $_SESSION['new-project']['assignments'][$_SESSION['num']['new-project']]['fields']['objective'] = $preset['objective'];
                            $_SESSION['num']['new-project']++;
                        }
                }
                else {
                    $_SESSION['new-project']['fields']['presetid'] = null;
                    $_SESSION['new-project']['info']['preset'] = "None";
                }

                $_SESSION['new-project']['stage'] = '3';
                if (!isset($_SESSION['new-project']['info']['title']))
                    $_SESSION['new-project']['info']['title'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-project']['stage'] == '3') {
                $_SESSION['new-project']['fields']['title'] = $_POST['title'];
                $_SESSION['new-project']['info']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-project']['info']['title']) > InfobarCharLimit)
                    $_SESSION['new-project']['info']['title'] = substr($_SESSION['new-project']['info']['title'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-project']['stage'] = '5';
                if (!isset($_SESSION['new-project']['info']['description']))
                    $_SESSION['new-project']['info']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-project']['stage'] == '4') {
                $_SESSION['new-project']['fields']['description'] = $_POST['description'];
                $_SESSION['new-project']['info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-project']['info']['description']) > InfobarCharLimit)
                    $_SESSION['new-project']['info']['description'] = substr($_SESSION['new-project']['info']['description'], 0, InfobarCharLimit) . "...";

                // Insert to `project` table and save ID of the new record
                $_SESSION['new-project']['fields']['projectid'] = Project::insert('project', $_SESSION['new-project']['fields'], true, false);

                $fieldsStatus = [
                    'projectid' => $_SESSION['new-project']['fields']['projectid'],
                    'statusid' => 6,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "New Project"
                ];

                // Insert to `project_status` table and save ID of the new record
                $statusID = Project::insert('project_status', $fieldsStatus, true, false);
                // Update `project` table record with saved ID status
                Project::update('project', $_SESSION['new-project']['fields']['projectid'], ["statusid" => $statusID], false);

                // Insert assignments
                if (isset($_SESSION['new-project']['assignments'])) {
                    foreach ($_SESSION['new-project']['assignments'] as $assignment) {
                        $assignment['fields']['projectid'] = $_SESSION['new-project']['fields']['projectid'];

                        // Insert to `assignment` table and save ID of the new record
                        $asgID = Assignment::insert('assignment', $assignment['fields'], true, false);

                        $fieldsStatus = [
                            'assignmentid' => $asgID,
                            'statusid' => 1,
                            'time' => date("Y-m-d H-i-s"),
                            'assigned_by' => $account->id,
                            'note' => "New Assignment"
                        ];
                        // Insert to `assignment_status` table and save ID of the new record
                        $statusID = Assignment::insert('assignment_status', $fieldsStatus, true, false);
                        // Update `assignment` table record with saved ID status
                        Assignment::update('assignment', $asgID, ["statusid" => $statusID], false);
                    }
                }

                header('Location: projects.php?p=' . $_SESSION['new-project']['fields']['projectid'] . "&l1=assignments&l2=pending");
                unset($_SESSION['new-project']);
                exit();
            }

            if (empty($_SESSION['new-project']['info']['product'])) $_SESSION['new-project']['stage'] = '1';
            elseif (empty($_SESSION['new-project']['info']['preset'])) $_SESSION['new-project']['stage'] = '2';
            elseif (empty($_SESSION['new-project']['info']['title'])) $_SESSION['new-project']['stage'] = '3';
            else $_SESSION['new-project']['stage'] = '4';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-project']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-project']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-project']['stage'] = '3';
        if (isset($_POST['stage4'])) $_SESSION['new-project']['stage'] = '4';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-project']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-project']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>Select a product for the new project</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form method="post" class="container-button">
                    <input type="submit" name="submit" value="NONE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="search-bar">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="name" class="input-name" placeholder="Enter Product Name" required style="width: calc(20% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="description" class="input-description" placeholder="Enter Product Description" required style="width: calc(65% - 8px);">
            </div>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Product Name</div>
                    <div class="head admin" style="width: 65%">Description</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            $products = Project::selectProducts();
            if ($products) { ?>
                <div class="table admin"> <?php
                    foreach ($products as $product) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%02d', $product['id']); ?>" class="content"></div>
                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $product['title']; ?>" class="content"></div>
                            <div class="cell description" style="width: 65%"><input type="submit" name="submit" value="<?php echo $product['description']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="product" value="<?php echo $product['id']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO PRODUCTS</div> <?php
            }
        }
        elseif ($_SESSION['new-project']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>Select a project preset for the new project</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form method="post" class="container-button">
                    <input type="submit" name="submit" value="NONE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="search-bar">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="name" class="input-name" placeholder="Enter Preset Name" required style="width: calc(20% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="description" class="input-description" placeholder="Enter Preset Description" required style="width: calc(50% - 8px);">
            </div>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Preset Name</div>
                    <div class="head admin" style="width: 50%">Description</div>
                    <div class="head admin assignments" style="width: 15%" onclick="sortTable('.head.assignments', '.cell.assignments .content')">Assignments</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            $projectPresets = Project::selectPresetsByProductID($_SESSION['new-project']['fields']['productid']);
            if (is_array($projectPresets)) { ?>
                <div class="table admin"> <?php
                    foreach ($projectPresets as $preset) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                            <div class="cell description" style="width: 50%"><input type="submit" name="submit" value="<?php echo $preset['description']; ?>" class="content"></div>
                            <div class="cell assignments" style="width: 15%"><input type="submit" name="submit" value="<?php echo $preset['assignments']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="preset" value="<?php echo $preset['id']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO PRESETS</div> <?php
            }
        }
        elseif ($_SESSION['new-project']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>Enter the name of the new project</span>
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
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension small admin"></div>
                <div class="header small">
                    <div class="head admin">Project Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="test" name="title" id="title" class="field admin" placeholder="Enter Project Name Here" maxlength="50" value="<?php if (isset($_SESSION['new-project']['fields']['title'])) echo $_SESSION['new-project']['fields']['title']; ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }
        elseif ($_SESSION['new-project']['stage'] == '4') { ?>
            <div class="head-up-display-bar">
                <span>Enter a description of the new project</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="test" name="test" method="post" class="container-button">
                    <input type="submit" name="submit" value="Create Project" class="button admin-menu" maxlength="200">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension large admin"></div>
                <div class="header large">
                    <div class="head admin">Project Description</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="test" name="description" id="description" class="field admin" placeholder="Enter Project Description Here" value="<?php if (isset($_SESSION['new-project']['fields']['description'])) echo $_SESSION['new-project']['fields']['description']; ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }

        require_once "includes/footer.php";

    }
    else
        header('Location: error.php');
}
else require_once "login.php";