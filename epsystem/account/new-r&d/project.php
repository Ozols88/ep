<?php
ob_start();
$page = "r&d";
include "../includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "../includes/header.php";

        if (!isset($_SESSION['new-projectpr']))
            $_SESSION['new-projectpr']['stage'] = '1';
        if (!isset($_SESSION['new-projectpr']['info']['product']))
            $_SESSION['new-projectpr']['info']['product'] = ""; // Info bar fix

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-projectpr']['stage'] == '1') {
                if (isset($_POST['product'])) {
                    $_SESSION['new-projectpr']['fields']['productid'] = $_POST['product'];
                    $_SESSION['new-projectpr']['info']['product'] = $_POST['product-title'];
                    if (strlen($_SESSION['new-projectpr']['info']['product']) > InfobarCharLimit)
                        $_SESSION['new-projectpr']['info']['product'] = substr($_SESSION['new-projectpr']['info']['product'], 0, InfobarCharLimit) . "...";
                }
                else {
                    $_SESSION['new-projectpr']['fields']['productid'] = null;
                    $_SESSION['new-projectpr']['info']['product'] = "None";
                }

                $_SESSION['new-projectpr']['stage'] = '2';
                if (!isset($_SESSION['new-projectpr']['info']['title']))
                    $_SESSION['new-projectpr']['info']['title'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-projectpr']['stage'] == '2') {
                $_SESSION['new-projectpr']['fields']['title'] = $_POST['title'];
                $_SESSION['new-projectpr']['info']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-projectpr']['info']['title']) > InfobarCharLimit)
                    $_SESSION['new-projectpr']['info']['title'] = substr($_SESSION['new-projectpr']['info']['title'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-projectpr']['stage'] = '3';
                if (!isset($_SESSION['new-projectpr']['info']['description']))
                    $_SESSION['new-projectpr']['info']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-projectpr']['stage'] == '3') {
                $_SESSION['new-projectpr']['fields']['description'] = $_POST['description'];
                $_SESSION['new-projectpr']['info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-projectpr']['info']['description']) > InfobarCharLimit)
                    $_SESSION['new-projectpr']['info']['description'] = substr($_SESSION['new-projectpr']['info']['description'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-projectpr']['fields']['date_created'] = date("Y-m-d H-i-s");
                $presetID = Database::insert('preset-project', $_SESSION['new-projectpr']['fields'], true, false);
                unset($_SESSION['new-projectpr']);
                header('Location: ../r&d.php?p=' . $presetID . '&l1=overview');
                exit();
            }

            if (empty($_SESSION['new-projectpr']['info']['product'])) $_SESSION['new-projectpr']['stage'] = '1';
            elseif (empty($_SESSION['new-projectpr']['info']['title'])) $_SESSION['new-projectpr']['stage'] = '2';
            else $_SESSION['new-projectpr']['stage'] = '3';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-projectpr']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-projectpr']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-projectpr']['stage'] = '3';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-projectpr']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-projectpr']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>New Project Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form method="post" class="container-button">
                    <input type="submit" name="submit" value="NONE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
            <div class="search-bar">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="name" class="input-name" placeholder="Enter Product Name" required style="width: calc(20% - 8px);">
                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                       type="text" name="description" class="input-description" placeholder="Enter Product Description" required style="width: calc(65% - 8px);">
            </div>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Product Name</div>
                    <div class="head admin" style="width: 65%">Product Description</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div>
            <div class="table admin"> <?php
                $products = Project::selectProducts();
                if (is_array($products)) {
                    foreach ($products as $product) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $product['id']; ?>" class="content"></div>
                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $product['title']; ?>" class="content"></div>
                            <div class="cell description" style="width: 65%"><input type="submit" name="submit" value="<?php echo $product['description']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="product" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="product-title" value="<?php echo $product['title']; ?>">
                        </form> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO PRODUCTS</div> <?php
                } ?>
            </div> <?php
        }
        elseif ($_SESSION['new-projectpr']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>New Project Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="test" name="test" method="post" class="container-button">
                    <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension small admin"></div>
                <div class="header small">
                    <div class="head admin">Preset Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="test" name="title" id="title" class="field admin" placeholder="Enter Preset Name Here" value="<?php if (isset($_SESSION['new-projectpr']['fields']['title'])) echo htmlspecialchars($_SESSION['new-projectpr']['fields']['title']); ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }
        elseif ($_SESSION['new-projectpr']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>New Project Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="test" name="test" method="post" class="container-button">
                    <input type="submit" name="submit" value="Save" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
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
                    <input form="test" name="description" id="description" class="field admin" placeholder="Enter Project Description Here" value="<?php if (isset($_SESSION['new-projectpr']['fields']['description'])) echo htmlspecialchars($_SESSION['new-projectpr']['fields']['description']); ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }

        require_once "../includes/footer.php";

    }
    else
        header('Location: ../error.php');
}
else require_once "../login.php";