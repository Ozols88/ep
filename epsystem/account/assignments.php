<?php
ob_start();
$page = "assignments";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];

    require_once "includes/header.php";

    if ($account->type == 1) { ?>
        <div class="menu"> <?php
        require "includes/menu.php";
        if (!isset($_GET['a'])) {
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
                                    <?php $link = "?a=" . $assignment['assignment_id']; ?>
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
                                    <?php $link = "http://ozols88.id.lv/ep/epsystem/account/projects.php?p=" . $assignment['project_id'] . "&l1=assignments&l2=" . $assignment['department_id'] . "&l3=" . $assignment['assignment_id'] . "&l4=assignment&preview" ?>
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
                elseif (isset($_GET['l2']) && $_GET['l2'] == "review") { ?>
                    </div> <?php
                }
                elseif (isset($_GET['l2']) && $_GET['l2'] == "management") { ?>
                    </div> <?php
                }
                else { ?>
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
                else { ?>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "all") { ?>
                </div> <?php
            }
            else { ?>
                </div> <?php
            }
        }
        elseif (isset($assignment)) {
            if (isset($_GET['l1']) && $_GET['l1'] == "assignment") {
                if (isset($_POST['delete'])) {
                    Assignment::remove('assignment', $_GET['a'], "projects.php?p=" . $assignment['projectid'] . "&l1=assignments");
                } ?>
                </div>
                <form method="post" class="decision-bar">
                    <input type="hidden" name="delete">
                    <input type="submit" name="submit" value="DELETE ASSIGNMENT" class="button">
                </form> <?php
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "tasks") {
                if (isset($_GET['l2'])) {
                    $task = Task::selectTask($_GET['l2']);
                    if ($task) {
                        if (isset($_POST['delete']))
                            Task::remove('task', $_GET['l2'], "assignments.php?a=" . $_GET['a'] . "&l1=tasks"); ?>

                        </div>
                        <div class="info-bar extended">
                            <div class="section">
                                <div class="stage">STATUS:</div>
                                <div class="content"><?php echo $task['status']; ?></div>
                            </div>
                            <div class="section">
                                <div class="stage">ACTION:</div>
                                <div class="content"><?php echo $task['action']; ?></div>
                            </div>
                            <div class="section">
                                <div class="stage">TIME:</div>
                                <div class="content"><?php echo $task['estimated-min']; ?></div>
                            </div>
                        </div>

                        <div class="objective-header">Objective</div>
                        <div class="objective-body">
                            <span class="objective"><?php echo strtoupper($task['objective']); ?></span>
                            <span class="description"><?php echo $task['description']; ?></span>
                        </div>

                        <div class="link-section">
                            <div class="link-type">
                                <div class="link-title">Info</div> <?php
                                $linksInfo = Task::selectTaskLinks($_GET['l2'], 1);
                                if ($linksInfo) {
                                    foreach ($linksInfo as $link) {
                                        if ($link['link'] != null) {
                                            $link['link'] = "?a=" . $_GET['a'] . $link['link'];
                                            $link['custom'] = "ep system link";
                                        }
                                        else {
                                            $link['link'] = $link['custom-link'];
                                            $link['custom'] = "custom link";
                                        } ?>

                                        <a class="link" href="<?php echo $link['link']; ?>" target="_blank">
                                            <span class="id"><?php echo $link['custom']; ?></span>
                                            <span class="title"><?php echo $link['title']; ?></span>
                                            <span class="description">Find info about the project here</span>
                                        </a> <?php
                                    }
                                } ?>
                            </div>
                            <div class="link-type">
                                <div class="link-title">Resources</div> <?php
                                $linksRes = Task::selectTaskLinks($_GET['l2'], 2);
                                if ($linksRes)
                                    foreach ($linksRes as $link) {
                                        if ($link['link'] != null) {
                                            $link['link'] = "?a=" . $_GET['a'] . $link['link'];
                                            $link['custom'] = "ep system link";
                                        }
                                        else {
                                            $link['link'] = $link['custom-link'];
                                            $link['custom'] = "custom link";
                                        } ?>

                                        <a class="link" href="<?php echo $link['link']; ?>" target="_blank">
                                            <span class="id"><?php echo $link['custom']; ?></span>
                                            <span class="title"><?php echo $link['title']; ?></span>
                                            <span class="description">Upload & download files here</span>
                                        </a> <?php
                                    } ?>
                            </div>
                            <div class="link-type">
                                <div class="link-title">Research & Development</div> <?php
                                $linksRnD = Task::selectTaskLinks($_GET['l2'], 3);
                                if ($linksRnD)
                                    foreach ($linksRnD as $link) {
                                        if ($link['link'] != null) {
                                            $link['link'] = "?a=" . $_GET['a'] . $link['link'];
                                            $link['custom'] = "ep system link";
                                        }
                                        else {
                                            $link['link'] = $link['custom-link'];
                                            $link['custom'] = "custom link";
                                        } ?>

                                        <a class="link" href="?p=<?php echo $_GET['p'] . $link['link']; ?>" target="_blank">
                                            <span class="id"><?php echo $link['custom']; ?></span>
                                            <span class="title"><?php echo $link['title']; ?></span>
                                            <span class="description">Learn how to complete the task here</span>
                                        </a> <?php
                                    } ?>
                            </div>
                        </div>

                        <form method="post" class="decision-bar">
                            <input type="hidden" name="delete">
                            <input type="submit" name="submit" value="DELETE TASK" class="button">
                        </form> <?php
                    }
                }
                else { ?>
                    </div> <?php
                }
            }
            elseif (isset($_GET['l1']) && $_GET['l1'] == "options") { ?>
                    </div> <?php
                }
        }
    }

    require_once "includes/footer.php";

}
else require_once "login.php";