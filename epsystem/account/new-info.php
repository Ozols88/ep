<?php
$page = "projects";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "includes/header.php";

        if (!isset($_SESSION['new-info'])) {
            $_SESSION['new-info']['stage'] = '1';
            $_SESSION['new-info']['group'] = ""; // Info bar fix
        }

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-info']['stage'] == '1') {
                if (isset($_POST['group'])) {
                    $_SESSION['new-info']['fields']['groupid'] = $_POST['group'];
                    $_SESSION['new-info']['group'] = $_POST['group-title'];
                    if (strlen($_SESSION['new-info']['group']) > InfobarCharLimit)
                        $_SESSION['new-info']['group'] = substr($_POST['group-title'], 0, InfobarCharLimit) . "...";
                }
                else {
                    $_SESSION['new-info']['fields']['groupid'] = null;
                    $_SESSION['new-info']['group'] = "None";
                }

                $_SESSION['new-info']['stage'] = '2';
                if (!isset($_SESSION['new-info']['name']))
                    $_SESSION['new-info']['name'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-info']['stage'] == '2') {
                $projectLinks = Project::selectProjectInfoPages($_GET['p']);
                foreach ($projectLinks as $link)
                    if ($link['title'] == $_POST['name']) {
                        $sameNameError = true;
                        break;
                    }
                if (!isset($sameNameError)) {
                    $_SESSION['new-info']['fields']['title'] = $_POST['name'];
                    $_SESSION['new-info']['name'] = $_POST['name'];
                    if (strlen($_SESSION['new-info']['name']) > InfobarCharLimit)
                        $_SESSION['new-info']['name'] = substr($_POST['name'], 0, InfobarCharLimit) . "...";

                    $_SESSION['new-info']['stage'] = '3';
                    if (!isset($_SESSION['new-info']['link']))
                        $_SESSION['new-info']['link'] = ""; // Info bar fix
                }
            }
            elseif ($_SESSION['new-info']['stage'] == '3') {
                $_SESSION['new-info']['fields']['link'] = $_POST['link'];
                $_SESSION['new-info']['link'] = $_POST['link'];
                if (strlen($_SESSION['new-info']['link']) > InfobarCharLimit)
                    $_SESSION['new-info']['link'] = substr($_POST['link'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-info']['stage'] = '4';
                if (!isset($_SESSION['new-info']['description']))
                    $_SESSION['new-info']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-info']['stage'] == '4') {
                $_SESSION['new-info']['fields']['description'] = $_POST['description'];
                $_SESSION['new-info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-info']['description']) > InfobarCharLimit)
                    $_SESSION['new-info']['description'] = substr($_POST['description'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-info']['fields']['projectid'] = $_GET['p'];
                Database::insert('project_infopage', $_SESSION['new-info']['fields'], false, "projects.php?p=" . $_GET['p'] . "&ioptions&l1=edit");
                unset($_SESSION['new-info']);
                exit();
            }

            if (empty($_SESSION['new-info']['group'])) $_SESSION['new-info']['stage'] = '1';
            elseif (empty($_SESSION['new-info']['name'])) $_SESSION['new-info']['stage'] = '2';
            elseif (empty($_SESSION['new-info']['link'])) $_SESSION['new-info']['stage'] = '3';
            else $_SESSION['new-info']['stage'] = '4';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-info']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-info']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-info']['stage'] = '3';
        if (isset($_POST['stage4'])) $_SESSION['new-info']['stage'] = '4'; ?>

        <div class="menu"> <?php
        if ($_SESSION['new-info']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>New Project Link</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="none" name="none" method="post" class="container-button">
                    <input type="submit" name="submit" value="NONE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 35%">Link Group Name</div>
                    <div class="head admin" style="width: 50%">Description</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            $groups = Project::selectInfoPageGroups();
            if (isset($groups)) { ?>
                <div class="table admin"> <?php
                    foreach ($groups as $group) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%02d', $group['id']); ?>" class="content"></div>
                            <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $group['title']; ?>" class="content"></div>
                            <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $group['description']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="group" value="<?php echo $group['id']; ?>">
                            <input type="hidden" name="group-title" value="<?php echo $group['title']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO LINK GROUPS</div> <?php
            }
        }
        elseif ($_SESSION['new-info']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>New Project Link</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="name" name="name" method="post" class="container-button">
                    <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension small admin"></div>
                <div class="header small">
                    <div class="head admin">Link Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="name" name="name" id="name" class="field admin" placeholder="Enter Link Name Here" maxlength="50" value="<?php if (isset($_SESSION['new-info']['fields']['title'])) echo htmlspecialchars($_SESSION['new-info']['fields']['title']); ?>">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-info']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>New Project Link</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="link" name="link" method="post" class="container-button">
                    <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension large admin"></div>
                <div class="header large">
                    <div class="head admin">Link URL</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="link" name="link" id="link" class="field admin" placeholder="Paste Link URL Here" maxlength="255" value="<?php if (isset($_SESSION['new-info']['fields']['link'])) echo htmlspecialchars($_SESSION['new-info']['fields']['link']); ?>">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-info']['stage'] == '4') { ?>
            <div class="head-up-display-bar">
                <span>New Project Link</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="description" name="description" method="post" class="container-button">
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
                    <div class="head admin">Link Description</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="description" name="description" id="description" class="field admin" placeholder="Enter Link Description Here" maxlength="255" value="<?php if (isset($_SESSION['new-info']['fields']['description'])) echo htmlspecialchars($_SESSION['new-info']['fields']['description']); ?>">
                </div>
            </div> <?php
        }

        require_once "includes/footer.php";

    }
    else
        header('Location: error.php');
}
else require_once "login.php";