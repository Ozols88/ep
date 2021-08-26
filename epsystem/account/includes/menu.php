<?php

if (basename($_SERVER['REQUEST_URI']) == "ep" || basename($_SERVER['REQUEST_URI']) == "")
    require "menu/public.php";

elseif (basename($_SERVER['REQUEST_URI']) == "account")
    require "menu/hub.php";

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "projects.php") {
    if (!isset($_GET['p']))
        require "menu/projects.php";
    else
        require "menu/project.php";
}

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "assignments.php") {
    if (!isset($_GET['a']) && !isset($_GET['t']))
        require "menu/assignments.php";
    else
        require "menu/assignment.php";
}

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "resources.php")
    require "menu/resources.php";

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "r&d.php")
    require "menu/r&d.php";

elseif ($_SERVER['REQUEST_URI'] == RootPath . "epsystem/account/new-r&d/index.php")
    require "menu/r&d.php";

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "numbers.php")
    require "menu/numbers.php";

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "member.php")
    if (!isset($_GET['m']))
        require "menu/members.php";
    else
        require "menu/member.php";

// HUD

$hud = "";
if (isset($_GET['l1']) && isset($menu)) {
    foreach ($menu['level-1'] as $menuLvl1) {
        if (isset($menuLvl1['link']) && $menuLvl1['link'] == $_GET['l1']) {
            if (isset($menuLvl1['hud']))
                $hud = $menuLvl1['hud'];
            if (isset($_GET['l2']) && isset($menuLvl1['level-2'])) {
                foreach ($menuLvl1['level-2'] as $menuLvl2) {
                    if (isset($menuLvl2['link']) && $menuLvl2['link'] == $_GET['l2']) {
                        if (isset($menuLvl2['hud']))
                            $hud = $menuLvl2['hud'];
                        if (isset($_GET['l3']) && isset($menuLvl2['level-3'])) {
                            foreach ($menuLvl2['level-3'] as $menuLvl3) {
                                if (isset($menuLvl3['link']) && $menuLvl3['link'] == $_GET['l3']) {
                                    if (isset($menuLvl3['hud']))
                                        $hud = $menuLvl3['hud'];
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
elseif (isset($menu)) $hud = $menu['hud'];

if (isset($menu)) { ?>
    <div class="head-up-display-bar">
        <span><?php echo $hud; ?></span>
    </div> <?php
}

// LEVEL 1
if (isset($menu) && isset($menu['level-1'])) {

    $current = false;
    foreach ($menu['level-1'] as $menuLvl1ItemName => $menuLvl1Item)
        if (isset($menuLvl1Item['home']))
            $current = true; ?>
    <div class="navbar level-1<?php if (!isset($_GET['l1']) && $current == true) echo " current"; if (!isset($_GET['l1'])) echo " unselected"; ?>"> <?php

    foreach ($menu['level-1'] as $menuLvl1ItemName => $menuLvl1Item) {
        // Hide manager buttons from non-managers
        if (isset($menuLvl1Item['manager']) && $menuLvl1Item['manager'] == true && $_SESSION['account']->manager != 1) {
            unset($menu['level-1'][$menuLvl1ItemName]);
            continue;
        }

        // Page check
        if (isset($menuLvl1Item['page']))
            $href = $menuLvl1Item['page'];
        // Link check
        elseif (isset($menuLvl1Item['default-link'])) {
            if (isset($_GET['p'])) {
                if (!isset($_GET['options']) && !isset($_GET['ioptions']))
                    $href = "?p=" . $_GET['p'] . "&l1=" . $menuLvl1Item['default-link'];
                elseif (isset($_GET['options'])) {
                    $href = "?p=" . $_GET['p'] . "&options&l1=" . $menuLvl1Item['default-link'];
                }
                else
                    $href = "?p=" . $_GET['p'] . "&ioptions&l1=" . $menuLvl1Item['default-link'];
            }
            elseif (isset($_GET['a'])) {
                if (!isset($_GET['options']))
                    $href = "?a=" . $_GET['a'] . "&l1=" . $menuLvl1Item['default-link'];
                else
                    $href = "?a=" . $_GET['a'] . "&options&l1=" . $menuLvl1Item['default-link'];

            }
            elseif (isset($_GET['t'])) {
                if (!isset($_GET['options']))
                    $href = "?t=" . $_GET['t'] . "&l1=" . $menuLvl1Item['default-link'];
                else
                    $href = "?t=" . $_GET['t'] . "&options&l1=" . $menuLvl1Item['default-link'];
            }
            elseif (isset($_GET['l'])) {
                if (!isset($_GET['options']))
                    $href = "?l=" . $_GET['l'] . "&l1=" . $menuLvl1Item['default-link'];
                else
                    $href = "?l=" . $_GET['l'] . "&options&l1=" . $menuLvl1Item['default-link'];
            }
            elseif (isset($_GET['py'])) {
                if (!isset($_GET['options']))
                    $href = "?py=" . $_GET['py'] . "&l1=" . $menuLvl1Item['default-link'];
                else
                    $href = "?py=" . $_GET['py'] . "&options&l1=" . $menuLvl1Item['default-link'];
            }
            elseif (isset($_GET['m'])) {
                if (!isset($_GET['options']))
                    $href = "?m=" . $_GET['m'] . "&l1=" . $menuLvl1Item['default-link'];
                else
                    $href = "?m=" . $_GET['m'] . "&options&l1=" . $menuLvl1Item['default-link'];
            }
            elseif (isset($_GET['f'])) {
                if (!isset($_GET['options']))
                    $href = "?f=" . $_GET['f'] . "&l1=" . $menuLvl1Item['default-link'];
                else
                    $href = "?f=" . $_GET['f'] . "&options&l1=" . $menuLvl1Item['default-link'];
            }
            elseif (isset($_GET['i'])) {
                if (!isset($_GET['options']))
                    $href = "?i=" . $_GET['i'] . "&l1=" . $menuLvl1Item['default-link'];
                else
                    $href = "?i=" . $_GET['i'] . "&options&l1=" . $menuLvl1Item['default-link'];
            }
            elseif (isset($_GET['d'])) {
                if (!isset($_GET['options']))
                    $href = "?d=" . $_GET['d'] . "&l1=" . $menuLvl1Item['default-link'];
                else
                    $href = "?d=" . $_GET['d'] . "&options&l1=" . $menuLvl1Item['default-link'];
            }
            elseif (isset($_GET['dp'])) {
                if (!isset($_GET['options']))
                    $href = "?dp=" . $_GET['dp'] . "&l1=" . $menuLvl1Item['default-link'];
                else
                    $href = "?dp=" . $_GET['dp'] . "&options&l1=" . $menuLvl1Item['default-link'];
            }
            elseif (isset($_GET['ig'])) {
                if (!isset($_GET['options']))
                    $href = "?ig=" . $_GET['ig'] . "&l1=" . $menuLvl1Item['default-link'];
                else
                    $href = "?ig=" . $_GET['ig'] . "&options&l1=" . $menuLvl1Item['default-link'];
            }
            elseif (isset($_GET['lt'])) {
                if (!isset($_GET['options']))
                    $href = "?lt=" . $_GET['lt'] . "&l1=" . $menuLvl1Item['default-link'];
                else
                    $href = "?lt=" . $_GET['lt'] . "&options&l1=" . $menuLvl1Item['default-link'];
            }
            elseif (isset($_GET['all'])) {
                $href = "?all&l1=" . $menuLvl1Item['default-link'];
            }
            else
                $href = "?l1=" . $menuLvl1Item['default-link'];
        }
        if (isset($menuLvl1Item['new-tab']))
            $target = "_blank";
        else
            $target = "_self";

        // Check for disabled buttons
        if (count($menu['level-1']) == 1) {
            $singleButton = true;
            $button = current($menu['level-1']);
            if ($button['admin'] == true)
                $admin = true;
            else
                $admin = false;
        }
        else $singleButton = false;

        if ($singleButton) {
            if ($admin == false) { ?>
                <div class="container-button disabled">
                    <a class="button disabled"></a>
                </div> <?php
            }
            else { ?>
                <div class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </div> <?php
            }
        } ?>

        <div class="container-button">
            <a<?php if (array_key_exists('default-link', $menuLvl1Item)|| isset($menuLvl1Item['page'])) { ?> href="<?php echo $href; ?>" target="<?php echo $target; ?>"<?php } ?> class="button<?php if (isset($menuLvl1Item['page'])) echo " page"; if ($menuLvl1Item['admin']) echo " admin-menu"; if (isset($_GET['l1']) && isset($menuLvl1Item['link']) && $_GET['l1'] == $menuLvl1Item['link']) echo " active-menu"; ?>">
                <span><?php echo $menuLvl1ItemName; ?></span> <?php
                if (isset($menuLvl1Item['count']) && $menuLvl1Item['count']) { ?>
                    <div class="count"><?php echo $menuLvl1Item['count']; ?></div> <?php
                } ?>
            </a>
            <span class="hover-text"><?php echo $menuLvl1Item['hud']; ?></span><?php
            if (!isset($_GET['l1']) && isset($menuLvl1Item['home'])) { ?>
                <a<?php if (array_key_exists('default-link', $menuLvl1Item) || isset($menuLvl1Item['page'])) { ?> href="<?php echo $href; ?>" target="<?php echo $target; ?>"<?php } ?> class="home-menu<?php if ($menuLvl1Item['admin']) echo " admin"; if (!array_key_exists('default-link', $menuLvl1Item) && !isset($menuLvl1Item['page'])) echo " disabled"; ?>">
                    <span class="title"><?php echo $menuLvl1Item['home']['title']; ?></span>
                    <span class="description"><?php echo $menuLvl1Item['home']['description']; ?></span>
                    <div class="total-count">
                        <div class="count"><?php echo $menuLvl1Item['home']['total']['count']; ?></div>
                        <span><?php echo $menuLvl1Item['home']['total']['name']; ?></span>
                    </div>
                    <div class="last-hours">
                        <span class="title"><?php echo $menuLvl1Item['home']['last-hours']['title']; ?></span> <?php
                        foreach ($menuLvl1Item['home']['last-hours']['details'] as $details) { ?>
                            <div class="details-count">
                                <span><?php echo $menuLvl1Item['details']['name']; ?></span>
                                <div class="count"><?php echo $menuLvl1Item['details']['note']; ?></div>
                            </div> <?php
                        } ?>
                    </div>
                    <div class="bottom">
                        <span class="note"><?php echo $menuLvl1Item['home']['title']; ?></span>
                    </div>
                </a> <?php
            } ?>
        </div> <?php
    }

    if (isset($singleButton) && $singleButton) {
        if ($admin == false) { ?>
            <div class="container-button disabled">
                <a class="button disabled"></a>
            </div> <?php
        }
        else { ?>
            <div class="container-button disabled">
                <a class="button admin-menu disabled"></a>
            </div> <?php
        }
    } ?>
    </div> <?php
    // LEVEL 2
    if (isset($_GET['l1'])) {
        foreach ($menu['level-1'] as $menuLvl1Item) {
            if ($_GET['l1'] == $menuLvl1Item['link'] && isset($menuLvl1Item['level-2'])) {

                $current = false;
                foreach ($menuLvl1Item['level-2'] as $menuLvl2ItemName => $menuLvl2Item)
                    if (isset($menuLvl2Item['home']))
                        $current = true; ?>
                <div class="navbar level-2<?php if (!isset($_GET['l2']) && $current == true) echo " current"; if (!isset($_GET['l2'])) echo " unselected"; ?>"> <?php

                foreach ($menuLvl1Item['level-2'] as $menuLvl2ItemName => $menuLvl2Item) {
                    // Hide manager buttons from non-managers
                    if (isset($menuLvl2Item['manager']) && $menuLvl2Item['manager'] == true && $_SESSION['account']->manager != 1) {
                        unset($menu['level-2'][$menuLvl2ItemName]);
                        continue;
                    }

                    if (isset($menuLvl2Item['page'])) {
                        $href = $menuLvl2Item['page'];
                    }
                    elseif (array_key_exists('default-link', $menuLvl2Item)) {
                        if (isset($_GET['p'])) {
                            if (!isset($_GET['options']) && !isset($_GET['ioptions']))
                                $href = "?p=" . $_GET['p'] . "&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                            elseif (isset($_GET['ioptions']) && isset($_GET['l1']) && $_GET['l1'] == "edit" && isset($_GET['i']))
                                $href = "?p=" . $_GET['p'] . "&ioptions&l1=" . $_GET['l1'] . "&i=" . $_GET['i'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?p=" . $_GET['p'] . "&options&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        elseif (isset($_GET['a'])) {
                            if (!isset($_GET['options']))
                                $href = "?a=" . $_GET['a'] . "&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?a=" . $_GET['a'] . "&options&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        elseif (isset($_GET['t'])) {
                            if (!isset($_GET['options']))
                                $href = "?t=" . $_GET['t'] . "&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?t=" . $_GET['t'] . "&options&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        elseif (isset($_GET['l'])) {
                            if (!isset($_GET['options']))
                                $href = "?l=" . $_GET['l'] . "&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?l=" . $_GET['l'] . "&options&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        elseif (isset($_GET['py'])) {
                            if (!isset($_GET['options']))
                                $href = "?py=" . $_GET['py'] . "&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?py=" . $_GET['py'] . "&options&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        elseif (isset($_GET['m'])) {
                            if (!isset($_GET['options']))
                                $href = "?m=" . $_GET['m'] . "&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?m=" . $_GET['m'] . "&options&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        elseif (isset($_GET['f'])) {
                            if (!isset($_GET['options']))
                                $href = "?f=" . $_GET['f'] . "&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?f=" . $_GET['f'] . "&options&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        elseif (isset($_GET['i'])) {
                            if (!isset($_GET['options']))
                                $href = "?i=" . $_GET['i'] . "&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?i=" . $_GET['i'] . "&options&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        elseif (isset($_GET['d'])) {
                            if (!isset($_GET['options']))
                                $href = "?d=" . $_GET['d'] . "&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?d=" . $_GET['d'] . "&options&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        elseif (isset($_GET['dp'])) {
                            if (!isset($_GET['options']))
                                $href = "?dp=" . $_GET['dp'] . "&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?dp=" . $_GET['dp'] . "&options&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        elseif (isset($_GET['ig'])) {
                            if (!isset($_GET['options']))
                                $href = "?ig=" . $_GET['ig'] . "&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?ig=" . $_GET['ig'] . "&options&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        elseif (isset($_GET['lt'])) {
                            if (!isset($_GET['options']))
                                $href = "?lt=" . $_GET['lt'] . "&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                            else
                                $href = "?lt=" . $_GET['lt'] . "&options&l1=" . $menuLvl1Item['default-link'] . "&l2=" . $menuLvl2Item['default-link'];
                        }
                        else
                            $href = "?l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                    }
                    if (isset($menuLvl2Item['new-tab']))
                        $target = "_blank";
                    else
                        $target = "_self"; ?>

                    <div class="container-button<?php if (isset($_GET['l2']) && array_key_exists('link', $menuLvl2Item) && $_GET['l2'] == $menuLvl2Item['link']) echo " active"; ?>">
                        <a<?php if (array_key_exists('default-link', $menuLvl2Item) || isset($menuLvl2Item['page'])) { ?> href="<?php echo $href; ?>" target="<?php echo $target; ?>"<?php } ?> class="button<?php if (isset($menuLvl2Item['page'])) echo " page"; if ($menuLvl2Item['admin']) echo " admin-menu"; if (isset($_GET['l2']) && array_key_exists('link', $menuLvl2Item) && $_GET['l2'] == $menuLvl2Item['link']) echo " active-menu"; ?>">
                            <span><?php echo $menuLvl2ItemName; ?></span> <?php
                            if (isset($menuLvl2Item['count']) && $menuLvl2Item['count']) { ?>
                                <div class="count"><?php echo $menuLvl2Item['count']; ?></div> <?php
                            } ?>
                        </a>
                        <span class="hover-text"><?php echo $menuLvl2Item['hud']; ?></span><?php
                        if (!isset($_GET['l2']) && isset($menuLvl2Item['home'])) { ?>
                            <a<?php if (array_key_exists('default-link', $menuLvl2Item) || isset($menuLvl2Item['page'])) { ?> href="<?php echo $href; ?>" target="<?php echo $target; ?>"<?php } ?> class="home-menu<?php if ($menuLvl2Item['admin']) echo " admin"; if (!array_key_exists('default-link', $menuLvl2Item) && !isset($menuLvl2Item['page'])) echo " disabled"; ?>">
                                <span class="title"><?php echo $menuLvl2Item['home']['title']; ?></span>
                                <span class="description"><?php echo $menuLvl2Item['home']['description']; ?></span>
                                <div class="total-count">
                                    <div class="count"><?php echo $menuLvl2Item['home']['total']['count']; ?></div>
                                    <span><?php echo $menuLvl2Item['home']['total']['name']; ?></span>
                                </div>
                                <div class="last-hours">
                                    <span class="title"><?php echo $menuLvl2Item['home']['last-hours']['title']; ?></span> <?php
                                    foreach ($menuLvl2Item['home']['last-hours']['details'] as $details) { ?>
                                        <div class="details-count">
                                            <span><?php echo $details['name']; ?></span>
                                            <div class="count"><?php echo $details['count']; ?></div>
                                        </div> <?php
                                    } ?>
                                </div>
                                <div class="bottom">
                                    <span class="note"><?php echo $menuLvl2Item['home']['note']; ?></span>
                                </div>
                            </a> <?php
                        } ?>
                    </div> <?php

                    if (isset($_GET['l2']) && isset($menuLvl2Item['level-3']))
                        if ($_GET['l2'] == $menuLvl2Item['link']) {
                            $menuLvl3 = $menuLvl2Item['level-3'];
                            if ($menuLvl2Item['admin']) $isAdminMenu = true;
                            else $isAdminMenu = false;
                        }
                } ?>

                </div> <?php
                // LEVEL 3
                if (isset($_GET['l2']) && isset($menuLvl3)) {
                    $current = false;
                    foreach ($menuLvl3 as $menuLvl3ItemName => $menuLvl3Item)
                        if (isset($menuLvl3Item['home']))
                            $current = true; ?>
                    <div class="navbar level-3<?php if (!isset($_GET['l3']) && $current) echo " current"; if (!isset($_GET['l3'])) echo " unselected"; if ($isAdminMenu) echo " admin"; ?>"> <?php

                    foreach ($menuLvl3 as $menuLvl3ItemName => $menuLvl3Item) {
                        // Hide manager buttons from non-managers
                        if (isset($menuLvl3Item['manager']) && $menuLvl3Item['manager'] == true && $_SESSION['account']->manager != 1) {
                            unset($menu['level-3'][$menuLvl3ItemName]);
                            continue;
                        }

                        if (isset($menuLvl3Item['page']))
                            $href = $menuLvl3Item['page'];
                        elseif (array_key_exists('default-link', $menuLvl3Item)) {
                            if (isset($_GET['p'])) {
                                if (!isset($_GET['options']))
                                    $href = "?p=" . $_GET['p'] . "&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                                else
                                    $href = "?p=" . $_GET['p'] . "&options&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                            }
                            elseif (isset($_GET['a'])) {
                                if (!isset($_GET['options']))
                                    $href = "?a=" . $_GET['a'] . "&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                                else
                                    $href = "?a=" . $_GET['a'] . "&options&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                            }
                            elseif (isset($_GET['m'])) {
                                if (!isset($_GET['options']))
                                    $href = "?m=" . $_GET['m'] . "&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                                else
                                    $href = "?m=" . $_GET['m'] . "&options&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                            }
                            elseif (isset($_GET['f']))
                                $href = "?f=" . $_GET['f'] . "&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                            elseif (isset($_GET['t']))
                                $href = "?t=" . $_GET['t'] . "&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                            else
                                $href = "?l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                        }

                        if (isset($menuLvl3Item['new-tab']))
                            $target = "_blank";
                        else
                            $target = "_self"; ?>

                        <div class="container-button">
                            <a<?php if (array_key_exists('default-link', $menuLvl3Item) || isset($menuLvl3Item['page'])) { ?> href="<?php echo $href; ?>" target="<?php echo $target; ?>"<?php } ?> class="button<?php if (isset($menuLvl3Item['page'])) echo " page"; if ($menuLvl3Item['admin']) echo " admin-menu"; if (isset($_GET['l3']) && isset($menuLvl3Item['link']) && $_GET['l3'] == $menuLvl3Item['link']) echo " active-menu"; ?>">
                                <span><?php echo $menuLvl3ItemName; ?></span> <?php
                                if (isset($menuLvl3Item['count']) && $menuLvl3Item['count']) { ?>
                                    <div class="count"><?php echo $menuLvl3Item['count']; ?></div> <?php
                                } ?>
                            </a>
                            <span class="hover-text"><?php echo $menuLvl3Item['hud']; ?></span><?php
                            if (!isset($_GET['l3']) && isset($menuLvl3Item['home'])) { ?>
                                <a<?php if (array_key_exists('default-link', $menuLvl3Item) || isset($menuLvl3Item['page'])) { ?> href="<?php echo $href; ?>" target="<?php echo $target; ?>"<?php } ?> class="home-menu<?php if ($menuLvl3Item['admin']) echo " admin"; if (!array_key_exists('default-link', $menuLvl3Item) && !isset($menuLvl3Item['page'])) echo " disabled"; ?>">
                                    <span class="title"><?php echo $menuLvl3Item['home']['title']; ?></span>
                                    <span class="description"><?php echo $menuLvl3Item['home']['description']; ?></span>
                                    <div class="total-count">
                                        <div class="count"><?php echo $menuLvl3Item['home']['total']['count']; ?></div>
                                        <span><?php echo $menuLvl3Item['home']['total']['name']; ?></span>
                                    </div>
                                    <div class="last-hours">
                                        <span class="title"><?php echo $menuLvl3Item['home']['last-hours']['title']; ?></span> <?php
                                        foreach ($menuLvl3Item['home']['last-hours']['details'] as $details) { ?>
                                            <div class="details-count">
                                                <span><?php echo $details['name']; ?></span>
                                                <div class="count"><?php echo $details['count']; ?></div>
                                            </div> <?php
                                        } ?>
                                    </div>
                                    <div class="bottom">
                                        <span class="note"><?php echo $menuLvl3Item['home']['note']; ?></span>
                                    </div>
                                </a> <?php
                            } ?>
                        </div> <?php

                    } ?>

                    </div> <?php
                }
            }
        }
    }
}