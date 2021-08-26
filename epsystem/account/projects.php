<?php
ob_start();
$page = "projects";
include "includes/autoloader.php";
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
    if (!isset($project)) {
        if (isset($_GET['l1']) && $_GET['l1'] == "pending") {
            $products = Project::selectProducts();
            $presets = Project::selectPresets(); ?>
            <form class="search-bar with-space">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                <div class="custom-select input-product" style="width: calc(15% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="product" class="input-product" required>
                        <option value="">All Products</option>
                        <option value="None">None</option> <?php
                        foreach ($products as $product) { ?>
                            <option value="<?php echo $product['title']; ?>"><?php echo $product['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
                <div class="custom-select input-preset" style="width: calc(25% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="preset" class="input-preset" required>
                        <option value="">All Presets</option>
                        <option value="None">None</option> <?php
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
                    <div class="head" style="width: 15%">Product</div>
                    <div class="head" style="width: 25%">Preset</div>
                    <div class="head tasks" style="width: 15%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Pending Tasks</div>
                    <div class="head time" style="width: 10%" onclick="sortTime('.head.time', '.cell.time .content')">Time Spent</div>
                    <div class="head" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                if (isset($pending)) {
                    foreach ($pending as $row) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo "#" . sprintf('%04d', $row['project_id']); ?></a></div>
                            <div class="cell name" style="width: 20%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_title']; ?></a></div>
                            <div class="cell product" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_product']; ?></a></div>
                            <div class="cell preset" style="width: 25%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                            <div class="cell tasks" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['pending_tasks']; ?></a></div>
                            <div class="cell time" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_time']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content open-button">Open</a></div>
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO PROJECTS</div> <?php
                } ?>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "active") {
            $products = Project::selectProducts();
            $presets = Project::selectPresets(); ?>
            <form class="search-bar with-space">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                <div class="custom-select input-product" style="width: calc(15% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="product" class="input-product" required>
                        <option value="">All Products</option>
                        <option value="None">None</option> <?php
                        foreach ($products as $product) { ?>
                            <option value="<?php echo $product['title']; ?>"><?php echo $product['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
                <div class="custom-select input-preset" style="width: calc(25% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="preset" class="input-preset" required>
                        <option value="">All Presets</option>
                        <option value="None">None</option> <?php
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
                    <div class="head" style="width: 15%">Product</div>
                    <div class="head" style="width: 25%">Preset</div>
                    <div class="head" style="width: 15%">Tasks</div>
                    <div class="head time" style="width: 10%" onclick="sortTime('.head.time', '.cell.time .content')">Time Spent</div>
                    <div class="head" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                if (isset($active)) {
                    foreach ($active as $row) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a href="<?php echo $_SERVER['REQUEST_URI'] . "?p=" . $row['project_id']; ?>" class="content"><?php echo "#" . sprintf('%04d', $row['project_id']); ?></a></div>
                            <div class="cell name" style="width: 20%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_title']; ?></a></div>
                            <div class="cell product" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_product']; ?></a></div>
                            <div class="cell preset" style="width: 25%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                            <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['completed_tasks'] . " / " . $row['total_tasks']; ?></a></div>
                            <div class="cell time" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_time']; ?></a></div>
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
            $products = Project::selectProducts();
            $presets = Project::selectPresets(); ?>
            <form class="search-bar with-space">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                <div class="custom-select input-product" style="width: calc(15% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="product" class="input-product" required>
                        <option value="">All Products</option>
                        <option value="None">None</option> <?php
                        foreach ($products as $product) { ?>
                            <option value="<?php echo $product['title']; ?>"><?php echo $product['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
                <div class="custom-select input-preset" style="width: calc(25% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="preset" class="input-preset" required>
                        <option value="">All Presets</option>
                        <option value="None">None</option> <?php
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
                    <div class="head" style="width: 15%">Product</div>
                    <div class="head" style="width: 25%">Preset</div>
                    <div class="head date" style="width: 15%" onclick="sortDates('.head.date', '.cell.date .content', '.finished')">Completed</div>
                    <div class="head time" style="width: 10%" onclick="sortTime('.head.time', '.cell.time .content')">Time Spent</div>
                    <div class="head" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                if (isset($completed)) {
                    foreach ($completed as $row) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo "#" . sprintf('%04d', $row['project_id']); ?></a></div>
                            <div class="cell name" style="width: 20%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_title']; ?></a></div>
                            <div class="cell product" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_product']; ?></a></div>
                            <div class="cell preset" style="width: 25%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                            <div class="cell date" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['status_time2']; ?></a></div>
                            <div class="cell time" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_time']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content open-button">Open</a></div>
                            <input class="finished" type="hidden" value="<?php echo $row['status_time']; ?>">
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO PROJECTS</div> <?php
                } ?>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "canceled") {
            $products = Project::selectProducts();
            $presets = Project::selectPresets(); ?>
            <form class="search-bar with-space">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'})"
                       type="text" name="name" class="input-name" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                <div class="custom-select input-product" style="width: calc(15% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="product" class="input-product" required>
                        <option value="">All Products</option>
                        <option value="None">None</option> <?php
                        foreach ($products as $product) { ?>
                            <option value="<?php echo $product['title']; ?>"><?php echo $product['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
                <div class="custom-select input-preset" style="width: calc(25% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-preset .input-preset':'.cell.preset'}, this)"
                            name="preset" class="input-preset" required>
                        <option value="">All Presets</option>
                        <option value="None">None</option> <?php
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
                    <div class="head" style="width: 15%">Product</div>
                    <div class="head" style="width: 25%">Preset</div>
                    <div class="head" style="width: 15%">Cancellation Reason</div>
                    <div class="head time" style="width: 10%" onclick="sortTime('.head.time', '.cell.time .content')">Time Spent</div>
                    <div class="head" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                if (isset($canceled)) {
                    foreach ($canceled as $row) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo "#" . sprintf('%04d', $row['project_id']); ?></a></div>
                            <div class="cell name" style="width: 20%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_title']; ?></a></div>
                            <div class="cell product" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_product']; ?></a></div>
                            <div class="cell preset" style="width: 25%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                            <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['note']; ?></a></div>
                            <div class="cell time" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['task_time']; ?></a></div>
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
            elseif (isset($_POST['delete'])  && isset($canDelete) && $canDelete) {
                // Delete assignments
                $assignments = Assignment::selectProjectAssignments($_GET['p']);
                foreach ($assignments as $assignment)
                    Assignment::remove('assignment', $assignment['id'], false);
                // Delete project
                Project::remove('project', $_GET['p'], "projects.php?l1=active");
            }
            elseif ((isset($_POST['cancel1']) || isset($_POST['cancel2']) || isset($_POST['cancel3'])) && isset($canCancel) && $canCancel) {
                $fields = [
                    'projectid' => $_GET['p'],
                    'status1' => 4,
                    'status2' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                ];
                if (isset($_POST['cancel1'])) $fields['note'] = "Canceled by client";
                if (isset($_POST['cancel2'])) $fields['note'] = "Couldn't finish";
                if (isset($_POST['cancel3'])) $fields['note'] = "Other";

                $statusID = Project::insert('status_project', $fields, true, false);
                $redirect = "projects.php?p=" . $_GET['p'] . "&l1=project";
                Project::update('project', $_GET['p'], ["statusid" => $statusID], false);
                $assignments = Assignment::selectProjectAssignments($_GET['p']);
                // Remove unnecessary(1,2,3) assignments
                foreach ($assignments as $assignment) {
                    if ($assignment['status1'] == 1 && $assignment['status2'] != 10 && $assignment['status2'] != 11)
                        Assignment::remove('assignment', $assignment['id'], false);
                }
                header('Location: ' . $redirect);
            }
            elseif (isset($_POST['complete']) && isset($canComplete) && $canComplete) {
                $fields = [
                    'projectid' => $_GET['p'],
                    'status1' => 3,
                    'status2' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                ];

                $statusID = Project::insert('status_project', $fields, true, false);
                $redirect = "projects.php?p=" . $_GET['p'] . "&l1=project";
                Project::update('project', $_GET['p'], ["statusid" => $statusID], $redirect);
            }

            if (isset($_GET['l1']) && $_GET['l1'] == "add") {
                if (isset($_POST['custom'])) {
                    $_SESSION['new-assignment']['stage'] = '1c';
                    $_SESSION['new-assignment']['info']['title'] = "";
                    header('Location: new-assignment.php?p=' . $_GET['p']);
                }
                elseif (isset($_POST['asg'])) {
                    $preset = Assignment::selectPresetByID($_POST['asg']);
                    $_SESSION['new-assignment']['fields']['title'] = $preset['title'];
                    $_SESSION['new-assignment']['fields']['projectid'] = $_GET['p'];
                    $_SESSION['new-assignment']['fields']['presetid'] = $preset['id'];
                    $_SESSION['new-assignment']['fields']['divisionid'] = $preset['divisionid'];
                    $_SESSION['new-assignment']['fields']['objective'] = $preset['objective'];
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

                    Project::projectStatusChanger($project['id'], $account->id);

                    header('Location: projects.php?p=' . $_SESSION['new-assignment']['fields']['projectid'] . '&l1=assignments&l2=pending');
                    unset($_SESSION['new-assignment']);
                    exit();
                } ?>

                <div class="navbar level-2 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="custom">
                        <input type="submit" name="submit" value="+ Custom Assignment" class="button admin-menu">
                    </form>
                </div> <?php
                $divisions = Assignment::selectDivisions();
                $presets = Assignment::selectPresets();
                include_once "includes/info-bar.php"; ?>
                <div class="search-bar admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-objective':'.cell.objective'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-objective':'.cell.objective'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(20% - 8px);">
                    <div class="custom-select input-division" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-objective':'.cell.objective'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option>
                            <option value="Custom">Custom</option> <?php
                            foreach ($divisions as $division) { ?>
                                <option value="<?php echo $division['title']; ?>"><?php echo $division['title']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-objective':'.cell.objective'})"
                           type="text" name="objective" class="input-objective" placeholder="Enter Assignment Objective" required style="width: calc(40% - 8px);">
                </div>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Assignment Preset Name</div>
                        <div class="head admin" style="width: 15%">Division</div>
                        <div class="head admin" style="width: 40%">Objective</div>
                        <div class="head admin tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                        <div class="head admin" style="width: 7.5%">Add</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    foreach ($presets as $preset) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%04d', $preset['id']); ?>" class="content"></div>
                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                            <div class="cell division" style="width: 15%"><input type="submit" name="submit" value="<?php echo $preset['div_title']; ?>" class="content"></div>
                            <div class="cell objective" style="width: 40%"><input type="submit" name="submit" value="<?php echo $preset['objective']; ?>" class="content"></div>
                            <div class="cell tasks" style="width: 10%"><input type="submit" name="submit" value="<?php echo $preset['task_count']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                            <input type="hidden" name="asg" value="<?php echo $preset['id']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                if (isset($_GET['l2']) && $_GET['l2'] == "preset") {
                    if (isset($_POST['preset']))
                        Database::update('project', $_GET['p'], ["presetid" => $_POST['preset'], "productid" => $_POST['preset-product']], "projects.php?p=" . $_GET['p'] . "&options&l1=edit");
                    elseif (isset($_POST['none'])) {
                        Database::update('project', $_GET['p'], ["presetid" => null], false);
                        Database::update('project', $_GET['p'], ["productid" => null], "projects.php?p=" . $_GET['p'] . "&options&l1=edit");
                    }

                    $products = Project::selectProducts(); ?>
                    <div class="navbar level-3 unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="none">
                            <input type="submit" name="submit" value="NONE" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="search-bar admin">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-product .input-product':'.cell.product'})"
                               type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-product .input-product':'.cell.product'})"
                               type="text" name="name" class="input-name" placeholder="Enter Project Preset Name" required style="width: calc(20% - 8px);">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-product .input-product':'.cell.product'})"
                               type="text" name="description" class="input-description" placeholder="Enter Project Preset Description" required style="width: calc(50% - 8px);">
                        <div class="custom-select input-product" style="width: calc(15% - 8px);">
                            <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-product .input-product':'.cell.product'}, this)"
                                    name="product" class="input-product" required>
                                <option value="">All Products</option>
                                <option value="None">None</option> <?php
                                foreach ($products as $product) { ?>
                                    <option value="<?php echo $product['title']; ?>"><?php echo $product['title']; ?></option> <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-header-container">
                        <div class="header-extension admin"></div>
                        <div class="header">
                            <div class="head admin" style="width: 7.5%">№</div>
                            <div class="head admin" style="width: 20%">Project Preset Name</div>
                            <div class="head admin" style="width: 50%">Project Preset Description</div>
                            <div class="head admin" style="width: 15%">Product</div>
                            <div class="head admin" style="width: 7.5%">Select</div>
                        </div>
                        <div class="header-extension admin"></div>
                    </div>
                    </div> <?php
                    $presets = Project::selectPresets();
                    if ($presets) { ?>
                        <div class="table admin"> <?php
                            foreach ($presets as $preset) { ?>
                                <form method="post" class="row">
                                    <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                                    <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                                    <div class="cell description" style="width: 50%"><input type="submit" name="submit" value="<?php echo $preset['description']; ?>" class="content"></div>
                                    <div class="cell product" style="width: 15%"><input type="submit" name="submit" value="<?php echo $preset['product']; ?>" class="content"></div>
                                    <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                                    <input type="hidden" name="preset" value="<?php echo $preset['id']; ?>">
                                    <input type="hidden" name="preset-product" value="<?php echo $preset['productid']; ?>">
                                </form> <?php
                            } ?>
                        </div> <?php
                    }
                    else { ?>
                        <div class="empty-table">NO PROJECT PRESETS</div> <?php
                    }
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "name") {
                    if (isset($_POST['title']))
                        Database::update('project', $_GET['p'], ['title' => $_POST['title']], "projects.php?p=" . $_GET['p'] . "&options&l1=edit"); ?>

                    <div class="navbar level-3 unselected">
                        <form method="post" id="title" class="container-button">
                            <input type="hidden" name="title">
                            <input type="submit" name="submit" value="SAVE" class="button admin-menu">
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
                            <input form="title" name="title" class="field admin" placeholder="Enter Project Name Here" maxlength="50" value="<?php if (isset($project['title'])) echo htmlspecialchars($project['title']); ?>">
                        </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                    if (isset($_POST['description']))
                        Database::update('project', $_GET['p'], ['description' => $_POST['description']], "projects.php?p=" . $_GET['p'] . "&options&l1=edit"); ?>

                    <div class="navbar level-3 unselected">
                        <form method="post" id="description" class="container-button">
                            <input type="hidden" name="description">
                            <input type="submit" name="submit" value="SAVE" class="button admin-menu">
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
                            <input form="description" name="description" class="field admin" placeholder="Enter Project Description Here" maxlength="200" value="<?php if (isset($project['description'])) echo htmlspecialchars($project['description']); ?>">
                        </div>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "actions") {
                if (isset($_GET['l2']) && $_GET['l2'] == "delete") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="delete">
                            <input type="submit" name="submit" value="Confirm Delete" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="Don't Delete" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "cancel") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="cancel1">
                            <input type="submit" name="submit" value="Client Cancel" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="cancel2">
                            <input type="submit" name="submit" value="Can't Finish" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="cancel3">
                            <input type="submit" name="submit" value="Other" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "complete") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="complete">
                            <input type="submit" name="submit" value="Confirm Complete" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="Don't Complete" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                    </div>
                    </div> <?php
                }
            }
        }
        elseif (isset($_GET['ioptions'])) {
            if (isset($_GET['l1']) && $_GET['l1'] == "add") {
                if (isset($_POST['custom'])) {
                    header('Location: new-info.php?p=' . $_GET['p']);
                } ?>

                <div class="navbar level-2 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="custom">
                        <input type="submit" name="submit" value="+ Custom Project Link" class="button admin-menu">
                    </form>
                </div> <?php
                if (isset($_POST['preset'])) {
                    $preset = Database::selectInfoPagePreset($_POST['preset']);
                    $fields = [
                        'projectid' => $_GET['p'],
                        'presetid' => $preset['id'],
                        'title' => $preset['title'],
                        'description' => $preset['description'],
                        'link' => null
                    ];
                    Database::insert('project_infopage', $fields, false, "projects.php?p=" . $_GET['p'] . "&l1=info");
                }

                $presets = Database::selectInfoPagePresets();
                $groups = Database::selectInfoPageGroups(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                           type="text" name="name" class="input-name" placeholder="Enter Project Link Preset Name" required style="width: calc(20% - 8px);">
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
                        <div class="head admin" style="width: 7.5%">Add</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div> <?php
                $infopages = Database::selectInfoPagePresets();
                $projectInfopages = Project::selectProjectInfoPages($_GET['p']);
                if ($infopages && $projectInfopages)
                    foreach ($projectInfopages as $projectInfo) {
                        foreach ($infopages as $presetInfo) {
                            if ($projectInfo['presetid'] == $presetInfo['id'])
                                unset($infopages[$presetInfo['id']]);
                        }
                    }

                if ($infopages) { ?>
                    <div class="table admin"> <?php
                        foreach ($infopages as $infopage) { ?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $infopage['id']); ?>" class="content"></div>
                                <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $infopage['title']; ?>" class="content"></div>
                                <div class="cell description" style="width: 50%"><input type="submit" name="submit" value="<?php echo $infopage['description']; ?>" class="content"></div>
                                <div class="cell group" style="width: 15%"><input type="submit" name="submit" value="<?php echo $infopage['group']; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                                <input type="hidden" name="preset" value="<?php echo $infopage['id']; ?>">
                            </form> <?php
                        } ?>
                    </div> <?php
                }
                else { ?>
                    <div class="empty-table">NO PROJECT LINK PRESETS</div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                if (!isset($_GET['i'])) {
                    $presets = Project::selectProjectInfoPages($_GET['p']);
                    $groups = Database::selectInfoPageGroups(); ?>
                    <form class="search-bar with-space admin">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                               type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                               type="text" name="name" class="input-name" placeholder="Enter Project Link Name" required style="width: calc(20% - 8px);">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                               type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(40% - 8px);">
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
                            <div class="head admin" style="width: 20%">Project Link Name</div>
                            <div class="head admin" style="width: 40%">Description</div>
                            <div class="head admin" style="width: 15%">Group</div>
                            <div class="head admin" style="width: 10%">Link</div>
                            <div class="head admin" style="width: 7.5%">Edit</div>
                        </div>
                        <div class="header-extension admin"></div>
                    </div>
                    </div> <?php
                    if ($presets) { ?>
                        <div class="table admin"> <?php
                            foreach ($presets as $preset) {
                                $link = "projects.php?p=" . $_GET['p'] . "&ioptions&l1=edit&i=" . $preset['id']; ?>
                                <div class="row">
                                    <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%03d', $preset['id']); ?></a></div>
                                    <div class="cell name" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $preset['title']; ?></a></div>
                                    <div class="cell description" style="width: 40%"><a href="<?php echo $link; ?>" class="content"><?php echo $preset['description']; ?></a></div>
                                    <div class="cell group" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $preset['group']; ?></a></div>
                                    <div class="cell" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $preset['hasLink']; ?></a></div>
                                    <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content edit-button">Edit</a></div>
                                </div> <?php
                            } ?>
                        </div> <?php
                    }
                    else { ?>
                        <div class="empty-table">NO PROJECT LINKS</div> <?php
                    }
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "group") {
                    if (isset($_POST['group']))
                        Database::update('project_infopage', $_GET['i'], ["groupid" => $_POST['group']], "projects.php?p=" . $_GET['p'] . "&ioptions&l1=edit&i=" . $_GET['i']);
                    elseif (isset($_POST['none']))
                        Database::update('project_infopage', $_GET['i'], ["groupid" => null], "projects.php?p=" . $_GET['p'] . "&ioptions&l1=edit&i=" . $_GET['i']);

                    $products = Project::selectProducts(); ?>
                    <div class="navbar level-3 unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="none">
                            <input type="submit" name="submit" value="NONE" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="search-bar admin">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                               type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                               type="text" name="name" class="input-name" placeholder="Enter Project Link Group Name" required style="width: calc(20% - 8px);">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                               type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
                    </div>
                    <div class="table-header-container">
                        <div class="header-extension admin"></div>
                        <div class="header">
                            <div class="head admin" style="width: 7.5%">№</div>
                            <div class="head admin" style="width: 20%">Project Link Group Name</div>
                            <div class="head admin" style="width: 65%">Project Link Group Description</div>
                            <div class="head admin" style="width: 7.5%">Select</div>
                        </div>
                        <div class="header-extension admin"></div>
                    </div>
                    </div> <?php
                    $groups = Project::selectInfoPageGroups();
                    if ($groups) { ?>
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
                elseif (isset($_GET['l2']) && $_GET['l2'] == "name") {
                    if (isset($_POST['title']))
                        Database::update('project_infopage', $_GET['i'], ['title' => $_POST['title']], "projects.php?p=" . $_GET['p'] . "&ioptions&l1=edit&i=" . $_GET['i']); ?>

                    <div class="navbar level-3 unselected">
                        <form method="post" id="title" class="container-button">
                            <input type="hidden" name="title">
                            <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="table-header-container">
                        <div class="header-extension small admin"></div>
                        <div class="header small">
                            <div class="head admin">Project Link Name</div>
                        </div>
                        <div class="header-extension small admin"></div>
                    </div>
                    </div>
                    <div class="table small">
                        <div class="row">
                            <input form="title" name="title" class="field admin" placeholder="Enter Project Link Name Here" maxlength="50" value="<?php if (isset($infopage['title'])) echo htmlspecialchars($infopage['title']); ?>">
                        </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "link") {
                    if (isset($_POST['link']))
                        Database::update('project_infopage', $_GET['i'], ['link' => $_POST['link']], "projects.php?p=" . $_GET['p'] . "&ioptions&l1=edit&i=" . $_GET['i']); ?>

                    <div class="navbar level-3 unselected">
                        <form method="post" id="link" class="container-button">
                            <input type="hidden" name="link">
                            <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="table-header-container">
                        <div class="header-extension large admin"></div>
                        <div class="header large">
                            <div class="head admin">Project Link URL</div>
                        </div>
                        <div class="header-extension large admin"></div>
                    </div>
                    </div>
                    <div class="table large">
                        <div class="row">
                            <input form="link" name="link" class="field admin" placeholder="Enter Project Link URL Here" maxlength="255" value="<?php if (isset($infopage['link'])) echo htmlspecialchars($infopage['link']); ?>">
                        </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                    if (isset($_POST['description']))
                        Database::update('project_infopage', $_GET['i'], ['description' => $_POST['description']], "projects.php?p=" . $_GET['p'] . "&ioptions&l1=edit&i=" . $_GET['i']); ?>

                    <div class="navbar level-3 unselected">
                        <form method="post" id="description" class="container-button">
                            <input type="hidden" name="description">
                            <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="table-header-container">
                        <div class="header-extension large admin"></div>
                        <div class="header large">
                            <div class="head admin">Project Link Description</div>
                        </div>
                        <div class="header-extension large admin"></div>
                    </div>
                    </div>
                    <div class="table large">
                        <div class="row">
                            <input form="description" name="description" class="field admin" placeholder="Enter Project Link Description Here" maxlength="200" value="<?php if (isset($infopage['description'])) echo htmlspecialchars($infopage['description']); ?>">
                        </div>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "remove") {
                if (isset($_POST['del-info']))
                    Database::remove('project_infopage', $_POST['del-info'], "projects.php?p=" . $_GET['p'] . "&ioptions&l1=remove");

                $presets = Database::selectInfoPagePresets();
                $groups = Database::selectInfoPageGroups(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                           type="text" name="name" class="input-name" placeholder="Enter Project Link Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(40% - 8px);">
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
                        <div class="head admin" style="width: 20%">Project Link Name</div>
                        <div class="head admin" style="width: 40%">Description</div>
                        <div class="head admin" style="width: 15%">Group</div>
                        <div class="head admin" style="width: 10%">Link</div>
                        <div class="head admin" style="width: 7.5%">Remove</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div> <?php
                $infopages = Project::selectProjectInfoPages($_GET['p']);
                $tasks = Task::selectProjectTasks($_GET['p']);
                if ($infopages) {
                    foreach ($infopages as $infopage) {
                        foreach ($tasks as $task) {
                            if ($infopage['id'] == $task['infoid']) {
                                unset($infopages[$infopage['id']]);
                            }
                        }
                    }
                }
                if ($infopages) { ?>
                    <div class="table admin"> <?php
                        foreach ($infopages as $infopage) { ?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $infopage['id']); ?>" class="content"></div>
                                <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $infopage['title']; ?>" class="content"></div>
                                <div class="cell description" style="width: 40%"><input type="submit" name="submit" value="<?php echo $infopage['description']; ?>" class="content"></div>
                                <div class="cell group" style="width: 15%"><input type="submit" name="submit" value="<?php echo $infopage['group']; ?>" class="content"></div>
                                <div class="cell group" style="width: 10%"><input type="submit" name="submit" value="<?php echo $infopage['hasLink']; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                                <input type="hidden" name="del-info" value="<?php echo $infopage['id']; ?>">
                            </form> <?php
                        } ?>
                    </div> <?php
                }
                else { ?>
                    <div class="empty-table">NO PROJECT LINKS</div> <?php
                }
            }
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "project") {
            if (isset($_GET['l2']) && $_GET['l2'] == "overview") { ?>
                </div>
                <div class="overview-content"> <?php
                $projectData = Project::selectProjectDetails($project['id']);

                $projectHistory = Project::selectProjectHistory($project['id']);
                $created = "-";
                if ($projectHistory && $projectHistory[0]['status1'] == 1)
                    $created = $projectHistory[0]['time2'];

                $assignments = Assignment::selectProjectAssignments($project['id']);
                $members = [];
                if ($assignments) {
                    foreach ($assignments as $assignment) {
                        if ($assignment['assigned_to'] != null)
                            $members[$assignment['assigned_to']] = $assignment['assigned_to'];
                    }
                } ?>

                <div class="info-bar short">
                    <div class="section">
                        <div class="content light"><?php echo "#" . sprintf('%04d', $projectData['id']); ?></div>
                    </div>
                    <div class="section">
                        <div class="stage active">STATUS:</div>
                        <div class="content"><?php echo $projectData['status']; ?></div>
                    </div>
                    <div class="section">
                        <div class="content light"><?php echo $projectData['time2']; ?></div>
                    </div>
                </div>
                <div class="info-bar tiny">
                    <div class="section line-right active">
                        <div class="content"><?php echo $projectData['product']; ?></div>
                    </div>
                    <div class="section">
                        <div class="content"><?php echo $projectData['preset']; ?></div>
                    </div>
                </div>
                <div class="overview">
                    <div class="top">
                        <div class="box">
                            <div class="title"><?php echo $projectData['title']; ?></div>
                            <div class="data"><?php echo $projectData['description']; ?></div>
                        </div>
                    </div>
                    <div class="mid">
                        <div class="box-container">
                            <div class="box">
                                <div class="title"><?php echo $projectData['asgTotal']; ?> ASSIGNMENTS</div>
                                <div class="data">
                                    <div class="total-container">
                                        <span class="number"><?php echo $projectData['asgPending']; ?></span>
                                        <span class="num-data">PENDING</span>
                                    </div>
                                    <div class="total-container">
                                        <span class="number"><?php echo $projectData['asgAvailable']; ?></span>
                                        <span class="num-data">AVAILABLE</span>
                                    </div>
                                    <div class="total-container">
                                        <span class="number"><?php echo $projectData['asgActive']; ?></span>
                                        <span class="num-data">IN PROGRESS</span>
                                    </div>
                                    <div class="total-container">
                                        <span class="number"><?php echo $projectData['asgCompleted']; ?></span>
                                        <span class="num-data">COMPLETED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-container">
                            <div class="box">
                                <span class="title"><?php echo $projectData['tasksTotal']; ?> TASKS</span>
                                <div class="data">
                                    <div class="total-container">
                                        <span class="number"><?php echo $projectData['tasksPending']; ?></span>
                                        <span class="num-data">PENDING</span>
                                    </div>
                                    <div class="total-container">
                                        <span class="number"><?php echo $projectData['tasksActive']; ?></span>
                                        <span class="num-data">IN PROGRESS</span>
                                    </div>
                                    <div class="total-container">
                                        <span class="number"><?php echo $projectData['tasksCompleted']; ?></span>
                                        <span class="num-data">COMPLETED</span>
                                    </div>
                                </div>
                            </div>
                        </div> <?php
                        if ($account->manager == 1) { ?>
                            <div class="box-container">
                                <div class="box">
                                    <span class="title"><?php echo $projectData['links']; ?> PROJECT LINKS</span>
                                    <div class="data">
                                        <div class="total-container">
                                            <span class="number"><?php echo $projectData['link_groups']; ?></span>
                                            <span class="num-data">GROUPS</span>
                                        </div>
                                        <div class="total-container">
                                            <span class="number"><?php echo $projectData['links_nourl']; ?></span>
                                            <span class="num-data">NO URL</span>
                                        </div>
                                    </div>
                                </div>
                            </div> <?php
                        } ?>
                    </div>
                </div>
                <div class="info-bar" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                    <div class="section line-right active">
                        <div class="stage active"><?php echo $projectData['task_time_rem']; ?></div>
                        <div class="content">REMAINING</div>
                    </div>
                    <div class="section">
                        <div class="stage active"><?php echo count($members); ?></div>
                        <div class="content">MEMBERS</div>
                    </div>
                    <div class="section line-left active">
                        <div class="stage active"><?php echo $projectData['task_time_spent']; ?></div>
                        <div class="content">SPENT</div>
                    </div>
                </div>
                <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                    <div class="section">
                        <div class="content light"><?php echo $created; ?></div>
                    </div>
                </div>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "assignments") {
            $divisions = Assignment::selectDivisions(); // For search bar
            if (isset($_GET['l2']) && $_GET['l2'] == "pending") { ?>
                <form class="search-bar with-space">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Objective" required style="width: calc(45% - 8px);">
                    <div class="custom-select input-division" style="width: calc(20% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="preset" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option>
                            <option value="Custom">Custom</option> <?php
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
                        <div class="head" style="width: 45%">Assignment Objective</div>
                        <div class="head" style="width: 20%">Division</div>
                        <div class="head" style="width: 20%">Pending Reason</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if (isset($pending)) {
                        foreach ($pending as $row) { ?>
                            <div class="row">
                                <?php $link = "assignments.php?a=" . $row['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $row['assignment_id']); ?></a></div>
                                <div class="cell name" style="width: 45%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['objective']; ?></a></div>
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['division']; ?></a></div>
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
            elseif (isset($_GET['l2']) && $_GET['l2'] == "active") { ?>
                <form class="search-bar with-space">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Objective" required style="width: calc(45% - 8px);">
                    <div class="custom-select input-division" style="width: calc(20% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="preset" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option>
                            <option value="Custom">Custom</option> <?php
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
                        <div class="head" style="width: 45%">Assignment Objective</div>
                        <div class="head" style="width: 20%">Division</div>
                        <div class="head tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                        <div class="head time" style="width: 10%" onclick="sortTime('.head.time', '.cell.time .content')">Time</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if (isset($active)) {
                        foreach ($active as $row) { ?>
                            <div class="row">
                                <?php $link = "assignments.php?a=" . $row['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $row['assignment_id']); ?></a></div>
                                <div class="cell name" style="width: 45%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['objective']; ?></a></div>
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['division']; ?></a></div>
                                <div class="cell tasks" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['tasks']; ?></a></div>
                                <div class="cell time" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['time']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO ASSIGNMENTS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "completed") { ?>
                <form class="search-bar with-space">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Objective" required style="width: calc(45% - 8px);">
                    <div class="custom-select input-division" style="width: calc(20% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="preset" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option>
                            <option value="Custom">Custom</option> <?php
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
                        <div class="head" style="width: 45%">Assignment Objective</div>
                        <div class="head" style="width: 20%">Division</div>
                        <div class="head date" style="width: 20%" onclick="sortDates('.head.date', '.cell.date .content', '.finished')">Completed</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if (isset($completed)) {
                        foreach ($completed as $row) { ?>
                            <div class="row">
                                <?php $link = "assignments.php?a=" . $row['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $row['assignment_id']); ?></a></div>
                                <div class="cell name" style="width: 45%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['objective']; ?></a></div>
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['division']; ?></a></div>
                                <div class="cell date" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $row['status_time2']; ?></span></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                                <input class="finished" type="hidden" value="<?php echo $row[4]; ?>">
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
        elseif (isset($_GET['l1']) && $_GET['l1'] == "info") { ?>
            </div> <?php
        }
        else { ?>
            </div> <?php
        }
    }

    require_once "includes/footer.php";

}
else require_once "login.php";