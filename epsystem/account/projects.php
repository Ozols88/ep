<?php
ob_start();
$page = "projects";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];

    require_once "includes/header.php";

    if ($account->type == 1) { ?>
        <div class="menu"> <?php
        require "includes/menu.php";
        if (!isset($_GET['p'])) {
            if (isset($_GET['l1']) && $_GET['l1'] == "active") {
                $projects = Project::selectProjectListByStatus(1); ?>
                <form class="search-bar">
                    <input onchange="searchTable()" type="text" name="id" class="input-id" placeholder="Enter №">
                    <input onchange="searchTable()" type="text" name="name" class="input-name" placeholder="Enter Project Name">
                    <div class="custom-select input-division">
                        <select onchange="searchTable()" name="division" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="Animated Video">ep animations</option>
                            <option value="Animated Video">ep system</option>
                        </select>
                    </div>
                    <div class="custom-select input-preset">
                        <select onchange="searchTable()" name="preset" class="input-preset" required>
                            <option value="">All Presets</option>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 20%">Project Name</div>
                        <div class="head" style="width: 15%">Division</div>
                        <div class="head" style="width: 15%">Preset</div>
                        <div class="head" style="width: 15%">Tasks</div>
                        <div class="head" style="width: 10%" onclick="sortTable('.head.time', '.cell.time a')">Time Spent</div>
                        <div class="head" style="width: 10%" onclick="sortTable('.head.value', '.cell.value a')">Value</div>
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
                                <div class="cell division" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo ""; ?></a></div>
                                <div class="cell preset" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                                <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['completed_assignments'] . " / " . $row['total_assignments']; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo "0"; ?> Hours</a></div>
                                <div class="cell" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content">€<span><?php echo $row['price']; ?></span></a></div>
                                <div class="cell" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "pending") {
                $projects = Project::selectProjectListByStatus(2); ?>
                <form class="info-bar">
                    <div class="section">
                        <div class="stage">LAST</div>
                        <button type="button" class="hours-button">12h</button>
                        <button type="button" class="hours-button active">24h</button>
                        <button type="button" class="hours-button">48h</button>
                    </div>
                    <div class="section">
                        <div class="stage">NEW</div>
                        <div class="content active">1</div>
                        <div class="space"></div>
                        <div class="stage">ACTIVATED</div>
                        <div class="content active">1</div>
                        <div class="space"></div>
                        <div class="stage">PAUSED</div>
                        <div class="content active">0</div>
                    </div>
                    <div class="section">
                    </div>
                </form> <?php
                if (!isset($menu) || $menu['level-1']['PENDING']['count'] > 10) { ?>
                    <hr>
                    <form class="search-bar">
                        <div class="section">
                            <input type="text" name="id" class="input-id" placeholder="Enter №">
                            <input type="text" name="project" class="input-name" placeholder="Enter Project Name">
                            <div class="custom-select">
                                <select name="type" class="input-type" required>
                                    <option value="">All</option>
                                    <option value="Animated Video">Animated Video</option>
                                </select>
                            </div>
                            <input type="text" name="client" class="input-client" placeholder="Enter Client Name">
                            <button type="button" onclick="searchTable()" class="search-button"></button>
                        </div>
                        <div class="section">
                            <button type="button" class="filter-button">PRIORITIZE</button>
                            <button type="button" class="filter-button">FILTER OPTION 2</button>
                            <button type="button" class="filter-button">FILTER OPTION 3</button>
                            <button type="button" class="filter-button">FILTER OPTION 4</button>
                        </div>
                        <div class="section">
                            <button type="button" class="reset-button"></button>
                        </div>
                    </form> <?php
                } ?>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 20%">Project Name</div>
                        <div class="head" style="width: 15%">Project Preset</div>
                        <div class="head" style="width: 15%">Client</div>
                        <div class="head" style="width: 15%">Pending Reason</div>
                        <div class="head" style="width: 10%" onclick="sortTable('.head.time', '.cell.time a')">Time Spent</div>
                        <div class="head" style="width: 10%" onclick="sortTable('.head.value', '.cell.value a')">Value</div>
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
                                <div class="cell" style="width: 20%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_title']; ?></a></div>
                                <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                                <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['client_username']; ?></a></div>
                                <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['note']; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo ""; ?> Hours</a></div>
                                <div class="cell" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content">€<span><?php echo $row['price']; ?></span></a></div>
                                <div class="cell" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "completed") {
                $projects = Project::selectProjectListByStatus(3); ?>
                <form class="info-bar">
                    <div class="section">
                        <div class="stage">LAST</div>
                        <button type="button" class="hours-button">12h</button>
                        <button type="button" class="hours-button active">24h</button>
                        <button type="button" class="hours-button">48h</button>
                    </div>
                    <div class="section">
                        <div class="stage">COMPLETED</div>
                        <div class="content active">1</div>
                    </div>
                    <div class="section">
                    </div>
                </form> <?php
                if (!isset($menu) || $menu['level-1']['COMPLETED']['count'] > 10) { ?>
                    <hr>
                    <form class="search-bar">
                        <div class="section">
                            <input type="text" name="id" class="input-id" placeholder="Enter №">
                            <input type="text" name="project" class="input-name" placeholder="Enter Project Name">
                            <div class="custom-select">
                                <select name="type" class="input-type" required>
                                    <option value="">All</option>
                                    <option value="Animated Video">Animated Video</option>
                                </select>
                            </div>
                            <input type="text" name="client" class="input-client" placeholder="Enter Client Name">
                            <button type="button" onclick="searchTable()" class="search-button"></button>
                        </div>
                        <div class="section">
                            <button type="button" class="filter-button">PRIORITIZE</button>
                            <button type="button" class="filter-button">FILTER OPTION 2</button>
                            <button type="button" class="filter-button">FILTER OPTION 3</button>
                            <button type="button" class="filter-button">FILTER OPTION 4</button>
                        </div>
                        <div class="section">
                            <button type="button" class="reset-button"></button>
                        </div>
                    </form> <?php
                } ?>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 20%">Project Name</div>
                        <div class="head" style="width: 15%">Project Preset</div>
                        <div class="head" style="width: 15%">Client</div>
                        <div class="head" style="width: 15%">Finish Date</div>
                        <div class="head" style="width: 10%">Time Spent</div>
                        <div class="head" style="width: 10%" onclick="sortTable('.head.value', '.cell.value a span')">Value</div>
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
                                <div class="cell" style="width: 20%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_title']; ?></a></div>
                                <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                                <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['client_username']; ?></a></div>
                                <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['date']; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo "Hours"; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content">€<span><?php echo $row['price']; ?></span></a></div>
                                <div class="cell" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "canceled") {
                $projects = Project::selectProjectListByStatus(4); ?>
                <form class="info-bar">
                    <div class="section">
                        <div class="stage">LAST</div>
                        <button type="button" class="hours-button">12h</button>
                        <button type="button" class="hours-button active">24h</button>
                        <button type="button" class="hours-button">48h</button>
                    </div>
                    <div class="section">
                        <div class="stage">CANCELED</div>
                        <div class="content active">1</div>
                    </div>
                    <div class="section">
                    </div>
                </form> <?php
                if (!isset($menu) || $menu['level-1']['CANCELED']['count'] > 10) { ?>
                    <hr>
                    <form class="search-bar">
                        <div class="section">
                            <input type="text" name="id" class="input-id" placeholder="Enter №">
                            <input type="text" name="project" class="input-name" placeholder="Enter Project Name">
                            <div class="custom-select">
                                <select name="type" class="input-type" required>
                                    <option value="">All</option>
                                    <option value="Animated Video">Animated Video</option>
                                </select>
                            </div>
                            <input type="text" name="client" class="input-client" placeholder="Enter Client Name">
                            <button type="button" onclick="searchTable()" class="search-button"></button>
                        </div>
                        <div class="section">
                            <button type="button" class="filter-button">PRIORITIZE</button>
                            <button type="button" class="filter-button">FILTER OPTION 2</button>
                            <button type="button" class="filter-button">FILTER OPTION 3</button>
                            <button type="button" class="filter-button">FILTER OPTION 4</button>
                        </div>
                        <div class="section">
                            <button type="button" class="reset-button"></button>
                        </div>
                    </form> <?php
                } ?>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 20%">Project Name</div>
                        <div class="head" style="width: 15%">Project Preset</div>
                        <div class="head" style="width: 15%">Client</div>
                        <div class="head" style="width: 15%">Cancellation Reason</div>
                        <div class="head" style="width: 10%">Time Spent</div>
                        <div class="head" style="width: 10%" onclick="sortTable('.head.value', '.cell.value a span')">Value</div>
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
                                <div class="cell" style="width: 20%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_title']; ?></a></div>
                                <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['project_preset']; ?></a></div>
                                <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['client_username']; ?></a></div>
                                <div class="cell" style="width: 15%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['note']; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content"><?php echo $row['date']; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content">€<span><?php echo $row['price']; ?></span></a></div>
                                <div class="cell" style="width: 7.5%"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        else {
            if (isset($_GET['l4'])) {
                if ($_GET['l4'] == "assignment") {
                    if (isset($_POST['delete'])) {
                        Assignment::remove('assignment', $_GET['l3'], "projects.php?p=" . $_GET['p'] . "&l1=" . $_GET['l1']);
                    } ?>
                    </div>
                    <form method="post" class="decision-bar">
                        <input type="hidden" name="delete">
                        <input type="submit" name="submit" value="DELETE ASSIGNMENT" class="button">
                    </form> <?php
                }
                else {
                    $task = Task::selectTask($_GET['l4']);
                    if ($task) {
                        if (isset($_POST['delete']))
                            Task::remove('task', $_GET['l4'], "projects.php?p=" . $_GET['p'] . "&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $_GET['l3'] . "&l4=assignment"); ?>

                        </div>
                        <div class="info-bar extended">
                            <div class="section">
                                <div class="stage">STATUS:</div>
                                <div class="content"><?php echo $task['status']; ?></div>
                            </div>
                            <div class="section">
                                <div class="stage">ACTION:</div>
                                <div class="content"><?php echo $task['action']; ?></div>
                            </div>
                            <div class="section">
                                <div class="stage">TIME:</div>
                                <div class="content"><?php echo $task['estimated-min']; ?></div>
                            </div>
                        </div>
                        
                        <div class="objective-header">Objective</div>
                        <div class="objective-body">
                            <span class="objective"><?php echo strtoupper($task['objective']); ?></span>
                            <span class="description"><?php echo $task['description']; ?></span>
                        </div>

                        <div class="link-section">
                            <div class="link-type">
                                <div class="link-title">Info</div> <?php
                                $linksInfo = Task::selectTaskLinks($_GET['l4'], 1);
                                foreach ($linksInfo as $link) {
                                    if ($link['link'] != null) {
                                        $link['link'] = "?p=" . $_GET['p'] . $link['link'];
                                        $link['custom'] = "ep system link";
                                    }
                                    else {
                                        $link['link'] = $link['custom-link'];
                                        $link['custom'] = "custom link";
                                    } ?>

                                    <a class="link" href="<?php echo $link['link']; ?>" target="_blank">
                                        <span class="id"><?php echo $link['custom']; ?></span>
                                        <span class="title"><?php echo $link['title']; ?></span>
                                        <span class="description">Find info about the project here</span>
                                    </a> <?php
                                } ?>
                            </div>
                            <div class="link-type">
                                <div class="link-title">Resources</div> <?php
                                $linksRes = Task::selectTaskLinks($_GET['l4'], 2);
                                if ($linksRes)
                                foreach ($linksRes as $link) {
                                    if ($link['link'] != null) {
                                        $link['link'] = "?p=" . $_GET['p'] . $link['link'];
                                        $link['custom'] = "ep system link";
                                    }
                                    else {
                                        $link['link'] = $link['custom-link'];
                                        $link['custom'] = "custom link";
                                    } ?>

                                    <a class="link" href="<?php echo $link['link']; ?>" target="_blank">
                                        <span class="id"><?php echo $link['custom']; ?></span>
                                        <span class="title"><?php echo $link['title']; ?></span>
                                        <span class="description">Upload & download files here</span>
                                    </a> <?php
                                } ?>
                            </div>
                            <div class="link-type">
                                <div class="link-title">Research & Development</div> <?php
                                $linksRnD = Task::selectTaskLinks($_GET['l4'], 3);
                                if ($linksRnD)
                                foreach ($linksRnD as $link) {
                                    if ($link['link'] != null) {
                                        $link['link'] = "?p=" . $_GET['p'] . $link['link'];
                                        $link['custom'] = "ep system link";
                                    }
                                    else {
                                        $link['link'] = $link['custom-link'];
                                        $link['custom'] = "custom link";
                                    } ?>

                                    <a class="link" href="?p=<?php echo $_GET['p'] . $link['link']; ?>" target="_blank">
                                        <span class="id"><?php echo $link['custom']; ?></span>
                                        <span class="title"><?php echo $link['title']; ?></span>
                                        <span class="description">Learn how to complete the task here</span>
                                    </a> <?php
                                } ?>
                            </div>
                        </div>

                        <form method="post" class="decision-bar">
                            <input type="hidden" name="delete">
                            <input type="submit" name="submit" value="DELETE TASK" class="button">
                        </form> <?php
                    }
                }
            }

            if (isset($_GET['l1']) && $_GET['l1'] == "project") {
                if (isset($_GET['l2']) && $_GET['l2'] == "overview") { ?>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "client") {
                    if (isset($project) && !$project['client_username']) {

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
                    if (isset($project) && !$project['assigned_to']) {

                        if (!isset($_SESSION['new-manager']))
                            $_SESSION['new-manager']['stage'] = 1;

                        if (isset($_POST['submit'])) {
                            if ($_SESSION['new-manager']['stage'] == 1) {
                                $_SESSION['new-manager']['stage'] = 2;
                            }
                            elseif ($_SESSION['new-manager']['stage'] == 2) {
                                $fieldsStatus = [
                                    'projectid' => $project['project_id'],
                                    'statusid' => $project['statusid'],
                                    'time' => date("Y-m-d H-i-s"),
                                    'assigned_by' => $account->id,
                                    'assigned_to' => $_POST['assign-to'],
                                    'note' => "Assigned Manager"
                                ];
                                $statusID = Project::insert('project_status', $fieldsStatus, true, null);
                                Project::update('project', $fieldsStatus['projectid'], ["statusid" => $statusID], $_SERVER['REQUEST_URI']);
                                unset($_SESSION['new-manager']);
                            }
                        }

                        if (isset($_SESSION['new-manager']['stage'])) {
                            if ($_SESSION['new-manager']['stage'] == 1) { ?>
                                <div class="navbar level-3">
                                    <form class="container-button disabled">
                                        <a class="button admin-menu disabled"></a>
                                    </form>
                                    <form method="post" class="container-button">
                                        <input type="submit" name="submit" value="Assign Manager" class="button admin-menu">
                                    </form>
                                    <form class="container-button disabled">
                                        <a class="button admin-menu disabled"></a>
                                    </form>
                                </div>
                                </div> <?php
                            }
                            elseif ($_SESSION['new-manager']['stage'] == 2) { ?>
                                <div class="navbar level-3">
                                    <form class="container-button disabled">
                                        <a class="button admin-menu disabled"></a>
                                    </form>
                                    <form method="post" class="container-button">
                                        <input type="hidden" name="assign-to" value="<?php echo $account->id; ?>">
                                        <input type="submit" name="submit" value="I WILL DO IT" class="button admin-menu">
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
                                        <div class="head admin" style="width: 7.5%">№</div>
                                        <div class="head admin" style="width: 50%">Member Name</div>
                                        <div class="head admin" style="width: 35%">Reg. Date</div>
                                        <div class="head admin" style="width: 7.5%">Add</div>
                                    </div>
                                    <div class="header-extension admin"></div>
                                </div>
                                </div>
                                <div class="table admin"> <?php
                                    $members = Project::selectMembers();
                                    foreach ($members as $member) { ?>
                                        <form method="post" class="row">
                                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $member['id']); ?>" class="content"></div>
                                            <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $member['username']; ?>" class="content"></div>
                                            <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $member['reg_time_date']; ?>" class="content"></div>
                                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                                            <input type="hidden" name="assign-to" value="<?php echo $member['id']; ?>">
                                        </form> <?php
                                    } ?>
                                </div> <?php
                            }
                        }
                    }
                    else {

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
                }
                else { ?>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "assignments") {
                if (isset($_GET['l3'])) {
                    $assignments = Assignment::selectProjectAssignmentsByTypeAndDepartment($_GET['p'], $_GET['l2'], $_GET['l3']); ?>
                    <form class="search-bar">
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
                                    <div class="cell" style="width: 7.5%"><a href="assignments.php?a=<?php echo $row['assignment_id']; ?>" class="content"><?php echo "#" . sprintf('%05d', $row['assignment_id']); ?></a></div>
                                    <div class="cell" style="width: 35%"><a href="assignments.php?a=<?php echo $row['assignment_id']; ?>" class="content"><?php echo $row['assignment_title']; ?></a></div>
                                    <div class="cell" style="width: 15%"><a href="assignments.php?a=<?php echo $row['assignment_id']; ?>" class="content"><?php echo $row['status']; ?></a></div>
                                    <div class="cell" style="width: 15%"><a href="assignments.php?a=<?php echo $row['assignment_id']; ?>" class="content"><?php echo "?"; ?></a></div>
                                    <div class="cell" style="width: 10%"><a href="assignments.php?a=<?php echo $row['assignment_id']; ?>" class="content"><?php echo "?"; ?></a></div>
                                    <div class="cell" style="width: 10%"><a href="assignments.php?a=<?php echo $row['assignment_id']; ?>" class="content"><?php echo "?"; ?></span></a></div>
                                    <div class="cell" style="width: 7.5%"><a href="assignments.php?a=<?php echo $row['assignment_id']; ?>" class="content open-button">Open</a></div>
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

            if (isset($_GET['preview'])) { ?>
                <div class="decision-bar">
                    <div class="button">MAYBE LATER</div>
                    <div class="button">ACCEPT</div>
                    <div class="button">NOT INTERESTED</div>
                </div> <?php
            }
        }
    }

    require_once "includes/footer.php";

}
else require_once "login.php";