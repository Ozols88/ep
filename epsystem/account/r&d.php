<?php
$page = "r&d";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    // Link for exit button
    if (isset($_GET['f']))
        $_SESSION['backPageR&D']['1'] = $_SERVER['REQUEST_URI'];
    elseif (isset($_GET['p']))
        $_SESSION['backPageR&D']['2a'] = $_SERVER['REQUEST_URI'];
    elseif (isset($_GET['a']) && isset($_SESSION['backPageR&D']['2a']))
        $_SESSION['backPageR&D']['3a'] = $_SERVER['REQUEST_URI'];
    elseif (isset($_GET['a']) && !isset($_SESSION['backPageR&D']['2a']))
        $_SESSION['backPageR&D']['2b'] = $_SERVER['REQUEST_URI'];

    require_once "includes/header.php"; ?>

    <div class="menu"> <?php
    require "includes/menu.php";
    if (isset($_GET['f'])) {
        if (isset($_GET['l1']) && $_GET['l1'] == "presets") {
            if (isset($_GET['l2']) && $_GET['l2'] == "edit") {
                if (isset($_GET['l3']) && $_GET['l3'] == "project") {
                    $presets = Project::selectPresetsByFloorID($_GET['f']); ?>
                    <form class="search-bar">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                               type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                               type="text" name="name" class="input-name" placeholder="Enter Preset Name" required style="width: calc(35% - 8px);">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                               type="text" name="description" class="input-description" placeholder="Enter Preset Description" required style="width: calc(50% - 8px);">
                    </form>
                    <div class="table-header-container">
                        <div class="header-extension"></div>
                        <div class="header">
                            <div class="head" style="width: 7.5%">№</div>
                            <div class="head" style="width: 35%">Preset Name</div>
                            <div class="head" style="width: 50%">Description</div>
                            <div class="head" style="width: 7.5%">Open</div>
                        </div>
                        <div class="header-extension"></div>
                    </div>
                    </div>
                    <div class="table"> <?php
                        if ($presets) {
                            foreach ($presets as $preset) { ?>
                                <div class="row">
                                    <div class="cell id" style="width: 7.5%"><a href="?p=<?php echo $preset['id']; ?>" class="content"><?php echo "#" . sprintf('%03d', $preset['id']); ?></a></div>
                                    <div class="cell name" style="width: 35%"><a href="?p=<?php echo $preset['id']; ?>" class="content"><?php echo $preset['title']; ?></a></div>
                                    <div class="cell description" style="width: 50%"><a href="?p=<?php echo $preset['id']; ?>" class="content"><?php echo $preset['description']; ?></a></div>
                                    <div class="cell" style="width: 7.5%"><a href="?p=<?php echo $preset['id']; ?>" class="content open-button">Open</a></div>
                                </div> <?php
                            }
                        }
                        else { ?>
                            <div class="empty-table">NO PRESETS</div> <?php
                        } ?>
                    </div> <?php
                }
                elseif (isset($_GET['l3']) && $_GET['l3'] == "assignment") {
                    $presets = Assignment::selectAssignmentPresetsByFloor($_GET['f']);
                    $divisions = Assignment::selectAllDivisions(); ?>
                    <form class="search-bar">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="name" class="input-name" placeholder="Enter Preset Name" required style="width: calc(20% - 8px);">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="objective" class="input-objective" placeholder="Enter Objective" required style="width: calc(35% - 8px);">
                        <div class="custom-select input-division" style="width: calc(20% - 8px);">
                            <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                    name="division" class="input-division" required>
                                <option value="">All Divisions</option> <?php
                                foreach ($divisions as $division) { ?>
                                    <option value="<?php echo $division['title']; ?>"><?php echo $division['title']; ?></option> <?php
                                } ?>
                            </select>
                        </div>
                    </form>
                    <div class="table-header-container">
                        <div class="header-extension"></div>
                        <div class="header">
                            <div class="head" style="width: 7.5%">№</div>
                            <div class="head" style="width: 20%">Preset Name</div>
                            <div class="head" style="width: 35%">Objective</div>
                            <div class="head" style="width: 20%">Division</div>
                            <div class="head" style="width: 10%">Tasks</div>
                            <div class="head" style="width: 7.5%">Open</div>
                        </div>
                        <div class="header-extension"></div>
                    </div>
                    </div>
                    <div class="table"> <?php
                        if ($presets) {
                            foreach ($presets as $preset) { ?>
                                <div class="row">
                                    <div class="cell id" style="width: 7.5%"><a href="?a=<?php echo $preset['id']; ?>" class="content"><?php echo "#" . sprintf('%03d', $preset['id']); ?></a></div>
                                    <div class="cell name" style="width: 20%"><a href="?a=<?php echo $preset['id']; ?>" class="content"><?php echo $preset['title']; ?></a></div>
                                    <div class="cell objective" style="width: 35%"><a href="?a=<?php echo $preset['id']; ?>" class="content"><?php echo $preset['objective']; ?></a></div>
                                    <div class="cell division" style="width: 20%"><a href="?a=<?php echo $preset['id']; ?>" class="content"><?php echo $preset['div_title']; ?></a></div>
                                    <div class="cell" style="width: 10%"><a href="?a=<?php echo $preset['id']; ?>" class="content"><?php echo $preset['task_count']; ?></a></div>
                                    <div class="cell" style="width: 7.5%"><a href="?a=<?php echo $preset['id']; ?>" class="content open-button">Open</a></div>
                                </div> <?php
                            }
                        }
                        else { ?>
                            <div class="empty-table">NO PRESETS</div> <?php
                        } ?>
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
        else { ?>
            </div> <?php
        }
    }
    elseif (isset($_GET['p'])) {
        if (isset($_GET['l1']) && $_GET['l1'] == "assignments") {
            $divisions = Assignment::selectAllDivisions(); ?>
            <form class="search-bar">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                       type="text" name="name" class="input-name" placeholder="Enter Preset Name" required style="width: calc(20% - 8px);">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                       type="text" name="objective" class="input-objective" placeholder="Enter Objective" required style="width: calc(35% - 8px);">
                <div class="custom-select input-division" style="width: calc(20% - 8px);">
                    <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                            name="division" class="input-division" required>
                        <option value="">All Divisions</option> <?php
                        foreach ($divisions as $division) { ?>
                            <option value="<?php echo $division['title']; ?>"><?php echo $division['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
            </form>
            <div class="table-header-container">
                <div class="header-extension"></div>
                <div class="header">
                    <div class="head" style="width: 7.5%">№</div>
                    <div class="head" style="width: 20%">Preset Name</div>
                    <div class="head" style="width: 35%">Objective</div>
                    <div class="head" style="width: 20%">Division</div>
                    <div class="head" style="width: 10%">Tasks</div>
                    <div class="head" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                $assignments = Assignment::selectAssignmentPresetsByProjectPreset($_GET['p']);
                if ($assignments) {
                    foreach ($assignments as $asg) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a href="?a=<?php echo $asg['assignmentid']; ?>" class="content"><?php echo "#" . sprintf('%03d', $asg['assignmentid']); ?></a></div>
                            <div class="cell name" style="width: 20%"><a href="?a=<?php echo $asg['assignmentid']; ?>" class="content"><?php echo $asg['title']; ?></a></div>
                            <div class="cell objective" style="width: 35%"><a href="?a=<?php echo $asg['assignmentid']; ?>" class="content"><?php echo $asg['objective']; ?></a></div>
                            <div class="cell division" style="width: 20%"><a href="?a=<?php echo $asg['assignmentid']; ?>" class="content"><?php echo $asg['div_title']; ?></a></div>
                            <div class="cell" style="width: 10%"><a href="?a=<?php echo $asg['assignmentid']; ?>" class="content"><?php echo $asg['task_count']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="?a=<?php echo $asg['assignmentid']; ?>" class="content open-button">Open</a></div>
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO ASSIGNMENTS</div> <?php
                } ?>
            </div> <?php
        }
        if (isset($_GET['l1']) && $_GET['l1'] == "options") {
            if (isset($_POST['submit'])) {
                if (isset($_POST['delete']))
                    Project::remove('preset-project', $_GET['p'], "r&d.php?f=" . Project::selectPresetByID($_GET['p'])['floorid'] . "&l1=presets&l2=edit&l3=project");
            } ?>

            <div class="navbar level-2 unselected"> <?php
                if (true) { ?>
                    <form method="post" class="container-button">
                        <input type="hidden" name="delete">
                        <input type="submit" name="submit" value="Remove" class="button">
                    </form> <?php
                } ?>
            </div>
            </div> <?php
        }
        else { ?>
            </div> <?php
        }
    }
    elseif (isset($_GET['a'])) {
        if (isset($_GET['l1']) && $_GET['l1'] == "tasks") {
            $actions = Task::selectActions(); ?>
            <form class="search-bar">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-action .input-action':'.cell.action'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-action .input-action':'.cell.action'})"
                       type="text" name="objective" class="input-objective" placeholder="Enter Objective" required style="width: calc(60% - 8px);">
                <div class="custom-select input-action" style="width: calc(25% - 8px);">
                    <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-action .input-action':'.cell.action'}, this)"
                            name="action" class="input-action" required>
                        <option value="">All Actions</option> <?php
                        foreach ($actions as $action) { ?>
                            <option value="<?php echo $action['title']; ?>"><?php echo $action['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
            </form>
            <div class="table-header-container">
                <div class="header-extension"></div>
                <div class="header">
                    <div class="head" style="width: 7.5%">№</div>
                    <div class="head" style="width: 60%">Task Objective</div>
                    <div class="head" style="width: 25%">Action</div>
                    <div class="head" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                $tasks = Task::selectAssignmentPresetTasks($_GET['a']);
                if ($tasks) {
                    foreach ($tasks as $task) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a href="?t=<?php echo $task['id']; ?>" class="content"><?php echo "#" . sprintf('%05d', $task['id']); ?></a></div>
                            <div class="cell objective" style="width: 60%"><a href="?t=<?php echo $task['id']; ?>" class="content"><?php echo $task['objective']; ?></a></div>
                            <div class="cell action" style="width: 25%"><a href="?t=<?php echo $task['id']; ?>" class="content"><?php echo $task['action']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="?t=<?php echo $task['id']; ?>" class="content open-button">Open</a></div>
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO TASKS</div> <?php
                } ?>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "options") {
            if (isset($_POST['submit'])) {
                if (isset($_POST['delete']))
                    Assignment::remove('preset-assignment', $_GET['a'], "r&d.php?f=" . Assignment::selectPresetByID($_GET['a'])['floorid'] . "&l1=presets&l2=edit&l3=assignment");
            } ?>

            <div class="navbar level-2 unselected"> <?php
                if (true) { ?>
                    <form method="post" class="container-button">
                        <input type="hidden" name="delete">
                        <input type="submit" name="submit" value="Remove" class="button">
                    </form> <?php
                } ?>
            </div>
            </div> <?php
        }
        else { ?>
            </div> <?php
        }
    }
    elseif (isset($_GET['t'])) {
        if (isset($_GET['l1']) && $_GET['l1'] == "options") {
            if (isset($_POST['submit'])) {
                if (isset($_POST['delete']))
                    Task::remove('preset-task', $_GET['t'], "r&d.php?a=" . Task::selectTaskPreset($_GET['t'])['preset-assignmentid'] . "&l1=tasks");
            } ?>

            <div class="navbar level-2 unselected"> <?php
                if (true) { ?>
                    <form method="post" class="container-button">
                        <input type="hidden" name="delete">
                        <input type="submit" name="submit" value="Remove" class="button">
                    </form> <?php
                } ?>
            </div>
            </div> <?php
        }
        else { ?>
            </div> <?php
        }
    }

    require_once "includes/footer.php";

} else require_once "login.php";