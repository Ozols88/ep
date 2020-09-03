<?php
$page = "member";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "includes/header.php";

        // From new-project
        if (isset($_SESSION['new-project']['new-client'])) {
            $_SESSION['new-member']['stage'] = '4';
            $_SESSION['new-member']['num'] = 1;
            $_SESSION['new-member']['fields']['manager'] = 0;
            $_SESSION['new-member']['info']['manager'] = "NO";
            $_SESSION['new-member']['fields']['client'] = 1;
            $_SESSION['new-member']['info']['client'] = "YES";
            $_SESSION['new-member']['divisions'] = "";
        }
        // from new-member
        if (!isset($_SESSION['new-member'])) {
            $_SESSION['new-member']['stage'] = '1';
            $_SESSION['new-member']['num'] = 1;
        }

        if (!isset($_SESSION['new-member']['info']['manager']))
            $_SESSION['new-member']['info']['manager'] = ""; // Info bar fix

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-member']['stage'] == '1') {
                $_SESSION['new-member']['fields']['manager'] = $_POST['manager'];
                $_SESSION['new-member']['info']['manager'] = $_POST['submit'];

                $_SESSION['new-member']['stage'] = '2';
                if (!isset($_SESSION['new-member']['info']['client']))
                    $_SESSION['new-member']['info']['client'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-member']['stage'] == '2') {
                $_SESSION['new-member']['fields']['client'] = $_POST['client'];
                $_SESSION['new-member']['info']['client'] = $_POST['submit'];

                $_SESSION['new-member']['stage'] = '3';
                if (!isset($_SESSION['new-member']['divisions']))
                    $_SESSION['new-member']['divisions'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-member']['stage'] == '3') {
                if (isset($_POST['add-division-page']))
                    $_SESSION['new-member']['add-division-page'] = array();
                if (isset($_POST['floor'])) {
                    $_SESSION['new-member']['add-division-page']['floor'] = $_POST['floor'];
                    $_SESSION['new-member']['add-division-page']['select-division'] = true;
                }
                if (isset($_POST['division'])) {
                    if ($_SESSION['new-member']['divisions'] == "")
                        $_SESSION['new-member']['divisions'] = null;
                    $_SESSION['new-member']['divisions'][$_SESSION['new-member']['num']] = Assignment::selectDivisionByID($_POST['division']);
                    $_SESSION['new-member']['divisions'][$_SESSION['new-member']['num']]['floor'] = $_SESSION['new-member']['add-division-page']['floor'];
                    $_SESSION['new-member']['divisions'][$_SESSION['new-member']['num']++]['floor_title'] = Project::selectFloorByID($_SESSION['new-member']['add-division-page']['floor'])['title'];
                    unset($_SESSION['new-member']['add-division-page']);
                    header("Refresh:0");
                }
                if (isset($_POST['del-division']))
                    unset($_SESSION['new-member']['divisions'][$_POST['del-division']]);

                if (isset($_POST['submit']) && $_POST['submit'] == "NEXT") {
                    $_SESSION['new-member']['stage'] = '4';
                    if (!isset($_SESSION['new-member']['info']['username']))
                        $_SESSION['new-member']['info']['username'] = ""; // Info bar fix
                }
            }
            elseif ($_SESSION['new-member']['stage'] == '4') {
                $_SESSION['new-member']['fields']['username'] = $_POST['username'];
                $_SESSION['new-member']['fields']['reg_time'] = date("Y-m-d H-i-s");

                $_SESSION['new-member']['fields']['memberid'] = Database::insert('account', $_SESSION['new-member']['fields'], true, null);

                foreach ($_SESSION['new-member']['divisions'] as $division) {
                    $fieldsDivision = [
                        'accountid' => $_SESSION['new-member']['fields']['memberid'],
                        'divisionid' => $division['id']
                    ];
                    if ($division['floorid'] == null)
                        $fieldsDivision['floorid'] = $division['floor'];

                    Database::insert('account_division', $fieldsDivision, true, null);
                }
                $redirect = "member";
                if (isset($_SESSION['new-project']['new-client'])) {
                    $_SESSION['new-project']['fields']['clientid'] = $_SESSION['new-member']['fields']['memberid'];
                    $_SESSION['new-project']['info']['client'] = $_SESSION['new-member']['fields']['username'];
                    $_SESSION['new-project']['stage'] = '4';
                    $redirect = "new-project";
                }
                header("Location: " . $redirect);
                unset($_SESSION['new-member']);
            }

            if (empty($_SESSION['new-member']['info']['manager'])) $_SESSION['new-member']['stage'] = '1';
            elseif (empty($_SESSION['new-member']['info']['client'])) $_SESSION['new-member']['stage'] = '2';
            //elseif (empty($_SESSION['new-member']['divisions'])) $_SESSION['new-member']['stage'] = '3';
            //else $_SESSION['new-member']['stage'] = '4'
        }
        if (isset($_POST['stage1'])) $_SESSION['new-member']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-member']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-member']['stage'] = '3';
        if (isset($_POST['stage4'])) $_SESSION['new-member']['stage'] = '4';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-member']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-member']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>+ New Member: Manager?</span>
            </div>
            <div class="navbar level-1 unselected current">
                <form method="post" class="container-button">
                    <input type="hidden" name="manager" value="1">
                    <input type="submit" name="submit" value="YES" class="button admin-menu">
                    <div class="home-menu"></div>
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="manager" value="0">
                    <input type="submit" name="submit" value="NO" class="button admin-menu">
                    <div class="home-menu"></div>
                </form>
            </div>
            </div> <?php
        }
        elseif ($_SESSION['new-member']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>+ New Member: Client?</span>
            </div>
            <div class="navbar level-1 unselected current">
                <form method="post" class="container-button">
                    <input type="hidden" name="client" value="1">
                    <input type="submit" name="submit" value="YES" class="button admin-menu">
                    <div class="home-menu"></div>
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="client" value="0">
                    <input type="submit" name="submit" value="NO" class="button admin-menu">
                    <div class="home-menu"></div>
                </form>
            </div>
            </div> <?php
        }
        elseif ($_SESSION['new-member']['stage'] == '3') {
            if (!isset($_SESSION['new-member']['add-division-page'])) { ?>
                <div class="head-up-display-bar">
                    <span>+ New Member: Floors & Divisions</span>
                </div>
                <div class="navbar level-1 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="add-division-page">
                        <input type="submit" name="submit" value="+ ADD DIVISION" class="button admin-menu">
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
                        <div class="head admin" style="width: 35%">Floor</div>
                        <div class="head admin" style="width: 50%">Division</div>
                        <div class="head admin" style="width: 7.5%">Remove</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if (is_array($_SESSION['new-member']['divisions']) && count($_SESSION['new-member']['divisions']) > 0) {
                        foreach ($_SESSION['new-member']['divisions'] as $num => $division) {?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $num; ?>" class="content"></div>
                                <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $division['floor_title']; ?>" class="content"></div>
                                <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $division['title']; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                                <input type="hidden" name="del-division" value="<?php echo $num; ?>">
                            </form> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO DIVISIONS</div> <?php
                    } ?>
                </div> <?php
            }
            else {
                if (!isset($_SESSION['new-member']['add-division-page']['select-division'])) { ?>
                    <div class="head-up-display-bar">
                        <span>+ New Member: Select Floor</span>
                    </div>
                    <div class="navbar level-1 unselected current"> <?php
                        $floors = Project::selectFloors();
                        foreach ($floors as $floor) { ?>
                            <form method="post" class="container-button">
                                <input type="hidden" name="floor" value="<?php echo $floor['id']; ?>">
                                <input type="submit" name="submit" value="<?php echo $floor['title']; ?>" class="button admin-menu">
                                <div class="home-menu"></div>
                            </form> <?php
                        } ?>
                    </div>
                    </div> <?php
                }
                else { ?>
                    <div class="head-up-display-bar">
                        <span>+ New Member: Select Division</span>
                    </div>
                    <div class="navbar level-1 unselected">
                        <form class="container-button disabled">
                            <input class="button admin-menu disabled">
                        </form>
                    </div> <?php
                    include_once "includes/info-bar.php"; ?>
                    <div class="table-header-container">
                        <div class="header-extension admin"></div>
                        <div class="header">
                            <div class="head admin" style="width: 7.5%">№</div>
                            <div class="head admin" style="width: 15%">Name</div>
                            <div class="head admin" style="width: 70%">Description</div>
                            <div class="head admin" style="width: 7.5%">Add</div>
                        </div>
                        <div class="header-extension admin"></div>
                    </div>
                    </div> <?php
                    $divisions = Assignment::selectDivisionsByFloor($_SESSION['new-member']['add-division-page']['floor']);
                    if ($divisions) { ?>
                        <div class="table admin"> <?php
                            foreach ($divisions as $division) {
                                if ($division['division_id'] == "2" && $_SESSION['new-member']['fields']['manager'] == 0 || ($division['division_id'] == "3" && $_SESSION['new-member']['fields']['client'] == 0))
                                    continue;
                                else { ?>
                                    <form method="post" class="row">
                                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $division['division_id']); ?>" class="content"></div>
                                        <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo $division['division_title']; ?>" class="content"></div>
                                        <div class="cell" style="width: 70%"><input type="submit" name="submit" value="<?php echo $division['division_desc']; ?>" class="content"></div>
                                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content add-button"></div>
                                        <input type="hidden" name="division" value="<?php echo $division['division_id']; ?>">
                                    </form> <?php
                                }
                            } ?>
                        </div> <?php
                    }
                    else { ?>
                        <div class="empty-table">NO DIVISIONS</div> <?php
                    }
                }
            }
        }
        elseif ($_SESSION['new-member']['stage'] == '4') { ?>
            <div class="head-up-display-bar">
                <span>+ New Member: Enter Username</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="username" name="username" method="post" class="container-button">
                    <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
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
                    <input form="username" name="username" id="username" class="field admin" placeholder="Enter Member Name Here" maxlength="30">
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