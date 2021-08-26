<?php
ob_start();
$page = "member";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];

    require_once "includes/header.php"; ?>

    <div class="menu"> <?php
    require "includes/menu.php";
    if (!isset($member)) {
        if (isset($_GET['l1']) && $_GET['l1'] == "membership") {
            $acc = Database::selectAccountByID($account->id); ?>
            </div>
            <div class="overview-content">
            <div class="info-bar short">
                <div class="section">
                    <div class="stage active">STATUS:</div>
                    <div class="content"><?php echo $acc['status_txt']; ?></div>
                </div>
            </div>
            <div class="info-bar tiny">
                <div class="section active">
                    <div class="content"><?php echo $acc['manager_txt']; ?></div>
                </div>
            </div>
            <div class="overview">
                <div class="top">
                    <div class="box">
                        <div class="title"><?php echo $acc['username']; ?></div>
                        <div class="data"><?php echo $acc['description']; ?></div>
                    </div>
                </div>
                <div class="info-bar">
                    <div class="section active">
                        <div class="stage active"><?php echo $acc['reg_time3']; ?></div>
                        <div class="content">EP SYSTEM MEMBER</div>
                    </div>
                </div>
            </div>
            <div class="info-bar" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                <div class="section line-right active">
                    <div class="stage active"><?php echo $acc['departments']; ?></div>
                    <div class="content">DEPARTMENTS</div>
                </div>
                <div class="section line-left active">
                    <div class="stage active"><?php echo $acc['divisions']; ?></div>
                    <div class="content">DIVISIONS</div>
                </div>
            </div>
            <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                <div class="section">
                    <div class="content light"><?php echo $acc['reg_time2']; ?></div>
                </div>
            </div>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "divisions") {
            $departments = Assignment::selectDepartments(); ?>
            <form class="search-bar with-space">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                       type="text" name="name" class="input-name" placeholder="Enter Division Name" required style="width: calc(20% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                       type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(50% - 8px);">
                <div class="custom-select input-depart" style="width: calc(15% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'}, this)"
                            name="depart" class="input-depart" required>
                        <option value="">All Departments</option> <?php
                        foreach ($departments as $depart) { ?>
                            <option value="<?php echo $depart['title']; ?>"><?php echo $depart['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
            </form>
            <div class="table-header-container">
                <div class="header-extension"></div>
                <div class="header">
                    <div class="head" style="width: 7.5%">№</div>
                    <div class="head" style="width: 20%">Division Name</div>
                    <div class="head" style="width: 50%">Division Description</div>
                    <div class="head" style="width: 15%">Department</div>
                    <div class="head" style="width: 7.5%"></div>
                </div>
                <div class="header-extension"></div>
            </div>
            </div>
            <div class="table"> <?php
                $divisions = Database::selectAccountDivisions($account->id);
                if ($divisions) {
                    foreach ($divisions as $division) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a class="content"><?php echo "#" . sprintf('%03d', $division['id']); ?></a></div>
                            <div class="cell name" style="width: 20%"><a class="content"><?php echo $division['title']; ?></a></div>
                            <div class="cell description" style="width: 50%"><a class="content"><?php echo $division['description']; ?></a></div>
                            <div class="cell depart" style="width: 15%"><a class="content"><?php echo $division['department']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a class="content empty-button"></a></div>
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO DIVISIONS</div> <?php
                } ?>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "members") {
            $members = Database::selectMembers(); ?>
            <div class="search-bar with-space admin">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-status .input-status':'.cell.status'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-status .input-status':'.cell.status'})"
                       type="text" name="name" class="input-name" placeholder="Enter Member Name" required style="width: calc(20% - 8px);">
                <div class="custom-select input-status" style="width: calc(10% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-status .input-status':'.cell.status'}, this)"
                            name="status" class="input-status" required>
                        <option value="">All</option>
                        <option value="Active">Active</option>
                        <option value="Paused">Paused</option>
                    </select>
                </div>
            </div>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Member Name</div>
                    <div class="head admin" style="width: 10%">Status</div>
                    <div class="head admin divisions" style="width: 7.5%" onclick="sortTable('.head.divisions', '.cell.divisions .content')">Divisions</div>
                    <div class="head admin a-asg" style="width: 7.5%" onclick="sortTable('.head.a-asg', '.cell.a-asg .content')">Active</div>
                    <div class="head admin p-asg" style="width: 7.5%" onclick="sortTable('.head.p-asg', '.cell.p-asg .content')">Pending</div>
                    <div class="head admin c-asg" style="width: 7.5%" onclick="sortTable('.head.c-asg', '.cell.c-asg .content')">Completed</div>
                    <div class="head admin unpaid" style="width: 7.5%" onclick="sortTable('.head.unpaid', '.cell.unpaid .content')">Unpaid</div>
                    <div class="head admin payments" style="width: 7.5%" onclick="sortTable('.head.payments', '.cell.payments .content')">Payments</div>
                    <div class="head admin date" style="width: 10%" onclick="sortDates('.head.date', '.cell.date .content', '.online')">Last Online</div>
                    <div class="head admin" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div>
            <div class="table admin"> <?php
                if ($members) {
                    foreach ($members as $member) { ?>
                        <div class="row">
                            <?php $link = "?m=" . $member['id'] . "&l1=overview"; ?>
                            <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%03d', $member['id']); ?></a></div>
                            <div class="cell name" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $member['username']; ?></a></div>
                            <div class="cell status" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $member['status_txt']; ?></a></div>
                            <div class="cell divisions" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $member['division_count']; ?></a></div>
                            <div class="cell a-asg" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $member['asg_active']; ?></a></div>
                            <div class="cell p-asg" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $member['asg_pending']; ?></a></div>
                            <div class="cell c-asg" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $member['asg_completed']; ?></a></div>
                            <div class="cell unpaid" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $member['asg_unpaid']; ?></a></div>
                            <div class="cell payments" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $member['payment_count']; ?></a></div>
                            <div class="cell date" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $member['last_online']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            <input class="online" type="hidden" value="<?php echo $member['last_activity_timestamp']; ?>">
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
        if (isset($_GET['options'])) {
            if (isset($_POST['back'])) {
                if (isset($_GET['l2'])) {
                    unset($_GET['l2']);
                    $query_string = http_build_query($_GET);
                    header('Location: member.php?' . $query_string);
                }
                elseif (isset($_GET['l1']))
                    header('Location: member.php?m=' . $_GET['m'] . '&l1=overview');
            }
            elseif (isset($_POST['activate'])) {
                $redirect = "member.php?m=" . $_GET['m'] . "&l1=overview";
                Database::update('account', $_GET['m'], ["status" => 1], $redirect);
            }
            elseif (isset($_POST['pause'])) {
                $redirect = "member.php?m=" . $_GET['m'] . "&l1=overview";
                Database::update('account', $_GET['m'], ["status" => 0], $redirect);
            }
            elseif (isset($_POST['delete'])) {
                $redirect = "member.php?l1=members";
                Database::remove('account', $_GET['m'], $redirect);
            }

            if (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                if (isset($_GET['l2']) && $_GET['l2'] == "divisions") {
                    if (isset($_GET['l3']) && $_GET['l3'] == "delete") {
                        if (isset($_POST['del-div']))
                            Database::remove('account_division', $_POST['del-div'], false);

                        $departments = Assignment::selectDepartments();
                        include_once "includes/info-bar.php"; ?>
                        <div class="table-header-container">
                            <div class="header-extension admin"></div>
                            <div class="header">
                                <div class="head admin" style="width: 7.5%">№</div>
                                <div class="head admin" style="width: 20%">Division Name</div>
                                <div class="head admin" style="width: 50%">Description</div>
                                <div class="head admin" style="width: 15%">Department</div>
                                <div class="head admin" style="width: 7.5%">Remove</div>
                            </div>
                            <div class="header-extension admin"></div>
                        </div>
                        </div>
                        <div class="table admin"> <?php
                            $divisions = Database::selectAccountDivisions($_GET['m']);
                            if ($divisions) {
                                foreach ($divisions as $division) { ?>
                                    <form method="post" class="row">
                                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $division['id']); ?>" class="content"></div>
                                        <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $division['title']; ?>" class="content"></div>
                                        <div class="cell description" style="width: 50%"><input type="submit" name="submit" value="<?php echo $division['description']; ?>" class="content"></div>
                                        <div class="cell depart" style="width: 15%"><input type="submit" name="submit" value="<?php echo $division['department']; ?>" class="content"></div>
                                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                                        <input type="hidden" name="del-div" value="<?php echo $division['id']; ?>">
                                    </form> <?php
                                }
                            }
                            else { ?>
                                <div class="empty-table">NO DIVISIONS</div> <?php
                            } ?>
                        </div> <?php
                    }
                    elseif (isset($_GET['l3']) && $_GET['l3'] == "add") {
                        if (isset($_POST['div'])) {
                            Database::insert('account_division', ['accountid' => $_GET['m'], 'divisionid' => $_POST['div']], false, false);

                            $currentSessionID = session_id();
                            session_write_close();

                            session_id($_GET['m']);
                            session_start();
                            $account->divisions = Database::selectStatic(array($_GET['m']), "SELECT * FROM `account_division` WHERE `accountid` = ?");
                            session_write_close();

                            session_id($currentSessionID);
                            session_start();

                            $query_string = http_build_query($_GET);
                            header('Location: member.php?' . $query_string);
                            unset($_SESSION['edit-member']);
                        }

                        $departments = Assignment::selectDepartments();
                        include_once "includes/info-bar.php"; ?>
                        <form class="search-bar admin">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                                   type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                                   type="text" name="name" class="input-name" placeholder="Enter Division Name" required style="width: calc(20% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                                   type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(50% - 8px);">
                            <div class="custom-select input-depart" style="width: calc(15% - 8px);">
                                <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'}, this)"
                                        name="depart" class="input-depart" required>
                                    <option value="">All Departments</option> <?php
                                    foreach ($departments as $depart) { ?>
                                        <option value="<?php echo $depart['title']; ?>"><?php echo $depart['title']; ?></option> <?php
                                    } ?>
                                </select>
                            </div>
                        </form>
                        <div class="table-header-container">
                            <div class="header-extension admin"></div>
                            <div class="header">
                                <div class="head admin" style="width: 7.5%">№</div>
                                <div class="head admin" style="width: 20%">Division Name</div>
                                <div class="head admin" style="width: 50%">Description</div>
                                <div class="head admin" style="width: 15%">Department</div>
                                <div class="head admin" style="width: 7.5%">Add</div>
                            </div>
                            <div class="header-extension admin"></div>
                        </div>
                        </div>
                        <div class="table admin"> <?php
                            $allDivisions = Assignment::selectDivisions();
                            $accDivisions = Database::selectAccountDivisions($_GET['m']);
                            if ($accDivisions) {
                                foreach ($accDivisions as $accDivision) {
                                    foreach ($allDivisions as $allDivision) {
                                        if ($accDivision['divisionid'] == $allDivision['id'])
                                            unset($allDivisions[$allDivision['id']]);
                                    }
                                }
                            }
                            if ($allDivisions) {
                                foreach ($allDivisions as $division) { ?>
                                    <form method="post" class="row">
                                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $division['id']); ?>" class="content"></div>
                                        <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $division['title']; ?>" class="content"></div>
                                        <div class="cell description" style="width: 50%"><input type="submit" name="submit" value="<?php echo $division['description']; ?>" class="content"></div>
                                        <div class="cell depart" style="width: 15%"><input type="submit" name="submit" value="<?php echo $division['department']; ?>" class="content"></div>
                                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                                        <input type="hidden" name="div" value="<?php echo $division['id']; ?>">
                                    </form> <?php
                                }
                            }
                            else { ?>
                                <div class="empty-table">NO DIVISIONS</div> <?php
                            } ?>
                        </div> <?php
                    }
                    else { ?>
                        </div> <?php
                    }
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "name") {
                    if (isset($_POST['username']))
                        Database::update('account', $_GET['m'], ['username' => $_POST['username']], "member.php?m=" . $_GET['m'] . "&options&l1=edit"); ?>

                    <div class="navbar level-3 unselected">
                        <form method="post" id="username" class="container-button">
                            <input type="hidden" name="username">
                            <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="table-header-container">
                        <div class="header-extension small admin"></div>
                        <div class="header small">
                            <div class="head admin">Member Name</div>
                        </div>
                        <div class="header-extension small admin"></div>
                    </div>
                    </div>
                    <div class="table small">
                        <div class="row">
                            <input form="username" name="username" class="field admin" placeholder="Enter Member Name Here" maxlength="50" value="<?php if (isset($member['username'])) echo htmlspecialchars($member['username']); ?>">
                        </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                    if (isset($_POST['description']))
                        Database::update('account', $_GET['m'], ['description' => $_POST['description']], "member.php?m=" . $_GET['m'] . "&options&l1=edit"); ?>

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
                            <div class="head admin">Member Description</div>
                        </div>
                        <div class="header-extension large admin"></div>
                    </div>
                    </div>
                    <div class="table large">
                        <div class="row">
                            <input form="description" name="description" class="field admin" placeholder="Enter Member Description Here" maxlength="255" value="<?php if (isset($member['description'])) echo htmlspecialchars($member['description']); ?>">
                        </div>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "password") {
                    if (isset($_POST['password']))
                        Database::update('account', $_GET['m'], ['password' => password_hash($_POST['password'], PASSWORD_DEFAULT)], "member.php?m=" . $_GET['m'] . "&options&l1=edit"); ?>

                    <div class="navbar level-3 unselected">
                        <form method="post" id="password" class="container-button">
                            <input type="hidden" name="password">
                            <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="table-header-container">
                        <div class="header-extension small admin"></div>
                        <div class="header small">
                            <div class="head admin">Member Password</div>
                        </div>
                        <div class="header-extension small admin"></div>
                    </div>
                    </div>
                    <div class="table small">
                        <div class="row">
                            <input form="password" name="password" class="field admin" placeholder="Enter Member Password Here" maxlength="50">
                        </div>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "activate") { ?>
                <div class="navbar level-2 current unselected">
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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "pause") { ?>
                <div class="navbar level-2 current unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="pause">
                        <input type="submit" name="submit" value="Confirm Pause" class="button admin-menu">
                        <input type="submit" name="submit" value="" class="home-menu admin">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="back">
                        <input type="submit" name="submit" value="Don't Pause" class="button admin-menu">
                        <input type="submit" name="submit" value="" class="home-menu admin">
                    </form>
                </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") { ?>
                <div class="navbar level-2 current unselected">
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

        if (isset($_GET['l1']) && $_GET['l1'] == "overview") { ?>
            </div>
            <div class="overview-content">
                <div class="info-bar short">
                    <div class="section">
                        <div class="stage active">MANAGER:</div>
                        <div class="content"><?php if ($member['manager']) echo "Yes"; else echo "No"; ?></div>
                    </div>
                    <div class="section">
                        <div class="stage active">STATUS:</div>
                        <div class="content"><?php if ($member['status']) echo "Active"; else echo "Paused"; ?></div>
                    </div>
                    <div class="section">
                        <div class="stage active">PAYMENTS:</div>
                        <div class="content"><?php echo $member['payment_count']; ?></div>
                    </div>
                </div>
                <div class="overview">
                    <div class="top">
                        <div class="box">
                            <div class="title"><?php echo $member['username']; ?></div>
                            <div class="data"><?php echo $member['description']; ?></div>
                        </div>
                    </div>
                    <div class="mid tbl">
                        <div class="table-container">
                            <div class="table ow"> <?php
                                $divisions = Database::selectAccountDivisions($_GET['m']);
                                if ($divisions) {
                                    foreach ($divisions as $div) { ?>
                                        <div class="row">
                                            <div class="cell id" style="width: 7.5%"><a class="content"><?php echo "#" . sprintf('%03d', $div['id']); ?></a></div>
                                            <div class="cell name" style="width: 20%"><a class="content"><?php echo $div['title']; ?></a></div>
                                            <div class="cell description" style="width: 50%"><a class="content"><?php echo $div['description'] . " Comments"; ?></a></div>
                                            <div class="cell depart" style="width: 15%"><a class="content"><?php echo $div['department'] . " Links"; ?></a></div>
                                            <div class="cell" style="width: 7.5%"><a class="content empty-button"></a></div>
                                        </div> <?php
                                    }
                                }
                                else { ?>
                                    <div class="empty-table">NO DIVISIONS</div> <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                    <div class="section">
                        <div class="content light"><?php echo $member['reg_time2']; ?></div>
                    </div>
                </div>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "divisions") {
            if (isset($_POST['edit-div'])) {
                $_SESSION['memberDivisionList'] = $_GET['m'];
                header('Location: member.php?m=' . $_GET['m'] . '&options&l1=edit&l2=divisions&l3=delete');
            } ?>

            <div class="navbar level-2 unselected">
                <form method="post" class="container-button">
                    <input type="hidden" name="edit-div">
                    <input type="submit" name="submit" value="+/- Divisions" class="button admin-menu">
                </form>
            </div> <?php
            $departments = Assignment::selectDepartments(); ?>
            <form class="search-bar with-space admin">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                       type="text" name="name" class="input-name" placeholder="Enter Division Name" required style="width: calc(20% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                       type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(50% - 8px);">
                <div class="custom-select input-depart" style="width: calc(15% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'}, this)"
                            name="depart" class="input-depart" required>
                        <option value="">All Departments</option>
                        <option value="None">None</option> <?php
                        foreach ($departments as $depart) { ?>
                            <option value="<?php echo $depart['title']; ?>"><?php echo $depart['title']; ?></option> <?php
                        } ?>
                    </select>
                </div>
            </form>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Division Name</div>
                    <div class="head admin" style="width: 50%">Division Description</div>
                    <div class="head admin" style="width: 15%">Department</div>
                    <div class="head admin" style="width: 7.5%"></div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div>
            <div class="table admin"> <?php
                $divisions = Database::selectAccountDivisions($_GET['m']);
                if ($divisions) {
                    foreach ($divisions as $division) { ?>
                        <div class="row">
                            <div class="cell id" style="width: 7.5%"><a class="content"><?php echo "#" . sprintf('%03d', $division['id']); ?></a></div>
                            <div class="cell name" style="width: 20%"><a class="content"><?php echo $division['title']; ?></a></div>
                            <div class="cell description" style="width: 50%"><a class="content"><?php echo $division['description']; ?></a></div>
                            <div class="cell depart" style="width: 15%"><a class="content"><?php echo $division['department']; ?></a></div>
                            <div class="cell" style="width: 7.5%"><a class="content empty-button"></a></div>
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO DIVISIONS</div> <?php
                } ?>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "payments") {
            if (isset($_POST['open-payment'])) {
                $_SESSION['memberPage'] = $_GET['m'];
                header('Location: numbers.php?py=' . $_POST['open-payment'] . '&l1=overview');
            }
            elseif (isset($_POST['new-payment'])) {
                $_SESSION['new-payment']['info']['member'] = Account::selectAccountByID($_GET['m'])['username'];
                if (strlen($_SESSION['new-payment']['info']['member']) > InfobarCharLimit)
                    $_SESSION['new-payment']['info']['member'] = substr($_SESSION['new-payment']['info']['member'], 0, InfobarCharLimit) . "...";
                $_SESSION['new-payment']['fields']['accountid'] = $_GET['m'];

                $_SESSION['new-payment']['stage'] = '2';
                if (!isset($_SESSION['new-payment']['assignments']))
                    $_SESSION['new-payment']['assignments'] = ""; // Info bar fix

                $_SESSION['new-payment']['exitLink'] = "member.php?m=" . $_GET['m'] . "&l1=payments";
                header('Location: new-payment.php');
            } ?>

            <div class="navbar level-2 unselected">
                <form method="post" class="container-button">
                    <input type="hidden" name="new-payment">
                    <input type="submit" name="submit" value="+ Payment" class="button admin-menu">
                </form>
            </div>
            </div>
            <form class="search-bar with-space admin">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="description" class="input-description" placeholder="Enter Payment Description" required style="width: calc(40% - 8px);">
            </form>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 40%">Payment Description</div>
                    <div class="head admin date" style="width: 20%" onclick="sortDates('.head.date', '.cell.date .content', '.time')">Date</div>
                    <div class="head admin assignments" style="width: 10%" onclick="sortTable('.head.assignments', '.cell.assignments .content')">Assignments</div>
                    <div class="head admin total" style="width: 15%" onclick="sortTable('.head.total', '.cell.total .content')">Total</div>
                    <div class="head admin" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            <div class="table admin"> <?php
                $payments = Assignment::selectPaymentsByAccount($_GET['m']);
                if ($payments) {
                    foreach ($payments as $payment) {
                        $link = "numbers.php?py=" . $payment['id'] . "&l1=overview"; ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" class="content" value="<?php echo "#" . sprintf('%05d', $payment['id']); ?>"></div>
                            <div class="cell description" style="width: 40%"><input type="submit" class="content" value="<?php echo $payment['description']; ?>"></div>
                            <div class="cell date" style="width: 20%"><input type="submit" class="content" value="<?php echo $payment['date']; ?>"></div>
                            <div class="cell assignments" style="width: 10%"><input type="submit" class="content" value="<?php echo $payment['assignment_count']; ?>"></div>
                            <div class="cell total" style="width: 15%"><input type="submit" class="content" value="<?php echo $payment['total'] . "€"; ?>"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" class="content open-button"></div>
                            <input class="time" type="hidden" value="<?php echo $payment['time']; ?>">
                            <input type="hidden" name="open-payment" value="<?php echo $payment['id']; ?>">
                        </form> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO PAYMENTS</div> <?php
                } ?>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "assignments") {
            if (isset($_POST['open-asg'])) {
                $_SESSION['memberPage'] = $_GET['m'];
                header('Location: assignments.php?a=' . $_POST['open-asg'] . '&l1=assignment');
            }

            $divisions = Assignment::selectDivisions(); ?>
            </div>
            <form class="search-bar admin with-space">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-status .input-status':'.cell.status', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-status .input-status':'.cell.status', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                       type="text" name="objective" class="input-objective" placeholder="Enter Assignment Objective" required style="width: calc(35% - 8px);">
                <div class="custom-select input-status" style="width: calc(15% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-status .input-status':'.cell.status', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                            name="status" class="input-status" required>
                        <option value="">All Statuses</option>
                        <option value="Pending">Pending</option>
                        <option value="Active">Active</option>
                        <option value="Completed">Completed</option>
                        <option value="Paid">Paid</option>
                    </select>
                </div>
                <div class="custom-select input-division" style="width: calc(15% - 8px);">
                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-status .input-status':'.cell.status', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
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
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 35%">Assignment Objective</div>
                    <div class="head admin" style="width: 15%">Status</div>
                    <div class="head admin" style="width: 15%">Division</div>
                    <div class="head admin tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                    <div class="head admin time" style="width: 10%" onclick="sortTime('.head.time', '.cell.time .content')">Total</div>
                    <div class="head admin" style="width: 7.5%">Open</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            <div class="table admin"> <?php
                $assignments = Assignment::selectAssignmentListByAccount($_GET['m']);
                if ($assignments) {
                    foreach ($assignments as $assignment) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" class="content" value="<?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?>"></div>
                            <div class="cell objective" style="width: 35%"><input type="submit" name="submit" class="content" value="<?php echo $assignment['objective']; ?>"></div>
                            <div class="cell status" style="width: 15%"><input type="submit" name="submit" class="content" value="<?php echo $assignment['status']; ?>"></div>
                            <div class="cell division" style="width: 15%"><input type="submit" name="submit" class="content" value="<?php echo $assignment['division']; ?>"></div>
                            <div class="cell tasks" style="width: 10%"><input type="submit" name="submit" class="content" value="<?php echo $assignment['task_count']; ?>"></div>
                            <div class="cell time" style="width: 10%"><input type="submit" name="submit" class="content" value="<?php echo $assignment['time']; ?>"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" class="content open-button" value="Open"></div>
                            <input type="hidden" name="open-asg" value="<?php echo $assignment['assignment_id']; ?>">
                        </form> <?php
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

    require_once "includes/footer.php";

}
else require_once "login.php";