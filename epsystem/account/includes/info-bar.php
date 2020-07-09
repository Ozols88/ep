<?php
if (basename($_SERVER['PHP_SELF']) == 'new-project.php') {
    if (!isset($_SESSION['new-project']['add-assignment-page'])) { ?>
        <div class="info-bar extended">
            <div class="section line-right">
                <div class="stage admin">№:</div>
                <div class="content"><?php echo "#" . sprintf('%04d', Project::selectNextNewID('project')); ?></div>
            </div> <?php
            if (isset($_SESSION['new-project']['info']['floor'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-project']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="FLOOR:">
                    <div class="content"><?php echo $_SESSION['new-project']['info']['floor']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-project']['stage'] == '1') echo " active"; else echo " admin"; ?>">PRESET:</div>
                </div> <?php
            }
            if (isset($_SESSION['new-project']['info']['preset'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-project']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="PRESET:">
                    <div class="content"><?php echo $_SESSION['new-project']['info']['preset']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-project']['stage'] == '2') echo " active"; else echo " admin"; ?>">PRESET:</div>
                </div> <?php
            }
            if (isset($_SESSION['new-project']['info']['client'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-project']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="CLIENT:">
                    <div class="content"><?php echo $_SESSION['new-project']['info']['client']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-project']['stage'] == '3') echo " active"; else echo " admin"; ?>">CLIENT:</div>
                </div> <?php
            }
            if (isset($_SESSION['new-project']['info']['title'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage4" class="stage<?php if ($_SESSION['new-project']['stage'] == '4') echo " active"; else echo " admin"; ?>" value="NAME:">
                    <div class="content"><?php echo $_SESSION['new-project']['info']['title']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-project']['stage'] == '4') echo " active"; else echo " admin"; ?>">NAME:</div>
                </div> <?php
            }
            if (isset($_SESSION['new-project']['info']['description'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage5" class="stage<?php if ($_SESSION['new-project']['stage'] == '5') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                    <div class="content"><?php echo $_SESSION['new-project']['info']['description']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-project']['stage'] == '5') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
                </div> <?php
            }
            if (isset($_SESSION['new-project']['info']['assignments'])) { ?>
                <form method="post" class="section line-left">
                    <input type="submit" name="stage6" class="stage<?php if ($_SESSION['new-project']['stage'] == '6') echo " active"; else echo " admin"; ?>" value="ASSIGNMENTS:">
                    <div class="content"><?php if (isset($_SESSION['new-project']['assignments'])) echo count($_SESSION['new-project']['assignments']); else echo "0"; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section line-left">
                    <div class="stage<?php if ($_SESSION['new-project']['stage'] == '6') echo " active"; else echo " admin"; ?>">ASSIGNMENTS:</div>
                </div> <?php
            } ?>
        </div> <?php
    }
    else { ?>
        <div class="info-bar extended">
            <div class="section">
                <div class="stage active">Assignment Presets:</div>
                <div class="content"><?php if (isset($_SESSION['new-project']['assignmentPresets'])) echo count($_SESSION['new-project']['assignmentPresets']); else echo "0"; ?></div>
            </div>
        </div> <?php
    }
}
elseif (basename($_SERVER['PHP_SELF']) == 'new-assignment.php') {
    if (!empty($_SESSION['new-assignment']['info']['division'])) {
        if (is_null($_SESSION['new-assignment']['divisionid'])) { ?>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%05d', Assignment::selectNextNewID('assignment')); ?></div>
                </div> <?php
                if (isset($_SESSION['new-assignment']['info']['project'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="PROJECT:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['info']['project']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1') echo " active"; else echo " admin"; ?>">PROJECT:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['info']['division'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="DIVISION:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['info']['division']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '2') echo " active"; else echo " admin"; ?>">DIVISION:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['info']['title'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage3c" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '3c') echo " active"; else echo " admin"; ?>" value="NAME:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['info']['title']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '3c') echo " active"; else echo " admin"; ?>">NAME:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['info']['objective'])) { ?>
                    <form method="post" class="section">
                        <input type="submit" name="stage4c" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '4c') echo " active"; else echo " admin"; ?>" value="OBJECTIVE:">
                        <div class="content"><?php echo $_SESSION['new-assignment']['info']['objective']; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '4c') echo " active"; else echo " admin"; ?>">OBJECTIVE:</div>
                    </div> <?php
                }
                if (isset($_SESSION['new-assignment']['tasks'])) { ?>
                    <form method="post" class="section line-left">
                        <input type="submit" name="stage5c" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '5c') echo " active"; else echo " admin"; ?>" value="TASKS:">
                        <div class="content"><?php if (is_countable($_SESSION['new-assignment']['tasks'])) echo count($_SESSION['new-assignment']['tasks']); else echo "0"; ?></div>
                    </form> <?php
                }
                else { ?>
                    <div class="section line-left">
                        <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '5c') echo " active"; else echo " admin"; ?>">TASKS:</div>
                    </div> <?php
                } ?>
            </div> <?php
        }
        else {
            if (!isset($_SESSION['new-assignment']['add-task-page'])) { ?>
                <div class="info-bar extended">
                    <div class="section line-right">
                        <div class="stage admin">№:</div>
                        <div class="content"><?php echo "#" . sprintf('%05d', Assignment::selectNextNewID('assignment')); ?></div>
                    </div> <?php
                    if (isset($_SESSION['new-assignment']['info']['project'])) { ?>
                        <form method="post" class="section">
                            <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="PROJECT:">
                            <div class="content"><?php echo $_SESSION['new-assignment']['info']['project']; ?></div>
                        </form> <?php
                    }
                    else { ?>
                        <div class="section">
                            <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1') echo " active"; else echo " admin"; ?>">PROJECT:</div>
                        </div> <?php
                    }
                    if (isset($_SESSION['new-assignment']['info']['division'])) { ?>
                        <form method="post" class="section">
                            <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="DIVISION:">
                            <div class="content"><?php echo $_SESSION['new-assignment']['info']['division']; ?></div>
                        </form> <?php
                    }
                    else { ?>
                        <div class="section">
                            <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '2') echo " active"; else echo " admin"; ?>">DIVISION:</div>
                        </div> <?php
                    }
                    if (isset($_SESSION['new-assignment']['info']['preset'])) { ?>
                        <form method="post" class="section">
                            <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="PRESET:">
                            <div class="content"><?php echo $_SESSION['new-assignment']['info']['preset']; ?></div>
                        </form> <?php
                    }
                    else { ?>
                        <div class="section">
                            <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '3') echo " active"; else echo " admin"; ?>">PRESET:</div>
                        </div> <?php
                    }
                    if (isset($_SESSION['new-assignment']['tasks'])) { ?>
                        <form method="post" class="section">
                            <input type="submit" name="stage4" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '4') echo " active"; else echo " admin"; ?>" value="TASKS:">
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
            else { ?>
                <div class="info-bar extended">
                    <div class="section">
                        <div class="stage active">Task Presets:</div>
                        <div class="content"><?php if (isset($_SESSION['new-assignment']['presetTasks'])) echo count($_SESSION['new-assignment']['presetTasks']); else echo "0"; ?></div>
                    </div>
                </div> <?php
            }
        }
    }
    else { ?>
        <div class="info-bar extended">
            <div class="section line-right">
                <div class="stage admin">№:</div>
                <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
            </div> <?php
            if (isset($_SESSION['new-assignment']['info']['project'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="PROJECT:">
                    <div class="content"><?php echo $_SESSION['new-assignment']['info']['project']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1') echo " active"; else echo " admin"; ?>">PROJECT:</div>
                </div> <?php
            }
            if (isset($_SESSION['new-assignment']['info']['division'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="DIVISION:">
                    <div class="content"><?php echo $_SESSION['new-assignment']['info']['division']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '2') echo " active"; else echo " admin"; ?>">DIVISION:</div>
                </div> <?php
            } ?>
            <div class="section line-left">
                <div class="stage admin">TASKS:</div>
            </div>
        </div> <?php
    }
}
elseif (basename($_SERVER['PHP_SELF']) == 'new-task.php') {
    if ($_SESSION['new-task']['stage'] != '1') { ?>
        <div class="info-bar extended">
            <div class="section line-right">
                <div class="stage admin">№:</div>
                <div class="content"><?php echo "#" . sprintf('%04d', Task::selectNextNewID('task')); ?></div>
            </div> <?php
            if (isset($_SESSION['new-task']['objective'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage1c" class="stage<?php if ($_SESSION['new-task']['stage'] == '1c') echo " active"; else echo " admin"; ?>" value="OBJECTIVE:">
                    <div class="content"><?php echo $_SESSION['new-task']['objective']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-task']['stage'] == '1c') echo " active"; else echo " admin"; ?>">OBJECTIVE:</div>
                </div> <?php
            }
            if (isset($_SESSION['new-task']['description'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage2c" class="stage<?php if ($_SESSION['new-task']['stage'] == '2c') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                    <div class="content"><?php echo $_SESSION['new-task']['description']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-task']['stage'] == '2c') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
                </div> <?php
            }
            if (isset($_SESSION['new-task']['action'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage3c" class="stage<?php if ($_SESSION['new-task']['stage'] == '3c') echo " active"; else echo " admin"; ?>" value="ACTION:">
                    <div class="content"><?php echo $_SESSION['new-task']['action']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-task']['stage'] == '3c') echo " active"; else echo " admin"; ?>">ACTION:</div>
                </div> <?php
            }
            if (isset($_SESSION['new-task']['value'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage4c" class="stage<?php if ($_SESSION['new-task']['stage'] == '4c') echo " active"; else echo " admin"; ?>" value="VALUE:">
                    <div class="content"><?php echo $_SESSION['new-task']['value']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-task']['stage'] == '4c') echo " active"; else echo " admin"; ?>">VALUE:</div>
                </div> <?php
            }
            if (isset($_SESSION['new-task']['links'])) { ?>
                <form method="post" class="section line-left">
                    <input type="submit" name="stage7c" class="stage<?php if ($_SESSION['new-task']['stage'] == '7c') echo " active"; else echo " admin"; ?>" value="LINKS:">
                    <div class="content"><?php echo $_SESSION['new-task']['links']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section line-left">
                    <div class="stage<?php if ($_SESSION['new-task']['stage'] == '7c') echo " active"; else echo " admin"; ?>">LINKS:</div>
                </div> <?php
            } ?>
        </div> <?php
    }
    else { ?>
        <div class="info-bar extended">
            <div class="section">
                <div class="stage active">Task Presets:</div>
                <div class="content"><?php if (is_countable($_SESSION['new-task']['presetTasks'])) echo count($_SESSION['new-task']['presetTasks']); else echo "0"; ?></div>
            </div>
        </div> <?php
    }
}
elseif (basename($_SERVER['PHP_SELF']) == 'new-member.php') { ?>
    <div class="info-bar extended">
        <div class="section line-right">
            <div class="stage admin">№:</div>
            <div class="content"><?php echo "#" . sprintf('%04d', Database::selectNextNewID('account')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-member']['info']['manager'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-member']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="MANAGER:">
                <div class="content"><?php echo $_SESSION['new-member']['info']['manager']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-member']['stage'] == '1') echo " active"; else echo " admin"; ?>">MANAGER:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-member']['info']['client'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-member']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="CLIENT:">
                <div class="content"><?php echo $_SESSION['new-member']['info']['client']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-member']['stage'] == '2') echo " active"; else echo " admin"; ?>">CLIENT:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-member']['divisions'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-member']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="DIVISIONS:">
                <div class="content"><?php if (is_countable($_SESSION['new-member']['divisions'])) echo count($_SESSION['new-member']['divisions']); else echo "0"; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-member']['stage'] == '3') echo " active"; else echo " admin"; ?>">DIVISIONS:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-member']['info']['username'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage4" class="stage<?php if ($_SESSION['new-member']['stage'] == '4') echo " active"; else echo " admin"; ?>" value="USERNAME:">
                <div class="content"><?php echo $_SESSION['new-member']['info']['username']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-member']['stage'] == '4') echo " active"; else echo " admin"; ?>">USERNAME:</div>
            </div> <?php
        } ?>
    </div> <?php
}