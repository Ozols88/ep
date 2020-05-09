<?php
if (basename($_SERVER['PHP_SELF']) == 'new-project.php') { ?>
    <div class="info-bar extended">
        <div class="section line-right">
            <div class="stage admin">№:</div>
            <div class="content"><?php echo "#" . sprintf('%04d', Project::selectNextNewID('project')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-project']['preset'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-project']['stage'] == 1) echo " active"; else echo " admin"; ?>" value="PRESET:">
                <div class="content"><?php echo $_SESSION['new-project']['preset']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-project']['stage'] == 1) echo " active"; else echo " admin"; ?>">PRESET:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-project']['client'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-project']['stage'] == 2) echo " active"; else echo " admin"; ?>" value="CLIENT:">
                <div class="content"><?php echo $_SESSION['new-project']['client']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-project']['stage'] == 2) echo " active"; else echo " admin"; ?>">CLIENT:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-project']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-project']['stage'] == 3) echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo $_SESSION['new-project']['title']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-project']['stage'] == 3) echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-project']['manager-name'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage4" class="stage<?php if ($_SESSION['new-project']['stage'] == 4) echo " active"; else echo " admin"; ?>" value="MANAGER:">
                <div class="content"><?php echo $_SESSION['new-project']['manager-name']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-project']['stage'] == 4) echo " active"; else echo " admin"; ?>">MANAGER:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-project']['assignments'])) { ?>
            <form method="post" class="section line-left">
                <input type="submit" name="stage5" class="stage<?php if ($_SESSION['new-project']['stage'] == 5) echo " active"; else echo " admin"; ?>" value="ASSIGNMENTS:">
                <div class="content"><?php if (is_countable($_SESSION['new-project']['assignments'])) echo count($_SESSION['new-project']['assignments']); else echo "0"; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section line-left">
                <div class="stage<?php if ($_SESSION['new-project']['stage'] == 5) echo " active"; else echo " admin"; ?>">ASSIGNMENTS:</div>
            </div> <?php
        } ?>
    </div> <?php
}
elseif (basename($_SERVER['PHP_SELF']) == 'new-assignment.php') {
    if (isset($_SESSION['new-assignment']['fields']['type'])) {
        if ($_SESSION['new-assignment']['fields']['type'] == 0) { ?>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
                </div> <?php
                if (isset($_SESSION['new-assignment']['project'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="PROJECT:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['project']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1') echo " active"; else echo " admin"; ?>">PROJECT:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['type'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="TYPE:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['type']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '2') echo " active"; else echo " admin"; ?>">TYPE:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['department'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage3c" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '3c') echo " active"; else echo " admin"; ?>" value="DEPARTMENT:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['department']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '3c') echo " active"; else echo " admin"; ?>">DEPARTMENT:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['title'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage4c" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '4c') echo " active"; else echo " admin"; ?>" value="NAME:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['title']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '4c') echo " active"; else echo " admin"; ?>">NAME:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['objective'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage5c" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '5c') echo " active"; else echo " admin"; ?>" value="OBJECTIVE:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['objective']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '5c') echo " active"; else echo " admin"; ?>">OBJECTIVE:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['tasks'])) { ?>
                    <form method="post" class="section line-left">
                        <input type="submit" name="stage6c" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '6c') echo " active"; else echo " admin"; ?>" value="TASKS:">
                        <div class="content"><?php if (is_countable($_SESSION['new-assignment']['tasks'])) echo count($_SESSION['new-assignment']['tasks']); else echo "0"; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section line-left">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '6c') echo " active"; else echo " admin"; ?>">TASKS:</div>
                    </div> <?php
                } ?>
            </div> <?php
        }
        else { ?>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
                </div> <?php
                if (isset($_SESSION['new-assignment']['project'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="PROJECT:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['project']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1') echo " active"; else echo " admin"; ?>">PROJECT:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['type'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="TYPE:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['type']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '2') echo " active"; else echo " admin"; ?>">TYPE:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['preset'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="PRESET:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['preset']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '3') echo " active"; else echo " admin"; ?>">PRESET:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['tasks'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage4" class="stage<?php if ($_SESSION['new-assignment']['stage'] == 4) echo " active"; else echo " admin"; ?>" value="TASKS:">
                        <div class="content"><?php if (is_countable($_SESSION['new-assignment']['tasks'])) echo count($_SESSION['new-assignment']['tasks']); else echo "0"; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '4') echo " active"; else echo " admin"; ?>">TASKS:</div>
                    </div> <?php
                } ?>
            </div> <?php
        }
    }
    else { ?>
        <div class="info-bar extended">
            <div class="section line-right">
                <div class="stage admin">№:</div>
                <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
            </div> <?php
            if (isset($_SESSION['new-assignment']['project'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-assignment']['stage'] == 1) echo " active"; else echo " admin"; ?>" value="PROJECT:">
                    <div class="content"><?php echo $_SESSION['new-assignment']['project']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == 1) echo " active"; else echo " admin"; ?>">PROJECT:</div>
                </div> <?php
            }
            if (isset($_SESSION['new-assignment']['type'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-assignment']['stage'] == 2) echo " active"; else echo " admin"; ?>" value="TYPE:">
                    <div class="content"><?php echo $_SESSION['new-assignment']['type']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == 2) echo " active"; else echo " admin"; ?>">TYPE:</div>
                </div> <?php
            } ?>
            <div class="section line-left">
                <div class="stage admin">TASKS:</div>
            </div>
        </div> <?php
    }
}
elseif (basename($_SERVER['PHP_SELF']) == 'new-task.php') { ?>
    <div class="info-bar extended">
        <div class="section line-right">
            <div class="stage admin">№:</div>
            <div class="content"><?php echo "#" . sprintf('%04d', Task::selectNextNewID('task')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-task']['objective'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-task']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="OBJECTIVE:">
                <div class="content"><?php echo $_SESSION['new-task']['objective']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-task']['stage'] == '1') echo " active"; else echo " admin"; ?>">OBJECTIVE:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-task']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-task']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo $_SESSION['new-task']['description']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-task']['stage'] == '2') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-task']['action'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-task']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="ACTION:">
                <div class="content"><?php echo $_SESSION['new-task']['action']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-task']['stage'] == '3') echo " active"; else echo " admin"; ?>">ACTION:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-task']['links'])) { ?>
            <form method="post" class="section line-left">
                <input type="submit" name="stage4" class="stage<?php if ($_SESSION['new-task']['stage'] == '4') echo " active"; else echo " admin"; ?>" value="LINKS:">
                <div class="content"><?php echo $_SESSION['new-task']['links']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section line-left">
                <div class="stage<?php if ($_SESSION['new-task']['stage'] == '4') echo " active"; else echo " admin"; ?>">LINKS:</div>
            </div> <?php
        } ?>
    </div> <?php
}