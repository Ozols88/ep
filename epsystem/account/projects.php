<?php
ob_start();
$page = "projects";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    // Link for exit button
    if (!isset($_GET['p']))
        $_SESSION['backPage']['1'] = $_SERVER['REQUEST_URI'];
    else
        $_SESSION['backPage']['2'] = $_SERVER['REQUEST_URI'];

    require_once "includes/header.php"; ?>

    <div class="menu"> <?php
    require "includes/menu.php";
    if (!isset($_GET['p'])) {
        if (isset($_GET['l1']) && $_GET['l1'] == "active") {
            $projects = Project::selectProjectListByStatus(4);
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
                    <div class="head" style="width: 15%">Pending Tasks</div>
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
                            <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['pending_tasks']; ?></a></div>
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
            $projects = Project::selectProjectListByStatus(7);
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
            $projects = Project::selectProjectListByStatus(8);
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
        if (isset($_GET['options'])) {
            if (isset($_POST['back'])) {
                if (isset($_GET['l2']))
                    unset($_GET['l2']);
                elseif (isset($_GET['l1']))
                    unset($_GET['l1']);
                $query_string = http_build_query($_GET);
                header('Location: projects.php?' . $query_string);
            }
            elseif (isset($_POST['cancel']) && isset($canCancel) && $canCancel) {
                $fields = [
                    'projectid' => $_GET['p'],
                    'statusid' => 8,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                ];
                if ($_GET['l2'] == "1") $fields['note'] = "Canceled by client";
                if ($_GET['l2'] == "2") $fields['note'] = "Couldn't finish";
                if ($_GET['l2'] == "3") $fields['note'] = "Don't need";

                $statusID = Project::insert('project_status', $fields, true, false);
                $redirect = "projects.php?p=" . $_GET['p'] . "&options";
                Project::update('project', $_GET['p'], ["statusid" => $statusID], false);
                $assignments = Assignment::selectProjectAssignments($_GET['p']);
                // Remove unnecessary(1,2,3) assignments
                foreach ($assignments as $assignment) {
                    if ($assignment['statusid'] == 1 || $assignment['statusid'] == 2 || $assignment['statusid'] == 3)
                        Assignment::remove('assignment', $assignment['id'], false);
                }
                header('Location: ' . $redirect);
            }
            elseif (isset($_POST['complete']) && isset($canComplete) && $canComplete) {
                $fields = [
                    'projectid' => $_GET['p'],
                    'statusid' => 7,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                ];

                $statusID = Project::insert('project_status', $fields, true, false);
                $redirect = "projects.php?p=" . $_GET['p'] . "&options";
                Project::update('project', $_GET['p'], ["statusid" => $statusID], $redirect);
            }
            elseif (isset($_POST['delete'])  && isset($canDelete) && $canDelete) {
                // Delete assignments
                $assignments = Assignment::selectProjectAssignments($_GET['p']);
                foreach ($assignments as $assignment)
                    Assignment::remove('assignment', $assignment['id'], false);
                // Delete project
                Project::remove('project', $_GET['p'], "projects.php?l1=active");
            }

            if (isset($_GET['l1']) && $_GET['l1'] == "cancel") {
                if (!isset($canCancel) || !$canCancel) { ?>
                    <p style="text-align: center">delete sum bad assignments first!</p>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "1") { ?>
                    <div class="navbar level-2">
                        <form method="post" class="container-button">
                            <input type="hidden" name="cancel">
                            <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "2") { ?>
                    <div class="navbar level-2">
                        <form method="post" class="container-button">
                            <input type="hidden" name="cancel">
                            <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "3") { ?>
                    <div class="navbar level-2">
                        <form method="post" class="container-button">
                            <input type="hidden" name="cancel">
                            <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                        </form>
                    </div>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "complete") {
                if (!isset($canComplete) || !$canComplete) { ?>
                    <p style="text-align: center">complete or delete sum bad assignments first!</p>
                    </div> <?php
                }
                else { ?>
                    <div class="navbar level-2">
                        <form method="post" class="container-button">
                            <input type="hidden" name="complete">
                            <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                        </form>
                    </div>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") {
                if (!isset($canDelete) || !$canDelete) { ?>
                    <p style="text-align: center">delete sum bad assignments first!</p>
                    </div> <?php
                }
                else { ?>
                    <div class="navbar level-2">
                        <form method="post" class="container-button">
                            <input type="hidden" name="delete">
                            <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                        </form>
                    </div>
                    </div> <?php
                }
            }
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "project") {
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
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "assignments") {
            if (isset($_GET['l2']) && $_GET['l2'] == "pending") {
                $assignments = Assignment::selectProjectAssignmentsByStatus($_GET['p'], $_GET['l2']); ?>
                <form class="search-bar">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(35% - 8px);">
                    <div class="custom-select input-division" style="width: calc(15% - 8px);">
                        <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="preset" class="input-division" required>
                            <option value="">All Divisions</option>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 35%">Assignment Name</div>
                        <div class="head" style="width: 20%">Division</div>
                        <div class="head" style="width: 10%">Tasks</div>
                        <div class="head" style="width: 20%">Pending Reason</div>
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
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['division']; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['tasks']; ?></a></div>
                                <div class="cell" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['note']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO ASSIGNMENTS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "active") {
                $assignments = Assignment::selectProjectAssignmentsByStatus($_GET['p'], $_GET['l2']); ?>
                <form class="search-bar">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(35% - 8px);">
                    <div class="custom-select input-division" style="width: calc(15% - 8px);">
                        <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="preset" class="input-division" required>
                            <option value="">All Divisions</option>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 35%">Assignment Name</div>
                        <div class="head" style="width: 20%">Division</div>
                        <div class="head" style="width: 10%">Tasks</div>
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
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['division']; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['tasks']; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['time']; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['earn']; ?></span></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO ASSIGNMENTS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "completed") {
                $assignments = Assignment::selectProjectAssignmentsByStatus($_GET['p'], $_GET['l2']); ?>
                <form class="search-bar">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(35% - 8px);">
                    <div class="custom-select input-division" style="width: calc(15% - 8px);">
                        <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="preset" class="input-division" required>
                            <option value="">All Divisions</option>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 35%">Assignment Name</div>
                        <div class="head" style="width: 20%">Division</div>
                        <div class="head" style="width: 10%">Tasks</div>
                        <div class="head" style="width: 20%">Finished</div>
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
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['division']; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['tasks']; ?></a></div>
                                <div class="cell" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['finished']; ?></span></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO ASSIGNMENTS</div> <?php
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