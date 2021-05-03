<?php
$page = "numbers";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "includes/header.php";

        if (!isset($_SESSION['new-payment'])) {
            $_SESSION['new-payment']['stage'] = '1';
            $_SESSION['new-payment']['info']['member'] = ""; // Info bar fix
        }

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-payment']['stage'] == '1') {
                $_SESSION['new-payment']['fields']['accountid'] = $_POST['member'];
                $_SESSION['new-payment']['info']['member'] = $_POST['member-username'];
                if (strlen($_SESSION['new-payment']['info']['member']) > InfobarCharLimit)
                    $_SESSION['new-payment']['info']['member'] = substr($_SESSION['new-payment']['info']['member'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-payment']['stage'] = '2';
                if (!isset($_SESSION['new-payment']['assignments']))
                    $_SESSION['new-payment']['assignments'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-payment']['stage'] == '2') {
                if (isset($_POST['add-asg-page'])) {
                    $_SESSION['new-payment']['add-asg-page'] = true;
                    header('Location: new-payment.php');
                }
                elseif (isset($_POST['asg'])) {
                    if ($_SESSION['new-payment']['assignments'] == "")
                        $_SESSION['new-payment']['assignments'] = null;
                    $_SESSION['new-payment']['assignments'][$_POST['asg']] = Assignment::selectAssignmentByID($_POST['asg']);

                    $_SESSION['new-payment']['info']['total'] = 0;
                    foreach ($_SESSION['new-payment']['assignments'] as $asg) {
                        if ($asg['presetid'] == null)
                            $_SESSION['new-payment']['info']['total'] += $asg['value'];
                        else
                            $_SESSION['new-payment']['info']['total'] += $asg['task_sum'];
                    }

                    unset($_SESSION['new-payment']['add-asg-page']);
                }
                elseif (isset($_POST['del-asg'])) {
                    unset($_SESSION['new-payment']['assignments'][$_POST['del-asg']]);

                    $_SESSION['new-payment']['info']['total'] = 0;
                    foreach ($_SESSION['new-payment']['assignments'] as $asg) {
                        if ($asg['presetid'] == null)
                            $_SESSION['new-payment']['info']['total'] += $asg['value'];
                        else
                            $_SESSION['new-payment']['info']['total'] += $asg['task_sum'];
                    }
                }

                elseif (isset($_POST) && $_POST['submit'] == "NEXT" && is_countable($_SESSION['new-payment']['assignments']) && count($_SESSION['new-payment']['assignments']) > 0) {
                    $_SESSION['new-payment']['stage'] = '3';
                    if (!isset($_SESSION['new-payment']['info']['description']))
                        $_SESSION['new-payment']['info']['description'] = ""; // Info bar fix
                }
            }
            elseif ($_SESSION['new-payment']['stage'] == '3') {
                $_SESSION['new-payment']['fields']['description'] = $_POST['description'];
                $_SESSION['new-payment']['info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-payment']['info']['description']) > InfobarCharLimit)
                    $_SESSION['new-payment']['info']['description'] = substr($_SESSION['new-payment']['info']['description'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-payment']['fields']['value'] = $_SESSION['new-payment']['info']['total'];
                $_SESSION['new-payment']['payid'] = Database::insert('payment', $_SESSION['new-payment']['fields'], true, false);
                foreach ($_SESSION['new-payment']['assignments'] as $asg) {
                    $fields = [
                        'paymentid' => $_SESSION['new-payment']['payid'],
                        'assignmentid' => $asg['id']
                    ];
                    Database::insert('payment_assignment', $fields, true, false);

                    $fieldsStatus = [
                        'assignmentid' => $asg['id'],
                        'statusid' => 9,
                        'time' => date("Y-m-d H-i-s"),
                        'assigned_by' => $account->id,
                        'assigned_to' => $_SESSION['new-payment']['fields']['accountid'],
                        'note' => "Paid"
                    ];
                    $statusID = Database::insert('assignment_status', $fieldsStatus, true, false);
                    Database::update('assignment', $asg['id'], ['statusid' => $statusID], false);
                }

                if (isset($_SESSION['new-payment']['exitLink']))
                    header("Location: " . $_SESSION['new-payment']['exitLink']);
                else
                    header("Location: numbers.php?l1=everyone&l2=payments");
                unset($_SESSION['new-payment']);
            }
        }
        if (isset($_POST['stage1'])) $_SESSION['new-payment']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-payment']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-payment']['stage'] = '3';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-payment']); ?>

        <div class="menu"> <?php

        if ($_SESSION['new-payment']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>Select a member for the new payment</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="search-bar admin">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name'})"
                       type="text" name="name" class="input-name" placeholder="Enter Member Name" required style="width: calc(40% - 8px);">
            </div>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 40%">Member Name</div>
                    <div class="head admin unpaid" style="width: 15%" onclick="sortTable('.head.unpaid', '.cell.unpaid .content')">Unpaid Assignments</div>
                    <div class="head admin paid" style="width: 15%" onclick="sortTable('.head.paid', '.cell.paid .content')">Paid Assignments</div>
                    <div class="head admin payments" style="width: 15%" onclick="sortTable('.head.payments', '.cell.payments .content')">Payments</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            $members = Database::selectMembers();
            if ($members) { ?>
                <div class="table admin"> <?php
                    foreach ($members as $member) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $member['id']); ?>" class="content"></div>
                            <div class="cell name" style="width: 40%"><input type="submit" name="submit" value="<?php echo $member['username']; ?>" class="content"></div>
                            <div class="cell unpaid" style="width: 15%"><input type="submit" name="submit" value="<?php echo $member['asg_unpaid']; ?>" class="content"></div>
                            <div class="cell paid" style="width: 15%"><input type="submit" name="submit" value="<?php echo $member['asg_paid']; ?>" class="content"></div>
                            <div class="cell payments" style="width: 15%"><input type="submit" name="submit" value="<?php echo $member['payment_count']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="member" value="<?php echo $member['id']; ?>">
                            <input type="hidden" name="member-username" value="<?php echo $member['username']; ?>">
                            <input class="time" type="hidden" value="<?php echo $member['reg_time']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO MEMBERS</div> <?php
            }
        }
        elseif ($_SESSION['new-payment']['stage'] == '2') {
            if (!isset($_SESSION['new-payment']['add-asg-page'])) { ?>
                <div class="head-up-display-bar">
                    <span><?php echo $_SESSION['new-payment']['info']['member']; ?> assignments getting paid</span>
                </div>
                <div class="navbar level-1 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="add-asg-page">
                        <input type="submit" name="submit" value="+ Assignment" class="button admin-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                    </form>
                </div> <?php
                include_once "includes/info-bar.php"; ?>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin name" style="width: 30%">Assignment Name</div>
                        <div class="head admin project" style="width: 30%">Project</div>
                        <div class="head admin date" style="width: 15%" onclick="sortDates('.head.date', '.cell.date .content', '.completed')">Completed</div>
                        <div class="head admin total" style="width: 10%" onclick="sortTable('.head.total', '.cell.total .content')">Earned</div>
                        <div class="head admin" style="width: 7.5%">Remove</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if (is_array($_SESSION['new-payment']['assignments']) && count($_SESSION['new-payment']['assignments']) > 0) {
                        foreach ($_SESSION['new-payment']['assignments'] as $asg) { ?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $asg['id']); ?>" class="content"></div>
                                <div class="cell" style="width: 30%"><input type="submit" name="submit" value="<?php echo $asg['title']; ?>" class="content"></div>
                                <div class="cell" style="width: 30%"><input type="submit" name="submit" value="<?php echo $asg['project']; ?>" class="content"></div>
                                <div class="cell date" style="width: 15%"><input type="submit" name="submit" value="<?php echo $asg['time']; ?>" class="content"></div>
                                <div class="cell total" style="width: 10%"><input type="submit" name="submit" value="<?php if (isset($asg['task_sum'])) echo $asg['task_sum'] . "€"; else echo $asg['value'] . "€"; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                                <input type="hidden" name="del-asg" value="<?php echo $asg['id']; ?>">
                                <input class="completed" type="hidden" value="<?php echo $asg[5]; ?>">
                            </form> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO ASSIGNMENTS</div> <?php
                    } ?>
                </div> <?php
            }
            else {
                if (isset($_POST['cancel-add-asg'])) {
                    unset($_SESSION['new-payment']['add-asg-page']);
                    header('Location: new-payment.php');
                }
                $divisions = Assignment::selectDivisions();
                $products = Project::selectProducts(); ?>
                <div class="head-up-display-bar">
                    <span>Select an assignment to add to the payment</span>
                </div>
                <div class="navbar level-1 unselected">
                    <form class="container-button disabled">
                        <input class="button admin-menu disabled">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="cancel-add-asg">
                        <input type="submit" name="submit" value="Cancel" class="button admin-menu">
                    </form>
                    <form class="container-button disabled">
                        <input class="button admin-menu disabled">
                    </form>
                </div>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', 'search-bar .input-project':'.cell.project'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', 'search-bar .input-project':'.cell.project'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(30% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', 'search-bar .input-project':'.cell.project'})"
                           type="text" name="project" class="input-project" placeholder="Enter Project Name" required style="width: calc(30% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin id" style="width: 7.5%">№</div>
                        <div class="head admin name" style="width: 30%">Assignment Name</div>
                        <div class="head admin project" style="width: 30%">Project</div>
                        <div class="head admin date" style="width: 15%" onclick="sortDates('.head.date', '.cell.date .content', '.completed')">Completed</div>
                        <div class="head admin total" style="width: 10%" onclick="sortTable('.head.total', '.cell.total .content')">Earned</div>
                        <div class="head admin" style="width: 7.5%">Add</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div> <?php
                $assignments = Assignment::SelectUnpaidCompletedAssignmentsByAccount($_SESSION['new-payment']['fields']['accountid']);
                if ($_SESSION['new-payment']['assignments']) {
                    foreach ($_SESSION['new-payment']['assignments'] as $selectedAsg) {
                        foreach ($assignments as $allAsg) {
                            if ($selectedAsg['id'] == $allAsg['assignment_id'])
                                unset($assignments[$allAsg['assignment_id']]);
                        }
                    }
                }

                if ($assignments) { ?>
                    <div class="table admin"> <?php
                        foreach ($assignments as $asg) { ?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $asg['assignment_id']); ?>" class="content"></div>
                                <div class="cell name" style="width: 30%"><input type="submit" name="submit" value="<?php echo $asg['assignment_name']; ?>" class="content"></div>
                                <div class="cell project" style="width: 30%"><input type="submit" name="submit" value="<?php echo $asg['project']; ?>" class="content"></div>
                                <div class="cell date" style="width: 15%"><input type="submit" name="submit" value="<?php echo $asg['status_time2']; ?>" class="content"></div>
                                <div class="cell total" style="width: 10%"><input type="submit" name="submit" value="<?php echo $asg['earned'] . "€"; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                                <input type="hidden" name="asg" value="<?php echo $asg['assignment_id']; ?>">
                                <input class="completed" type="hidden" value="<?php echo $asg[5]; ?>">
                            </form> <?php
                        } ?>
                    </div> <?php
                }
                else { ?>
                    <div class="empty-table">NO ASSIGNMENTS</div> <?php
                }
            }
        }
        elseif ($_SESSION['new-payment']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>Enter a description of the new payment</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="description" name="description" method="post" class="container-button">
                    <input type="submit" name="submit" value="Create Payment" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension large admin"></div>
                <div class="header large">
                    <div class="head admin">Payment Description</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="description" name="description" id="description" class="field admin" placeholder="Enter Payment Description Here" maxlength="255" value="<?php if (isset($_SESSION['new-payment']['fields']['description'])) echo $_SESSION['new-payment']['fields']['description']; ?>">
                </div>
            </div> <?php
        }

        require_once "includes/footer.php";

    }
    else {
        header('Location: error.php');
    }
}
else require_once "login.php";