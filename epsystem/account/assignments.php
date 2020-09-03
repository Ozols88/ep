<?php
ob_start();
$page = "assignments";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    // Link for exit button
    if (!isset($_GET['a']) && !isset($_GET['t']))
        $_SESSION['backPage']['1'] = $_SERVER['REQUEST_URI'];

    require_once "includes/header.php"; ?>

    <div class="menu"> <?php
    require "includes/menu.php";
    if (!isset($assignment)) {
        $divisions = Assignment::selectAllDivisions(); // For search bar
        $floors = Project::selectFloors(); // For search bar
        if (isset($_GET['l1']) && $_GET['l1'] == "to-do") {
            $assignments = Assignment::selectAssignmentListByStatus(3); ?>
            <form class="search-bar">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                       type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(42.5% - 8px);">
                <div class="custom-select input-division" style="width: calc(20% - 8px);">
                    <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                            name="division" class="input-division" required>
                        <option value="">All Divisions</option>
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
                    <div class="head" style="width: 42.5%">Assignment Name</div>
                    <div class="head" style="width: 20%">Division</div>
                    <div class="head" style="width: 7.5%">Tasks</div>
                    <div class="head" style="width: 7.5%">Time</div>
                    <div class="head" style="width: 7.5%">Earn</div>
                    <div class="head" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                if ($assignments) {
                    foreach ($assignments as $assignment) { ?>
                        <div class="row">
                            <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                            <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                            <div class="cell name" style="width: 42.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['assignment_name']; ?></a></div>
                            <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_count']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['time']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "€" . $assignment['earn']; ?></a></div>
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
            if (isset($_GET['l2']) && $_GET['l2'] == "pending") {
                $assignments1 = Assignment::selectAssignmentListByStatusAndAccount(1, $account->id);
                $assignments2 = Assignment::selectAssignmentListByStatusAndAccount(2, $account->id);
                $assignments5 = Assignment::selectAssignmentListByStatusAndAccount(5, $account->id);
                $assignments6 = Assignment::selectAssignmentListByStatusAndAccount(6, $account->id);
                $assignments = array_merge((array)$assignments1, (array)$assignments2, (array)$assignments5, (array)$assignments6); ?>
                <form class="search-bar">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(42.5% - 8px);">
                    <div class="custom-select input-division" style="width: calc(20% - 8px);">
                        <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
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
                        <div class="head" style="width: 42.5%">Assignment Name</div>
                        <div class="head" style="width: 20%">Division</div>
                        <div class="head" style="width: 7.5%">Tasks</div>
                        <div class="head" style="width: 7.5%">Time</div>
                        <div class="head" style="width: 7.5%">Earn</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($assignments) {
                        foreach ($assignments as $assignment) { ?>
                            <div class="row">
                                <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell name" style="width: 42.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['assignment_name']; ?></a></div>
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_count']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['time']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "€" . $assignment['earn']; ?></a></div>
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
                $assignments = Assignment::selectAssignmentListByStatusAndAccount(4, $account->id); ?>
                <form class="search-bar">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(42.5% - 8px);">
                    <div class="custom-select input-division" style="width: calc(20% - 8px);">
                        <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
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
                        <div class="head" style="width: 42.5%">Assignment Name</div>
                        <div class="head" style="width: 20%">Division</div>
                        <div class="head" style="width: 7.5%">Tasks</div>
                        <div class="head" style="width: 7.5%">Time</div>
                        <div class="head" style="width: 7.5%">Earn</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($assignments) {
                        foreach ($assignments as $assignment) { ?>
                            <div class="row">
                                <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell name" style="width: 42.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['assignment_name']; ?></a></div>
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_count']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['time']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "€" . $assignment['earn']; ?></a></div>
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
                $assignments = Assignment::selectAssignmentListByStatusAndAccount(7, $account->id); ?>
                <form class="search-bar">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(42.5% - 8px);">
                    <div class="custom-select input-division" style="width: calc(20% - 8px);">
                        <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
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
                        <div class="head" style="width: 42.5%">Assignment Name</div>
                        <div class="head" style="width: 20%">Division</div>
                        <div class="head" style="width: 7.5%">Tasks</div>
                        <div class="head" style="width: 7.5%">Time</div>
                        <div class="head" style="width: 7.5%">Earn</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($assignments) {
                        foreach ($assignments as $assignment) { ?>
                            <div class="row">
                                <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell name" style="width: 42.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['assignment_name']; ?></a></div>
                                <div class="cell division" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_count']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['time']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "€" . $assignment['earn']; ?></a></div>
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
        elseif (isset($_GET['l1']) && $_GET['l1'] == "all") {
            if ($account->manager == 1) {
                if (isset($_GET['l2']) && $_GET['l2'] == "pending") {
                    $assignments1 = Assignment::selectCurrentProjectAssignmentsByStatus(1);
                    $assignments2 = Assignment::selectCurrentProjectAssignmentsByStatus(2);
                    $assignments5 = Assignment::selectCurrentProjectAssignmentsByStatus(5);
                    $assignments6 = Assignment::selectCurrentProjectAssignmentsByStatus(6);
                    $assignments = array_merge((array)$assignments1, (array)$assignments2, (array)$assignments5, (array)$assignments6); ?>
                    <form class="search-bar">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(25% - 8px);">
                        <div class="custom-select input-floor" style="width: calc(15% - 8px);">
                            <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                    name="floor" class="input-floor" required>
                                <option value="">All Floors</option> <?php
                                foreach ($floors as $floor) { ?>
                                    <option value="<?php echo $floor['title']; ?>"><?php echo $floor['title']; ?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="custom-select input-division" style="width: calc(15% - 8px);">
                            <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                    name="division" class="input-division" required>
                                <option value="">All Divisions</option>
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
                            <div class="head name" style="width: 25%">Assignment Name</div>
                            <div class="head floor" style="width: 15%">Floor</div>
                            <div class="head division" style="width: 15%">Division</div>
                            <div class="head" style="width: 15%">Reason</div>
                            <div class="head tasks" style="width: 7.5%" onclick="sortTable('.head.tasks', '.cell.tasks a')">Tasks</div>
                            <div class="head sum" style="width: 7.5%" onclick="sortTable('.head.sum', '.cell.sum a')">Sum</div>
                            <div class="head" style="width: 7.5%">Open</div>
                        </div>
                        <div class="header-extension"></div>
                    </div>
                    </div>
                    <div class="table"> <?php
                        if ($assignments) {
                            foreach ($assignments as $assignment) { ?>
                                <div class="row">
                                    <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                    <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                    <div class="cell name" style="width: 25%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['assignment_name']; ?></a></div>
                                    <div class="cell floor" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['floor']; ?></a></div>
                                    <div class="cell division" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                    <div class="cell" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['status_note']; ?></a></div>
                                    <div class="cell tasks" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['tasks']; ?></a></div>
                                    <div class="cell sum" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_sum']; ?></a></div>
                                    <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                                </div> <?php
                            }
                        }
                        else { ?>
                            <div class="empty-table">NO ASSIGNMENTS</div> <?php
                        } ?>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "available") {
                    $assignments = Assignment::selectCurrentProjectAssignmentsByStatus(3); ?>
                    <form class="search-bar">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(25% - 8px);">
                        <div class="custom-select input-floor" style="width: calc(15% - 8px);">
                            <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                    name="floor" class="input-floor" required>
                                <option value="">All Floors</option> <?php
                                foreach ($floors as $floor) { ?>
                                    <option value="<?php echo $floor['title']; ?>"><?php echo $floor['title']; ?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="custom-select input-division" style="width: calc(15% - 8px);">
                            <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                    name="division" class="input-division" required>
                                <option value="">All Divisions</option>
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
                            <div class="head name" style="width: 25%">Assignment Name</div>
                            <div class="head floor" style="width: 15%">Floor</div>
                            <div class="head division" style="width: 15%">Division</div>
                            <div class="head" style="width: 15%">Made Available</div>
                            <div class="head tasks" style="width: 7.5%" onclick="sortTable('.head.tasks', '.cell.tasks a')">Tasks</div>
                            <div class="head sum" style="width: 7.5%" onclick="sortTable('.head.sum', '.cell.sum a')">Sum</div>
                            <div class="head" style="width: 7.5%">Open</div>
                        </div>
                        <div class="header-extension"></div>
                    </div>
                    </div>
                    <div class="table"> <?php
                        if ($assignments) {
                            foreach ($assignments as $assignment) { ?>
                                <div class="row">
                                    <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                    <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                    <div class="cell name" style="width: 25%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['assignment_name']; ?></a></div>
                                    <div class="cell floor" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['floor']; ?></a></div>
                                    <div class="cell division" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                    <div class="cell" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['status_time-ago']; ?></a></div>
                                    <div class="cell tasks" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['tasks']; ?></a></div>
                                    <div class="cell sum" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_sum']; ?></a></div>
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
                    $assignments = Assignment::selectCurrentProjectAssignmentsByStatus(4); ?>
                    <form class="search-bar">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'})"
                               type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'})"
                               type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(25% - 8px);">
                        <div class="custom-select input-floor" style="width: calc(15% - 8px);">
                            <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'}, this)"
                                    name="floor" class="input-floor" required>
                                <option value="">All Floors</option> <?php
                                foreach ($floors as $floor) { ?>
                                    <option value="<?php echo $floor['title']; ?>"><?php echo $floor['title']; ?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="custom-select input-division" style="width: calc(15% - 8px);">
                            <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'}, this)"
                                    name="division" class="input-division" required>
                                <option value="">All Divisions</option>
                                <option value="Custom">Custom</option> <?php
                                foreach ($divisions as $division) { ?>
                                    <option value="<?php echo $division['title']; ?>"><?php echo $division['title']; ?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division', '.search-bar .input-member':'.cell.member'})"
                               type="text" name="name" class="input-member" placeholder="Enter Member Name" required style="width: calc(15% - 8px);">
                    </form>
                    <div class="table-header-container">
                        <div class="header-extension"></div>
                        <div class="header">
                            <div class="head id" style="width: 7.5%">№</div>
                            <div class="head name" style="width: 25%">Assignment Name</div>
                            <div class="head floor" style="width: 15%">Floor</div>
                            <div class="head division" style="width: 15%">Division</div>
                            <div class="head member" style="width: 15%">Member</div>
                            <div class="head tasks" style="width: 7.5%" onclick="sortTable('.head.tasks', '.cell.tasks a')">Tasks</div>
                            <div class="head sum" style="width: 7.5%" onclick="sortTable('.head.sum', '.cell.sum a')">Sum</div>
                            <div class="head" style="width: 7.5%">Open</div>
                        </div>
                        <div class="header-extension"></div>
                    </div>
                    </div>
                    <div class="table"> <?php
                        if ($assignments) {
                            foreach ($assignments as $assignment) { ?>
                                <div class="row">
                                    <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                    <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                    <div class="cell name" style="width: 25%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['assignment_name']; ?></a></div>
                                    <div class="cell floor" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['floor']; ?></a></div>
                                    <div class="cell division" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                    <div class="cell member" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['member']; ?></a></div>
                                    <div class="cell tasks" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['tasks']; ?></a></div>
                                    <div class="cell sum" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_sum']; ?></a></div>
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
                    $assignments = Assignment::selectCurrentProjectAssignmentsByStatus(7); ?>
                    <form class="search-bar">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                        <input onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                               type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(25% - 8px);">
                        <div class="custom-select input-floor" style="width: calc(15% - 8px);">
                            <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                    name="floor" class="input-floor" required>
                                <option value="">All Floors</option> <?php
                                foreach ($floors as $floor) { ?>
                                    <option value="<?php echo $floor['title']; ?>"><?php echo $floor['title']; ?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="custom-select input-division" style="width: calc(15% - 8px);">
                            <select onchange="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-floor .input-floor':'.cell.floor', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                    name="division" class="input-division" required>
                                <option value="">All Divisions</option>
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
                            <div class="head name" style="width: 25%">Assignment Name</div>
                            <div class="head floor" style="width: 15%">Floor</div>
                            <div class="head division" style="width: 15%">Division</div>
                            <div class="head" style="width: 15%">Date</div>
                            <div class="head tasks" style="width: 7.5%" onclick="sortTable('.head.tasks', '.cell.tasks a')">Tasks</div>
                            <div class="head sum" style="width: 7.5%" onclick="sortTable('.head.sum', '.cell.sum a')">Sum</div>
                            <div class="head" style="width: 7.5%">Open</div>
                        </div>
                        <div class="header-extension"></div>
                    </div>
                    </div>
                    <div class="table"> <?php
                        if ($assignments) {
                            foreach ($assignments as $assignment) { ?>
                                <div class="row">
                                    <?php $link = "?a=" . $assignment['assignment_id'] . "&l1=assignment"; ?>
                                    <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                    <div class="cell name" style="width: 25%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['assignment_name']; ?></a></div>
                                    <div class="cell floor" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['floor']; ?></a></div>
                                    <div class="cell division" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['division']; ?></a></div>
                                    <div class="cell" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['status_time']; ?></a></div>
                                    <div class="cell tasks" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['tasks']; ?></a></div>
                                    <div class="cell sum" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_sum']; ?></a></div>
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
            elseif (isset($_POST['force-cancel'])) {
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
            elseif (isset($_POST['lock'])) {
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 2,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "Locked"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                Assignment::update('assignment', $_GET['a'], ["statusid" => $statusID], $redirect);
                Project::projectStatusChanger($assignment['projectid'], $account->id);
            }
            elseif (isset($_POST['unlock'])) {
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "Unlocked"
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
                    'note' => "Assignment made unavailable"
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
                Assignment::remove('assignment', $_GET['a'], "projects.php?p=" . $assignment['projectid'] . "&l1=assignments");
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
            elseif (isset($_POST['cancel'])) {
                $fields = [
                    'assignmentid' => $_GET['a'],
                    'statusid' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "Cancel reason (in lvl3 homes)"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
                Assignment::update('assignment', $_GET['a'], ["statusid" => $statusID], $redirect);
                Project::projectStatusChanger($assignment['projectid'], $account->id);
            }

            if (isset($_GET['l1']) && $_GET['l1'] == "force-cancel") { ?>
                <div class="navbar level-2">
                    <form method="post" class="container-button">
                        <input type="hidden" name="force-cancel">
                        <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="back">
                        <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                    </form>
                </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "assign") {
                $members = Account::selectMembers(); ?>
                <div class="info-bar"></div>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 60%">Member Name</div>
                        <div class="head admin" style="width: 25%">Member Since</div>
                        <div class="head admin" style="width: 7.5%">Select</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    foreach ($members as $member) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $member['id']); ?>" class="content"></div>
                            <div class="cell" style="width: 60%"><input type="submit" name="submit" value="<?php echo $member['username']; ?>" class="content"></div>
                            <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo $member['reg_time_date']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="assign" value="<?php echo $member['id']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "lock") { ?>
                <div class="navbar level-2">
                    <form method="post" class="container-button">
                        <input type="hidden" name="lock">
                        <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="back">
                        <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                    </form>
                </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "unlock") { ?>
                <div class="navbar level-2">
                    <form method="post" class="container-button">
                        <input type="hidden" name="unlock">
                        <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="back">
                        <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                    </form>
                </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "publish") { ?>
                <div class="navbar level-2">
                    <form method="post" class="container-button">
                        <input type="hidden" name="publish">
                        <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="back">
                        <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                    </form>
                </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "unpublish") { ?>
                <div class="navbar level-2">
                    <form method="post" class="container-button">
                        <input type="hidden" name="unpublish">
                        <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="back">
                        <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                    </form>
                </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "complete") { ?>
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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") { ?>
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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "accept") { ?>
                <div class="navbar level-2">
                    <form method="post" class="container-button">
                        <input type="hidden" name="accept">
                        <input type="submit" name="submit" value="CONFIRM" class="button">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="back">
                        <input type="submit" name="submit" value="NOT NOW" class="button">
                    </form>
                </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "cancel") { ?>
                <div class="navbar level-2">
                    <form method="post" class="container-button">
                        <input type="hidden" name="cancel">
                        <input type="submit" name="submit" value="CONFIRM" class="button">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="back">
                        <input type="submit" name="submit" value="NOT NOW" class="button">
                    </form>
                </div>
                </div> <?php
            }
        }
        // Task options
        elseif (isset($_GET['options']) && isset($_GET['t'])) {
            if (isset($_POST['back'])) {
                if (isset($_GET['l1']))
                    unset($_GET['l1']);
                $query_string = http_build_query($_GET);
                header('Location: assignments.php?' . $query_string);
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
                Task::update('task', $_GET['t'], ["statusid" => $statusID], $redirect);
                Assignment::assignmentStatusChanger($assignment['id'], $account->id);
            }
            elseif (isset($_POST['problem'])) {
                if ($assignment['status_id'] != 5)
                    $asgFields = [
                        'assignmentid' => $assignment['id'],
                        'statusid' => 5,
                        'time' => date("Y-m-d H-i-s"),
                        'assigned_by' => $account->id,
                        'assigned_to' => $account->id,
                        'note' => "Task problem"
                    ];
                $taskFields = [
                    'taskid' => $_GET['t'],
                    'statusid' => 5,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id
                ];
                if (isset($_GET['l2']) && $_GET['l2'] == "file" && $_POST['submit'] == "NO FILE") $taskFields['note'] = "no file";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "file" && $_POST['submit'] == "CAN'T OPEN") $taskFields['note'] = "can't open file";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "file" && $_POST['submit'] == "NOT PREPARED") $taskFields['note'] = "file not prepared";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "file" && $_POST['submit'] == "WRONG FILE") $taskFields['note'] = "wrong file";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "link" && $_POST['submit'] == "NO LINK") $taskFields['note'] = "no link";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "link" && $_POST['submit'] == "WRONG LINK") $taskFields['note'] = "wrong link";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "link" && $_POST['submit'] == "NOT PREPARED") $taskFields['note'] = "link not prepared";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "completion" && $_POST['submit'] == "COMPLICATED") $taskFields['note'] = "complicated";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "completion" && $_POST['submit'] == "CAN'T") $taskFields['note'] = "can't";
                elseif (isset($_GET['l2']) && $_GET['l2'] == "completion" && $_POST['submit'] == "HELP FINISH") $taskFields['note'] = "help finish";

                // Update assignment status (if not already pending(problem) status)
                if ($assignment['status_id'] != 5) {
                    $asgStatusID = Assignment::insert('assignment_status', $asgFields, true, false);
                    Assignment::update('assignment', $assignment['id'], ["statusid" => $asgStatusID], false);
                }

                // Update task status
                $taskStatusID = Task::insert('task_status', $taskFields, true, false);
                $redirect = "assignments.php?a=" . $assignment['id'] . "&l1=tasks&l2=" . $_GET['t'];
                Task::update('task', $_GET['t'], ["statusid" => $taskStatusID], $redirect);
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
                Task::update('task', $_GET['t'], ["statusid" => $statusID], $redirect);
                if ($assignment['status_id'] != 6)
                    Assignment::assignmentStatusChanger($assignment['id'], $account->id);
            }
            elseif (isset($_POST['activate'])) {
                $fields = [
                    'taskid' => $_GET['t'],
                    'statusid' => 4,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "Activated"
                ];

                $statusID = Task::insert('task_status', $fields, true, false);
                $redirect = "assignments.php?a=" . $assignment['id'] . "&l1=tasks&l2=" . $_GET['t'];
                Task::update('task', $_GET['t'], ["statusid" => $statusID], $redirect);

                // Check if more tasks are pending(problem)
                $tasks = Task::selectAssignmentTasks($assignment['id']);
                $hasAnotherPendingTask = false;
                foreach ($tasks as $task) {
                    if ($task['statusid'] == 5) {
                        $hasAnotherPendingTask = true;
                        break;
                    }
                }
                if (!$hasAnotherPendingTask) {
                    $fields = [
                        'assignmentid' => $assignment['id'],
                        'statusid' => 4,
                        'time' => date("Y-m-d H-i-s"),
                        'assigned_by' => $account->id,
                        'assigned_to' => $assignment['assigned_by'],
                        'note' => "Activated"
                    ];
                    $statusID = Assignment::insert('assignment_status', $fields, true, false);
                    Assignment::update('assignment', $assignment['id'], ["statusid" => $statusID], false);
                }
            }
            elseif (isset($_POST['delete'])) {
                Task::remove('task', $_GET['t'], "assignments.php?a=" . $assignment['id'] . "&l1=tasks");
                Task::RenumberTasksInAssignment($assignment['id']);
            }

            if (isset($_GET['l1']) && $_GET['l1'] == "submit") { ?>
                <div class="navbar level-2">
                    <form method="post" class="container-button">
                        <input type="hidden" name="submit-complete">
                        <input type="submit" name="submit" value="CONFIRM" class="button">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="back">
                        <input type="submit" name="submit" value="NOT NOW" class="button">
                    </form>
                </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "problem") {
                if (isset($_GET['l2']) && $_GET['l2'] == "file") { ?>
                    <div class="navbar level-3">
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="NO FILE" class="button">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="CAN'T OPEN" class="button">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="NOT PREPARED" class="button">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="WRONG FILE" class="button">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "link") { ?>
                    <div class="navbar level-3">
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="NO LINK" class="button">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="WRONG LINK" class="button">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="NOT PREPARED" class="button">
                        </form>
                    </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "completion") { ?>
                    <div class="navbar level-3">
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="COMPLICATED" class="button">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="CAN'T" class="button">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="problem">
                            <input type="submit" name="submit" value="HELP FINISH" class="button">
                        </form>
                    </div>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "complete") { ?>
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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "activate") { ?>
                <div class="navbar level-2">
                    <form method="post" class="container-button">
                        <input type="hidden" name="activate">
                        <input type="submit" name="submit" value="CONFIRM" class="button admin-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="back">
                        <input type="submit" name="submit" value="NOT NOW" class="button admin-menu">
                    </form>
                </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") { ?>
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

        if (isset($_GET['l1']) && $_GET['l1'] == "assignment") {
            if ($assignment['status_id'] == '3') { ?>
                <div class="navbar level-2 unselected">
                    <div class="container-button">
                        <a href="<?php echo "?a=" . $_GET['a'] . "&options&l1=accept"; ?>" target="_self" class="button"><span>Accept</span></a>
                    </div>
                </div>
                </div> <?php
            }
            elseif ($assignment['status_id'] == '4' && $assignment['assigned_to'] == $account->id) { ?>
                <div class="navbar level-2 unselected">
                    <div class="container-button">
                        <a href="<?php echo "?a=" . $_GET['a'] . "&options&l1=cancel"; ?>" target="_self" class="button"><span>Cancel</span></a>
                    </div>
                </div>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "tasks") {
            if (isset($_GET['l2'])) {
                $task = Task::selectTask($_GET['l2']);
                if ($task) {
                    if ($task['statusid'] != 7) { ?>
                        <div class="navbar level-3 unselected"> <?php
                            if ($account->manager == 1) { ?>
                                <div class="container-button">
                                    <a href="" target="_self" class="button"><span>Edit</span></a>
                                </div> <?php
                            } ?>
                            <div class="container-button">
                                <a href="" target="_self" class="button"><span>Comment</span></a>
                            </div>
                            <div class="container-button">
                                <a href="<?php echo "?t=" . $_GET['l2'] . "&options"; ?>" target="_self" class="button"><span>Options</span></a>
                            </div>
                        </div> <?php
                    } ?>
                    </div>

                    <div class="info-bar extended"> <?php
                        if ($task['statusid'] != 5) { ?>
                            <div class="section">
                                <div class="stage">STATUS:</div>
                                <div class="content"><?php echo $task['status2']; ?></div>
                            </div> <?php
                        }
                        else { ?>
                            <div class="section">
                                <div class="stage">STATUS:</div>
                                <div class="content"><?php echo $task['status2'] . " - " . $task['note']; ?></div>
                            </div> <?php
                        } ?>
                        <div class="section">
                            <div class="stage">ACTION:</div>
                            <div class="content"><?php echo $task['action']; ?></div>
                        </div> <?php
                        if ($task['estimated'] != null) { ?>
                            <div class="section">
                                <div class="stage">VALUE:</div>
                                <div class="content"><?php echo $task['estimated'] . " min"; ?></div>
                            </div> <?php
                        }
                        elseif ($task['value'] != null) { ?>
                            <div class="section">
                                <div class="stage">VALUE:</div>
                                <div class="content"><?php echo $task['value'] . "€"; ?></div>
                            </div> <?php
                        }
                        else { ?>
                            <div class="section">
                                <div class="stage">VALUE:</div>
                                <div class="content"><?php echo "None"; ?></div>
                            </div> <?php
                        } ?>
                    </div>

                    <div class="objective-container">
                        <div class="objective"><?php echo ($task['objective']); ?></div>
                        <div class="description"><?php echo $task['description']; ?></div>
                    </div>

                    <div class="link-section">
                        <div class="link-type">
                            <div class="link-title">Info</div> <?php
                            $linksInfo = Task::selectTaskLinks($_GET['l2'], 1);
                            if ($linksInfo) {
                                foreach ($linksInfo as $link) {
                                    if ($link['link'] != null) {
                                        $link['link'] = "?a=" . $_GET['a'] . $link['link'];
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
                                }
                            } ?>
                        </div>
                        <div class="link-type">
                            <div class="link-title">Download</div> <?php
                            $linksRes = Task::selectTaskLinks($_GET['l2'], 2);
                            if ($linksRes)
                                foreach ($linksRes as $link) {
                                    if ($link['link'] != null) {
                                        $link['link'] = "?a=" . $_GET['a'] . $link['link'];
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
                            <div class="link-title">Upload</div> <?php
                            $linksRnD = Task::selectTaskLinks($_GET['l2'], 3);
                            if ($linksRnD)
                                foreach ($linksRnD as $link) {
                                    if ($link['link'] != null) {
                                        $link['link'] = "?a=" . $_GET['a'] . $link['link'];
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
                        <div class="link-type">
                            <div class="link-title">Tutorial</div> <?php
                            $linksRnD = Task::selectTaskLinks($_GET['l2'], 3);
                            if ($linksRnD)
                                foreach ($linksRnD as $link) {
                                    if ($link['link'] != null) {
                                        $link['link'] = "?a=" . $_GET['a'] . $link['link'];
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

                    <div class="comment-container">
                        <div class="comment-header">
                            <span class="align-helper"><?php echo "Added 5 minutes ago"; ?></span>
                            <span class="title"><?php echo "Comment #1"; ?></span>
                            <span class="added"><?php echo "Added 5 minutes ago"; ?></span>
                        </div>
                        <div class="comment-body">Custom comments and revision requests for this task will be shown here</div>
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