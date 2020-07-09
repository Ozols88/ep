<?php
ob_start();
$page = "assignments";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    // Link for exit button
    if (!isset($_GET['a']))
        $_SESSION['backPage'] = $_SERVER['REQUEST_URI'];

    require_once "includes/header.php"; ?>

    <div class="menu"> <?php
    require "includes/menu.php";
    if (!isset($_GET['a'])) {
        $divisions = Assignment::selectAllDivisions(); // For search bar
        $floors = Project::selectFloors(); // For search bar
        if (isset($_GET['l1']) && $_GET['l1'] == "to-do") {
            $assignments = Assignment::selectAssignmentListByStatus(2); ?>
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
            elseif (isset($_GET['l2']) && $_GET['l2'] == "active") {
                $assignments = Assignment::selectAssignmentListByStatusAndAccount(3, $account->id); ?>
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
                $assignments = Assignment::selectAssignmentListByStatusAndAccount(5, $account->id); ?>
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
            if (isset($_GET['l2']) && $_GET['l2'] == "new") {
                $assignments = Assignment::selectCurrentProjectAssignmentsByStatus(1); ?>
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
            elseif (isset($_GET['l2']) && $_GET['l2'] == "available") {
                $assignments = Assignment::selectCurrentProjectAssignmentsByStatus(2); ?>
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
            elseif (isset($_GET['l2']) && $_GET['l2'] == "active") {
                $assignments = Assignment::selectCurrentProjectAssignmentsByStatus(3); ?>
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
            elseif (isset($_GET['l2']) && $_GET['l2'] == "pending") {
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
                $assignments = Assignment::selectCurrentProjectAssignmentsByStatus(5); ?>
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
            else { ?>
                </div> <?php
            }
        }
        else { ?>
            </div> <?php
        }
    }
    elseif (isset($assignment)) {
        if (isset($_GET['l1']) && $_GET['l1'] == "assignment") {
            if (isset($_POST['submit'])) {
                if (isset($_POST['accept']))
                    Assignment::insertAssignmentStatus($_GET['a'], 1, $account->id, $account->id, "User accepted assignment");
                if (isset($_POST['cancel']))
                    Assignment::insertAssignmentStatus($_GET['a'], 5, $account->id, null, "User canceled his assignment");
            }

            if ($assignment['status_id'] == '2') { ?>
                <div class="navbar level-2 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="">
                        <input type="submit" name="submit" value="Maybe Later" class="button">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="accept">
                        <input type="submit" name="submit" value="Accept" class="button">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="">
                        <input type="submit" name="submit" value="Not Interested" class="button">
                    </form>
                </div>
                </div> <?php
            }
            elseif ($assignment['status_id'] == '3') { ?>
                <div class="navbar level-2 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="cancel">
                        <input type="submit" name="submit" value="Cancel" class="button">
                    </form>
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
                if ($task) { ?>
                    <div class="navbar level-3 unselected">
                        <form method="post" class="container-button">
                            <input type="submit" name="submit" value="Edit" class="button">
                        </form>
                        <form method="post" class="container-button">
                            <input type="submit" name="submit" value="Need Help" class="button">
                        </form>
                        <form method="post" class="container-button">
                            <input type="submit" name="submit" value="Complete" class="button">
                        </form>
                        <form method="post" class="container-button">
                            <input type="submit" name="submit" value="Can't Do It" class="button">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="delete">
                            <input type="submit" name="submit" value="Remove" class="button">
                        </form>
                    </div> <?php

                    if (isset($_POST['delete'])) {
                        Task::remove('task', $_GET['l2'], "assignments.php?a=" . $_GET['a'] . "&l1=tasks");
                        $projectID = Assignment::selectAssignmentByID($_GET['a'])['projectid'];
                        Task::RenumberTasksInProject($projectID);
                    } ?>

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
        elseif (isset($_GET['l1']) && $_GET['l1'] == "options") {
            if (isset($_POST['submit'])) {
                if (isset($_POST['delete']))
                    Assignment::remove('assignment', $_GET['a'], "projects.php?p=" . $assignment['projectid'] . "&l1=assignments");
                if (isset($_POST['publish']))
                    Assignment::insertAssignmentStatus($_GET['a'], 2, $account->id, null, "Assignment made available");
            } ?>

            <div class="navbar level-2 unselected"> <?php
                if ($assignment['status_id'] == 1) { ?>
                    <form method="post" class="container-button">
                        <input type="hidden" name="publish">
                        <input type="submit" name="submit" value="Make Available" class="button">
                    </form> <?php
                }
                if (true) { ?>
                    <form method="post" class="container-button">
                        <input type="hidden" name="delete">
                        <input type="submit" name="submit" value="Remove" class="button">
                    </form> <?php
                } ?>
            </div>
            </div> <?php
        }
    }

    require_once "includes/footer.php";

}
else require_once "login.php";