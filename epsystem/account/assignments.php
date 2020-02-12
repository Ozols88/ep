<?php
$page = "assignments";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php";
    $assignment = new Assignment();
    $count = [
        "PRODUCTION" => 1,

        "ACTIVE" => 1
    ];
    if ($account->type == 1) { ?>
        <div class="menu">
            <div class="head-up-display-bar">
                <span><?php echo $assignment::getHeadUp(); ?></span>
            </div> <?php
            if (isset($assignment::$menu) && isset($assignment::$menu['level-1'])) { ?>
                <div class="navbar level-1<?php if (!isset($_GET['t'])) echo " unselected" ?>"> <?php
                    foreach ($assignment::$menu['level-1'] as $menuLvl1ItemName => $menuLvl1Item) { ?>
                        <div class="container-button">
                            <a href="<?php echo "?t=" . $menuLvl1Item['default-link']; ?>" class="button<?php if ($menuLvl1Item['admin']) echo " admin-menu"; if (isset($_GET['t']) && $_GET['t'] == $menuLvl1Item['link']) echo " active-menu"; ?>">
                                <span><?php echo $menuLvl1ItemName; ?></span> <?php
                                if (isset($menuLvl1Item['locked']) && $menuLvl1Item['locked'] == true) { ?>
                                    <div class="lock"></div> <?php
                                }
                                elseif (isset($count[$menuLvl1ItemName])) { ?>
                                    <div class="count"><?php echo $count[$menuLvl1ItemName]; ?></div> <?php
                                } ?>
                            </a> <?php
                            if (!isset($_GET['t']) && isset($menuLvl1Item['home'])) { ?>
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
                                        <a href="<?php echo "?t=" . $menuLvl1Item['link']; ?>" class="enter-button"><?php echo $menuLvl1Item['home']['link']; ?></a>
                                        <span class="note"><?php echo $menuLvl1Item['home']['note']; ?></span>
                                    </div>
                                </div> <?php
                            } ?>
                        </div> <?php
                    } ?>
                </div> <?php
                if (isset($_GET['t'])) {
                    foreach ($assignment::$menu['level-1'] as $menuLvl1Item) {
                        if ($_GET['t'] == $menuLvl1Item['link'] && isset($menuLvl1Item['level-2'])) { ?>
                            <div class="navbar level-2<?php if ($menuLvl1Item['admin']) echo " admin"; ?>"> <?php
                                foreach ($menuLvl1Item['level-2'] as $menuLvl2ItemName => $menuLvl2Item) {?>
                                    <div class="container-button">
                                        <a href="<?php echo "?t=" . $_GET['t'] . "&m=" . $menuLvl2Item['default-link']; ?>" class="button<?php if ($menuLvl2Item['admin']) echo " admin-menu"; if (isset($_GET['m']) && $_GET['m'] == $menuLvl2Item['link']) echo " active-menu"; ?>">
                                            <span><?php echo $menuLvl2ItemName; ?></span> <?php
                                            if (isset($menuLvl2Item['locked']) && $menuLvl2Item['locked'] == true) { ?>
                                                <div class="lock"></div> <?php
                                            }
                                            elseif (isset($count[$menuLvl2ItemName])) { ?>
                                                <div class="count"><?php echo $count[$menuLvl2ItemName]; ?></div> <?php
                                            } ?>
                                        </a>
                                    </div> <?php
                                    if (isset($_GET['m']) && isset($menuLvl2Item['level-3']))
                                        if ($_GET['m'] == $menuLvl2Item['link']) {
                                            $menuLvl3 = $menuLvl2Item['level-3'];
                                            if ($menuLvl2Item['admin']) $isAdminMenu = true;
                                            else $isAdminMenu = false;
                                        }
                                } ?>
                            </div> <?php
                            if (isset($_GET['m']) && isset($menuLvl3)) { ?>
                                <div class="navbar level-3<?php if ($isAdminMenu) echo " admin"; ?>"> <?php
                                    foreach ($menuLvl3 as $menuLvl3ItemName => $menuLvl3Item) { ?>
                                        <div class="container-button">
                                            <a href="<?php echo "?t=" . $_GET['t'] . "&m=" . $_GET['m'] . "&b=" . $menuLvl3Item['default-link']; ?>" class="button<?php if ($menuLvl3Item['admin']) echo " admin-menu"; if (isset($_GET['b']) && $_GET['b'] == $menuLvl3Item['link']) echo " active-menu"; ?>">
                                                <span><?php echo $menuLvl3ItemName; ?></span> <?php
                                                if (isset($menuLvl3Item['locked']) && $menuLvl3Item['locked'] == true) { ?>
                                                    <div class="lock"></div> <?php
                                                }
                                                elseif (isset($count[$menuLvl3ItemName])) { ?>
                                                    <div class="count"><?php echo $count[$menuLvl3ItemName]; ?></div> <?php
                                                } ?>
                                            </a>
                                        </div> <?php
                                    } ?>
                                </div> <?php
                            }
                        }
                    }
                }
            }



            if (isset($_GET['t']) && $_GET['t'] == "my") {
                if (isset($_GET['m']) && $_GET['m'] == "active") { ?>
                    <form class="info-bar with-space">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+1</div>
                            <div class="spacer"></div>
                            <span>ACCEPTED</span>
                            <div class="count">0</div>
                        </div>
                        <div class="section">
                            <span>AVAILABLE ASSIGNMENTS</span>
                            <div class="count total">1</div>
                        </div>
                    </form>
                    <div class="table-header-container">
                        <div class="header-extension"></div>
                        <div class="header">
                            <div class="head id">№</div>
                            <div class="head project">Assignment</div>
                            <div class="head completed-in">Department Step</div>
                            <div class="head type">Project Type</div>
                            <div class="head type">Level</div>
                            <div class="head completed-in">Tasks</div>
                            <div class="head completed-in">Duration</div>
                            <div class="head completed-in">Earn</div>
                            <div class="head open">Open</div>
                        </div>
                        <div class="header-extension"></div>
                    </div>
                    </div>
                    <div class="table">
                        <div class="row">
                            <?php $link = "http://ozols88.id.lv/ep/epsystem/account/projects.php?p=7&t=production&m=operations&b=colors&x=assignment" ?>
                            <div class="cell id"><a href="<?php echo $link; ?>"><?php echo "#" . sprintf('%05d', "1"); ?></a></div>
                            <div class="cell project"><a href="<?php echo $link; ?>"><?php echo "Generate new colors"; ?></a></div>
                            <div class="cell completed-in"><a href="<?php echo $link; ?>"><?php echo "Color setup"; ?></a></div>
                            <div class="cell type"><a href="<?php echo $link; ?>"><?php echo "Animated video"; ?></a></div>
                            <div class="cell type"><a href="<?php echo $link; ?>"><?php echo "Level 1"; ?></a></div>
                            <div class="cell completed-in"><a href="<?php echo $link; ?>"><?php echo "5"; ?></a></div>
                            <div class="cell completed-in"><a href="<?php echo $link; ?>"><?php echo "15 min"; ?></a></div>
                            <div class="cell completed-in"><a href="<?php echo $link; ?>"><?php echo "€2.50"; ?></a></div>
                            <div class="cell open"><a href="<?php echo $link; ?>" class="open-button">Open</a></div>
                        </div>
                    </div> <?php
                }
            }
            elseif (isset($_GET['t']) && $_GET['t'] == "available") {
                if (isset($_GET['m']) && $_GET['m'] == "production") { ?>
                    <form class="info-bar with-space">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+1</div>
                            <div class="spacer"></div>
                            <span>ACCEPTED</span>
                            <div class="count">0</div>
                        </div>
                        <div class="section">
                            <div class="count total">1</div>
                            <span>AVAILABLE ASSIGNMENTS</span>
                        </div>
                    </form>
                    <div class="table-header-container">
                        <div class="header-extension"></div>
                        <div class="header">
                            <div class="head id">№</div>
                            <div class="head project">Assignment Name</div>
                            <div class="head type">Project Type</div>
                            <div class="head completed-in">Department</div>
                            <div class="head type">Level</div>
                            <div class="head completed-in">Tasks</div>
                            <div class="head completed-in">Estimated</div>
                            <div class="head earn">Earn</div>
                            <div class="head open">Open</div>
                        </div>
                        <div class="header-extension"></div>
                    </div>
                    </div>
                    <div class="table">
                        <div class="row">
                            <?php $link = "http://ozols88.id.lv/ep/epsystem/account/projects.php?p=1&t=production&m=operations&b=colors&x=assignment&preview" ?>
                            <div class="cell id"><a href="<?php echo $link; ?>"><?php echo "#" . sprintf('%05d', "12"); ?></a></div>
                            <div class="cell project"><a href="<?php echo $link; ?>"><?php echo "Colors"; ?></a></div>
                            <div class="cell type"><a href="<?php echo $link; ?>"><?php echo "Animated Video"; ?></a></div>
                            <div class="cell completed-in"><a href="<?php echo $link; ?>"><?php echo "Operations"; ?></a></div>
                            <div class="cell type"><a href="<?php echo $link; ?>"><?php echo "Level 1"; ?></a></div>
                            <div class="cell completed-in"><a href="<?php echo $link; ?>"><?php echo "5"; ?></a></div>
                            <div class="cell completed-in"><a href="<?php echo $link; ?>"><?php echo "15 min"; ?></a></div>
                            <div class="cell earn"><a href="<?php echo $link; ?>"><?php echo "€2.50"; ?></a></div>
                            <div class="cell open"><a href="<?php echo $link; ?>" class="open-button">Open</a></div>
                        </div>
                    </div> <?php
                }
            } ?>
        </div> <?php
    }
    require_once "includes/footer.php";
}
else require_once "login.php";