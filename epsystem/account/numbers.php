<?php
ob_start();
$page = "numbers";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    // Link for exit button
    if (!isset($_GET['py']))
        $_SESSION['backPageNumbers']['home'] = $_SERVER['REQUEST_URI'];

    require_once "includes/header.php"; ?>

    <div class="menu"> <?php
    require "includes/menu.php";
    if (!isset($payment)) {
        if (isset($_GET['l1']) && $_GET['l1'] == "progress") { ?>
            </div> <?php
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "money") {
            if (isset($_GET['l2']) && $_GET['l2'] == "overview") { ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "payments") { ?>
                <form class="search-bar with-space">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="description" class="input-description" placeholder="Enter Payment Description" required style="width: calc(40% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 40%">Payment Description</div>
                        <div class="head date" style="width: 20%" onclick="sortDates('.head.date', '.cell.date .content', '.time')">Date</div>
                        <div class="head assignments" style="width: 10%" onclick="sortTable('.head.assignments', '.cell.assignments .content')">Assignments</div>
                        <div class="head total" style="width: 15%" onclick="sortTable('.head.total', '.cell.total .content')">Total</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    $payments = Assignment::selectPaymentsByAccount($account->id);
                    if ($payments) {
                        foreach ($payments as $payment) {
                            $link = "numbers.php?py=" . $payment['id'] . "&l1=overview"; ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $payment['id']); ?></a></div>
                                <div class="cell description" style="width: 40%"><a href="<?php echo $link; ?>" class="content"><?php echo $payment['description']; ?></a></div>
                                <div class="cell date" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $payment['date']; ?></a></div>
                                <div class="cell assignments" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $payment['assignment_count']; ?></a></div>
                                <div class="cell total" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $payment['total'] . "€"; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button"></a></div>
                                <input class="time" type="hidden" value="<?php echo $payment['time']; ?>">
                                <input class="eur" type="hidden" value="<?php echo $payment['total']; ?>">
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO PAYMENTS</div> <?php
                    } ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "everyone") {
            if (isset($_GET['l2']) && $_GET['l2'] == "overview") { ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "payments") { ?>
                <div class="navbar level-3 unselected">
                    <div class="container-button">
                        <a href="new-payment.php" class="button admin-menu"><span>+ Payment</span></a>
                    </div>
                </div> <?php
                $members = Account::selectMembers(); ?>
                <form class="search-bar with-space">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .custom-select.input-member .input-member':'.cell.member'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <div class="custom-select input-member" style="width: calc(40% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .custom-select.input-member .input-member':'.cell.member'}, this)"
                                name="member" class="input-member" required>
                            <option value="">All Members</option> <?php
                            foreach ($members as $member) { ?>
                                <option value="<?php echo $member['username']; ?>"><?php echo $member['username']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 40%">Member</div>
                        <div class="head date" style="width: 20%" onclick="sortDates('.head.date', '.cell.date .content', '.time')">Date</div>
                        <div class="head assignments" style="width: 10%" onclick="sortTable('.head.assignments', '.cell.assignments .content')">Assignments</div>
                        <div class="head total" style="width: 15%" onclick="sortTable('.head.total', '.cell.total .content')">Total</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    $payments = Assignment::selectPayments();
                    if ($payments) {
                        foreach ($payments as $payment) {
                            $link = "numbers.php?py=" . $payment['id'] . "&l1=overview"; ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $payment['id']); ?></a></div>
                                <div class="cell member" style="width: 40%"><a href="<?php echo $link; ?>" class="content"><?php echo $payment['username']; ?></a></div>
                                <div class="cell date" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $payment['date']; ?></a></div>
                                <div class="cell assignments" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $payment['assignment_count']; ?></a></div>
                                <div class="cell total" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $payment['total'] . "€"; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button"></a></div>
                                <input class="time" type="hidden" value="<?php echo $payment['time']; ?>">
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO PAYMENTS</div> <?php
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
    else {
        if (!isset($_GET['options'])) {
            if (isset($_GET['l1']) && $_GET['l1'] == "overview") { ?>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "assignments") {
                if (isset($_POST['open-asg'])) {
                    $_SESSION['paymentPage'] = $_GET['py'];
                    header('Location: assignments.php?a=' . $_POST['open-asg'] . '&l1=assignment');
                }
                $assignments = Assignment::selectPaymentAssignments($_GET['py']);
                $divisions = Assignment::selectDivisions(); ?>
                <form class="search-bar with-space">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(25% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="project" class="input-project" placeholder="Enter Project Name" required style="width: calc(20% - 8px);">
                    <div class="custom-select input-division" style="width: calc(20% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-project':'.cell.project', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
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
                        <div class="head" style="width: 25%">Assignment Name</div>
                        <div class="head" style="width: 20%">Project</div>
                        <div class="head" style="width: 20%">Division</div>
                        <div class="head tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                        <div class="head time" style="width: 10%" onclick="sortTime('.head.time', '.cell.time .content')">Time</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($assignments) {
                        foreach ($assignments as $asg) { ?>
                            <form method="post" class="row">
                                <?php $link = "?a=" . $asg['assignment_id'] . "&l1=assignment"; ?>
                                <div class="cell id" style="width: 7.5%"><input type="submit" class="content" value="<?php echo "#" . sprintf('%05d', $asg['id']); ?>"></div>
                                <div class="cell name" style="width: 25%"><input type="submit" class="content" value="<?php echo $asg['assignment_name']; ?>"></div>
                                <div class="cell project" style="width: 20%"><input type="submit" class="content" value="<?php echo $asg['project_name']; ?>"></div>
                                <div class="cell division" style="width: 20%"><input type="submit" class="content" value="<?php echo $asg['division']; ?>"></div>
                                <div class="cell tasks" style="width: 10%"><input type="submit" class="content" value="<?php echo $asg['task_count']; ?>"></div>
                                <div class="cell time" style="width: 10%"><input type="submit" class="content" value="<?php echo $asg['time']; ?>"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" class="content open-button"></div>
                                <input type="hidden" name="open-asg" value="<?php echo $asg['assignment_id']; ?>">
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
        else {
            if (isset($_POST['description']))
                Database::update('payment', $_GET['py'], ['description' => $_POST['description']], "numbers.php?py=" . $_GET['py'] . "&l1=overview"); ?>

            <div class="head-up-display-bar">
                <span>Edit the description of the payment</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form method="post" id="description" class="container-button">
                    <input type="hidden" name="description">
                    <input type="submit" name="submit" value="Save" class="button admin-menu">
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
                    <input form="description" name="description" class="field admin" placeholder="Enter Payment Description Here" maxlength="255" value="<?php if (isset($payment['description'])) echo $payment['description']; ?>">
                </div>
            </div> <?php
        }
    }

    require_once "includes/footer.php";

}
else require_once "login.php";