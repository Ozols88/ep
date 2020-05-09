<?php

if (basename($_SERVER['SCRIPT_FILENAME']) == "index.php")
    require "menu/hub.php";

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "projects.php") {
    if (!isset($_GET['p']))
        require "menu/projects.php";
    else
        require "menu/project.php";
}

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "assignments.php") {
    if (!isset($_GET['a']))
        require "menu/assignments.php";
    else
        require "menu/assignment.php";
}

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "resources.php")
    require "menu/resources.php";

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "r&d.php")
    require "menu/r&d.php";

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "numbers.php")
    require "menu/numbers.php";

elseif (basename($_SERVER['SCRIPT_FILENAME']) == "member.php")
    require "menu/member.php";

// HUD

$hud = "";
if (isset($_GET['l1']) && isset($menu)) {
    foreach ($menu['level-1'] as $menuLvl1) {
        if ($menuLvl1['link'] == $_GET['l1']) {
            if (isset($menuLvl1['hud']))
                $hud = $menuLvl1['hud'];
            if (isset($_GET['l2']) && isset($menuLvl1['level-2'])) {
                foreach ($menuLvl1['level-2'] as $menuLvl2) {
                    if ($menuLvl2['link'] == $_GET['l2']) {
                        if (isset($menuLvl2['hud']))
                            $hud = $menuLvl2['hud'];
                        if (isset($_GET['l3']) && isset($menuLvl2['level-3'])) {
                            foreach ($menuLvl2['level-3'] as $menuLvl3) {
                                if ($menuLvl3['link'] == $_GET['l3']) {
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
elseif (isset($menu)) $hud = $menu['hud']; ?>

<div class="head-up-display-bar">
    <span><?php echo $hud; ?></span>
</div> <?php

// LEVEL 1
if (isset($menu) && isset($menu['level-1'])) {
    // Check for disabled buttons
    if (count($menu['level-1']) == 1) $singleButton = true;
    else $singleButton = false; ?>

    <div class="navbar level-1<?php if (!isset($_GET['l1'])) echo " current"; if (!isset($_GET['l1'])) echo " unselected"; ?>"> <?php

    if ($singleButton) { ?>
        <div class="container-button disabled">
            <a class="button disabled"></a>
        </div> <?php
    }

    foreach ($menu['level-1'] as $menuLvl1ItemName => $menuLvl1Item) {
        // Lock check
        if (isset($menuLvl1Item['locked']) || isset($_GET['preview']) && $menuLvl1ItemName != "INFO" && $menuLvl1ItemName != "PRODUCTION")
            $locked = true;
        else
            $locked = false;
        // Page check
        if (isset($menuLvl1Item['page']))
            $href = $menuLvl1Item['page'];
        // Link check
        else {
            if (isset($_GET['p']))
                $href = "?p=" . $_GET['p'] . "&l1=" . $menuLvl1Item['default-link'];
            elseif (isset($_GET['a']))
                $href = "?a=" . $_GET['a'] . "&l1=" . $menuLvl1Item['default-link'];
            else
                $href = "?l1=" . $menuLvl1Item['default-link'];
            if (isset($_GET['preview']))
                $href .= "&preview";
        } ?>

        <div class="container-button">
            <a<?php if (!$locked && !isset($_GET['preview2'])) { ?> href="<?php echo $href; ?>"<?php } ?> class="button<?php if (isset($menuLvl1Item['page'])) echo " page"; if ($menuLvl1Item['admin']) echo " admin-menu"; if (isset($_GET['l1']) && $_GET['l1'] == $menuLvl1Item['link']) echo " active-menu"; elseif (isset($_GET['preview2'])) echo " locked"; elseif ($locked) echo " locked"; ?>">
                <span><?php echo $menuLvl1ItemName; ?></span> <?php
                if ($locked || (isset($_GET['l1']) && $_GET['l1'] != $menuLvl1Item['link']) && isset($_GET['preview2'])) { ?>
                    <div class="lock"></div> <?php
                }
                elseif (isset($menuLvl1Item['count']) && $menuLvl1Item['count']) { ?>
                    <div class="count"><?php echo $menuLvl1Item['count']; ?></div> <?php
                } ?>
            </a> <?php
            if (!isset($_GET['l1']) && isset($menuLvl1Item['home'])) { ?>
                <div class="home-menu<?php if ($menuLvl1Item['admin']) echo " admin"; ?>">
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
                                <span><?php echo $details['name']; ?></span>
                                <div class="count"><?php echo $details['count']; ?></div>
                            </div> <?php
                        } ?>
                    </div>
                    <div class="bottom">
                        <a href="<?php echo $href; ?>" class="enter-button"><?php echo $menuLvl1Item['home']['link']; ?></a>
                        <span class="note"><?php echo $menuLvl1Item['home']['note']; ?></span>
                    </div>
                </div> <?php
            } ?>
        </div> <?php
    }

    if ($singleButton) { ?>
        <div class="container-button disabled">
            <a class="button disabled"></a>
        </div> <?php
    } ?>
    </div> <?php
    // LEVEL 2
    if (isset($_GET['l1'])) {
        foreach ($menu['level-1'] as $menuLvl1Item) {
            if ($_GET['l1'] == $menuLvl1Item['link'] && isset($menuLvl1Item['level-2'])) {

                if (count($menuLvl1Item['level-2']) == 1) $singleButton = true;
                else $singleButton = false; ?>

                <div class="navbar level-2<?php if (!isset($_GET['l2'])) echo " current"; if (!isset($_GET['l2'])) echo " unselected"; if ($menuLvl1Item['admin']) echo " admin"; ?>"> <?php

                if ($singleButton) { ?>
                    <div class="container-button disabled">
                        <a class="button disabled"></a>
                    </div> <?php
                }

                foreach ($menuLvl1Item['level-2'] as $menuLvl2ItemName => $menuLvl2Item) {
                    if (isset($menuLvl2Item['locked']) || isset($_GET['preview']) && $menuLvl2ItemName != "OPERATIONS")
                        $locked = true;
                    else
                        $locked = false;
                    if (isset($menuLvl2Item['page']))
                        $href = $menuLvl2Item['page'];
                    else {
                        if (isset($_GET['p']))
                            $href = "?p=" . $_GET['p'] . "&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                        elseif (isset($_GET['a']))
                            $href = "?a=" . $_GET['a'] . "&l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                        else
                            $href = "?l1=" . $_GET['l1'] . "&l2=" . $menuLvl2Item['default-link'];
                        if (isset($_GET['preview']))
                            $href .= "&preview";
                    } ?>

                    <div class="container-button">
                        <a<?php if (!$locked && !isset($_GET['preview2'])) { ?> href="<?php echo $href; ?>"<?php } ?> class="button<?php if ($menuLvl2Item['admin']) echo " admin-menu"; if (isset($_GET['l2']) && $_GET['l2'] == $menuLvl2Item['link']) echo " active-menu"; elseif (isset($_GET['preview2'])) echo " locked"; elseif ($locked) echo " locked"; ?>">
                            <span><?php echo $menuLvl2ItemName; ?></span> <?php
                            if ($locked || (isset($_GET['l2']) && $_GET['l2'] != $menuLvl2Item['link']) && isset($_GET['preview2'])) { ?>
                                <div class="lock"></div> <?php
                            }
                            elseif (isset($menuLvl2Item['count']) && $menuLvl2Item['count']) { ?>
                                <div class="count"><?php echo $menuLvl2Item['count']; ?></div> <?php
                            } ?>
                        </a> <?php
                        if (!isset($_GET['l2']) && isset($menuLvl2Item['home'])) { ?>
                            <div class="home-menu<?php if ($menuLvl2Item['admin']) echo " admin"; ?>">
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
                                    <a href="<?php echo $href; ?>" class="enter-button"><?php echo $menuLvl2Item['home']['link']; ?></a>
                                    <span class="note"><?php echo $menuLvl2Item['home']['note']; ?></span>
                                </div>
                            </div> <?php
                        } ?>
                    </div> <?php

                    if (isset($_GET['l2']) && isset($menuLvl2Item['level-3']))
                        if ($_GET['l2'] == $menuLvl2Item['link']) {
                            $menuLvl3 = $menuLvl2Item['level-3'];
                            if ($menuLvl2Item['admin']) $isAdminMenu = true;
                            else $isAdminMenu = false;
                        }
                }

                if ($singleButton) { ?>
                    <div class="container-button disabled">
                        <a class="button disabled"></a>
                    </div> <?php
                } ?>
                </div> <?php
                // LEVEL 3
                if (isset($_GET['l2']) && isset($menuLvl3)) {

                    if (count($menuLvl3) == 1) $singleButton = true;
                    else $singleButton = false; ?>

                    <div class="navbar level-3<?php if (!isset($_GET['l3'])) echo " current"; if (!isset($_GET['l3'])) echo " unselected"; if ($isAdminMenu) echo " admin"; ?>"> <?php

                    if ($singleButton) { ?>
                        <div class="container-button disabled">
                            <a class="button disabled"></a>
                        </div> <?php
                    }

                    foreach ($menuLvl3 as $menuLvl3ItemName => $menuLvl3Item) {
                        if (isset($menuLvl3Item['locked']) || isset($_GET['preview']) && $menuLvl3ItemName != "Colors")
                            $locked = true;
                        else
                            $locked = false;
                        if (isset($menuLvl3Item['page']))
                            $href = $menuLvl3Item['page'];
                        else {
                            if (isset($_GET['p']))
                                $href = "?p=" . $_GET['p'] . "&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                            elseif (isset($_GET['a']))
                                $href = "?a=" . $_GET['a'] . "&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                            else
                                $href = "?l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $menuLvl3Item['default-link'];
                            if (isset($_GET['preview']))
                                $href .= "&preview";
                        } ?>

                        <div class="container-button">
                            <a<?php if (!$locked && !isset($_GET['preview2'])) { ?> href="<?php echo $href; ?>"<?php } ?> class="button<?php if ($menuLvl3Item['admin']) echo " admin-menu"; if (isset($_GET['l3']) && $_GET['l3'] == $menuLvl3Item['link']) echo " active-menu"; elseif (isset($_GET['preview2'])) echo " locked"; elseif ($locked) echo " locked"; ?>">
                                <span><?php echo $menuLvl3ItemName; ?></span> <?php
                                if ($locked || (isset($_GET['l3']) && $_GET['l3'] != $menuLvl3Item['link']) && isset($_GET['preview2'])) { ?>
                                    <div class="lock"></div> <?php
                                }
                                elseif (isset($menuLvl3Item['count']) && $menuLvl3Item['count']) { ?>
                                    <div class="count"><?php echo $menuLvl3Item['count']; ?></div> <?php
                                } ?>
                            </a> <?php
                            if (!isset($_GET['l3']) && isset($menuLvl3Item['home'])) { ?>
                                <div class="home-menu<?php if ($menuLvl3Item['admin']) echo " admin"; ?>">
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
                                        <a href="<?php echo $href; ?>" class="enter-button"><?php echo $menuLvl3Item['home']['link']; ?></a>
                                        <span class="note"><?php echo $menuLvl3Item['home']['note']; ?></span>
                                    </div>
                                </div> <?php
                            } ?>
                        </div> <?php

                        if (isset($_GET['l3']) && isset($menuLvl3Item['level-4']))
                            if ($_GET['l3'] == $menuLvl3Item['link']) {
                                $menuLvl4 = $menuLvl3Item['level-4'];
                                if ($menuLvl3Item['admin']) $isAdminMenu = true;
                                else $isAdminMenu = false;
                            }
                    }

                    if ($singleButton) { ?>
                        <div class="container-button disabled">
                            <a class="button disabled"></a>
                        </div> <?php
                    } ?>

                    </div> <?php
                }
                if (isset($_GET['l3']) && isset($menuLvl4)) {

                    if (count($menuLvl4) == 1) $singleButton = true;
                    else $singleButton = false; ?>

                    <div class="navbar level-4<?php if ($isAdminMenu) echo " admin"; ?>"> <?php

                        if ($singleButton) { ?>
                            <div class="container-button disabled">
                                <a class="button disabled"></a>
                            </div> <?php
                        }

                        foreach ($menuLvl4 as $menuLvl4ItemName => $menuLvl4Item) {
                            if (isset($menuLvl4Item['locked']) || isset($_GET['preview']) && $menuLvl4ItemName != "ASSIGNMENT")
                                $locked = true;
                            else
                                $locked = false;
                            if (isset($menuLvl4Item['page']))
                                $href = $menuLvl4Item['page'];
                            else {
                                if (isset($_GET['p']))
                                    $href = "?p=" . $_GET['p'] . "&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $_GET['l3'] . "&l4=" . $menuLvl4Item['default-link'];
                                elseif (isset($_GET['a']))
                                    $href = "?a=" . $_GET['a'] . "&l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $_GET['l3'] . "&l4=" . $menuLvl4Item['default-link'];
                                else
                                    $href = "?l1=" . $_GET['l1'] . "&l2=" . $_GET['l2'] . "&l3=" . $_GET['l3'] . "&l4=" . $menuLvl4Item['default-link'];
                                if (isset($_GET['preview']))
                                    $href .= "&preview";
                            } ?>

                            <div class="container-button">
                                <a<?php if (!$locked && !isset($_GET['preview2'])) { ?> href="<?php echo $href; ?>"<?php } ?> class="button<?php if ($menuLvl4Item['admin']) echo " admin-menu"; if (isset($_GET['l4']) && $_GET['l4'] == $menuLvl4Item['link']) echo " active-menu"; elseif (isset($_GET['preview2'])) echo " locked"; elseif ($locked) echo " locked"; ?>">
                                    <span><?php echo $menuLvl4ItemName; ?></span> <?php
                                    if ($locked || (isset($_GET['l4']) && $_GET['l4'] != $menuLvl4Item['link']) && isset($_GET['preview2'])) { ?>
                                        <div class="lock"></div> <?php
                                    }
                                    elseif (isset($menuLvl4Item['count']) && $menuLvl4Item['count']) { ?>
                                        <div class="count"><?php echo $menuLvl4Item['count']; ?></div> <?php
                                    } ?>
                                </a>
                            </div> <?php
                        }

                        if ($singleButton) { ?>
                            <div class="container-button disabled">
                                <a class="button disabled"></a>
                            </div> <?php
                        } ?>

                    </div> <?php
                }
            }
        }
    }
}