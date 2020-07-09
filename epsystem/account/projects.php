<?php
ob_start();
$page = "projects";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    // Link for exit button
    if (!isset($_GET['p']))
        $_SESSION['backPage'] = $_SERVER['REQUEST_URI'];
    else
        $_SESSION['backPage2'] = $_SERVER['REQUEST_URI'];

    require_once "includes/header.php"; ?>

    <div class="menu"> <?php
    require "includes/menu.php";
    if (!isset($_GET['p'])) {
        if (isset($_GET['l1']) && $_GET['l1'] == "active") {
            $projects = Project::selectProjectListByStatus(3);
            $floors = Project::selectFloors();
            $presets = Project::selectPresets(); ?>
            <form class="search-bar">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                <div class="custom-select input-floor" style="width: calc(15% - 8px);">
                    <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="floor" class="input-floor" required>
                        <option value="">All Floors</option> <?php
                        foreach ($floors as $floor) { ?>
                            <option value="<?php echo $floor['title']; ?>"><?php echo $floor['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
                <div class="custom-select input-preset" style="width: calc(15% - 8px);">
                    <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="preset" class="input-preset" required>
                        <option value="">All Presets</option> <?php
                        foreach ($presets as $preset) { ?>
                            <option value="<?php echo $preset['title']; ?>"><?php echo $preset['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
            </form>
            <div class="table-header-container">
                <div class="header-extension"></div>
                <div class="header">
                    <div class="head" style="width: 7.5%">№</div>
                    <div class="head" style="width: 20%">Project Name</div>
                    <div class="head" style="width: 15%">Floor</div>
                    <div class="head" style="width: 15%">Preset</div>
                    <div class="head" style="width: 15%">Tasks</div>
                    <div class="head time" style="width: 10%" onclick="sortTable('.head.time', '.cell.time a')">Time Spent</div>
                    <div class="head value" style="width: 10%" onclick="sortTable('.head.value', '.cell.value a')">Sum</div>
                    <div class="head" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                if ($projects) {
                    foreach ($projects as $row) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a href="<?php echo $_SERVER['PHP_SELF'] . "?p=" . $row['project_id']; ?>" class="content"><?php echo "#" . sprintf('%04d', $row['project_id']); ?></a></div>
                            <div class="cell name" style="width: 20%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_title']; ?></a></div>
                            <div class="cell floor" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_floor']; ?></a></div>
                            <div class="cell preset" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                            <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['completed_tasks'] . " / " . $row['total_tasks']; ?></a></div>
                            <div class="cell time" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_time']; ?></a></div>
                            <div class="cell value" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_sum']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content open-button">Open</a></div>
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO PROJECTS</div> <?php
                } ?>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "pending") {
            $projects4 = Project::selectProjectListByStatus(4);
            $projects1 = Project::selectProjectListByStatus(1);
            $projects = array_merge((array) $projects4, (array) $projects1);
            $floors = Project::selectFloors();
            $presets = Project::selectPresets(); ?>
            <form class="search-bar">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                <div class="custom-select input-floor" style="width: calc(15% - 8px);">
                    <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="floor" class="input-floor" required>
                        <option value="">All Floors</option> <?php
                        foreach ($floors as $floor) { ?>
                            <option value="<?php echo $floor['title']; ?>"><?php echo $floor['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
                <div class="custom-select input-preset" style="width: calc(15% - 8px);">
                    <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="preset" class="input-preset" required>
                        <option value="">All Presets</option> <?php
                        foreach ($presets as $preset) { ?>
                            <option value="<?php echo $preset['title']; ?>"><?php echo $preset['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
            </form>
            <div class="table-header-container">
                <div class="header-extension"></div>
                <div class="header">
                    <div class="head" style="width: 7.5%">№</div>
                    <div class="head" style="width: 20%">Project Name</div>
                    <div class="head" style="width: 15%">Floor</div>
                    <div class="head" style="width: 15%">Preset</div>
                    <div class="head" style="width: 15%">Pending Reason</div>
                    <div class="head time" style="width: 10%" onclick="sortTable('.head.time', '.cell.time a')">Time Spent</div>
                    <div class="head value" style="width: 10%" onclick="sortTable('.head.value', '.cell.value a')">Sum</div>
                    <div class="head" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                if ($projects) {
                    foreach ($projects as $row) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo "#" . sprintf('%04d', $row['project_id']); ?></a></div>
                            <div class="cell name" style="width: 20%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_title']; ?></a></div>
                            <div class="cell floor" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_floor']; ?></a></div>
                            <div class="cell preset" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                            <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['note']; ?></a></div>
                            <div class="cell time" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_time']; ?></a></div>
                            <div class="cell value" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_sum']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content open-button">Open</a></div>
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO PROJECTS</div> <?php
                } ?>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "completed") {
            $projects = Project::selectProjectListByStatus(5);
            $floors = Project::selectFloors();
            $presets = Project::selectPresets(); ?>
            <form class="search-bar">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                <div class="custom-select input-floor" style="width: calc(15% - 8px);">
                    <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="floor" class="input-floor" required>
                        <option value="">All Floors</option> <?php
                        foreach ($floors as $floor) { ?>
                            <option value="<?php echo $floor['title']; ?>"><?php echo $floor['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
                <div class="custom-select input-preset" style="width: calc(15% - 8px);">
                    <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="preset" class="input-preset" required>
                        <option value="">All Presets</option> <?php
                        foreach ($presets as $preset) { ?>
                            <option value="<?php echo $preset['title']; ?>"><?php echo $preset['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
            </form>
            <div class="table-header-container">
                <div class="header-extension"></div>
                <div class="header">
                    <div class="head" style="width: 7.5%">№</div>
                    <div class="head" style="width: 20%">Project Name</div>
                    <div class="head" style="width: 15%">Floor</div>
                    <div class="head" style="width: 15%">Preset</div>
                    <div class="head" style="width: 15%">Finish Date</div>
                    <div class="head time" style="width: 10%" onclick="sortTable('.head.time', '.cell.time a')">Time Spent</div>
                    <div class="head value" style="width: 10%" onclick="sortTable('.head.value', '.cell.value a')">Sum</div>
                    <div class="head" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                if ($projects) {
                    foreach ($projects as $row) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo "#" . sprintf('%04d', $row['project_id']); ?></a></div>
                            <div class="cell title" style="width: 20%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_title']; ?></a></div>
                            <div class="cell floor" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_floor']; ?></a></div>
                            <div class="cell preset" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                            <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['date']; ?></a></div>
                            <div class="cell time" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_time']; ?></a></div>
                            <div class="cell value" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_sum']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content open-button">Open</a></div>
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO PROJECTS</div> <?php
                } ?>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "canceled") {
            $projects = Project::selectProjectListByStatus(6);
            $floors = Project::selectFloors();
            $presets = Project::selectPresets(); ?>
            <form class="search-bar">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                <div class="custom-select input-floor" style="width: calc(15% - 8px);">
                    <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="floor" class="input-floor" required>
                        <option value="">All Floors</option> <?php
                        foreach ($floors as $floor) { ?>
                            <option value="<?php echo $floor['title']; ?>"><?php echo $floor['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
                <div class="custom-select input-preset" style="width: calc(15% - 8px);">
                    <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="preset" class="input-preset" required>
                        <option value="">All Presets</option> <?php
                        foreach ($presets as $preset) { ?>
                            <option value="<?php echo $preset['title']; ?>"><?php echo $preset['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
            </form>
            <div class="table-header-container">
                <div class="header-extension"></div>
                <div class="header">
                    <div class="head" style="width: 7.5%">№</div>
                    <div class="head" style="width: 20%">Project Name</div>
                    <div class="head" style="width: 15%">Floor</div>
                    <div class="head" style="width: 15%">Preset</div>
                    <div class="head" style="width: 15%">Cancellation Reason</div>
                    <div class="head time" style="width: 10%" onclick="sortTable('.head.time', '.cell.time a')">Time Spent</div>
                    <div class="head value" style="width: 10%" onclick="sortTable('.head.value', '.cell.value a')">Sum</div>
                    <div class="head" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                if ($projects) {
                    foreach ($projects as $row) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo "#" . sprintf('%04d', $row['project_id']); ?></a></div>
                            <div class="cell title" style="width: 20%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_title']; ?></a></div>
                            <div class="cell floor" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_floor']; ?></a></div>
                            <div class="cell preset" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                            <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['note']; ?></a></div>
                            <div class="cell time" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_time']; ?></a></div>
                            <div class="cell value" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_sum']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content open-button">Open</a></div>
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO PROJECTS</div> <?php
                } ?>
            </div> <?php
        }
        else { ?>
            </div> <?php
        }
    }
    else {
        if (isset($_GET['l1']) && $_GET['l1'] == "project") {
            if (isset($_GET['l2']) && $_GET['l2'] == "overview") { ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "client") {
                if (isset($project) && !$project['client']) {

                    if (!isset($_SESSION['add-client']))
                        $_SESSION['add-client']['stage'] = 1;

                    if (isset($_POST['submit'])) {
                        if ($_SESSION['add-client']['stage'] == 1) {
                            $_SESSION['add-client']['stage'] = 2;
                        }
                        elseif ($_SESSION['add-client']['stage'] == 2) {
                            if (isset($_POST['new-client']))
                                $_SESSION['add-client']['new-client'] = true;
                            else {
                                if (isset($_POST['username'])) {
                                    $fieldsClient = [
                                        'username' => $_POST['username'],
                                        'type' => 2,
                                        'reg_time' => date("Y-m-d H-i-s")
                                    ];
                                    $clientID = Project::insert('account', $fieldsClient, true, null);
                                    $_POST['client'] = $clientID;
                                }
                                if (isset($_POST['client'])) {
                                    $fields = ["clientid" => $_POST['client']];
                                    Project::update('project', $project['project_id'], $fields, $_SERVER['REQUEST_URI']);
                                    unset($_SESSION['add-client']);
                                }
                            }
                        }
                    }
                    if (isset($_SESSION['add-client']['stage'])) {
                        if ($_SESSION['add-client']['stage'] == 1) { ?>
                            <div class="navbar level-3">
                                <form class="container-button disabled">
                                    <a class="button admin-menu disabled"></a>
                                </form>
                                <form method="post" class="container-button">
                                    <input type="submit" name="submit" value="Add Client" class="button admin-menu">
                                </form>
                                <form class="container-button disabled">
                                    <a class="button admin-menu disabled"></a>
                                </form>
                            </div>
                            </div> <?php
                        }
                        elseif ($_SESSION['add-client']['stage'] == 2) {
                            if (!isset($_SESSION['add-client']['new-client'])) { ?>
                                <div class="navbar level-3">
                                    <form class="container-button disabled">
                                        <a class="button admin-menu disabled"></a>
                                    </form>
                                    <form method="post" class="container-button">
                                        <input type="hidden" name="new-client">
                                        <input type="submit" name="submit" value="+ New Client" class="button admin-menu">
                                    </form>
                                    <form class="container-button disabled">
                                        <a class="button admin-menu disabled"></a>
                                    </form>
                                </div>
                                <div class="info-bar">
                                </div>
                                <div class="table-header-container">
                                    <div class="header-extension admin"></div>
                                    <div class="header">
                                        <div class="head admin id" style="width: 7.5%">№</div>
                                        <div class="head admin" style="width: 60%">Client Name</div>
                                        <div class="head admin" style="width: 10%">Projects</div>
                                        <div class="head admin" style="width: 15%">Reg. Date</div>
                                        <div class="head admin" style="width: 7.5%">Add</div>
                                    </div>
                                    <div class="header-extension admin"></div>
                                </div>
                                </div>
                                <div class="table admin"> <?php
                                    $clients = Project::selectClients();
                                    foreach ($clients as $client) { ?>
                                        <form method="post" class="row">
                                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $client['id']); ?>" class="content"></div>
                                            <div class="cell" style="width: 60%"><input type="submit" name="submit" value="<?php echo $client['username']; ?>" class="content"></div>
                                            <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $client['project_count']; ?>" class="content"></div>
                                            <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo $client['reg_time_date']; ?>" class="content"></div>
                                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                                            <input type="hidden" name="client" value="<?php echo $client['id']; ?>">
                                        </form> <?php
                                    } ?>
                                </div> <?php
                            }
                            else { ?>
                                <div class="navbar level-3">
                                    <form class="container-button disabled">
                                        <a class="button admin-menu disabled"></a>
                                    </form>
                                    <form id="test2" name="test2" method="post" class="container-button">
                                        <input type="submit" name="submit" value="Save" class="button admin-menu">
                                    </form>
                                    <form class="container-button disabled">
                                        <a class="button admin-menu disabled"></a>
                                    </form>
                                </div>
                                <div class="info-bar">
                                </div>
                                <div class="table-header-container">
                                    <div class="header-extension small admin"></div>
                                    <div class="header small">
                                        <div class="head admin">Client Username</div>
                                    </div>
                                    <div class="header-extension small admin"></div>
                                </div>
                                </div>
                                <div class="table small">
                                    <div class="row">
                                        <input form="test2" name="username" id="username" class="field admin" placeholder="Enter Client Username">
                                    </div>
                                </div> <?php
                            }
                        }
                    }
                }
                else { ?>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "options") {
                if (isset($_POST['delete'])) {
                    Project::remove('project', $_GET['p'], "projects.php?l1=active");
                } ?>

                <div class="navbar level-3">
                    <form method="post" class="container-button">
                        <input type="hidden" name="re-assign">
                        <input type="submit" name="submit" value="RE-ASSIGN" class="button">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="edit">
                        <input type="submit" name="submit" value="EDIT" class="button">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="pause">
                        <input type="submit" name="submit" value="PAUSE" class="button">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="cancel">
                        <input type="submit" name="submit" value="CANCEL" class="button">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="delete">
                        <input type="submit" name="submit" value="DELETE" class="button">
                    </form>
                </div>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "assignments") {
            if (isset($_GET['l2']) && !isset($groupView) || (isset($groupView)) && isset($_GET['l3'])) {
                if (!isset($groupView))
                    $assignments = Assignment::selectProjectAssignmentsByDivision($_GET['p'], $_GET['l2']);
                else
                    $assignments = Assignment::selectProjectAssignmentsByDivision($_GET['p'], $_GET['l3']); ?>

                <form class="search-bar">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-status .input-status':'.cell.status'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-status .input-status':'.cell.status'})"
                           type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(35% - 8px);">
                    <div class="custom-select input-status" style="width: calc(15% - 8px);">
                        <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-status .input-status':'.cell.status'}, this)"
                                name="preset" class="input-status" required>
                            <option value="">All Statuses</option>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 35%">Assignment Name</div>
                        <div class="head" style="width: 15%">Status</div>
                        <div class="head" style="width: 15%">Tasks</div>
                        <div class="head" style="width: 10%">Time</div>
                        <div class="head" style="width: 10%">Earn</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($assignments) {
                        foreach ($assignments as $row) { ?>
                            <div class="row">
                                <?php $link = "assignments.php?a=" . $row['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $row['assignment_id']); ?></a></div>
                                <div class="cell name" style="width: 35%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['assignment_title']; ?></a></div>
                                <div class="cell status" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['status']; ?></a></div>
                                <div class="cell" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo "?"; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo "?"; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo "?"; ?></span></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "info") {
            if (isset($_GET['l2']) && $_GET['l2'] == "product") { ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "style") { ?>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        else { ?>
            </div> <?php
        }
    }

    require_once "includes/footer.php";

}
else require_once "login.php";