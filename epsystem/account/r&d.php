<?php
ob_start();
$page = "r&d";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {
        // Link for exit button
        if (isset($_GET['p']))
            $_SESSION['backPageR&D']['prj'] = $_SERVER['REQUEST_URI'];
        elseif (isset($_GET['a']))
            $_SESSION['backPageR&D']['asg'] = $_SERVER['REQUEST_URI'];
        elseif (isset($_GET['f']))
            $_SESSION['backPageR&D']['prd'] = $_SERVER['REQUEST_URI'];
        elseif (isset($_GET['ig']))
            $_SESSION['backPageR&D']['igroup'] = $_SERVER['REQUEST_URI'];
        elseif (isset($_GET['dp']))
            $_SESSION['backPageR&D']['depart'] = $_SERVER['REQUEST_URI'];
        elseif (isset($_GET['d']))
            $_SESSION['backPageR&D']['div'] = $_SERVER['REQUEST_URI'];

        require_once "includes/header.php"; ?>

        <div class="menu"> <?php
        require "includes/menu.php";
        if (isset($_POST['back'])) {
            if (isset($_GET['l1']))
                unset($_GET['l1']);
            $query_string = http_build_query($_GET);
            header('Location: r&d.php?' . $query_string);
        }
        if (isset($_GET['l1']) && $_GET['l1'] == "project") {
            if (isset($_GET['l2']) && $_GET['l2'] == "projects") { ?>
                <div class="navbar level-3 unselected">
                    <div class="container-button">
                        <a href="new-r&d/project.php" class="button admin-menu"><span>+ Project Preset</span></a>
                    </div>
                </div> <?php
                $presets = Project::selectPresets();
                $products = Project::selectProducts(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-product .input-product':'.cell.product'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-product .input-product':'.cell.product'})"
                           type="text" name="name" class="input-name" placeholder="Enter Project Preset Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-product .input-product':'.cell.product'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(40% - 8px);">
                    <div class="custom-select input-product" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-product .input-product':'.cell.product'}, this)"
                                name="product" class="input-product" required>
                            <option value="">All Products</option>
                            <option value="None">None</option> <?php
                            foreach ($products as $product) { ?>
                                <option value="<?php echo $product['title']; ?>"><?php echo $product['title']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Project Preset Name</div>
                        <div class="head admin" style="width: 40%">Project Preset Description</div>
                        <div class="head admin" style="width: 15%">Product</div>
                        <div class="head admin assignments" style="width: 10%" onclick="sortTable('.head.assignments', '.cell.assignments .content')">Assignments</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if ($presets) {
                        foreach ($presets as $preset) { ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="?p=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo "#" . sprintf('%03d', $preset['id']); ?></a></div>
                                <div class="cell name" style="width: 20%"><a href="?p=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['title']; ?></a></div>
                                <div class="cell description" style="width: 40%"><a href="?p=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['description']; ?></a></div>
                                <div class="cell product" style="width: 15%"><a href="?p=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['product']; ?></a></div>
                                <div class="cell assignments" style="width: 10%"><a href="?p=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['assignments']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="?p=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO PRESETS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "products") { ?>
                <div class="navbar level-3 unselected">
                    <div class="container-button">
                        <a href="new-r&d/product.php" class="button admin-menu"><span>+ Product</span></a>
                    </div>
                </div> <?php
                $products = Project::selectProducts(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="name" class="input-name" placeholder="Enter Product Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Product Name</div>
                        <div class="head admin" style="width: 65%">Description</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if ($products) {
                        foreach ($products as $product) {
                            $link = "?f=" . $product['id'] . "&l1=overview"; ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%02d', $product['id']); ?></a></div>
                                <div class="cell name" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $product['title']; ?></a></div>
                                <div class="cell description" style="width: 65%"><a href="<?php echo $link; ?>" class="content"><?php echo $product['description']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO PRODUCTS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "infogr") { ?>
                <div class="navbar level-3 unselected">
                    <div class="container-button">
                        <a href="new-r&d/infogroup.php" class="button admin-menu"><span>+ Project Link Group</span></a>
                    </div>
                </div> <?php
                $groups = Database::selectInfoPageGroups(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="name" class="input-name" placeholder="Enter Project Link Group Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Project Link Group Name</div>
                        <div class="head admin" style="width: 65%">Description</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if ($groups) {
                        foreach ($groups as $group) {
                            $link = "?ig=" . $group['id'] . "&l1=overview"; ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%02d', $group['id']); ?></a></div>
                                <div class="cell name" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $group['title']; ?></a></div>
                                <div class="cell description" style="width: 65%"><a href="<?php echo $link; ?>" class="content"><?php echo $group['description']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO PROJECT LINK GROUPS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "info") { ?>
                <div class="navbar level-3 unselected">
                    <div class="container-button">
                        <a href="new-r&d/info.php" class="button admin-menu"><span>+ Project Link Preset</span></a>
                    </div>
                </div> <?php
                $presets = Database::selectInfoPagePresets();
                $groups = Database::selectInfoPageGroups(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                           type="text" name="name" class="input-name" placeholder="Enter Project Link Preset Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(50% - 8px);">
                    <div class="custom-select input-group" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'}, this)"
                                name="group" class="input-group" required>
                            <option value="">All Groups</option>
                            <option value="None">None</option><?php
                            foreach ($groups as $group) { ?>
                                <option value="<?php echo $group['title']; ?>"><?php echo $group['title']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Project Link Preset Name</div>
                        <div class="head admin" style="width: 50%">Description</div>
                        <div class="head admin" style="width: 15%">Group</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if ($presets) {
                        foreach ($presets as $preset) { ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="?i=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo "#" . sprintf('%03d', $preset['id']); ?></a></div>
                                <div class="cell name" style="width: 20%"><a href="?i=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['title']; ?></a></div>
                                <div class="cell description" style="width: 50%"><a href="?i=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['description']; ?></a></div>
                                <div class="cell group" style="width: 15%"><a href="?i=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['group']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="?i=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO PRESETS</div> <?php
                    } ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "assignment") {
            if (isset($_GET['l2']) && $_GET['l2'] == "departments") { ?>
                <div class="navbar level-3 unselected">
                    <div class="container-button">
                        <a href="new-r&d/department.php" class="button admin-menu"><span>+ Department</span></a>
                    </div>
                </div> <?php
                $departments = Assignment::selectDepartments(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="name" class="input-name" placeholder="Enter Department Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Department Name</div>
                        <div class="head admin" style="width: 65%">Department Description</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if ($departments) {
                        foreach ($departments as $depart) {
                            $link = "?dp=" . $depart['id'] . "&l1=overview"; ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%02d', $depart['id']); ?></a></div>
                                <div class="cell name" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $depart['title']; ?></a></div>
                                <div class="cell description" style="width: 65%"><a href="<?php echo $link; ?>" class="content"><?php echo $depart['description']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO DEPARTMENTS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "divisions") { ?>
                <div class="navbar level-3 unselected">
                    <div class="container-button">
                        <a href="new-r&d/division.php" class="button admin-menu"><span>+ Division</span></a>
                    </div>
                </div> <?php
                $divisions = Assignment::selectDivisions();
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
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if ($divisions) {
                        foreach ($divisions as $division) {
                            $link = "?d=" . $division['id'] . "&l1=overview"; ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%03d', $division['id']); ?></a></div>
                                <div class="cell name" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $division['title']; ?></a></div>
                                <div class="cell description" style="width: 50%"><a href="<?php echo $link; ?>" class="content"><?php echo $division['description']; ?></a></div>
                                <div class="cell depart" style="width: 15%"><a href="<?php echo $link; ?>" class="content"><?php echo $division['department']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO DIVISIONS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "assignments") { ?>
                <div class="navbar level-3 unselected">
                    <div class="container-button">
                        <a href="new-r&d/assignment.php" class="button admin-menu"><span>+ Assignment Preset</span></a>
                    </div>
                </div> <?php
                $presets = Assignment::selectPresets();
                $divisions = Assignment::selectDivisions();
                $departments = Assignment::selectDepartments(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Preset Name" required style="width: calc(45% - 8px);">
                    <div class="custom-select input-department" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="department" class="input-department" required>
                            <option value="">All Departments</option>
                            <option value="None">None</option> <?php
                            foreach ($departments as $depart) { ?>
                                <option value="<?php echo $depart['title']; ?>"><?php echo $depart['title']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                    <div class="custom-select input-division" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option> <?php
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
                        <div class="head admin" style="width: 45%">Assignment Preset Name</div>
                        <div class="head admin" style="width: 15%">Department</div>
                        <div class="head admin" style="width: 15%">Division</div>
                        <div class="head admin tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if ($presets) {
                        foreach ($presets as $preset) { ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="?a=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo "#" . sprintf('%03d', $preset['id']); ?></a></div>
                                <div class="cell name" style="width: 45%"><a href="?a=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['title']; ?></a></div>
                                <div class="cell department" style="width: 15%"><a href="?a=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['depart_title']; ?></a></div>
                                <div class="cell division" style="width: 15%"><a href="?a=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['div_title']; ?></a></div>
                                <div class="cell tasks" style="width: 10%"><a href="?a=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['task_count']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="?a=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO PRESETS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "tasks") { ?>
                <div class="navbar level-3 unselected">
                    <div class="container-button">
                        <a href="new-r&d/task.php" class="button admin-menu"><span>+ Task Preset</span></a>
                    </div>
                </div> <?php
                $presets = Task::selectPresets();
                $divisions = Assignment::selectDivisions(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-name-asg':'.cell.name-asg', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-name-asg':'.cell.name-asg', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Task Preset Name" required style="width: calc(25% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-name-asg':'.cell.name-asg', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name-asg" class="input-name-asg" placeholder="Enter Assignment Preset Name" required style="width: calc(25% - 8px);">
                    <div class="custom-select input-division" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-name-asg':'.cell.name-asg', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option> <?php
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
                        <div class="head admin" style="width: 25%">Task Preset Name</div>
                        <div class="head admin" style="width: 25%">Assignment Preset Name</div>
                        <div class="head admin" style="width: 15%">Division</div>
                        <div class="head admin links" style="width: 10%" onclick="sortTable('.head.links', '.cell.links .content')">Links</div>
                        <div class="head admin time" style="width: 10%" onclick="sortTime('.head.time', '.cell.time .content')">Time</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if ($presets) {
                        foreach ($presets as $preset) { ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="?t=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo "#" . sprintf('%05d', $preset['id']); ?></a></div>
                                <div class="cell name" style="width: 25%"><a href="?t=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['name']; ?></a></div>
                                <div class="cell name-asg" style="width: 25%"><a href="?t=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['asg-title']; ?></a></div>
                                <div class="cell division" style="width: 15%"><a href="?t=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['division']; ?></a></div>
                                <div class="cell links" style="width: 10%"><a href="?t=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['links']; ?></a></div>
                                <div class="cell time" style="width: 10%"><a href="?t=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['estimated']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="?t=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO PRESETS</div> <?php
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "linktypes") { ?>
                <div class="navbar level-3 unselected">
                    <div class="container-button">
                        <a href="new-r&d/linktype.php" class="button admin-menu"><span>+ Task Link Type</span></a>
                    </div>
                </div> <?php
                $types = Task::selectLinkTypes(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="name" class="input-name" placeholder="Enter Link Type Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Task Link Type Name</div>
                        <div class="head admin" style="width: 65%">Description</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if ($types) {
                        foreach ($types as $type) {
                            $link = "?lt=" . $type['id'] . "&l1=overview"; ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%02d', $type['id']); ?></a></div>
                                <div class="cell name" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $type['title']; ?></a></div>
                                <div class="cell description" style="width: 65%"><a href="<?php echo $link; ?>" class="content"><?php echo $type['description']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO LINK TYPES</div> <?php
                    } ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['p']) && isset($preset)) {
            if (isset($_GET['options'])) {
                if (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                    if (isset($_GET['l2']) && $_GET['l2'] == "product") {
                        if (isset($_POST['product']))
                            Database::update('preset-project', $_GET['p'], ['productid' => $_POST['product'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?p=" . $_GET['p'] . "&options&l1=edit");
                        elseif (isset($_POST['none']))
                            Database::update('preset-project', $_GET['p'], ["productid" => null, 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?p=" . $_GET['p'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" class="container-button">
                                <input type="hidden" name="none">
                                <input type="submit" name="submit" value="NONE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
                        <form class="search-bar admin">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                                   type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                                   type="text" name="name" class="input-name" placeholder="Enter Product Name" required style="width: calc(20% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                                   type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
                        </form>
                        <div class="table-header-container">
                            <div class="header-extension admin"></div>
                            <div class="header">
                                <div class="head admin" style="width: 7.5%">№</div>
                                <div class="head admin" style="width: 20%">Product Name</div>
                                <div class="head admin" style="width: 65%">Description</div>
                                <div class="head admin" style="width: 7.5%">Select</div>
                            </div>
                            <div class="header-extension admin"></div>
                        </div>
                        </div>
                        <div class="table admin"> <?php
                            $products = Project::selectProducts();
                            if ($products) {
                                foreach ($products as $product) { ?>
                                    <form method="post" class="row">
                                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $product['id']; ?>" class="content"></div>
                                        <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $product['title']; ?>" class="content"></div>
                                        <div class="cell description" style="width: 65%"><input type="submit" name="submit" value="<?php echo $product['description']; ?>" class="content"></div>
                                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                                        <input type="hidden" name="product" value="<?php echo $product['id']; ?>">
                                    </form> <?php
                                }
                            }
                            else { ?>
                                <div class="empty-table">NO PRODUCTS</div> <?php
                            } ?>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "name") {
                        if (isset($_POST['title']))
                            Database::update('preset-project', $_GET['p'], ['title' => $_POST['title'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?p=" . $_GET['p'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" id="title" class="container-button">
                                <input type="hidden" name="title">
                                <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
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
                                <input form="title" name="title" class="field admin" placeholder="Enter Preset Name Here" maxlength="50" value="<?php if (isset($preset['title'])) echo htmlspecialchars($preset['title']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                        if (isset($_POST['description']))
                            Database::update('preset-project', $_GET['p'], ['description' => $_POST['description'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?p=" . $_GET['p'] . "&options&l1=edit"); ?>

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
                                <div class="head admin">Preset Description</div>
                            </div>
                            <div class="header-extension large admin"></div>
                        </div>
                        </div>
                        <div class="table large">
                            <div class="row">
                                <input form="description" name="description" class="field admin" placeholder="Enter Preset Description Here" maxlength="200" value="<?php if (isset($preset['description'])) echo htmlspecialchars($preset['description']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "assignments") {
                        if (isset($_GET['l3']) && $_GET['l3'] == "remove") {
                            if (isset($_POST['del-asg'])) {
                                Database::remove('preset-project_assignment', $_POST['del-asg'], false);
                                Database::update('preset-project', $_GET['p'], ['date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], false);
                            }
                            $divisions = Assignment::selectDivisions();
                            include_once "includes/info-bar.php"; ?>
                            <form class="search-bar admin">
                                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                                       type="text" name="name" class="input-name" placeholder="Enter Preset Name" required style="width: calc(20% - 8px);">
                                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                                       type="text" name="objective" class="input-objective" placeholder="Enter Objective" required style="width: calc(35% - 8px);">
                                <div class="custom-select input-division" style="width: calc(20% - 8px);">
                                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                            name="division" class="input-division" required>
                                        <option value="">All Divisions</option>
                                        <option value="None">None</option> <?php
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
                                    <div class="head admin" style="width: 20%">Assignment Name</div>
                                    <div class="head admin" style="width: 35%">Assignment Objective</div>
                                    <div class="head admin" style="width: 20%">Division</div>
                                    <div class="head admin tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                                    <div class="head admin" style="width: 7.5%">Remove</div>
                                </div>
                                <div class="header-extension admin"></div>
                            </div>
                            </div>
                            <div class="table admin"> <?php
                                $assignments = Assignment::selectAssignmentPresetsByProjectPreset($_GET['p']);
                                if ($assignments) {
                                    foreach ($assignments as $assignment) { ?>
                                        <form method="post" class="row">
                                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $assignment['id']; ?>" class="content"></div>
                                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $assignment['title']; ?>" class="content"></div>
                                            <div class="cell objective" style="width: 35%"><input type="submit" name="submit" value="<?php echo $assignment['objective']; ?>" class="content"></div>
                                            <div class="cell division" style="width: 20%"><input type="submit" name="submit" value="<?php echo $assignment['div_title']; ?>" class="content"></div>
                                            <div class="cell tasks" style="width: 10%"><input type="submit" name="submit" value="<?php echo $assignment['task_count']; ?>" class="content"></div>
                                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                                            <input type="hidden" name="del-asg" value="<?php echo $assignment['id']; ?>">
                                        </form> <?php
                                    }
                                }
                                else { ?>
                                    <div class="empty-table">NO ASSIGNMENTS</div> <?php
                                } ?>
                            </div> <?php
                        }
                        elseif (isset($_GET['l3']) && $_GET['l3'] == "add") {
                            if (isset($_POST['add-asg'])) {
                                Database::insert('preset-project_assignment', ['projectid' => $_GET['p'], 'assignmentid' => $_POST['add-asg']], false, false);
                                Database::update('preset-project', $_GET['p'], ['date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], false);
                                if (isset($_SESSION['edit-projectpr']['add-assignment']))
                                    header('Location: r&d.php?p=' . $_GET['p'] . '&l1=assignments');
                                else
                                    header('Location: r&d.php?p=' . $_GET['p'] . '&options&l1=edit&l2=assignments&l3=remove');
                                unset($_SESSION['edit-projectpr']);
                            }

                            $divisions = Assignment::selectDivisions();
                            include_once "includes/info-bar.php"; ?>
                            <form class="search-bar admin">
                                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                                       type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                                       type="text" name="name" class="input-name" placeholder="Enter Preset Name" required style="width: calc(20% - 8px);">
                                <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                                       type="text" name="objective" class="input-objective" placeholder="Enter Objective" required style="width: calc(35% - 8px);">
                                <div class="custom-select input-division" style="width: calc(20% - 8px);">
                                    <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                            name="division" class="input-division" required>
                                        <option value="">All Divisions</option>
                                        <option value="None">None</option> <?php
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
                                    <div class="head admin" style="width: 20%">Assignment Name</div>
                                    <div class="head admin" style="width: 35%">Assignment Objective</div>
                                    <div class="head admin" style="width: 20%">Division</div>
                                    <div class="head admin tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                                    <div class="head admin" style="width: 7.5%">Add</div>
                                </div>
                                <div class="header-extension admin"></div>
                            </div>
                            </div>
                            <div class="table admin"> <?php
                                $assignments = Assignment::selectPresets();
                                if ($assignments) {
                                    foreach ($assignments as $assignment) { ?>
                                        <form method="post" class="row">
                                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $assignment['id']; ?>" class="content"></div>
                                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $assignment['title']; ?>" class="content"></div>
                                            <div class="cell objective" style="width: 35%"><input type="submit" name="submit" value="<?php echo $assignment['objective']; ?>" class="content"></div>
                                            <div class="cell division" style="width: 20%"><input type="submit" name="submit" value="<?php echo $assignment['div_title']; ?>" class="content"></div>
                                            <div class="cell tasks" style="width: 10%"><input type="submit" name="submit" value="<?php echo $assignment['task_count']; ?>" class="content"></div>
                                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                                            <input type="hidden" name="add-asg" value="<?php echo $assignment['id']; ?>">
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
                    else { ?>
                        </div> <?php
                    }
                }
                elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") {
                    if (isset($_POST['delete']))
                        Project::remove('preset-project', $_GET['p'], "r&d.php?l1=project&l2=projects"); ?>

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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "overview") { ?>
                </div>
                <div class="overview-content">
                    <div class="info-bar short">
                        <div class="section">
                            <div class="content light"><?php echo "#" . sprintf('%03d', $preset['id']); ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Product:</div>
                            <div class="content"><?php echo $preset['product']; ?></div>
                        </div>
                    </div>
                    <div class="info-bar tiny">
                        <div class="section line-right active">
                            <div class="stage active">Projects:</div>
                            <div class="content"><?php echo $preset['projects']; ?></div>
                        </div>
                        <div class="section active">
                            <div class="stage active">Assignments:</div>
                            <div class="content"><?php echo $preset['assignments']; ?></div>
                        </div>
                    </div>
                    <div class="overview">
                        <div class="top">
                            <div class="box">
                                <div class="title"><?php echo $preset['title']; ?></div>
                                <div class="data"><?php echo $preset['description']; ?></div>
                            </div>
                        </div>
                    </div> <?php
                    if ($preset['date_updated']) { ?>
                        <div class="info-bar" style="margin: 0 20vw; padding: 5vh 0 3.5vh 0;">
                            <div class="section line-right active">
                                <div class="stage active"><?php echo $preset['times_updated']; ?></div>
                                <div class="content">TIMES UPDATED</div>
                            </div>
                            <div class="section active">
                                <div class="stage active"><?php echo $preset['date_updated_time2']; ?></div>
                                <div class="content">LAST UPDATED</div>
                            </div>
                        </div> <?php
                    } ?>
                    <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                        <div class="section">
                            <div class="content light"><?php echo $preset['date_created_time']; ?></div>
                        </div>
                    </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "assignments") {
                if (isset($_POST['add-asg-page'])) {
                    $_SESSION['edit-projectpr']['add-assignment'] = true;
                    header('Location: r&d.php?p=' . $_GET['p'] . '&options&l1=edit&l2=assignments&l3=remove');
                } ?>

                <div class="navbar level-2 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="add-asg-page">
                        <input type="submit" name="submit" value="+/- Assignment Preset" class="button admin-menu">
                    </form>
                </div> <?php
                $divisions = Assignment::selectDivisions(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="objective" class="input-objective" placeholder="Enter Assignment Objective" required style="width: calc(35% - 8px);">
                    <div class="custom-select input-division" style="width: calc(20% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                name="division" class="input-division" required>
                            <option value="">All Divisions</option>
                            <option value="None">None</option> <?php
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
                        <div class="head admin" style="width: 20%">Assignment Name</div>
                        <div class="head admin" style="width: 35%">Assignment Objective</div>
                        <div class="head admin" style="width: 20%">Division</div>
                        <div class="head admin tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    $assignments = Assignment::selectAssignmentPresetsByProjectPreset($_GET['p']);
                    if ($assignments) {
                        foreach ($assignments as $asg) { ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="?a=<?php echo $asg['assignmentid'] . "&l1=overview"; ?>" class="content"><?php echo "#" . sprintf('%03d', $asg['assignmentid']); ?></a></div>
                                <div class="cell name" style="width: 20%"><a href="?a=<?php echo $asg['assignmentid'] . "&l1=overview"; ?>" class="content"><?php echo $asg['title']; ?></a></div>
                                <div class="cell objective" style="width: 35%"><a href="?a=<?php echo $asg['assignmentid'] . "&l1=overview"; ?>" class="content"><?php echo $asg['objective']; ?></a></div>
                                <div class="cell division" style="width: 20%"><a href="?a=<?php echo $asg['assignmentid'] . "&l1=overview"; ?>" class="content"><?php echo $asg['div_title']; ?></a></div>
                                <div class="cell tasks" style="width: 10%"><a href="?a=<?php echo $asg['assignmentid'] . "&l1=overview"; ?>" class="content"><?php echo $asg['task_count']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="?a=<?php echo $asg['assignmentid'] . "&l1=overview"; ?>" class="content open-button">Open</a></div>
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
        elseif (isset($_GET['a']) && isset($preset)) {
            if (isset($_GET['options'])) {
                if (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                    if (isset($_GET['l2']) && $_GET['l2'] == "division") {
                        if (isset($_POST['division']))
                            Database::update('preset-assignment', $_GET['a'], ['divisionid' => $_POST['division'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?a=" . $_GET['a'] . "&options&l1=edit");
                        elseif (isset($_POST['none']))
                            Database::update('preset-assignment', $_GET['a'], ["divisionid" => null, 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?a=" . $_GET['a'] . "&options&l1=edit");

                        $departments = Assignment::selectDepartments(); ?>
                        <div class="navbar level-3 unselected">
                            <form method="post" class="container-button">
                                <input type="hidden" name="none">
                                <input type="submit" name="submit" value="NONE" class="button admin-menu">
                            </form>
                        </div> <?php
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
                                <div class="head admin" style="width: 50%">Description</div>
                                <div class="head admin" style="width: 15%">Department</div>
                                <div class="head admin" style="width: 7.5%">Select</div>
                            </div>
                            <div class="header-extension admin"></div>
                        </div>
                        </div>
                        <div class="table admin"> <?php
                            if (isset($preset)) {
                                $divisions = Assignment::selectDivisions();
                                if ($divisions) {
                                    foreach ($divisions as $division) { ?>
                                        <form method="post" class="row">
                                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $division['id']; ?>" class="content"></div>
                                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $division['title']; ?>" class="content"></div>
                                            <div class="cell description" style="width: 50%"><input type="submit" name="submit" value="<?php echo $division['description']; ?>" class="content"></div>
                                            <div class="cell depart" style="width: 15%"><input type="submit" name="submit" value="<?php echo $division['department']; ?>" class="content"></div>
                                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                                            <input type="hidden" name="division" value="<?php echo $division['id']; ?>">
                                        </form> <?php
                                    }
                                }
                                else { ?>
                                    <div class="empty-table">NO DIVISIONS</div> <?php
                                }
                            } ?>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "name") {
                        if (isset($_POST['title']))
                            Database::update('preset-assignment', $_GET['a'], ['title' => $_POST['title'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?a=" . $_GET['a'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" id="title" class="container-button">
                                <input type="hidden" name="title">
                                <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
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
                                <input form="title" name="title" class="field admin" placeholder="Enter Preset Name Here" maxlength="50" value="<?php if (isset($preset['title'])) echo htmlspecialchars($preset['title']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "objective") {
                        if (isset($_POST['objective']))
                            Database::update('preset-assignment', $_GET['a'], ['objective' => $_POST['objective'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?a=" . $_GET['a'] . "&options&l1=edit"); ?>

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
                                <div class="head admin">Preset Objective</div>
                            </div>
                            <div class="header-extension medium admin"></div>
                        </div>
                        </div>
                        <div class="table medium">
                            <div class="row">
                                <input form="objective" name="objective" class="field admin" placeholder="Enter Assignment Objective Here" maxlength="100" value="<?php if (isset($preset['objective'])) echo htmlspecialchars($preset['objective']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "tasks") {
                        if (isset($_POST['new-task-page'])) {
                            $_SESSION['edit-assignmentpr']['redirect'] = 2;
                            $_SESSION['new-taskpr']['fields']['assignmentid'] = $_GET['a'];
                            $_SESSION['new-taskpr']['infoAssignmentLock'] = true;
                            header('Location: new-r&d/task.php');
                        }
                        if (isset($_POST['del-task'])) {
                            $taskPreset = Task::selectTaskPreset($_POST['del-task']);
                            Database::update('preset-task', $_POST['del-task'], ['assignmentid' => null, 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$taskPreset['times_updated']], false);
                            Database::update('preset-assignment', $_GET['a'], ['date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], false);
                            header('Location: r&d.php?' . http_build_query($_GET));
                        } ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" class="container-button">
                                <input type="hidden" name="new-task-page">
                                <input type="submit" name="submit" value="+ Task Preset" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
                        <form class="search-bar admin">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name'})"
                                   type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name'})"
                                   type="text" name="name" class="input-name" placeholder="Enter Task Preset Name" required style="width: calc(65% - 8px);">
                        </form>
                        <div class="table-header-container">
                            <div class="header-extension admin"></div>
                            <div class="header">
                                <div class="head admin" style="width: 7.5%">№</div>
                                <div class="head admin" style="width: 65%">Task Preset Name</div>
                                <div class="head admin links" style="width: 10%" onclick="sortTable('.head.links', '.cell.links .content')">Links</div>
                                <div class="head admin time" style="width: 10%" onclick="sortTime('.head.time', '.cell.time .content')">Time</div>
                                <div class="head admin" style="width: 7.5%">Remove</div>
                            </div>
                            <div class="header-extension admin"></div>
                        </div>
                        </div>
                        <div class="table admin"> <?php
                            $tasks = Task::selectAssignmentPresetTasks($_GET['a']);
                            if ($tasks) {
                                foreach ($tasks as $task) { ?>
                                    <form method="post" class="row">
                                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $task['id']; ?>" class="content"></div>
                                        <div class="cell name" style="width: 65%"><input type="submit" name="submit" value="<?php echo $task['name']; ?>" class="content"></div>
                                        <div class="cell links" style="width: 10%"><input type="submit" name="submit" value="<?php echo $task['links']; ?>" class="content"></div>
                                        <div class="cell time" style="width: 10%"><input type="submit" name="submit" value="<?php echo $task['estimated']; ?>" class="content"></div>
                                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                                        <input type="hidden" name="del-task" value="<?php echo $task['id']; ?>">
                                    </form> <?php
                                }
                            }
                            else { ?>
                                <div class="empty-table">NO TASKS</div> <?php
                            } ?>
                        </div> <?php
                    }
                }
                elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") {
                    if (isset($_POST['delete']))
                        Assignment::remove('preset-assignment', $_GET['a'], "r&d.php?l1=assignment&l2=assignments"); ?>

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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "overview") { ?>
                </div>
                <div class="overview-content">
                    <div class="info-bar short">
                        <div class="section">
                            <div class="content light"><?php echo "#" . sprintf('%03d', $preset['id']); ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Task Presets:</div>
                            <div class="content"><?php echo $preset['task_count']; ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Division:</div>
                            <div class="content"><?php echo $preset['div_title']; ?></div>
                        </div>
                    </div>
                    <div class="info-bar tiny">
                        <div class="section active">
                            <div class="stage active">Assignments:</div>
                            <div class="content"><?php echo $preset['assignments']; ?></div>
                        </div>
                        <div class="section active">
                            <div class="stage active">Used In Projects:</div>
                            <div class="content"><?php echo $preset['projects']; ?></div>
                        </div>
                        <div class="section active">
                            <div class="stage active">Used In Project Presets:</div>
                            <div class="content"><?php echo $preset['prj_presets']; ?></div>
                        </div>
                    </div>
                    <div class="overview">
                        <div class="top">
                            <div class="box">
                                <div class="title"><?php echo $preset['title']; ?></div>
                                <div class="data"><?php echo $preset['objective']; ?></div>
                            </div>
                        </div>
                    </div> <?php
                    if ($preset['date_updated']) { ?>
                        <div class="info-bar" style="margin: 0 20vw; padding: 5vh 0 3.5vh 0;">
                            <div class="section line-right active">
                                <div class="stage active"><?php echo $preset['times_updated']; ?></div>
                                <div class="content">TIMES UPDATED</div>
                            </div>
                            <div class="section active">
                                <div class="stage active"><?php echo $preset['date_updated_time2']; ?></div>
                                <div class="content">LAST UPDATED</div>
                            </div>
                        </div> <?php
                    } ?>
                    <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                        <div class="section">
                            <div class="content light"><?php echo $preset['date_created_time']; ?></div>
                        </div>
                    </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "tasks") {
                if (isset($_POST['task-presets']))
                    header('Location: r&d.php?a=' . $_GET['a'] . '&options&l1=edit&l2=tasks'); ?>

                <div class="navbar level-2 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="task-presets">
                        <input type="submit" name="submit" value="+/- Task Presets" class="button admin-menu">
                    </form>
                </div>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name'})"
                           type="text" name="name" class="input-name" placeholder="Enter Task Preset Name" required style="width: calc(65% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 65%">Task Preset Name</div>
                        <div class="head admin links" style="width: 10%" onclick="sortTable('.head.links', '.cell.links .content')">Links</div>
                        <div class="head admin time" style="width: 10%" onclick="sortTime('.head.time', '.cell.time .content')">Time</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    $tasks = Task::selectAssignmentPresetTasks($_GET['a']);
                    if ($tasks) {
                        foreach ($tasks as $task) { ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="?t=<?php echo $task['id'] . "&l1=overview"; ?>" class="content"><?php echo "#" . sprintf('%05d', $task['id']); ?></a></div>
                                <div class="cell name" style="width: 65%"><a href="?t=<?php echo $task['id'] . "&l1=overview"; ?>" class="content"><?php echo $task['name']; ?></a></div>
                                <div class="cell links" style="width: 10%"><a href="?t=<?php echo $task['id'] . "&l1=overview"; ?>" class="content"><?php echo $task['links']; ?></a></div>
                                <div class="cell time" style="width: 10%"><a href="?t=<?php echo $task['id'] . "&l1=overview"; ?>" class="content"><?php echo $task['estimated']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="?t=<?php echo $task['id'] . "&l1=overview"; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO TASKS</div> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['t']) && isset($preset)) {
            if (isset($_GET['options'])) {
                if (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                    if (isset($_GET['l2']) && $_GET['l2'] == "assignment") {
                        if (isset($_POST['asg']))
                            Database::update('preset-task', $_GET['t'], ['assignmentid' => $_POST['asg'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?t=" . $_GET['t'] . "&options&l1=edit");
                        elseif (isset($_POST['none']))
                            Database::update('preset-task', $_GET['t'], ['assignmentid' => null, 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?t=" . $_GET['t'] . "&options&l1=edit");

                        $presets = Assignment::selectPresets();
                        $divisions = Assignment::selectDivisions();
                        $departments = Assignment::selectDepartments(); ?>
                        <div class="navbar level-3 unselected">
                            <form method="post" class="container-button">
                                <input type="hidden" name="none">
                                <input type="submit" name="submit" value="NONE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
                        <form class="search-bar admin">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                                   type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                                   type="text" name="name" class="input-name" placeholder="Enter Assignment Preset Name" required style="width: calc(45% - 8px);">
                            <div class="custom-select input-department" style="width: calc(15% - 8px);">
                                <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                        name="department" class="input-department" required>
                                    <option value="">All Departments</option>
                                    <option value="None">None</option> <?php
                                    foreach ($departments as $depart) { ?>
                                        <option value="<?php echo $depart['title']; ?>"><?php echo $depart['title']; ?></option> <?php
                                    } ?>
                                </select>
                            </div>
                            <div class="custom-select input-division" style="width: calc(15% - 8px);">
                                <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'}, this)"
                                        name="division" class="input-division" required>
                                    <option value="">All Divisions</option>
                                    <option value="None">None</option> <?php
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
                                <div class="head admin" style="width: 45%">Assignment Preset Name</div>
                                <div class="head admin" style="width: 15%">Department</div>
                                <div class="head admin" style="width: 15%">Division</div>
                                <div class="head admin tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                                <div class="head admin" style="width: 7.5%">Select</div>
                            </div>
                            <div class="header-extension admin"></div>
                        </div>
                        </div>
                        <div class="table admin"> <?php
                            $asgPresets = Assignment::selectPresets();
                            if ($asgPresets) {
                                foreach ($asgPresets as $preset) { ?>
                                    <form method="post" class="row">
                                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                                        <div class="cell name" style="width: 45%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                                        <div class="cell department" style="width: 15%"><input type="submit" name="submit" value="<?php echo $preset['depart_title']; ?>" class="content"></div>
                                        <div class="cell division" style="width: 15%"><input type="submit" name="submit" value="<?php echo $preset['div_title']; ?>" class="content"></div>
                                        <div class="cell tasks" style="width: 10%"><input type="submit" name="submit" value="<?php echo $preset['task_count']; ?>" class="content"></div>
                                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                                        <input type="hidden" name="asg" value="<?php echo $preset['id']; ?>">
                                    </form> <?php
                                }
                            }
                            else { ?>
                                <div class="empty-table">NO ASSIGNMENT PRESETS</div> <?php
                            } ?>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "name") {
                        if (isset($_POST['name']))
                            Project::update('preset-task', $_GET['t'], ['name' => $_POST['name'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?t=" . $_GET['t'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" id="name" class="container-button">
                                <input type="hidden" name="name">
                                <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
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
                                <input form="name" name="name" class="field admin" placeholder="Enter Preset Name Here" maxlength="50" value="<?php if (isset($preset['name'])) echo htmlspecialchars($preset['name']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                        if (isset($_POST['description']))
                            Project::update('preset-task', $_GET['t'], ['description' => $_POST['description'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?t=" . $_GET['t'] . "&options&l1=edit"); ?>

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
                                <div class="head admin">Preset Description</div>
                            </div>
                            <div class="header-extension large admin"></div>
                        </div>
                        </div>
                        <div class="table large">
                            <div class="row">
                                <input form="description" name="description" class="field admin" placeholder="Enter Preset Description Here" maxlength="200" value="<?php if (isset($preset['description'])) echo htmlspecialchars($preset['description']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "time") {
                        if (isset($_POST['time'])) {
                            if (ctype_digit($_POST['time']) && $_POST['time'] <= 7200 && $_POST['time'] >= 10) {
                                $time = gmdate("H:i:s", $_POST['time']);
                                Project::update('preset-task', $_GET['t'], ['estimated' => $time, 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?t=" . $_GET['t'] . "&options&l1=edit");
                            }
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
                                <input form="time" name="time" type="number" min="10" max="7200" placeholder="Seconds" class="field admin" value="<?php if (isset($preset['estimated'])) echo strtotime($preset['estimated']) - strtotime('TODAY'); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "info") {
                        if (isset($_POST['info']))
                            Database::update('preset-task', $_GET['t'], ['infoid' => $_POST['info'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?t=" . $_GET['t'] . "&options&l1=edit");
                        elseif (isset($_POST['none']))
                            Project::update('preset-task', $_GET['t'], ['infoid' => null, 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?t=" . $_GET['t'] . "&options&l1=edit");

                        $groups = Database::selectInfoPageGroups(); ?>
                        <div class="navbar level-3 unselected">
                            <form method="post" class="container-button">
                                <input type="hidden" name="none">
                                <input type="submit" name="submit" value="NONE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
                        <form class="search-bar admin">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                                   type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                                   type="text" name="name" class="input-name" placeholder="Enter Preset Name" required style="width: calc(20% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                                   type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(50% - 8px);">
                            <div class="custom-select input-group" style="width: calc(15% - 8px);">
                                <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'}, this)"
                                        name="group" class="input-group" required>
                                    <option value="">All Groups</option>
                                    <option value="None">None</option> <?php
                                    foreach ($groups as $group) { ?>
                                        <option value="<?php echo $group['title']; ?>"><?php echo $group['title']; ?></option> <?php
                                    } ?>
                                </select>
                            </div>
                        </form>
                        <div class="table-header-container">
                            <div class="header-extension admin"></div>
                            <div class="header">
                                <div class="head admin" style="width: 7.5%">№</div>
                                <div class="head admin" style="width: 20%">Project Link Preset Name</div>
                                <div class="head admin" style="width: 50%">Description</div>
                                <div class="head admin" style="width: 15%">Group</div>
                                <div class="head admin" style="width: 7.5%">Select</div>
                            </div>
                            <div class="header-extension admin"></div>
                        </div>
                        </div>
                        <div class="table admin"> <?php
                            $infopages = Database::selectInfoPagePresets();
                            if ($infopages) {
                                foreach ($infopages as $infopage) { ?>
                                    <form method="post" class="row">
                                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $infopage['id']; ?>" class="content"></div>
                                        <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $infopage['title']; ?>" class="content"></div>
                                        <div class="cell description" style="width: 50%"><input type="submit" name="submit" value="<?php echo $infopage['description']; ?>" class="content"></div>
                                        <div class="cell group" style="width: 15%"><input type="submit" name="submit" value="<?php echo $infopage['group']; ?>" class="content"></div>
                                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                                        <input type="hidden" name="info" value="<?php echo $infopage['id']; ?>">
                                    </form> <?php
                                }
                            }
                            else { ?>
                                <div class="empty-table">NO INFO PAGE PRESETS</div> <?php
                            } ?>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "links") {
                        if (isset($_POST['new-link-page'])) {
                            $_SESSION['new-task-link']['fields']['taskid'] = $_GET['t'];
                            $_SESSION['new-task-link']['stage'] = '1';
                            $_SESSION['new-task-link']['info']['type'] = "";
                            $_SESSION['new-task-link']['redirect'] = 2;
                            header('Location: new-r&d/task-link.php');
                        }
                        if (isset($_POST['del-link'])) {
                            Database::remove('preset-task_links', $_POST['del-link'], false);
                            Database::update('preset-task', $_GET['t'], ['date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], false);
                            header('Location: r&d.php?' . http_build_query($_GET));
                        } ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" class="container-button">
                                <input type="hidden" name="new-link-page">
                                <input type="submit" name="submit" value="+ Task Link Preset" class="button admin-menu">
                            </form>
                        </div> <?php
                        $types = Task::selectLinkTypes();
                        include_once "includes/info-bar.php"; ?>
                        <form class="search-bar admin">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-title':'.cell.title', '.search-bar .custom-select.input-type .input-type':'.cell.type'})"
                                   type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-title':'.cell.title', '.search-bar .custom-select.input-type .input-type':'.cell.type'})"
                                   type="text" name="title" class="input-title" placeholder="Enter Link Name" required style="width: calc(20% - 8px);">
                            <div class="custom-select input-type" style="width: calc(15% - 8px);">
                                <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-title':'.cell.title', '.search-bar .custom-select.input-type .input-type':'.cell.type'}, this)"
                                        name="type" class="input-type" required>
                                    <option value="">All Types</option>
                                    <option value="None">None</option> <?php
                                    foreach ($types as $type) { ?>
                                        <option value="<?php echo $type['title']; ?>"><?php echo $type['title']; ?></option> <?php
                                    } ?>
                                </select>
                            </div>
                        </form>
                        <div class="table-header-container">
                            <div class="header-extension admin"></div>
                            <div class="header">
                                <div class="head admin" style="width: 7.5%">№</div>
                                <div class="head admin" style="width: 20%">Link Preset Name</div>
                                <div class="head admin" style="width: 15%">Type</div>
                                <div class="head admin" style="width: 50%">URL</div>
                                <div class="head admin" style="width: 7.5%">Remove</div>
                            </div>
                            <div class="header-extension admin"></div>
                        </div>
                        </div>
                        <div class="table admin"> <?php
                            $links = Task::selectTaskPresetLinks($_GET['t']);
                            if ($links) {
                                foreach ($links as $link) { ?>
                                    <form method="post" class="row">
                                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $link['id']; ?>" class="content"></div>
                                        <div class="cell title" style="width: 20%"><input type="submit" name="submit" value="<?php echo $link['title']; ?>" class="content"></div>
                                        <div class="cell type" style="width: 15%"><input type="submit" name="submit" value="<?php echo $link['type']; ?>" class="content"></div>
                                        <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $link['linkWithNone']; ?>" class="content"></div>
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
                    else { ?>
                        </div> <?php
                    }
                }
                elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") {
                    if (isset($_POST['delete'])) {
                        $asgID = Task::selectTaskPreset($_GET['t'])['assignmentid'];
                        Task::remove('preset-task', $_GET['t'], false);
                        if (isset($_SESSION['backPageR&D']['asg']))
                            header('Location: r&d.php?a=' . $asgID . '&l1=tasks');
                        else
                            header('Location: r&d.php?l1=assignment&l2=tasks');
                    } ?>

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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "overview") { ?>
                </div>
                <div class="overview-content">
                    <div class="info-bar short">
                        <div class="section">
                            <div class="content light"><?php echo "#" . sprintf('%05d', $preset['id']); ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Assignment Preset:</div>
                            <div class="content"><?php echo $preset['assignment']; ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Time:</div>
                            <div class="content"><?php echo $preset['estimated']; ?></div>
                        </div>
                    </div>
                    <div class="info-bar tiny">
                        <div class="section active">
                            <div class="stage active">Project Link Preset:</div>
                            <div class="content"><?php echo $preset['project_link_preset']; ?></div>
                        </div>
                        <div class="section active">
                            <div class="stage active">Tasks:</div>
                            <div class="content"><?php echo $preset['task_count']; ?></div>
                        </div>
                        <div class="section active">
                            <div class="stage active">Links:</div>
                            <div class="content"><?php echo $preset['links']; ?></div>
                        </div>
                    </div>
                    <div class="overview">
                        <div class="top">
                            <div class="box">
                                <div class="title"><?php echo $preset['name']; ?></div>
                                <div class="data"><?php echo $preset['description']; ?></div>
                            </div>
                        </div>
                    </div> <?php
                    if ($preset['date_updated']) { ?>
                        <div class="info-bar" style="margin: 0 20vw; padding: 5vh 0 3.5vh 0;">
                            <div class="section line-right active">
                                <div class="stage active"><?php echo $preset['times_updated']; ?></div>
                                <div class="content">TIMES UPDATED</div>
                            </div>
                            <div class="section active">
                                <div class="stage active"><?php echo $preset['date_updated_time2']; ?></div>
                                <div class="content">LAST UPDATED</div>
                            </div>
                        </div> <?php
                    } ?>
                    <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                        <div class="section">
                            <div class="content light"><?php echo $preset['date_created_time']; ?></div>
                        </div>
                    </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "links") {
                if (isset($_POST['links']))
                    header('Location: r&d.php?t=' . $_GET['t'] . '&options&l1=edit&l2=links'); ?>

                <div class="navbar level-2 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="links">
                        <input type="submit" name="submit" value="+/- Task Link Presets" class="button admin-menu">
                    </form>
                </div> <?php
                $types = Task::selectLinkTypes(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-title':'.cell.title', '.search-bar .custom-select.input-type .input-type':'.cell.type'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-title':'.cell.title', '.search-bar .custom-select.input-type .input-type':'.cell.type'})"
                           type="text" name="title" class="input-title" placeholder="Enter Link Name" required style="width: calc(20% - 8px);">
                    <div class="custom-select input-type" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-title':'.cell.title', '.search-bar .custom-select.input-type .input-type':'.cell.type'}, this)"
                                name="type" class="input-type" required>
                            <option value="">All Types</option>
                            <option value="None">None</option> <?php
                            foreach ($types as $type) { ?>
                                <option value="<?php echo $type['title']; ?>"><?php echo $type['title']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Link Name</div>
                        <div class="head admin" style="width: 15%">Link Type</div>
                        <div class="head admin" style="width: 50%">Link</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    $links = Task::selectTaskPresetLinks($_GET['t']);
                    if ($links) {
                        foreach ($links as $link) { ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link['link']; ?>" target="_blank" class="content"><?php echo "#" . sprintf('%05d', $link['id']); ?></a></div>
                                <div class="cell title" style="width: 20%"><a href="<?php echo $link['link']; ?>" target="_blank" class="content"><?php echo $link['title']; ?></a></div>
                                <div class="cell type" style="width: 15%"><a href="<?php echo $link['link']; ?>" target="_blank" class="content"><?php echo $link['type']; ?></a></div>
                                <div class="cell" style="width: 50%"><a href="<?php echo $link['link']; ?>" target="_blank" class="content"><?php echo $link['linkWithNone']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link['link']; ?>" target="_blank" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO LINKS</div> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['i']) && isset($preset)) {
            if (isset($_GET['options'])) {
                if (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                    if (isset($_GET['l2']) && $_GET['l2'] == "group") {
                        if (isset($_POST['group']))
                            Project::update('preset-infopage', $_GET['i'], ['groupid' => $_POST['group'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?i=" . $_GET['i'] . "&options&l1=edit");
                        elseif (isset($_POST['none']))
                            Project::update('preset-infopage', $_GET['i'], ["groupid" => null, 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?i=" . $_GET['i'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" class="container-button">
                                <input type="hidden" name="none">
                                <input type="submit" name="submit" value="NONE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
                        <form class="search-bar admin">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                                   type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                                   type="text" name="name" class="input-name" placeholder="Enter Group Name" required style="width: calc(20% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                                   type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
                        </form>
                        <div class="table-header-container">
                            <div class="header-extension admin"></div>
                            <div class="header">
                                <div class="head admin" style="width: 7.5%">№</div>
                                <div class="head admin" style="width: 20%">Project Link Group Name</div>
                                <div class="head admin" style="width: 65%">Project Link Group Description</div>
                                <div class="head admin" style="width: 7.5%">Select</div>
                            </div>
                            <div class="header-extension admin"></div>
                        </div>
                        </div>
                        <div class="table admin"> <?php
                            $groups = Database::selectInfoPageGroups();
                            if ($groups) {
                                foreach ($groups as $group) { ?>
                                    <form method="post" class="row">
                                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%02d', $group['id']); ?>" class="content"></div>
                                        <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $group['title']; ?>" class="content"></div>
                                        <div class="cell description" style="width: 65%"><input type="submit" name="submit" value="<?php echo $group['description']; ?>" class="content"></div>
                                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                                        <input type="hidden" name="group" value="<?php echo $group['id']; ?>">
                                    </form> <?php
                                }
                            }
                            else { ?>
                                <div class="empty-table">NO PROJECT LINK GROUPS</div> <?php
                            } ?>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "name") {
                        if (isset($_POST['title']))
                            Project::update('preset-infopage', $_GET['i'], ['title' => $_POST['title'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?i=" . $_GET['i'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" id="title" class="container-button">
                                <input type="hidden" name="title">
                                <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
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
                                <input form="title" name="title" class="field admin" placeholder="Enter Preset Name Here" maxlength="50" value="<?php if (isset($preset['title'])) echo htmlspecialchars($preset['title']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                        if (isset($_POST['description']))
                            Project::update('preset-infopage', $_GET['i'], ['description' => $_POST['description'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], "r&d.php?i=" . $_GET['i'] . "&options&l1=edit"); ?>

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
                                <div class="head admin">Preset Description</div>
                            </div>
                            <div class="header-extension large admin"></div>
                        </div>
                        </div>
                        <div class="table large">
                            <div class="row">
                                <input form="description" name="description" class="field admin" placeholder="Enter Preset Description Here" maxlength="200" value="<?php if (isset($preset['description'])) echo htmlspecialchars($preset['description']); ?>">
                            </div>
                        </div> <?php
                    }
                    else { ?>
                        </div> <?php
                    }
                }
                elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") {
                    if (isset($_POST['delete']))
                        Database::remove('preset-infopage', $_GET['i'], "r&d.php?l1=project&l2=info"); ?>

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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "overview") { ?>
                </div>
                <div class="overview-content">
                    <div class="info-bar short">
                        <div class="section">
                            <div class="content light"><?php echo "#" . sprintf('%03d', $preset['id']); ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Group:</div>
                            <div class="content"><?php echo $preset['group']; ?></div>
                        </div>
                    </div>
                    <div class="info-bar tiny">
                        <div class="section line-right active">
                            <div class="stage active">Projects:</div>
                            <div class="content"><?php echo $preset['projects']; ?></div>
                        </div>
                        <div class="section active">
                            <div class="stage active">Task Presets:</div>
                            <div class="content"><?php echo $preset['task_presets']; ?></div>
                        </div>
                    </div>
                    <div class="overview">
                        <div class="top">
                            <div class="box">
                                <div class="title"><?php echo $preset['title']; ?></div>
                                <div class="data"><?php echo $preset['description']; ?></div>
                            </div>
                        </div>
                    </div> <?php
                    if ($preset['date_updated']) { ?>
                        <div class="info-bar" style="margin: 0 20vw; padding: 5vh 0 3.5vh 0;">
                            <div class="section line-right active">
                                <div class="stage active"><?php echo $preset['times_updated']; ?></div>
                                <div class="content">TIMES UPDATED</div>
                            </div>
                            <div class="section active">
                                <div class="stage active"><?php echo $preset['date_updated_time2']; ?></div>
                                <div class="content">LAST UPDATED</div>
                            </div>
                        </div> <?php
                    } ?>
                    <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                        <div class="section">
                            <div class="content light"><?php echo $preset['date_created_time']; ?></div>
                        </div>
                    </div>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['f']) && isset($product)) {
            if (isset($_GET['options'])) {
                if (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                    if (isset($_GET['l2']) && $_GET['l2'] == "name") {
                        if (isset($_POST['title']))
                            Project::update('product', $_GET['f'], ['title' => $_POST['title'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$product['times_updated']], "r&d.php?f=" . $_GET['f'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" id="title" class="container-button">
                                <input type="hidden" name="title">
                                <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
                        <div class="table-header-container">
                            <div class="header-extension small admin"></div>
                            <div class="header small">
                                <div class="head admin">Product Name</div>
                            </div>
                            <div class="header-extension small admin"></div>
                        </div>
                        </div>
                        <div class="table small">
                            <div class="row">
                                <input form="title" name="title" class="field admin" placeholder="Enter Product Name Here" maxlength="50" value="<?php if (isset($product['title'])) echo htmlspecialchars($product['title']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                        if (isset($_POST['description']))
                            Project::update('product', $_GET['f'], ['description' => $_POST['description'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$product['times_updated']], "r&d.php?f=" . $_GET['f'] . "&options&l1=edit"); ?>

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
                                <div class="head admin">Product Description</div>
                            </div>
                            <div class="header-extension large admin"></div>
                        </div>
                        </div>
                        <div class="table large">
                            <div class="row">
                                <input form="description" name="description" class="field admin" placeholder="Enter Product Description Here" maxlength="200" value="<?php if (isset($product['description'])) echo htmlspecialchars($product['description']); ?>">
                            </div>
                        </div> <?php
                    }
                    else { ?>
                        </div> <?php
                    }
                }
                elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") {
                    if (isset($_POST['delete']))
                        Database::remove('product', $_GET['f'], "r&d.php?l1=project&l2=products"); ?>

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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "overview") { ?>
                </div>
                <div class="overview-content">
                    <div class="info-bar short">
                        <div class="section">
                            <div class="content light"><?php echo "#" . sprintf('%02d', $product['id']); ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Projects:</div>
                            <div class="content"><?php echo $product['projects']; ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Project Presets:</div>
                            <div class="content"><?php echo $product['presets']; ?></div>
                        </div>
                    </div>
                    <div class="overview">
                        <div class="top">
                            <div class="box">
                                <div class="title"><?php echo $product['title']; ?></div>
                                <div class="data"><?php echo $product['description']; ?></div>
                            </div>
                        </div>
                    </div> <?php
                    if ($product['date_updated']) { ?>
                        <div class="info-bar" style="margin: 0 20vw; padding: 5vh 0 3.5vh 0;">
                            <div class="section line-right active">
                                <div class="stage active"><?php echo $product['times_updated']; ?></div>
                                <div class="content">TIMES UPDATED</div>
                            </div>
                            <div class="section active">
                                <div class="stage active"><?php echo $product['date_updated_time2']; ?></div>
                                <div class="content">LAST UPDATED</div>
                            </div>
                        </div> <?php
                    } ?>
                    <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                        <div class="section">
                            <div class="content light"><?php echo $product['date_created_time']; ?></div>
                        </div>
                    </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "projects") {
                $divisions = Assignment::selectDivisions(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Project Preset Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-objective':'.cell.objective', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(55% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Project Preset Name</div>
                        <div class="head admin" style="width: 55%">Project Preset Description</div>
                        <div class="head admin assignments" style="width: 10%" onclick="sortTable('.head.assignments', '.cell.assignments .content')">Assignments</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    $projects = Project::selectProductProjectPresets($_GET['f']);
                    if ($projects) {
                        foreach ($projects as $prj) { ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="?p=<?php echo $prj['id'] . "&l1=overview"; ?>" class="content"><?php echo "#" . sprintf('%03d', $prj['id']); ?></a></div>
                                <div class="cell name" style="width: 20%"><a href="?p=<?php echo $prj['id'] . "&l1=overview"; ?>" class="content"><?php echo $prj['title']; ?></a></div>
                                <div class="cell description" style="width: 55%"><a href="?p=<?php echo $prj['id'] . "&l1=overview"; ?>" class="content"><?php echo $prj['description']; ?></a></div>
                                <div class="cell assignments" style="width: 10%"><a href="?p=<?php echo $prj['id'] . "&l1=overview"; ?>" class="content"><?php echo $prj['assignments']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="?p=<?php echo $prj['id'] . "&l1=overview"; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO PROJECT PRESETS</div> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['dp']) && isset($depart)) {
            if (isset($_GET['options'])) {
                if (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                    if (isset($_GET['l2']) && $_GET['l2'] == "name") {
                        if (isset($_POST['title']))
                            Project::update('department', $_GET['dp'], ['title' => $_POST['title'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$depart['times_updated']], "r&d.php?dp=" . $_GET['dp'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" id="title" class="container-button">
                                <input type="hidden" name="title">
                                <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
                        <div class="table-header-container">
                            <div class="header-extension small admin"></div>
                            <div class="header small">
                                <div class="head admin">Department Name</div>
                            </div>
                            <div class="header-extension small admin"></div>
                        </div>
                        </div>
                        <div class="table small">
                            <div class="row">
                                <input form="title" name="title" class="field admin" placeholder="Enter Department Name Here" maxlength="50" value="<?php if (isset($depart['title'])) echo htmlspecialchars($depart['title']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                        if (isset($_POST['description']))
                            Project::update('department', $_GET['dp'], ['description' => $_POST['description'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$depart['times_updated']], "r&d.php?dp=" . $_GET['dp'] . "&options&l1=edit"); ?>

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
                                <div class="head admin">Department Description</div>
                            </div>
                            <div class="header-extension large admin"></div>
                        </div>
                        </div>
                        <div class="table large">
                            <div class="row">
                                <input form="description" name="description" class="field admin" placeholder="Enter Department Description Here" maxlength="200" value="<?php if (isset($depart['description'])) echo htmlspecialchars($depart['description']); ?>">
                            </div>
                        </div> <?php
                    }
                    else { ?>
                        </div> <?php
                    }
                }
                elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") {
                    if (isset($_POST['delete']))
                        Database::remove('department', $_GET['dp'], "r&d.php?l1=assignment&l2=departments"); ?>

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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "overview") { ?>
                </div>
                <div class="overview-content">
                    <div class="info-bar short">
                        <div class="section">
                            <div class="content light"><?php echo "#" . sprintf('%02d', $depart['id']); ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Divisions:</div>
                            <div class="content"><?php echo $depart['divisions']; ?></div>
                        </div>
                    </div>
                    <div class="overview">
                        <div class="top">
                            <div class="box">
                                <div class="title"><?php echo $depart['title']; ?></div>
                                <div class="data"><?php echo $depart['description']; ?></div>
                            </div>
                        </div>
                    </div> <?php
                    if ($depart['date_updated']) { ?>
                        <div class="info-bar" style="margin: 0 20vw; padding: 5vh 0 3.5vh 0;">
                            <div class="section line-right active">
                                <div class="stage active"><?php echo $depart['times_updated']; ?></div>
                                <div class="content">TIMES UPDATED</div>
                            </div>
                            <div class="section active">
                                <div class="stage active"><?php echo $depart['date_updated_time2']; ?></div>
                                <div class="content">LAST UPDATED</div>
                            </div>
                        </div> <?php
                    } ?>
                    <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                        <div class="section">
                            <div class="content light"><?php echo $depart['date_created_time']; ?></div>
                        </div>
                    </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "divisions") { ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                           type="text" name="name" class="input-name" placeholder="Enter Division Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Division Name</div>
                        <div class="head admin" style="width: 65%">Division Description</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    $divisions = Assignment::selectDivisionsByDepart($_GET['dp']);
                    if ($divisions) {
                        foreach ($divisions as $division) {
                            $link = "?d=" . $division['id'] . "&l1=overview"; ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%03d', $division['id']); ?></a></div>
                                <div class="cell name" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $division['title']; ?></a></div>
                                <div class="cell description" style="width: 65%"><a href="<?php echo $link; ?>" class="content"><?php echo $division['description']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
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
        elseif (isset($_GET['d']) && isset($division)) {
            if (isset($_GET['options'])) {
                if (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                    if (isset($_GET['l2']) && $_GET['l2'] == "department") {
                        if (isset($_POST['depart']))
                            Database::update('division', $_GET['d'], ['departid' => $_POST['depart'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$division['times_updated']], "r&d.php?d=" . $_GET['d'] . "&options&l1=edit");
                        elseif (isset($_POST['none']))
                            Database::update('division', $_GET['d'], ["departid" => null, 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$division['times_updated']], "r&d.php?d=" . $_GET['d'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" class="container-button">
                                <input type="hidden" name="none">
                                <input type="submit" name="submit" value="NONE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
                        <form class="search-bar admin">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                                   type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                                   type="text" name="name" class="input-name" placeholder="Enter Division Name" required style="width: calc(20% - 8px);">
                            <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description'})"
                                   type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
                        </form>
                        <div class="table-header-container">
                            <div class="header-extension admin"></div>
                            <div class="header">
                                <div class="head admin" style="width: 7.5%">№</div>
                                <div class="head admin" style="width: 20%">Department Name</div>
                                <div class="head admin" style="width: 65%">Department Description</div>
                                <div class="head admin" style="width: 7.5%">Select</div>
                            </div>
                            <div class="header-extension admin"></div>
                        </div>
                        </div>
                        <div class="table admin"> <?php
                            $departments = Assignment::selectDepartments();
                            if ($departments) {
                                foreach ($departments as $depart) { ?>
                                    <form method="post" class="row">
                                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%02d', $depart['id']); ?>" class="content"></div>
                                        <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $depart['title']; ?>" class="content"></div>
                                        <div class="cell description" style="width: 65%"><input type="submit" name="submit" value="<?php echo $depart['description']; ?>" class="content"></div>
                                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                                        <input type="hidden" name="depart" value="<?php echo $depart['id']; ?>">
                                    </form> <?php
                                }
                            }
                            else { ?>
                                <div class="empty-table">NO DEPARTMENTS</div> <?php
                            } ?>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "name") {
                        if (isset($_POST['title']))
                            Project::update('division', $_GET['d'], ['title' => $_POST['title'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$division['times_updated']], "r&d.php?d=" . $_GET['d'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" id="title" class="container-button">
                                <input type="hidden" name="title">
                                <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
                        <div class="table-header-container">
                            <div class="header-extension small admin"></div>
                            <div class="header small">
                                <div class="head admin">Division Name</div>
                            </div>
                            <div class="header-extension small admin"></div>
                        </div>
                        </div>
                        <div class="table small">
                            <div class="row">
                                <input form="title" name="title" class="field admin" placeholder="Enter Division Name Here" maxlength="50" value="<?php if (isset($division['title'])) echo htmlspecialchars($division['title']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                        if (isset($_POST['description']))
                            Project::update('division', $_GET['d'], ['description' => $_POST['description'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$division['times_updated']], "r&d.php?d=" . $_GET['d'] . "&options&l1=edit"); ?>

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
                                <div class="head admin">Division Description</div>
                            </div>
                            <div class="header-extension large admin"></div>
                        </div>
                        </div>
                        <div class="table large">
                            <div class="row">
                                <input form="description" name="description" class="field admin" placeholder="Enter Division Description Here" maxlength="200" value="<?php if (isset($division['description'])) echo htmlspecialchars($division['description']); ?>">
                            </div>
                        </div> <?php
                    }
                    else { ?>
                        </div> <?php
                    }
                }
                elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") {
                    if (isset($_POST['delete']))
                        Database::remove('division', $_GET['d'], "r&d.php?l1=assignment&l2=divisions"); ?>

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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "overview") { ?>
                </div>
                <div class="overview-content">
                    <div class="info-bar short">
                        <div class="section">
                            <div class="content light"><?php echo "#" . sprintf('%03d', $division['id']); ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Department:</div>
                            <div class="content"><?php echo $division['department']; ?></div>
                        </div>
                    </div>
                    <div class="info-bar tiny">
                        <div class="section active">
                            <div class="stage active">Members:</div>
                            <div class="content"><?php echo $division['members']; ?></div>
                        </div>
                        <div class="section active">
                            <div class="stage active">Assignments:</div>
                            <div class="content"><?php echo $division['assignments']; ?></div>
                        </div>
                        <div class="section active">
                            <div class="stage active">Assignment Presets:</div>
                            <div class="content"><?php echo $division['asg_presets']; ?></div>
                        </div>
                    </div>
                    <div class="overview">
                        <div class="top">
                            <div class="box">
                                <div class="title"><?php echo $division['title']; ?></div>
                                <div class="data"><?php echo $division['description']; ?></div>
                            </div>
                        </div>
                    </div> <?php
                    if ($division['date_updated']) { ?>
                        <div class="info-bar" style="margin: 0 20vw; padding: 5vh 0 3.5vh 0;">
                            <div class="section line-right active">
                                <div class="stage active"><?php echo $division['times_updated']; ?></div>
                                <div class="content">TIMES UPDATED</div>
                            </div>
                            <div class="section active">
                                <div class="stage active"><?php echo $division['date_updated_time2']; ?></div>
                                <div class="content">LAST UPDATED</div>
                            </div>
                        </div> <?php
                    } ?>
                    <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                        <div class="section">
                            <div class="content light"><?php echo $division['date_created_time']; ?></div>
                        </div>
                    </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "assignments") { ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .custom-select.input-department .input-department':'.cell.department', '.search-bar .custom-select.input-division .input-division':'.cell.division'})"
                           type="text" name="name" class="input-name" placeholder="Enter Assignment Preset Name" required style="width: calc(75% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 75%">Assignment Preset Name</div>
                        <div class="head admin tasks" style="width: 10%" onclick="sortTable('.head.tasks', '.cell.tasks .content')">Tasks</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    $presets = Assignment::selectAssignmentPresetsByDivision($_GET['d']);
                    if ($presets) {
                        foreach ($presets as $preset) {
                            $link = "?a=" . $preset['id'] . "&l1=overview"; ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%03d', $preset['id']); ?></a></div>
                                <div class="cell name" style="width: 75%"><a href="<?php echo $link; ?>" class="content"><?php echo $preset['title']; ?></a></div>
                                <div class="cell tasks" style="width: 10%"><a href="<?php echo $link; ?>" class="content"><?php echo $preset['tasks']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO ASSIGNMENT PRESETS</div> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['ig']) && isset($group)) {
            if (isset($_GET['options'])) {
                if (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                    if (isset($_GET['l2']) && $_GET['l2'] == "name") {
                        if (isset($_POST['title']))
                            Project::update('infopage_group', $_GET['ig'], ['title' => $_POST['title'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$group['times_updated']], "r&d.php?ig=" . $_GET['ig'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" id="title" class="container-button">
                                <input type="hidden" name="title">
                                <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
                        <div class="table-header-container">
                            <div class="header-extension small admin"></div>
                            <div class="header small">
                                <div class="head admin">Group Name</div>
                            </div>
                            <div class="header-extension small admin"></div>
                        </div>
                        </div>
                        <div class="table small">
                            <div class="row">
                                <input form="title" name="title" class="field admin" placeholder="Enter Project Link Group Name Here" maxlength="50" value="<?php if (isset($group['title'])) echo htmlspecialchars($group['title']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                        if (isset($_POST['description']))
                            Project::update('infopage_group', $_GET['ig'], ['description' => $_POST['description'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$group['times_updated']], "r&d.php?ig=" . $_GET['ig'] . "&options&l1=edit"); ?>

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
                                <div class="head admin">Group Description</div>
                            </div>
                            <div class="header-extension large admin"></div>
                        </div>
                        </div>
                        <div class="table large">
                            <div class="row">
                                <input form="description" name="description" class="field admin" placeholder="Enter Project Link Group Description Here" maxlength="200" value="<?php if (isset($group['description'])) echo htmlspecialchars($group['description']); ?>">
                            </div>
                        </div> <?php
                    }
                    else { ?>
                        </div> <?php
                    }
                }
                elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") {
                    if (isset($_POST['delete']))
                        Database::remove('infopage_group', $_GET['ig'], "r&d.php?l1=project&l2=infogr"); ?>

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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "overview") { ?>
                </div>
                <div class="overview-content">
                    <div class="info-bar short">
                        <div class="section">
                            <div class="content light"><?php echo "#" . sprintf('%02d', $group['id']); ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Project Links:</div>
                            <div class="content"><?php echo $group['links']; ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Project Link Presets:</div>
                            <div class="content"><?php echo $group['presets']; ?></div>
                        </div>
                    </div>
                    <div class="overview">
                        <div class="top">
                            <div class="box">
                                <div class="title"><?php echo $group['title']; ?></div>
                                <div class="data"><?php echo $group['description']; ?></div>
                            </div>
                        </div>
                    </div> <?php
                    if ($group['date_updated']) { ?>
                        <div class="info-bar" style="margin: 0 20vw; padding: 5vh 0 3.5vh 0;">
                            <div class="section line-right active">
                                <div class="stage active"><?php echo $group['times_updated']; ?></div>
                                <div class="content">TIMES UPDATED</div>
                            </div>
                            <div class="section active">
                                <div class="stage active"><?php echo $group['date_updated_time2']; ?></div>
                                <div class="content">LAST UPDATED</div>
                            </div>
                        </div> <?php
                    } ?>
                    <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                        <div class="section">
                            <div class="content light"><?php echo $group['date_created_time']; ?></div>
                        </div>
                    </div>
                </div> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "links") {
                $types = Task::selectLinkTypes(); ?>
                <form class="search-bar with-space admin">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                           type="text" name="name" class="input-name" placeholder="Enter Project Link Preset Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-group .input-group':'.cell.group'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(65% - 8px);">
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Project Link Preset Name</div>
                        <div class="head admin" style="width: 65%">Description</div>
                        <div class="head admin" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    $presets = Database::selectInfoPagePresetsByGroup($_GET['ig']);
                    if ($presets) {
                        foreach ($presets as $preset) { ?>
                            <div class="row">
                                <div class="cell id" style="width: 7.5%"><a href="?i=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo "#" . sprintf('%03d', $preset['id']); ?></a></div>
                                <div class="cell name" style="width: 20%"><a href="?i=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['title']; ?></a></div>
                                <div class="cell description" style="width: 65%"><a href="?i=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content"><?php echo $preset['description']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="?i=<?php echo $preset['id'] . "&l1=overview"; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO LINK PRESETS</div> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['lt']) && isset($type)) {
            if (isset($_GET['options'])) {
                if (isset($_GET['l1']) && $_GET['l1'] == "edit") {
                    if (isset($_GET['l2']) && $_GET['l2'] == "name") {
                        if (isset($_POST['title']))
                            Project::update('link_type', $_GET['lt'], ['title' => $_POST['title'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$type['times_updated']], "r&d.php?lt=" . $_GET['lt'] . "&options&l1=edit"); ?>

                        <div class="navbar level-3 unselected">
                            <form method="post" id="title" class="container-button">
                                <input type="hidden" name="title">
                                <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                            </form>
                        </div> <?php
                        include_once "includes/info-bar.php"; ?>
                        <div class="table-header-container">
                            <div class="header-extension small admin"></div>
                            <div class="header small">
                                <div class="head admin">Task Link Type Name</div>
                            </div>
                            <div class="header-extension small admin"></div>
                        </div>
                        </div>
                        <div class="table small">
                            <div class="row">
                                <input form="title" name="title" class="field admin" placeholder="Enter Task Link Type Name Here" maxlength="50" value="<?php if (isset($type['title'])) echo htmlspecialchars($type['title']); ?>">
                            </div>
                        </div> <?php
                    }
                    elseif (isset($_GET['l2']) && $_GET['l2'] == "description") {
                        if (isset($_POST['description']))
                            Project::update('link_type', $_GET['lt'], ['description' => $_POST['description'], 'date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$type['times_updated']], "r&d.php?lt=" . $_GET['lt'] . "&options&l1=edit"); ?>

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
                                <div class="head admin">Task Link Type Description</div>
                            </div>
                            <div class="header-extension large admin"></div>
                        </div>
                        </div>
                        <div class="table large">
                            <div class="row">
                                <input form="description" name="description" class="field admin" placeholder="Enter Task Link Type Description Here" maxlength="200" value="<?php if (isset($type['description'])) echo htmlspecialchars($type['description']); ?>">
                            </div>
                        </div> <?php
                    }
                    else { ?>
                        </div> <?php
                    }
                }
                elseif (isset($_GET['l1']) && $_GET['l1'] == "delete") {
                    if (isset($_POST['delete']))
                        Database::remove('link_type', $_GET['lt'], "r&d.php?l1=assignment&l2=linktypes"); ?>

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
            elseif (isset($_GET['l1']) && $_GET['l1'] == "overview") { ?>
                </div>
                <div class="overview-content">
                    <div class="info-bar short">
                        <div class="section">
                            <div class="content light"><?php echo "#" . sprintf('%02d', $type['id']); ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Used In Tasks:</div>
                            <div class="content"><?php echo $type['tasks']; ?></div>
                        </div>
                        <div class="section">
                            <div class="stage active">Used In Task Presets:</div>
                            <div class="content"><?php echo $type['presets']; ?></div>
                        </div>
                    </div>
                    <div class="overview">
                        <div class="top">
                            <div class="box">
                                <div class="title"><?php echo $type['title']; ?></div>
                                <div class="data"><?php echo $type['description']; ?></div>
                            </div>
                        </div>
                    </div> <?php
                    if ($type['date_updated']) { ?>
                        <div class="info-bar" style="margin: 0 20vw; padding: 5vh 0 3.5vh 0;">
                            <div class="section line-right active">
                                <div class="stage active"><?php echo $type['times_updated']; ?></div>
                                <div class="content">TIMES UPDATED</div>
                            </div>
                            <div class="section active">
                                <div class="stage active"><?php echo $type['date_updated_time2']; ?></div>
                                <div class="content">LAST UPDATED</div>
                            </div>
                        </div> <?php
                    } ?>
                    <div class="info-bar short" style="margin: 0 20vw; padding: 0 0 3.5vh 0;">
                        <div class="section">
                            <div class="content light"><?php echo $type['date_created_time']; ?></div>
                        </div>
                    </div>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        else { ?>
            </div> <?php
        }

        require_once "includes/footer.php";
    }
    else
        header('Location: error.php');
}
else require_once "login.php";