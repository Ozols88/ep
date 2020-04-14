<?php
$page = "assignments";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];

    require_once "includes/header.php";

    if ($account->type == 1) { ?>
        <div class="menu"> <?php
        require "includes/menu.php";
        if (isset($_GET['l1']) && $_GET['l1'] == "available") {
            if (isset($_GET['l2']) && $_GET['l2'] == "production") {
                $assignments = Assignment::selectAssignmentListByStatus(5, true); ?>
                <form class="info-bar with-space">
                    <div class="section">
                        <div class="stage">LAST</div>
                        <button type="button" class="hours-button">12h</button>
                        <button type="button" class="hours-button active">24h</button>
                        <button type="button" class="hours-button">48h</button>
                    </div>
                    <div class="section">
                        <div class="stage">NEW ADDED</div>
                        <div class="content active">+1</div>
                        <div class="space"></div>
                        <div class="stage">ACCEPTED</div>
                        <div class="content active">0</div>
                    </div>
                    <div class="section">
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 22.5%">Assignment Name</div>
                        <div class="head" style="width: 20%">Department</div>
                        <div class="head" style="width: 20%">Project Preset</div>
                        <div class="head" style="width: 7.5%">Tasks</div>
                        <div class="head" style="width: 7.5%">Time</div>
                        <div class="head" style="width: 7.5%">Earn</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($assignments) {
                        foreach ($assignments as $assignment) { ?>
                            <div class="row">
                                <?php $link = "http://ozols88.id.lv/ep/epsystem/account/projects.php?p=" . $assignment['project_id'] . "&l1=1&l2=" . $assignment['department_id'] . "&l3=" . $assignment['assignment_id'] . "&l4=summary&preview" ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell" style="width: 22.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['assignment_name']; ?></a></div>
                                <div class="cell" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['department']; ?></a></div>
                                <div class="cell" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['project_preset']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_count']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['time']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "€" . $assignment['earn']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "custom") {
                $assignments = Assignment::selectAssignmentListByStatus(5, false); ?>
                <form class="info-bar with-space">
                    <div class="section">
                        <div class="stage">LAST</div>
                        <button type="button" class="hours-button">12h</button>
                        <button type="button" class="hours-button active">24h</button>
                        <button type="button" class="hours-button">48h</button>
                    </div>
                    <div class="section">
                        <div class="stage">NEW ADDED</div>
                        <div class="content active">+1</div>
                        <div class="space"></div>
                        <div class="stage">ACCEPTED</div>
                        <div class="content active">0</div>
                    </div>
                    <div class="section">
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 22.5%">Assignment Name</div>
                        <div class="head" style="width: 20%">Department</div>
                        <div class="head" style="width: 20%">Project Preset</div>
                        <div class="head" style="width: 7.5%">Tasks</div>
                        <div class="head" style="width: 7.5%">Time</div>
                        <div class="head" style="width: 7.5%">Earn</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($assignments) {
                        foreach ($assignments as $assignment) { ?>
                            <div class="row">
                                <?php $link = "http://ozols88.id.lv/ep/epsystem/account/projects.php?p=" . $assignment['project_id'] . "&l1=assignments&l2=" . $assignment['department_id'] . "&l3=" . $assignment['assignment_id'] . "&l4=summary&preview" ?>
                                <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%05d', $assignment['assignment_id']); ?></a></div>
                                <div class="cell" style="width: 22.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['assignment_name']; ?></a></div>
                                <div class="cell" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['department']; ?></a></div>
                                <div class="cell" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['project_preset']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['task_count']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo $assignment['time']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "€" . $assignment['earn']; ?></a></div>
                                <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "approval") { ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "management") { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "mine") {
            if (isset($_GET['l2']) && $_GET['l2'] == "pending") { ?>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "active") { ?>
                <form class="info-bar with-space">
                    <div class="section">
                        <div class="stage">LAST</div>
                        <button type="button" class="hours-button">12h</button>
                        <button type="button" class="hours-button active">24h</button>
                        <button type="button" class="hours-button">48h</button>
                    </div>
                    <div class="section">
                        <div class="stage">NEW ADDED</div>
                        <div class="content active">+1</div>
                        <div class="space"></div>
                        <div class="stage">COMPLETED</div>
                        <div class="content active">0</div>
                    </div>
                    <div class="section">
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head" style="width: 7.5%">№</div>
                        <div class="head" style="width: 22.5%">Assignment Name</div>
                        <div class="head" style="width: 20%">Department</div>
                        <div class="head" style="width: 20%">Assignment Type</div>
                        <div class="head" style="width: 7.5%">Tasks</div>
                        <div class="head" style="width: 7.5%">Time</div>
                        <div class="head" style="width: 7.5%">Earn</div>
                        <div class="head" style="width: 7.5%">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table">
                    <div class="row">
                        <?php $link = "http://ozols88.id.lv/ep/epsystem/account/projects.php?p=1&l1=1&l2=1&l3=1&l4=summary" ?>
                        <div class="cell id" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "#" . sprintf('%04d', "1"); ?></a></div>
                        <div class="cell" style="width: 22.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "Color palette"; ?></a></div>
                        <div class="cell" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo "Operations"; ?></a></div>
                        <div class="cell" style="width: 20%"><a href="<?php echo $link; ?>" class="content"><?php echo "Production"; ?></a></div>
                        <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "1"; ?></a></div>
                        <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "15 min"; ?></a></div>
                        <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content"><?php echo "€1.50"; ?></a></div>
                        <div class="cell" style="width: 7.5%"><a href="<?php echo $link; ?>" class="content open-button">Open</a></div>
                    </div>
                </div> <?php
            }
            elseif (isset($_GET['l2']) && $_GET['l2'] == "completed") { ?>
                </div> <?php
            }
        }
        elseif (isset($_GET['l1']) && $_GET['l1'] == "admin") { ?>
            </div> <?php
        }
        else { ?>
            </div> <?php
        }
    }

    require_once "includes/footer.php";

}
else require_once "login.php";