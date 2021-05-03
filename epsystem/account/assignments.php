<?php
ob_start();
$page = "assignments";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    // Link for exit button
    if (!isset($_GET['a']) && !isset($_GET['t']))
        $_SESSION['backPage']['1'] = $_SERVER['REQUEST_URI'];

    require_once "includes/header.php"; ?>

    <div class="menu"> <?php
    require "includes/menu.php";
    if (!isset($assignment)) {
        $divisions = Assignment::selectDivisions(); // For search bar
        $products = Project::selectProducts(); // For search bar
        if (isset($_GET['l1']) && $_GET['l1'] == "to-do") { ?>
            <form class="search-bar with-space">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                       type="text" name="objective" class="input-objective" placeholder="Enter Assignment Objective" required style="width: calc(45% - 8px);">
                <div class="custom-select input-division" style="width: calc(20% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                            name="division" class="input-division" required>
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
                if (isset($todo) && $todo) {
                    foreach ($todo as $assignment) { ?>
                        <div class="row">
                            <?php $link = "?a=" . $assignment['id'] . "&l1=assignment"; ?>
                            <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['id']); ?></a></div>
                            <div class="cell objective" style="width: 45%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['objective']; ?></a></div>
                            <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                            <div class="cell tasks" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_count']; ?></a></div>
                            <div class="cell time" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_time']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO ASSIGNMENTS</div> <?php
                } ?>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "my") {
            if (isset($_GET['l2']) && $_GET['l2'] == "pending") { ?>
                <form class="search-bar with-space">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="objective" class="input-objective" placeholder="Enter Assignment Objective" required style="width: calc(45% - 8px);">
                    <div class="custom-select input-division" style="width: calc(20% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option>
                            <option value="Custom">Custom</option> <?php                            foreach ($divisions as $division) { ?>
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
                    if (isset($myPending) && $myPending) {
                        foreach ($myPending as $assignment) { ?>
                            <div class="row">
                                <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell objective" style="width: 45%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['objective']; ?></a></div>
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                <div class="cell tasks" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_count']; ?></a></div>
                                <div class="cell time" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['time']; ?></a></div>
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
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="objective" class="input-objective" placeholder="Enter Assignment Objective" required style="width: calc(45% - 8px);">
                    <div class="custom-select input-division" style="width: calc(20% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option>
                            <option value="Custom">Custom</option> <?php                            foreach ($divisions as $division) { ?>
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
                    if (isset($myActive) && $myActive) {
                        foreach ($myActive as $assignment) { ?>
                            <div class="row">
                                <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell objective" style="width: 45%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['objective']; ?></a></div>
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                <div class="cell tasks" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_count']; ?></a></div>
                                <div class="cell time" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['time']; ?></a></div>
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
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-paid .input-paid':'.cell.paid'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-paid .input-paid':'.cell.paid'})"
                           type="text" name="objective" class="input-objective" placeholder="Enter Assignment Objective" required style="width: calc(45% - 8px);">
                    <div class="custom-select input-division" style="width: calc(20% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-paid .input-paid':'.cell.paid'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option>
                            <option value="Custom">Custom</option> <?php                            foreach ($divisions as $division) { ?>
                                <option value="<?php echo $division['title']; ?>"><?php echo $division['title']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                    <div class="custom-select input-paid" style="width: calc(10% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-paid .input-paid':'.cell.paid'}, this)"
                                name="paid" class="input-paid" required>
                            <option value="">All</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 45%">Assignment Objective</div>
                        <div class="head" style="width: 20%">Division</div>
                        <div class="head" style="width: 10%">Paid</div>
                        <div class="head time" style="width: 10%" onclick="sortTime('.head.time', '.cell.time .content')">Time</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if (isset($myCompleted) && $myCompleted) {
                        foreach ($myCompleted as $assignment) { ?>
                            <div class="row">
                                <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell objective" style="width: 45%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['objective']; ?></a></div>
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                <div class="cell paid" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['paid_txt']; ?></a></div>
                                <div class="cell time" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['time']; ?></a></div>
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
        elseif (isset($_GET['l1']) && $_GET['l1'] == "all" && $account->manager == 1) {
            if (isset($_GET['l2']) && $_GET['l2'] == "pending") { ?>
                <form class="search-bar with-space">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-reason .input-reason':'.cell.reason'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-reason .input-reason':'.cell.reason'})"
                           type="text" name="preset" class="input-preset" placeholder="Enter Assignment Preset Name" required style="width: calc(25% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-reason .input-reason':'.cell.reason'})"
                           type="text" name="project" class="input-project" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                    <div class="custom-select input-division" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-reason .input-reason':'.cell.reason'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option>
                            <option value="Custom">Custom</option> <?php
                            foreach ($divisions as $division) { ?>
                                <option value="<?php echo $division['title']; ?>"><?php echo $division['title']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                    <div class="custom-select input-reason" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-reason .input-reason':'.cell.reason'}, this)"
                                name="reason" class="input-reason" required>
                            <option value="">All Reasons</option>
                            <option value="Submitted">Submitted</option>
                            <option value="Problem">Problem</option>
                            <option value="Canceled">Canceled</option>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head id" style="width: 7.5%">№</div>
                        <div class="head preset" style="width: 25%">Assignment Preset Name</div>
                        <div class="head project" style="width: 20%">Project</div>
                        <div class="head division" style="width: 15%">Division</div>
                        <div class="head" style="width: 15%">Reason</div>
                        <div class="head tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if (isset($allPending) && $allPending) {
                        foreach ($allPending as $assignment) { ?>
                            <div class="row">
                                <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell preset" style="width: 25%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['asg_preset']; ?></a></div>
                                <div class="cell project" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['project']; ?></a></div>
                                <div class="cell division" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                <div class="cell reason" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['status_note']; ?></a></div>
                                <div class="cell tasks" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['tasks']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO ASSIGNMENTS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "available") { ?>
                <form class="search-bar with-space">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-reason .input-reason':'.cell.reason'})"
                           type="text" name="preset" class="input-preset" placeholder="Enter Assignment Preset Name" required style="width: calc(25% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-reason .input-reason':'.cell.reason'})"
                           type="text" name="project" class="input-project" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                    <div class="custom-select input-division" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="division" class="input-division" required>
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
                        <div class="head id" style="width: 7.5%">№</div>
                        <div class="head preset" style="width: 25%">Assignment Preset Name</div>
                        <div class="head project" style="width: 20%">Project</div>
                        <div class="head division" style="width: 15%">Division</div>
                        <div class="head time" style="width: 15%" onclick="sortDates('.head.time', '.cell.time .content', '.made-avb')">Made Available</div>
                        <div class="head tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if (isset($allAvailable) && $allAvailable) {
                        foreach ($allAvailable as $assignment) { ?>
                            <div class="row">
                                <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell preset" style="width: 25%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['asg_preset']; ?></a></div>
                                <div class="cell project" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['project']; ?></a></div>
                                <div class="cell division" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                <div class="cell time" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['status_time_ago']; ?></a></div>
                                <div class="cell tasks" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['tasks']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                                <input class="made-avb" type="hidden" value="<?php echo $assignment[5]; ?>">
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
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-reason .input-reason':'.cell.reason'})"
                           type="text" name="preset" class="input-preset" placeholder="Enter Assignment Preset Name" required style="width: calc(25% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .custom-select.input-reason .input-reason':'.cell.reason'})"
                           type="text" name="project" class="input-project" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                    <div class="custom-select input-division" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option>
                            <option value="Custom">Custom</option> <?php
                            foreach ($divisions as $division) { ?>
                                <option value="<?php echo $division['title']; ?>"><?php echo $division['title']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-product .input-product':'.cell.product', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'})"
                           type="text" name="name" class="input-member" placeholder="Enter Member Name" required style="width: calc(15% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head id" style="width: 7.5%">№</div>
                        <div class="head preset" style="width: 25%">Assignment Preset Name</div>
                        <div class="head project" style="width: 20%">Project</div>
                        <div class="head division" style="width: 15%">Division</div>
                        <div class="head member" style="width: 15%">Member</div>
                        <div class="head tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if (isset($allActive) && $allActive) {
                        foreach ($allActive as $assignment) { ?>
                            <div class="row">
                                <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell preset" style="width: 25%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['asg_preset']; ?></a></div>
                                <div class="cell project" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['project']; ?></a></div>
                                <div class="cell division" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                <div class="cell member" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['member']; ?></a></div>
                                <div class="cell tasks" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['tasks']; ?></a></div>
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
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'})"
                           type="text" name="preset" class="input-preset" placeholder="Enter Assignment Preset Name" required style="width: calc(25% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'})"
                           type="text" name="project" class="input-project" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                    <div class="custom-select input-division" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option>
                            <option value="Custom">Custom</option> <?php
                            foreach ($divisions as $division) { ?>
                                <option value="<?php echo $division['title']; ?>"><?php echo $division['title']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-preset':'.cell.preset', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'})"
                           type="text" name="name" class="input-member" placeholder="Enter Member Name" required style="width: calc(15% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head id" style="width: 7.5%">№</div>
                        <div class="head preset" style="width: 25%">Assignment Preset Name</div>
                        <div class="head project" style="width: 20%">Project</div>
                        <div class="head division" style="width: 15%">Division</div>
                        <div class="head member" style="width: 15%">Member</div>
                        <div class="head" style="width: 10%">Paid</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if (isset($allCompleted) && $allCompleted) {
                        foreach ($allCompleted as $assignment) { ?>
                            <div class="row">
                                <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell preset" style="width: 25%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['asg_preset']; ?></a></div>
                                <div class="cell project" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['project']; ?></a></div>
                                <div class="cell division" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                <div class="cell member" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['member']; ?></a></div>
                                <div class="cell" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['paid_txt']; ?></a></div>
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
        else { ?>
            </div> <?php
        }
    }
    elseif (isset($assignment)) {
        // Assignment options
        if (isset($_GET['options']) && !isset($_GET['t'])) {
            if (isset($_POST['back'])) {
                if (isset($_GET['l2']))
                    unset($_GET['l2']);
                elseif (isset($_GET['l1']))
                    unset($_GET['l1']);
                $query_string = http_build_query($_GET);
                header('Location: assignments.php?' . $query_string);
            }
            elseif (isset($_POST['exit'])) {
                $link = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                header('Location: ' . $link);
            }
            elseif (isset($_POST['cancel'])) {
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'assigned_to' => null,
                    'note' => "Canceled by manager"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                Assignment::update('assignment', $_GET['a'], ["statusid" => $statusID], $redirect);
                Project::projectStatusChanger($assignment['projectid'], $account->id);

                // Update all task status
                $tasks = Task::selectAssignmentTasks($assignment['id']);
                if ($tasks) {
                    foreach ($tasks as $task) {
                        if ($task['statusid'] != 1 && 7) {
                            $fields = [
                                'taskid' => $task['id'],
                                'statusid' => 1,
                                'time' => date("Y-m-d H-i-s"),
                                'assigned_by' => $account->id,
                                'note' => "Assignment canceled by manager"
                            ];

                            $statusID = Task::insert('task_status', $fields, true, false);
                            Task::update('task', $task['id'], ["statusid" => $statusID], false);
                        }
                    }
                }
            }
            elseif (isset($_POST['assign'])) {
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 3,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'assigned_to' => $_POST['assign'],
                    'note' => "Manager assigned to member"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                Assignment::update('assignment', $_GET['a'], ["statusid" => $statusID], $redirect);
                Project::projectStatusChanger($assignment['projectid'], $account->id);
            }
            elseif (isset($_POST['hide'])) {
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 2,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "Hidden"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                Assignment::update('assignment', $_GET['a'], ["statusid" => $statusID], $redirect);
                Project::projectStatusChanger($assignment['projectid'], $account->id);
            }
            elseif (isset($_POST['show'])) {
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "New Assignment"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                Assignment::update('assignment', $_GET['a'], ["statusid" => $statusID], $redirect);
                Project::projectStatusChanger($assignment['projectid'], $account->id);
            }
            elseif (isset($_POST['publish'])) {
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 3,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "Assignment made available"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                Assignment::update('assignment', $_GET['a'], ["statusid" => $statusID], $redirect);
                Project::projectStatusChanger($assignment['projectid'], $account->id);
            }
            elseif (isset($_POST['unpublish'])) {
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "Made unavailable"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                Assignment::update('assignment', $_GET['a'], ["statusid" => $statusID], $redirect);
                Project::projectStatusChanger($assignment['projectid'], $account->id);
            }
            elseif (isset($_POST['complete'])) {
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 7,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'assigned_to' => $assignment['assigned_to'],
                    'note' => "Completed"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                Assignment::update('assignment', $_GET['a'], ["statusid" => $statusID], $redirect);
                Project::projectStatusChanger($assignment['projectid'], $account->id);
            }
            elseif (isset($_POST['delete'])) {
                Assignment::remove('assignment', $_GET['a'], "projects.php?p=" . $assignment['projectid'] . "&l1=assignments&l2=pending");
                Project::projectStatusChanger($assignment['projectid'], $account->id);
            }
            elseif (isset($_POST['accept'])) {
                // Update assignment status
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 4,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'assigned_to' => $account->id,
                    'note' => "User accepted assignment"
                ];
                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                Assignment::update('assignment', $_GET['a'], ["statusid" => $statusID], false);

                // Update project status (if needed)
                Project::projectStatusChanger($assignment['projectid'], $account->id);

                // Update all task status
                $tasks = Task::selectAssignmentTasks($assignment['id']);
                if ($tasks) {
                    foreach ($tasks as $task) {
                        if ($task['statusid'] == 1) {
                            $fields = [
                                'taskid' => $task['id'],
                                'statusid' => 4,
                                'time' => date("Y-m-d H-i-s"),
                                'assigned_by' => $account->id,
                                'note' => "User accepted assignment"
                            ];

                            $statusID = Task::insert('task_status', $fields, true, false);
                            Task::update('task', $task['id'], ["statusid" => $statusID], false);
                        }
                    }
                }

                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                header('Location: ' . $redirect);
            }
            elseif (isset($_POST['undo-accept'])) {
                // Update assignment status
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "Undone accept"
                ];
                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                Assignment::update('assignment', $_GET['a'], ["statusid" => $statusID], false);

                // Update project status (if needed)
                Project::projectStatusChanger($assignment['projectid'], $account->id);

                // Update all task status
                $tasks = Task::selectAssignmentTasks($assignment['id']);
                if ($tasks) {
                    foreach ($tasks as $task) {
                        if ($task['statusid'] != 6 && $task['statusid'] != 7) {
                            $fields = [
                                'taskid' => $task['id'],
                                'statusid' => 1,
                                'time' => date("Y-m-d H-i-s"),
                                'assigned_by' => $account->id,
                                'note' => "Assignment canceled by member"
                            ];

                            $statusID = Task::insert('task_status', $fields, true, false);
                            Task::update('task', $task['id'], ["statusid" => $statusID], false);
                        }
                    }
                }

                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                header('Location: ' . $redirect);
            }

            if (isset($_GET['l1']) && $_GET['l1'] == "add") {
                if ($assignment['presetid'] == null) {
                    $_SESSION['new-task']['time'] = "";
                    $_SESSION['new-task']['stage'] = '1c';
                    $_SESSION['new-task']['assignment'] = $assignment;
                    $_SESSION['new-task']['fields']['assignmentid'] = $_GET['a'];
                    $_SESSION['new-task']['presetid'] = null;
                    header('Location: new-task.php');
                }
                if (isset($_POST['custom'])) {
                    $_SESSION['new-task']['time'] = "";
                    $_SESSION['new-task']['stage'] = '1c';
                    $_SESSION['new-task']['assignment'] = $assignment;
                    $_SESSION['new-task']['fields']['assignmentid'] = $_GET['a'];
                    $_SESSION['new-task']['presetid'] = $assignment['presetid'];
                    header('Location: new-task.php');
                }
                elseif (isset($_POST['task'])) {
                    $_SESSION['new-task']['fieldsPreset'] = Task::selectTaskPreset($_POST['task']);
                    $_SESSION['new-task']['fields'] = [
                        'assignmentid' => $_GET['a'],
                        'presetid' => $_SESSION['new-task']['fieldsPreset']['id'],
                        'name' => $_SESSION['new-task']['fieldsPreset']['name'],
                        'description' => $_SESSION['new-task']['fieldsPreset']['description'],
                        'estimated' => $_SESSION['new-task']['fieldsPreset']['estimated']
                    ];

                    $number = Task::RenumberTasksInAssignment($_GET['a']);
                    $_SESSION['new-task']['fields']['number'] = $number;
                    $taskID = Task::insert('task', $_SESSION['new-task']['fields'], true, false);

                    if ($assignment['status_id'] == 5 || $assignment['status_id'] == 6)
                        $fieldsStatus = [
                            'taskid' => $taskID,
                            'statusid' => 4,
                            'time' => date("Y-m-d H-i-s"),
                            'assigned_by' => $account->id,
                            'note' => "New Task"
                        ];
                    else
                        $fieldsStatus = [
                            'taskid' => $taskID,
                            'statusid' => 1,
                            'time' => date("Y-m-d H-i-s"),
                            'assigned_by' => $account->id,
                            'note' => "New Task"
                        ];
                    $statusID = Task::insert('task_status', $fieldsStatus, true, false);
                    Task::update('task', $taskID, ["statusid" => $statusID], false);
                    Assignment::assignmentStatusChanger($assignment, $account->id);

                    // Add info link to task (and project if not already)
                    if ($_SESSION['new-task']['fieldsPreset']['infoid']) {
                        $projectInfoPages = Project::selectProjectInfoPages($assignment['projectid']);
                        $add = true;
                        if ($projectInfoPages)
                            foreach ($projectInfoPages as $infoPage) {
                                if ($infoPage['presetid'] == $_SESSION['new-task']['fieldsPreset']['infoid']) {
                                    $add = false;
                                    $infoID = $infoPage['id'];
                                    break;
                                }
                            }
                        if ($add) {
                            $fieldsProjectInfo = [
                                'projectid' => $assignment['projectid'],
                                'presetid' => $_SESSION['new-task']['fieldsPreset']['infoid'],
                                'title' => $_SESSION['new-task']['fieldsPreset']['info-title'],
                                'description' => $_SESSION['new-task']['fieldsPreset']['info-desc']
                            ];
                            $infoID = Project::insert('project_infopage', $fieldsProjectInfo, true, false);
                        }
                        Database::update('task', $taskID, ['infoid' => $infoID], false);
                    }

                    // Add links
                    $links = Task::selectTaskPresetLinks($_POST['task']);
                    if ($links) {
                        foreach ($links as $link) {
                            $fieldsLink = [
                                'taskid' => $taskID,
                                'typeid' => $link['typeid'],
                                'title' => $link['title'],
                                'link' => $link['link'],
                            ];
                            Task::insert('task_link', $fieldsLink, false, false);
                        }
                    }

                    header("Location: assignments.php?a=" . $_GET['a'] . "&l1=tasks&l2=" . $taskID);
                    unset($_SESSION['new-task']);
                    exit();
                } ?>

                <div class="navbar level-2 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="custom">
                        <input type="submit" name="submit" value="+ Custom Task" class="button admin-menu">
                    </form>
                </div> <?php
                include_once "includes/info-bar.php"; ?>
                <div class="search-bar admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name'})"
                           type="text" name="name" class="input-name" placeholder="Enter Task Preset Name" required style="width: calc(65% - 8px);">
                </div>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 65%">Task Preset</div>
                        <div class="head admin" style="width: 20%">Time</div>
                        <div class="head admin" style="width: 7.5%">Add</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    $_SESSION['new-task']['presetTasks'] = Task::selectAssignmentPresetTasks($assignment['presetid']);
                    if (isset($_SESSION['new-task']['presetTasks'])) {
                        foreach ($_SESSION['new-task']['presetTasks'] as $task) { ?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $task['id']); ?>" class="content"></div>
                                <div class="cell name" style="width: 65%"><input type="submit" name="submit" value="<?php echo $task['name']; ?>" class="content"></div>
                                <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $task['estimated']; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                                <input type="hidden" name="task" value="<?php echo $task['id']; ?>">
                            </form> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO TASK PRESETS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                if (isset($_GET['l2']) && $_GET['l2'] == "preset") {
                    if (isset($_POST['preset'])) {
                        $fields = [
                            'title' => $_POST['preset-name'],
                            'presetid' => $_POST['preset'],
                            'divisionid' => $_POST['preset-division'],
                            'objective' => $_POST['preset-objective']
                        ];
                        Database::update('assignment', $_GET['a'], $fields, "assignments.php?a=" . $_GET['a'] . "&options&l1=edit");
                    }
                    elseif (isset($_POST['none'])) {
                        $tasks = Task::selectAssignmentTasks($_GET['a']);
                        if ($tasks)
                            foreach ($tasks as $task)
                                Database::update('task', $task['id'], ["presetid" => null], false);
                        Database::update('assignment', $_GET['a'], ["presetid" => null], "assignments.php?a=" . $_GET['a'] . "&options&l1=edit");
                    }

                    $divisions = Assignment::selectDivisions(); ?>
                    <div class="navbar level-3 unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="none">
                            <input type="submit" name="submit" value="NONE" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="search-bar admin">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="name" class="input-name" placeholder="Enter Assignment Preset Name" required style="width: calc(20% - 8px);">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="objective" class="input-objective" placeholder="Enter Assignment Preset Objective" required style="width: calc(50% - 8px);">
                        <div class="custom-select input-division" style="width: calc(15% - 8px);">
                            <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                    name="division" class="input-division" required>
                                <option value="">All Divisions</option>
                                <option value="None">None</option> <?php
                                foreach ($divisions as $division) { ?>
                                    <option value="<?php echo $division['title']; ?>"><?php echo $division['title']; ?></option> <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-header-container">
                        <div class="header-extension admin"></div>
                        <div class="header">
                            <div class="head admin" style="width: 7.5%">№</div>
                            <div class="head admin" style="width: 20%">Assignment Preset Name</div>
                            <div class="head admin" style="width: 50%">Assignment Preset Objective</div>
                            <div class="head admin" style="width: 15%">Division</div>
                            <div class="head admin" style="width: 7.5%">Select</div>
                        </div>
                        <div class="header-extension admin"></div>
                    </div>
                    </div> <?php
                    $presets = Assignment::selectPresets();
                    if ($presets) { ?>
                        <div class="table admin"> <?php
                            foreach ($presets as $preset) { ?>
                                <form method="post" class="row">
                                    <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                                    <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                                    <div class="cell objective" style="width: 50%"><input type="submit" name="submit" value="<?php echo $preset['objective']; ?>" class="content"></div>
                                    <div class="cell division" style="width: 15%"><input type="submit" name="submit" value="<?php echo $preset['div_title']; ?>" class="content"></div>
                                    <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                                    <input type="hidden" name="preset" value="<?php echo $preset['id']; ?>">
                                    <input type="hidden" name="preset-name" value="<?php echo $preset['title']; ?>">
                                    <input type="hidden" name="preset-division" value="<?php echo $preset['divisionid']; ?>">
                                    <input type="hidden" name="preset-objective" value="<?php echo $preset['objective']; ?>">
                                </form> <?php
                            } ?>
                        </div> <?php
                    }
                    else { ?>
                        <div class="empty-table">NO ASSIGNMENT PRESETS</div> <?php
                    }
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "objective") {
                    if (isset($_POST['objective']))
                        Database::update('assignment', $_GET['a'], ['objective' => $_POST['objective']], "assignments.php?a=" . $_GET['a'] . "&options&l1=edit"); ?>

                    <div class="navbar level-3 unselected">
                        <form method="post" id="objective" class="container-button">
                            <input type="hidden" name="objective">
                            <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
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
                            <input form="objective" name="objective" class="field admin" placeholder="Enter Assignment Objective Here" maxlength="100" value="<?php if (isset($assignment['objective'])) echo $assignment['objective']; ?>">
                        </div>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "actions") {
                if (isset($_GET['l2']) && $_GET['l2'] == "cancel") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="cancel">
                            <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "assign") {
                    if ($assignment['presetid'] != null)
                        $members = Account::selectAccountsByDivision($assignment['divisionid']);
                    else
                        $members = Account::selectMembers(); ?>
                    <form class="search-bar with-space">
                        <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id'})"
                               type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    </form>
                    <div class="table-header-container">
                        <div class="header-extension admin"></div>
                        <div class="header">
                            <div class="head admin" style="width: 7.5%">№</div>
                            <div class="head admin" style="width: 60%">Member Name</div>
                            <div class="head admin date" style="width: 25%" onclick="sortDates('.head.date', '.cell.date .content', '.reg')">Member Since</div>
                            <div class="head admin" style="width: 7.5%">Select</div>
                        </div>
                        <div class="header-extension admin"></div>
                    </div>
                    </div>
                    <div class="table admin"> <?php
                        if ($members) {
                            foreach ($members as $member) { ?>
                                <form method="post" class="row">
                                    <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $member['id']); ?>" class="content"></div>
                                    <div class="cell" style="width: 60%"><input type="submit" name="submit" value="<?php echo $member['username']; ?>" class="content"></div>
                                    <div class="cell date" style="width: 25%"><input type="submit" name="submit" value="<?php echo $member['reg_time_date']; ?>" class="content"></div>
                                    <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                                    <input type="hidden" name="assign" value="<?php echo $member['id']; ?>">
                                    <input class="reg" type="hidden" value="<?php echo $member['reg_time']; ?>">
                                </form> <?php
                            }
                        }
                        else { ?>
                            <div class="empty-table">NO MEMBERS</div> <?php
                        } ?>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "hide") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="hide">
                            <input type="submit" name="submit" value="Confirm Hide" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="Don't Hide" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "show") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="show">
                            <input type="submit" name="submit" value="Confirm Show" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="Don't Show" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "publish") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="publish">
                            <input type="submit" name="submit" value="Confirm Make Available" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="Don't Make Available" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "unpublish") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="unpublish">
                            <input type="submit" name="submit" value="Confirm Undo Available" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="Don't Undo Available" class="button admin-menu">
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
                elseif (isset($_GET['l2']) && $_GET['l2'] == "delete") { ?>
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
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "accept") { ?>
                <div class="navbar level-2 current unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="accept">
                        <input type="submit" name="submit" value="Confirm Accept" class="button">
                        <input type="submit" name="submit" value="" class="home-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="exit">
                        <input type="submit" name="submit" value="Don't Accept" class="button">
                        <input type="submit" name="submit" value="" class="home-menu">
                    </form>
                </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "undo-accept") { ?>
                <div class="navbar level-2 current unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="undo-accept">
                        <input type="submit" name="submit" value="Confirm Undo Accept" class="button">
                        <input type="submit" name="submit" value="" class="home-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="exit">
                        <input type="submit" name="submit" value="Don't Undo Accept" class="button">
                        <input type="submit" name="submit" value="" class="home-menu">
                    </form>
                </div>
                </div> <?php
            }
        }
        // Task options
        elseif (isset($_GET['options']) && isset($_GET['t']) && isset($task)) {
            if (isset($_POST['back'])) {
                if (isset($_GET['l1']))
                    unset($_GET['l1']);
                $query_string = http_build_query($_GET);
                header('Location: assignments.php?' . $query_string);
            }
            elseif (isset($_POST['exit'])) {
                $link = "assignments.php?a=" . $assignment['id'] . "&l1=tasks&l2=" . $_GET['t'];
                header('Location: ' . $link);
            }
            elseif (isset($_POST['comment'])) {
                $fields = [
                    'taskid' => $_GET['t'],
                    'accountid' => $account->id,
                    'time' => date("Y-m-d H-i-s"),
                    'comment' => $_POST['comment']

                ];
                $redirect = "?a=" . $assignment['id'] . "&l1=tasks&l2=" . $_GET['t'];
                Task::insert('task_comment', $fields, false, $redirect);
            }
            elseif (isset($_POST['submit-complete'])) {
                $fields = [
                    'taskid' => $_GET['t'],
                    'statusid' => 6,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "Member submitted task"
                ];

                $statusID = Task::insert('task_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $assignment['id'] . "&l1=tasks&l2=" . $_GET['t'];
                Task::update('task', $_GET['t'], ["statusid" => $statusID], false);
                Assignment::assignmentStatusChanger($assignment, $account->id);
                header('Location: ' . $redirect);
            }
            elseif (isset($_POST['problem'])) {
                $taskFields = [
                    'taskid' => $_GET['t'],
                    'statusid' => 5,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id
                ];
                if (isset($_GET['l2']) && $_GET['l2'] == "file" && $_POST['submit'] == "No File") $taskFields['note'] = "No file";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "file" && $_POST['submit'] == "Not Prepared") $taskFields['note'] = "File not prepared";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "file" && $_POST['submit'] == "Wrong File") $taskFields['note'] = "Wrong file";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "file" && $_POST['submit'] == "Other") $taskFields['note'] = "File (other)";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "link" && $_POST['submit'] == "No Link") $taskFields['note'] = "No link";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "link" && $_POST['submit'] == "Wrong Link") $taskFields['note'] = "Wrong link";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "link" && $_POST['submit'] == "Other") $taskFields['note'] = "Link (other)";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "completion" && $_POST['submit'] == "Can't Complete") $taskFields['note'] = "Can't complete";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "completion" && $_POST['submit'] == "Need Help") $taskFields['note'] = "Need help";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "completion" && $_POST['submit'] == "Other") $taskFields['note'] = "Completion (other)";

                $statusID = Task::insert('task_status', $taskFields, true, false);
                $redirect = "assignments.php?a=" . $assignment['id'] . "&l1=tasks&l2=" . $_GET['t'];
                Task::update('task', $_GET['t'], ["statusid" => $statusID], false);
                Assignment::assignmentStatusChanger($assignment, $account->id);
                header('Location: ' . $redirect);
            }
            elseif (isset($_POST['complete'])) {
                $fields = [
                    'taskid' => $_GET['t'],
                    'statusid' => 7,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "Completed"
                ];

                $statusID = Task::insert('task_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $assignment['id'] . "&l1=tasks&l2=" . $_GET['t'];
                Task::update('task', $_GET['t'], ["statusid" => $statusID], false);
                Assignment::assignmentStatusChanger($assignment, $account->id);
                header('Location: ' . $redirect);
            }
            elseif (isset($_POST['activate'])) {
                $fields = [
                    'taskid' => $_GET['t'],
                    'statusid' => 4,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "Task activated"
                ];

                $statusID = Task::insert('task_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $assignment['id'] . "&l1=tasks&l2=" . $_GET['t'];
                Task::update('task', $_GET['t'], ["statusid" => $statusID], false);
                Assignment::assignmentStatusChanger($assignment, $account->id);
                header('Location: ' . $redirect);
            }
            elseif (isset($_POST['delete'])) {
                Task::remove('task', $_GET['t'], "assignments.php?a=" . $assignment['id'] . "&l1=tasks");
                Task::RenumberTasksInAssignment($assignment['id']);
                Assignment::assignmentStatusChanger($assignment, $account->id);
                $redirect = "assignments.php?a=" . $assignment['id'] . "&l1=tasks";
                header('Location: ' . $redirect);
            }

            if (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                if (isset($_GET['l2']) && $_GET['l2'] == "preset") {
                    if (isset($_POST['preset'])) {
                        $fields = [
                            'presetid' => $_POST['preset'],
                            'name' => $_POST['preset-name'],
                            'description' => $_POST['preset-description'],
                            'estimated' => $_POST['preset-estimated']
                        ];
                        Database::update('task', $_GET['t'], $fields, "assignments.php?t=" . $_GET['t'] . "&options&l1=edit");
                    }
                    elseif (isset($_POST['none']))
                        Database::update('task', $_GET['t'], ["presetid" => null], "assignments.php?t=" . $_GET['t'] . "&options&l1=edit"); ?>

                    <div class="navbar level-3 unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="none">
                            <input type="submit" name="submit" value="NONE" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="table-header-container">
                        <div class="header-extension admin"></div>
                        <div class="header">
                            <div class="head admin" style="width: 7.5%">№</div>
                            <div class="head admin" style="width: 65%">Task Preset Name</div>
                            <div class="head admin" style="width: 20%">Time</div>
                            <div class="head admin" style="width: 7.5%">Select</div>
                        </div>
                        <div class="header-extension admin"></div>
                    </div>
                    </div> <?php
                    $presets = Task::selectAssignmentPresetTasks($assignment['presetid']);
                    if ($presets) { ?>
                        <div class="table admin"> <?php
                            foreach ($presets as $preset) { ?>
                                <form method="post" class="row">
                                    <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                                    <div class="cell name" style="width: 65%"><input type="submit" name="submit" value="<?php echo $preset['name']; ?>" class="content"></div>
                                    <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $preset['estimated']; ?>" class="content"></div>
                                    <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                                    <input type="hidden" name="preset" value="<?php echo $preset['id']; ?>">
                                    <input type="hidden" name="preset-name" value="<?php echo $preset['name']; ?>">
                                    <input type="hidden" name="preset-description" value="<?php echo $preset['description']; ?>">
                                    <input type="hidden" name="preset-estimated" value="<?php echo $preset['estimated']; ?>">
                                    <input type="hidden" name="preset-info" value="<?php echo $preset['infoid']; ?>">
                                </form> <?php
                            } ?>
                        </div> <?php
                    }
                    else { ?>
                        <div class="empty-table">NO TASK PRESETS</div> <?php
                    }
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                    if (isset($_POST['description']))
                        Database::update('task', $_GET['t'], ['description' => $_POST['description']], "assignments.php?t=" . $_GET['t'] . "&options&l1=edit"); ?>

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
                            <div class="head admin">Task Description</div>
                        </div>
                        <div class="header-extension large admin"></div>
                    </div>
                    </div>
                    <div class="table large">
                        <div class="row">
                            <input form="description" name="description" class="field admin" placeholder="Enter Task Description Here" maxlength="200" value="<?php if (isset($task['description'])) echo $task['description']; ?>">
                        </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "time") {
                    if (isset($_POST['time'])) {
                        $time = gmdate("H:i:s", $_POST['time']);
                        Database::update('task', $_GET['t'], ['estimated' => $time], "assignments.php?t=" . $_GET['t'] . "&options&l1=edit");
                    } ?>

                    <div class="navbar level-3 unselected">
                        <form method="post" id="time" class="container-button">
                            <input type="hidden" name="time">
                            <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="table-header-container">
                        <div class="header-extension small admin"></div>
                        <div class="header small">
                            <div class="head admin">Task Time</div>
                        </div>
                        <div class="header-extension small admin"></div>
                    </div>
                    </div>
                    <div class="table small">
                        <div class="row">
                            <input form="time" name="time" type="number" min="10" max="7200" class="field admin" placeholder="Enter Task Time Here" value="<?php if (isset($task['estimated'])) echo strtotime($task['estimated']) - strtotime('TODAY'); ?>">
                        </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "links") {
                    if (isset($_POST['new-link'])) {
                        $_SESSION['new-link']['info']['type'] = "";
                        $_SESSION['new-link']['stage'] = '1';
                        $_SESSION['new-link']['fields']['taskid'] = $_GET['t'];
                        header('Location: new-link.php');
                    }
                    elseif (isset($_POST['del-link']))
                        Database::remove('task_link', $_POST['del-link'], false); ?>

                    <div class="navbar level-3 unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="new-link">
                            <input type="submit" name="submit" value="+ Link" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="table-header-container">
                        <div class="header-extension admin"></div>
                        <div class="header">
                            <div class="head admin" style="width: 7.5%">№</div>
                            <div class="head admin" style="width: 20%">Name</div>
                            <div class="head admin" style="width: 15%">Type</div>
                            <div class="head admin" style="width: 50%">URL</div>
                            <div class="head admin" style="width: 7.5%">Remove</div>
                        </div>
                        <div class="header-extension admin"></div>
                    </div>
                    </div>
                    <div class="table admin"> <?php
                        $links = Task::selectTaskLinks($_GET['t']);
                        if ($links) {
                            foreach ($links as $link) { ?>
                                <form method="post" class="row">
                                    <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%05d', $link['id']); ?>" class="content"></div>
                                    <div class="cell title" style="width: 20%"><input type="submit" name="submit" value="<?php echo $link['title']; ?>" class="content"></div>
                                    <div class="cell type" style="width: 15%"><input type="submit" name="submit" value="<?php echo $link['type']; ?>" class="content"></div>
                                    <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $link['link']; ?>" class="content"></div>
                                    <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                                    <input type="hidden" name="del-link" value="<?php echo $link['id']; ?>">
                                </form> <?php
                            }
                        }
                        else { ?>
                            <div class="empty-table">NO LINKS</div> <?php
                        } ?>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "comments") {
                    if (isset($_POST['del-com']))
                        Database::remove('task_comment', $_POST['del-com'], false);

                    include_once "includes/info-bar.php"; ?>
                    <div class="table-header-container">
                        <div class="header-extension admin"></div>
                        <div class="header">
                            <div class="head admin" style="width: 7.5%">№</div>
                            <div class="head admin" style="width: 55%">Comment</div>
                            <div class="head admin" style="width: 15%">Member</div>
                            <div class="head admin time" style="width: 15%" onclick="sortDates('.head.time', '.cell.time .content', '.added')">Time</div>
                            <div class="head admin" style="width: 7.5%">Remove</div>
                        </div>
                        <div class="header-extension admin"></div>
                    </div>
                    </div>
                    <div class="table admin"> <?php
                        $comments = Task::selectTaskComments($_GET['t']);
                        if ($comments) {
                            foreach ($comments as $comment) { ?>
                                <form method="post" class="row">
                                    <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%05d', $comment['id']); ?>" class="content"></div>
                                    <div class="cell comment" style="width: 55%"><input type="submit" name="submit" value="<?php echo $comment['comment']; ?>" class="content"></div>
                                    <div class="cell member" style="width: 15%"><input type="submit" name="submit" value="<?php echo $comment['username']; ?>" class="content"></div>
                                    <div class="cell time" style="width: 15%"><input type="submit" name="submit" value="<?php echo $comment['time-ago']; ?>" class="content"></div>
                                    <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                                    <input type="hidden" name="del-com" value="<?php echo $comment['id']; ?>">
                                    <input class="added" type="hidden" value="<?php echo $comment['time']; ?>">
                                </form> <?php
                            }
                        }
                        else { ?>
                            <div class="empty-table">NO COMMENTS</div> <?php
                        } ?>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "actions") {
                if (isset($_GET['l2']) && $_GET['l2'] == "complete") { ?>
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
                elseif (isset($_GET['l2']) && $_GET['l2'] == "activate") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="activate">
                            <input type="submit" name="submit" value="Confirm Activate" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="back">
                            <input type="submit" name="submit" value="Don't Activate" class="button admin-menu">
                            <input type="submit" name="submit" value="" class="home-menu admin">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "delete") { ?>
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
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "comment") { ?>
                <div class="navbar level-2 unselected">
                    <form method="post" id="comment" class="container-button">
                        <input type="hidden" name="comment">
                        <input type="submit" name="submit" value="Publish Comment" class="button">
                    </form>
                </div>
                <div class="info-bar">
                    <div class="section">
                        <div class="stage">MANAGER COMMENTS:</div>
                        <div class="content"><?php echo $task['manager_comments']; ?></div>
                    </div>
                    <div class="section">
                        <div class="stage">MEMBER COMMENTS:</div>
                        <div class="content"><?php echo $task['member_comments']; ?></div>
                    </div>
                </div>
                <div class="table-header-container">
                    <div class="header-extension large"></div>
                    <div class="header large">
                        <div class="head">Task Comment</div>
                    </div>
                    <div class="header-extension large"></div>
                </div>
                </div>
                <div class="table large">
                    <div class="row">
                        <input form="comment" name="comment" id="comment" class="field" placeholder="Enter Task Comment Here" maxlength="500">
                    </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "submit") { ?>
                <div class="navbar level-2 current unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="submit-complete">
                        <input type="submit" name="submit" value="Confirm Submit" class="button">
                        <input type="submit" name="submit" value="" class="home-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="exit">
                        <input type="submit" name="submit" value="Don't Submit" class="button">
                        <input type="submit" name="submit" value="" class="home-menu">
                    </form>
                </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "problem") {
                if (isset($_GET['l2']) && $_GET['l2'] == "file") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="No File" class="button">
                            <input type="submit" name="submit" value="No File" class="home-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="Not Prepared" class="button">
                            <input type="submit" name="submit" value="Not Prepared" class="home-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="Wrong File" class="button">
                            <input type="submit" name="submit" value="Wrong File" class="home-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="Other" class="button">
                            <input type="submit" name="submit" value="Other" class="home-menu">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "link") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="No Link" class="button">
                            <input type="submit" name="submit" value="No Link" class="home-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="Wrong Link" class="button">
                            <input type="submit" name="submit" value="Wrong Link" class="home-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="Other" class="button">
                            <input type="submit" name="submit" value="Other" class="home-menu">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "completion") { ?>
                    <div class="navbar level-3 current unselected">
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="Can't Complete" class="button">
                            <input type="submit" name="submit" value="Can't Complete" class="home-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="Need Help" class="button">
                            <input type="submit" name="submit" value="Need Help" class="home-menu">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="Other" class="button">
                            <input type="submit" name="submit" value="Other" class="home-menu">
                        </form>
                    </div>
                    </div> <?php
                }
            }
        }

        if (isset($_GET['l1']) && $_GET['l1'] == "assignment") { ?>
            </div>
            <div class="overview-content"><?php
            $asgData = Assignment::selectAssignmentByID($assignment['id']);
            $tasks = Task::selectAssignmentTasks($assignment['id']); ?>

            <div class="info-bar short">
                <div class="section">
                </div>
                <div class="section">
                    <div class="stage active">STATUS:</div>
                    <div class="content"><?php echo $asgData['status']; ?></div>
                </div>
                <div class="section">
                    <div class="content"><?php echo $asgData['time2']; ?></div>
                </div>
            </div> <?php
            if ($asgData['divisionid'] != null) { ?>
                <div class="info-bar tiny">
                    <div class="section line-right active">
                        <div class="content"><?php echo $asgData['division']; ?></div>
                    </div>
                    <div class="section">
                        <div class="content lower"><?php echo "PROJECT \"" . $asgData['project'] . "\""; ?></div>
                    </div> <?php
                    if ($asgData['department']) { ?>
                        <div class="section line-left active">
                            <div class="content"><?php echo $asgData['department']; ?></div>
                        </div> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="info-bar tiny">
                    <div class="section line-right active">
                        <div class="content"><?php echo $asgData['division']; ?></div>
                    </div>
                    <div class="section active">
                        <div class="content"><?php echo "\"" . $asgData['project'] . "\""; ?></div>
                    </div>
                </div> <?php
            } ?>
            <div class="overview">
                <div class="top">
                    <div class="box">
                        <div class="title"><?php echo "#" . sprintf('%05d', $asgData['id']) . ": " . $asgData['title']; ?></div>
                        <div class="data"><?php echo $asgData['objective']; ?></div>
                    </div>
                </div>
                <div class="mid tbl">
                    <div class="table-container">
                        <div class="table ow"> <?php
                            if ($tasks) {
                                foreach ($tasks as $task) { ?>
                                    <div class="row">
                                        <?php $link = "?a=" . $assignment['id'] . "&l1=tasks&l2=" . $task['id']; ?>
                                        <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . $task['number']; ?></a></div>
                                        <div class="cell name" style="width: 30%"><a href="<?php echo $link; ?>" class="content"><?php echo $task['name']; ?></a></div>
                                        <div class="cell comments" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $task['comments'] . " Comments"; ?></a></div>
                                        <div class="cell links" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $task['links'] . " Links"; ?></a></div>
                                        <div class="cell status" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $task['status2']; ?></a></div>
                                        <div class="cell time" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $task['estimated']; ?></a></div>
                                        <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                                    </div> <?php
                                }
                            }
                            else { ?>
                                <div class="empty-table">NO TASKS</div> <?php
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="info-bar" style="margin: 0 20vw; padding: 5vh 0 3.5vh 0;">
                <div class="section line-right active">
                    <div class="stage active"><?php echo $asgData['tasks']; ?></div>
                    <div class="content">TASKS</div>
                </div> <?php
                if ($asgData['username'] && $asgData['status_id'] == 3) { ?>
                    <div class="section">
                        <div class="stage active"><?php echo "Assigned to " . $asgData['username']; ?></div>
                    </div> <?php
                }
                elseif ($asgData['username']) { ?>
                    <div class="section">
                        <div class="stage active"><?php echo $asgData['username']; ?></div>
                    </div> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage active"><?php echo "Not assigned"; ?></div>
                    </div> <?php
                } ?>
                <div class="section line-left active">
                    <div class="stage active"><?php echo $asgData['task_time']; ?></div>
                    <div class="content">TASK TIME</div>
                </div>
            </div>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "tasks") {
            if (isset($_GET['l2'])) {
                $task = Task::selectTask($_GET['l2']);
                $comments = Task::selectTaskComments($_GET['l2']);
                $linkTypes = Task::selectLinkTypes();
                $links = Task::selectTaskLinks($_GET['l2']);
                if ($task) { ?>
                    </div>
                    <div class="overview-content">
                    <div class="info-bar short">
                        <div class="section">
                        </div>
                        <div class="section">
                            <div class="stage active">STATUS:</div>
                            <div class="content"><?php echo $task['status2']; if ($task['statusid'] == 5) echo " - " . $task['note']; ?></div>
                        </div>
                        <div class="section">
                            <div class="content"><?php echo $task['time2']; ?></div>
                        </div>
                    </div> <?php
                    if ($task['estimated'] != "00:00:00") { ?>
                        <div class="info-bar tiny">
                            <div class="section active">
                                <div class="content"><?php echo $task['estimated']; ?></div>
                            </div>
                        </div> <?php
                    } ?>
                    <div class="overview">
                        <div class="top">
                            <div class="box">
                                <div class="title"><?php echo $task['name']; ?></div>
                                <div class="data"><?php echo $task['description']; ?></div>
                            </div>
                        </div> <?php
                        if ($links || $task['infoid']) { ?>
                            <div class="mid tbl">
                                <div class="table-container"> <?php
                                    if ($links) {
                                        foreach ($links as $link) { ?>
                                            <a class="link-box" href="<?php echo $link['link']; ?>" target="_blank">
                                                <span class="type"><?php echo $link['type']; ?></span>
                                                <span class="name"><?php echo $link['title']; ?></span>
                                                <span class="description"><?php echo $link['type_desc']; ?></span>
                                            </a> <?php
                                        }
                                    } ?>
                                </div>
                            </div> <?php
                        }
                        if ($comments) {
                            foreach ($comments as $comment) { ?>
                                <div class="comment-container<?php if ($comment['manager'] == 1) echo " manager"; ?>">
                                    <div class="comment-header">
                                        <span class="align-helper"><?php echo $comment['time-ago']; ?></span>
                                        <span class="username"><?php echo $comment['username']; ?></span>
                                        <span class="added"><?php echo $comment['time-ago']; ?></span>
                                    </div>
                                    <div class="comment-body"><?php echo $comment['comment']; ?></div>
                                </div> <?php
                            }
                        } ?>
                    </div>
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

    require_once "includes/footer.php";

}
else require_once "login.php";