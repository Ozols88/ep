<?php
function stringLengthCheck($text) {
    if (strlen($text) > InfobarCharLimit)
        $text = substr($text, 0, InfobarCharLimit) . "...";
    return $text;
}

if (basename($_SERVER['PHP_SELF']) == 'projects.php' && isset($project) && isset($_GET['options']) && isset($_GET['l1']) && (($_GET['l1'] == "edit" && isset($_GET['l2'])) || $_GET['l1'] == "add")) { ?>
    <div class="info-bar edit">
        <div class="section<?php if (isset($_GET['l2']) && $_GET['l2'] == "preset") echo " active"; ?>">
            <a href="?p=<?php echo $_GET['p'] ?>&options&l1=edit&l2=preset" class="stage">PROJECT PRESET:</a>
            <div class="content"><?php echo stringLengthCheck($project['preset']); ?></div>
        </div>
        <div class="section<?php if (isset($_GET['l2']) && $_GET['l2'] == "name") echo " active"; ?>">
            <a href="?p=<?php echo $_GET['p'] ?>&options&l1=edit&l2=name" class="stage">NAME:</a>
            <div class="content"><?php echo stringLengthCheck($project['title']); ?></div>
        </div>
        <div class="section<?php if (isset($_GET['l2']) && $_GET['l2'] == "description") echo " active"; ?>">
            <a href="?p=<?php echo $_GET['p'] ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
            <div class="content"><?php echo stringLengthCheck($project['description']); ?></div>
        </div>
        <div class="section<?php if ($_GET['l1'] == "add") echo " active"; ?>">
            <a href="?p=<?php echo $_GET['p'] ?>&options&l1=add" class="stage">ASSIGNMENTS:</a>
            <div class="content"><?php echo $project['asgCount']; ?></div>
        </div>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'projects.php' && isset($infopage) && isset($_GET['ioptions']) && isset($_GET['i']) && isset($_GET['l1']) && $_GET['l1'] == "edit" && isset($_GET['l2'])) { ?>
    <div class="info-bar edit">
        <div class="section<?php if (isset($_GET['l2']) && $_GET['l2'] == "group") echo " active"; ?>">
            <a href="?p=<?php echo $_GET['p'] ?>&ioptions&l1=edit&i=<?php echo $_GET['i']; ?>&l2=group" class="stage">GROUP:</a>
            <div class="content"><?php echo stringLengthCheck($infopage['group']); ?></div>
        </div>
        <div class="section<?php if (isset($_GET['l2']) && $_GET['l2'] == "name") echo " active"; ?>">
            <a href="?p=<?php echo $_GET['p'] ?>&ioptions&l1=edit&i=<?php echo $_GET['i']; ?>&l2=name" class="stage">NAME:</a>
            <div class="content"><?php echo stringLengthCheck($infopage['title']); ?></div>
        </div>
        <div class="section<?php if (isset($_GET['l2']) && $_GET['l2'] == "link") echo " active"; ?>">
            <a href="?p=<?php echo $_GET['p'] ?>&ioptions&l1=edit&i=<?php echo $_GET['i']; ?>&l2=link" class="stage">URL:</a>
            <div class="content"><?php echo stringLengthCheck($infopage['link']); ?></div>
        </div>
        <div class="section<?php if (isset($_GET['l2']) && $_GET['l2'] == "description") echo " active"; ?>">
            <a href="?p=<?php echo $_GET['p'] ?>&ioptions&l1=edit&i=<?php echo $_GET['i']; ?>&l2=description" class="stage">DESCRIPTION:</a>
            <div class="content"><?php echo stringLengthCheck($infopage['description']); ?></div>
        </div>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'assignments.php' && isset($_GET['a']) && isset($assignment) && isset($_GET['options']) && isset($_GET['l1']) && (($_GET['l1'] == "edit" && isset($_GET['l2'])) || $_GET['l1'] == "add")) { ?>
    <div class="info-bar edit">
        <div class="section<?php if (isset($_GET['l2']) && $_GET['l2'] == "preset") echo " active"; ?>">
            <a href="?a=<?php echo $_GET['a'] ?>&options&l1=edit&l2=preset" class="stage">ASSIGNMENT PRESET:</a>
            <div class="content"><?php echo stringLengthCheck($assignment['preset']); ?></div>
        </div>
        <div class="section<?php if (isset($_GET['l2']) && $_GET['l2'] == "objective") echo " active"; ?>">
            <a href="?a=<?php echo $_GET['a'] ?>&options&l1=edit&l2=objective" class="stage">OBJECTIVE:</a>
            <div class="content"><?php echo stringLengthCheck($assignment['objective']); ?></div>
        </div>
        <div class="section<?php if ($_GET['l1'] == "add") echo " active"; ?>">
            <a class="stage">TASKS:</a>
            <div class="content"><?php echo $assignment['tasks']; ?></div>
        </div>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'assignments.php' && isset($_GET['t']) && isset($task) && isset($_GET['options']) && isset($_GET['l1']) && $_GET['l1'] == "edit" && isset($_GET['l2'])) { ?>
    <div class="info-bar edit"> <?php
        if ($task['presetid']) { ?>
            <div class="section<?php if ($_GET['l2'] == "preset") echo " active"; ?>">
                <a href="?t=<?php echo $_GET['t'] ?>&options&l1=edit&l2=preset" class="stage">TASK PRESET:</a>
                <div class="content"><?php echo stringLengthCheck($task['preset']); ?></div>
            </div> <?php
        }
        else { ?>
            <div class="section<?php if ($_GET['l2'] == "preset") echo " active"; ?>">
                <a class="stage">TASK PRESET:</a>
                <div class="content"><?php echo stringLengthCheck($task['preset']); ?></div>
            </div> <?php
        } ?>
        <div class="section<?php if ($_GET['l2'] == "description") echo " active"; ?>">
            <a href="?t=<?php echo $_GET['t'] ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
            <div class="content"><?php echo stringLengthCheck($task['description']); ?></div>
        </div> <?php
        if ($task['presetid'] == null) { ?>
            <div class="section<?php if ($_GET['l2'] == "time") echo " active"; ?>">
                <a href="?t=<?php echo $_GET['t'] ?>&options&l1=edit&l2=time" class="stage">TIME:</a>
                <div class="content"><?php echo $task['estimated']; ?></div>
            </div> <?php
        } ?>
        <div class="section<?php if ($_GET['l2'] == "prjlink") echo " active"; ?>">
            <a href="?t=<?php echo $_GET['t'] ?>&options&l1=edit&l2=prjlink" class="stage">PROJECT LINK:</a>
            <div class="content"><?php echo stringLengthCheck($task['title']); ?></div>
        </div>
        <div class="section<?php if ($_GET['l2'] == "links") echo " active"; ?>">
            <a href="?t=<?php echo $_GET['t'] ?>&options&l1=edit&l2=links" class="stage">LINKS:</a>
            <div class="content"><?php echo $task['links']; ?></div>
        </div>
        <div class="section<?php if ($_GET['l2'] == "comments") echo " active"; ?>">
            <a href="?t=<?php echo $_GET['t'] ?>&options&l1=edit&l2=comments" class="stage">COMMENTS:</a>
            <div class="content"><?php echo $task['comments']; ?></div>
        </div>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'numbers.php' && isset($_GET['py']) && isset($payment) && isset($_GET['options']) && isset($_GET['l1']) && $_GET['l1'] == "edit" && isset($_GET['l2'])) { ?>
    <div class="info-bar edit">
        <div class="section<?php if ($_GET['l2'] == "description") echo " active"; ?>">
            <a href="?py=<?php echo $_GET['py']; ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
            <div class="content"><?php echo stringLengthCheck($payment['description']); ?></div>
        </div>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'member.php' && isset($_GET['m']) && isset($member) && isset($_GET['options']) && isset($_GET['l1']) && $_GET['l1'] == "edit" && isset($_GET['l2'])) { ?>
    <div class="info-bar edit">
        <div class="section<?php if ($_GET['l2'] == "name") echo " active"; ?>">
            <a href="?m=<?php echo $_GET['m']; ?>&options&l1=edit&l2=name" class="stage">NAME:</a>
            <div class="content"><?php echo stringLengthCheck($member['username']); ?></div>
        </div>
        <div class="section<?php if ($_GET['l2'] == "description") echo " active"; ?>">
            <a href="?m=<?php echo $_GET['m']; ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
            <div class="content"><?php echo stringLengthCheck($member['description']); ?></div>
        </div>
        <div class="section<?php if ($_GET['l2'] == "password") echo " active"; ?>">
            <a href="?m=<?php echo $_GET['m']; ?>&options&l1=edit&l2=password" class="stage">PASSWORD:</a>
            <div class="content"><?php echo "********"; ?></div>
        </div>
        <div class="section<?php if ($_GET['l2'] == "divisions") echo " active"; ?>">
            <a href="?m=<?php echo $_GET['m']; ?>&options&l1=edit&l2=divisions&l3=delete" class="stage">DIVISIONS:</a>
            <div class="content"><?php echo $member['divisions']; ?></div>
        </div>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'r&d.php' && isset($_GET['options']) && isset($_GET['l1']) && $_GET['l1'] == "edit" && isset($_GET['l2'])) {
    if (isset($_GET['p']) && isset($preset)) { ?>
        <div class="info-bar edit">
            <div class="section<?php if ($_GET['l2'] == "product") echo " active"; ?>">
                <a href="?p=<?php echo $_GET['p']; ?>&options&l1=edit&l2=product" class="stage">PRODUCT:</a>
                <div class="content"><?php echo stringLengthCheck($preset['product']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "name") echo " active"; ?>">
                <a href="?p=<?php echo $_GET['p']; ?>&options&l1=edit&l2=name" class="stage">NAME:</a>
                <div class="content"><?php echo stringLengthCheck($preset['title']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "description") echo " active"; ?>">
                <a href="?p=<?php echo $_GET['p']; ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
                <div class="content"><?php echo stringLengthCheck($preset['description']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "assignments") echo " active"; ?>">
                <a href="?p=<?php echo $_GET['p']; ?>&options&l1=edit&l2=assignments&l3=remove" class="stage">ASSIGNMENT PRESETS:</a>
                <div class="content"><?php echo $preset['assignments']; ?></div>
            </div>
        </div> <?php
    } // Project preset
    elseif (isset($_GET['a']) && isset($preset)) { ?>
        <div class="info-bar edit">
            <div class="section<?php if ($_GET['l2'] == "division") echo " active"; ?>">
                <a href="?a=<?php echo $_GET['a']; ?>&options&l1=edit&l2=division" class="stage">DIVISION:</a>
                <div class="content"><?php echo stringLengthCheck($preset['div_title']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "name") echo " active"; ?>">
                <a href="?a=<?php echo $_GET['a']; ?>&options&l1=edit&l2=name" class="stage">NAME:</a>
                <div class="content"><?php echo stringLengthCheck($preset['title']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "objective") echo " active"; ?>">
                <a href="?a=<?php echo $_GET['a']; ?>&options&l1=edit&l2=objective" class="stage">OBJECTIVE:</a>
                <div class="content"><?php echo stringLengthCheck($preset['objective']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "tasks") echo " active"; ?>">
                <a href="?a=<?php echo $_GET['a']; ?>&options&l1=edit&l2=tasks" class="stage">TASK PRESETS:</a>
                <div class="content"><?php echo $preset['task_count']; ?></div>
            </div>
        </div> <?php
    } // Assignment preset
    elseif (isset($_GET['t']) && isset($preset)) { ?>
        <div class="info-bar edit">
            <div class="section<?php if ($_GET['l2'] == "assignment") echo " active"; ?>">
                <a href="?t=<?php echo $_GET['t']; ?>&options&l1=edit&l2=assignment" class="stage">ASSIGNMENT:</a>
                <div class="content"><?php echo stringLengthCheck($preset['assignment']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "name") echo " active"; ?>">
                <a href="?t=<?php echo $_GET['t']; ?>&options&l1=edit&l2=name" class="stage">NAME:</a>
                <div class="content"><?php echo stringLengthCheck($preset['name']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "description") echo " active"; ?>">
                <a href="?t=<?php echo $_GET['t']; ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
                <div class="content"><?php echo stringLengthCheck($preset['description']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "time") echo " active"; ?>">
                <a href="?t=<?php echo $_GET['t']; ?>&options&l1=edit&l2=time" class="stage">TIME:</a>
                <div class="content"><?php echo $preset['estimated']; ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "info") echo " active"; ?>">
                <a href="?t=<?php echo $_GET['t']; ?>&options&l1=edit&l2=info" class="stage">PROJECT LINK:</a>
                <div class="content"><?php echo stringLengthCheck($preset['info-title']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "links") echo " active"; ?>">
                <a href="?t=<?php echo $_GET['t']; ?>&options&l1=edit&l2=links" class="stage">LINKS:</a>
                <div class="content"><?php echo $preset['links']; ?></div>
            </div>
        </div> <?php
    } // Task preset
    elseif (isset($_GET['i']) && isset($preset)) { ?>
        <div class="info-bar edit">
            <div class="section<?php if ($_GET['l2'] == "group") echo " active"; ?>">
                <a href="?i=<?php echo $_GET['i']; ?>&options&l1=edit&l2=group" class="stage">GROUP:</a>
                <div class="content"><?php echo stringLengthCheck($preset['group']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "name") echo " active"; ?>">
                <a href="?i=<?php echo $_GET['i']; ?>&options&l1=edit&l2=name" class="stage">NAME:</a>
                <div class="content"><?php echo stringLengthCheck($preset['title']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "description") echo " active"; ?>">
                <a href="?i=<?php echo $_GET['i']; ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
                <div class="content"><?php echo stringLengthCheck($preset['description']); ?></div>
            </div>
        </div> <?php
    } // Info page preset
    elseif (isset($_GET['f']) && isset($product)) { ?>
        <div class="info-bar edit">
            <div class="section<?php if ($_GET['l2'] == "name") echo " active"; ?>">
                <a href="?f=<?php echo $_GET['f']; ?>&options&l1=edit&l2=name" class="stage">NAME:</a>
                <div class="content"><?php echo stringLengthCheck($product['title']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "description") echo " active"; ?>">
                <a href="?f=<?php echo $_GET['f']; ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
                <div class="content"><?php echo stringLengthCheck($product['description']); ?></div>
            </div>
        </div> <?php
    } // Product
    elseif (isset($_GET['dp']) && isset($depart)) { ?>
        <div class="info-bar edit">
            <div class="section<?php if ($_GET['l2'] == "name") echo " active"; ?>">
                <a href="?dp=<?php echo $_GET['dp']; ?>&options&l1=edit&l2=name" class="stage">NAME:</a>
                <div class="content"><?php echo stringLengthCheck($depart['title']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "description") echo " active"; ?>">
                <a href="?dp=<?php echo $_GET['dp']; ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
                <div class="content"><?php echo stringLengthCheck($depart['description']); ?></div>
            </div>
        </div> <?php
    } // Department
    elseif (isset($_GET['d']) && isset($division)) { ?>
        <div class="info-bar edit">
            <div class="section<?php if ($_GET['l2'] == "department") echo " active"; ?>">
                <a href="?d=<?php echo $_GET['d']; ?>&options&l1=edit&l2=department" class="stage">DEPARTMENT:</a>
                <div class="content"><?php echo stringLengthCheck($division['department']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "name") echo " active"; ?>">
                <a href="?d=<?php echo $_GET['d']; ?>&options&l1=edit&l2=name" class="stage">NAME:</a>
                <div class="content"><?php echo stringLengthCheck($division['title']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "description") echo " active"; ?>">
                <a href="?d=<?php echo $_GET['d']; ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
                <div class="content"><?php echo stringLengthCheck($division['description']); ?></div>
            </div>
        </div> <?php
    } // Division
    elseif (isset($_GET['ig']) && isset($group)) { ?>
        <div class="info-bar edit">
            <div class="section<?php if ($_GET['l2'] == "name") echo " active"; ?>">
                <a href="?ig=<?php echo $_GET['ig']; ?>&options&l1=edit&l2=name" class="stage">NAME:</a>
                <div class="content"><?php echo stringLengthCheck($group['title']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "description") echo " active"; ?>">
                <a href="?ig=<?php echo $_GET['ig']; ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
                <div class="content"><?php echo stringLengthCheck($group['description']); ?></div>
            </div>
        </div> <?php
    } // Info group
    elseif (isset($_GET['lt']) && isset($type)) { ?>
        <div class="info-bar edit">
            <div class="section<?php if ($_GET['l2'] == "name") echo " active"; ?>">
                <a href="?lt=<?php echo $_GET['lt']; ?>&options&l1=edit&l2=name" class="stage">NAME:</a>
                <div class="content"><?php echo stringLengthCheck($type['title']); ?></div>
            </div>
            <div class="section<?php if ($_GET['l2'] == "description") echo " active"; ?>">
                <a href="?lt=<?php echo $_GET['lt']; ?>&options&l1=edit&l2=description" class="stage">DESCRIPTION:</a>
                <div class="content"><?php echo stringLengthCheck($type['description']); ?></div>
            </div>
        </div> <?php
    } // Link type
}

elseif (basename($_SERVER['PHP_SELF']) == 'new-project.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">PROJECT №:</div>
            <div class="content"><?php echo "#" . sprintf('%04d', Project::selectNextNewID('project')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-project']['info']['product'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-project']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="PRODUCT:">
                <div class="content"><?php echo $_SESSION['new-project']['info']['product']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-project']['stage'] == '1') echo " active"; else echo " admin"; ?>">PRODUCT:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-project']['info']['preset']) && $_SESSION['new-project']['fields']['productid'] != null) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-project']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="PROJECT PRESET:">
                <div class="content"><?php echo $_SESSION['new-project']['info']['preset']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-project']['stage'] == '2') echo " active"; else echo " admin"; ?>">PROJECT PRESET:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-project']['info']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-project']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo $_SESSION['new-project']['info']['title']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-project']['stage'] == '3') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-project']['info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage4" class="stage<?php if ($_SESSION['new-project']['stage'] == '4') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo $_SESSION['new-project']['info']['description']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-project']['stage'] == '4') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'new-assignment.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">ASSIGNMENT №:</div>
            <div class="content"><?php echo "#" . sprintf('%05d', Database::selectNextNewID('assignment')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-assignment']['info']['objective'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1c" class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1c') echo " active"; else echo " admin"; ?>" value="OBJECTIVE:">
                <div class="content"><?php echo $_SESSION['new-assignment']['info']['objective']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-assignment']['stage'] == '1c') echo " active"; else echo " admin"; ?>">OBJECTIVE:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'new-task.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">TASK №:</div>
            <div class="content"><?php echo "#" . sprintf('%04d', Task::selectNextNewID('task')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-task']['time'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1c" class="stage<?php if ($_SESSION['new-task']['stage'] == '1c') echo " active"; else echo " admin"; ?>" value="TIME:">
                <div class="content"><?php echo $_SESSION['new-task']['time']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-task']['stage'] == '1c') echo " active"; else echo " admin"; ?>">TIME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-task']['link'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2c" class="stage<?php if ($_SESSION['new-task']['stage'] == '2c') echo " active"; else echo " admin"; ?>" value="LINK:">
                <div class="content"><?php echo $_SESSION['new-task']['link']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-task']['stage'] == '2c') echo " active"; else echo " admin"; ?>">LINK:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-task']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3c" class="stage<?php if ($_SESSION['new-task']['stage'] == '3c') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo $_SESSION['new-task']['description']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-task']['stage'] == '3c') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'new-info.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">LINK №:</div>
            <div class="content"><?php echo "#" . sprintf('%05d', Database::selectNextNewID('project_infopage')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-info']['group'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-info']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="GROUP:">
                <div class="content"><?php echo $_SESSION['new-info']['group']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-info']['stage'] == '1') echo " active"; else echo " admin"; ?>">GROUP:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-info']['name'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-info']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo $_SESSION['new-info']['name']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-info']['stage'] == '2') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-info']['link'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-info']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="URL:">
                <div class="content"><?php echo $_SESSION['new-info']['link']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-info']['stage'] == '3') echo " active"; else echo " admin"; ?>">URL:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage4" class="stage<?php if ($_SESSION['new-info']['stage'] == '4') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo $_SESSION['new-info']['description']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-info']['stage'] == '4') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'new-link.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">LINK №:</div>
            <div class="content"><?php echo "#" . sprintf('%05d', Database::selectNextNewID('task_link')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-link']['type'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-link']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="TYPE:">
                <div class="content"><?php echo $_SESSION['new-link']['type']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-link']['stage'] == '1') echo " active"; else echo " admin"; ?>">TYPE:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-link']['link'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-link']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="URL:">
                <div class="content"><?php echo $_SESSION['new-link']['link']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-link']['stage'] == '2') echo " active"; else echo " admin"; ?>">URL:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-link']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-link']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo $_SESSION['new-link']['title']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-link']['stage'] == '3') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'new-member.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">MEMBER №:</div>
            <div class="content"><?php echo "#" . sprintf('%04d', Database::selectNextNewID('account')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-member']['info']['username'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-member']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo $_SESSION['new-member']['info']['username']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-member']['stage'] == '1') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-member']['info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-member']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo $_SESSION['new-member']['info']['description']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-member']['stage'] == '2') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-member']['info']['password'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-member']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="PASSWORD:">
                <div class="content"><?php echo $_SESSION['new-member']['info']['password']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-member']['stage'] == '3') echo " active"; else echo " admin"; ?>">PASSWORD:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-member']['divisions'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage4" class="stage<?php if ($_SESSION['new-member']['stage'] == '4') echo " active"; else echo " admin"; ?>" value="DIVISIONS:">
                <div class="content"><?php if (is_countable($_SESSION['new-member']['divisions'])) echo count($_SESSION['new-member']['divisions']); else echo "0"; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-member']['stage'] == '4') echo " active"; else echo " admin"; ?>">DIVISIONS:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif (basename($_SERVER['PHP_SELF']) == 'new-payment.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">PAYMENT №:</div>
            <div class="content"><?php echo "#" . sprintf('%04d', Database::selectNextNewID('payment')); ?></div>
        </div> <?php
        if (!isset($_SESSION['new-payment']['exitLink'])) {
            if (isset($_SESSION['new-payment']['info']['member'])) { ?>
                <form method="post" class="section">
                    <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-payment']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="MEMBER:">
                    <div class="content"><?php echo $_SESSION['new-payment']['info']['member']; ?></div>
                </form> <?php
            }
            else { ?>
                <div class="section">
                    <div class="stage<?php if ($_SESSION['new-payment']['stage'] == '1') echo " active"; else echo " admin"; ?>">MEMBER:</div>
                </div> <?php
            }
        }
        if (isset($_SESSION['new-payment']['assignments'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-payment']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="ASSIGNMENTS:">
                <div class="content"><?php if (is_countable($_SESSION['new-payment']['assignments']) && isset($_SESSION['new-payment']['info']['total'])) echo count($_SESSION['new-payment']['assignments']) . " (" . $_SESSION['new-payment']['info']['total'] . "€)"; else echo "0"; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-payment']['stage'] == '2') echo " active"; else echo " admin"; ?>">ASSIGNMENTS:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-payment']['info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-payment']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="PAYMENT DESCRIPTION:">
                <div class="content"><?php echo $_SESSION['new-payment']['info']['description']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-payment']['stage'] == '3') echo " active"; else echo " admin"; ?>">PAYMENT DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/project.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">PROJECT PRESET №:</div>
            <div class="content"><?php echo "#" . sprintf('%03d', Database::selectNextNewID('preset-project')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-projectpr']['info']['product'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-projectpr']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="PRODUCT:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-projectpr']['info']['product']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-projectpr']['stage'] == '1') echo " active"; else echo " admin"; ?>">PRODUCT:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-projectpr']['info']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-projectpr']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-projectpr']['info']['title']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-projectpr']['stage'] == '2') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-projectpr']['info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-projectpr']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-projectpr']['info']['description']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-projectpr']['stage'] == '3') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/assignment.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">ASSIGNMENT PRESET №:</div>
            <div class="content"><?php echo "#" . sprintf('%03d', Database::selectNextNewID('preset-assignment')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-assignmentpr']['info']['division'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-assignmentpr']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="DIVISION:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-assignmentpr']['info']['division']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-assignmentpr']['stage'] == '1') echo " active"; else echo " admin"; ?>">DIVISION:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-assignmentpr']['info']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-assignmentpr']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-assignmentpr']['info']['title']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-assignmentpr']['stage'] == '2') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-assignmentpr']['info']['objective'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-assignmentpr']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="OBJECTIVE:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-assignmentpr']['info']['objective']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-assignmentpr']['stage'] == '3') echo " active"; else echo " admin"; ?>">OBJECTIVE:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/task.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">TASK PRESET №:</div>
            <div class="content"><?php echo "#" . sprintf('%05d', Database::selectNextNewID('preset-task')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-taskpr']['info']['assignment']) && isset($_SESSION['new-taskpr']['infoAssignmentLock'])) { ?>
            <form method="post" class="section">
                <div class="stage<?php if ($_SESSION['new-taskpr']['stage'] == '1') echo " active"; else echo " admin"; ?>">ASSIGNMENT:</div>
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-taskpr']['info']['assignment']); ?></div>
            </form> <?php
        }
        elseif (isset($_SESSION['new-taskpr']['info']['assignment'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-taskpr']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="ASSIGNMENT:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-taskpr']['info']['assignment']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-taskpr']['stage'] == '1') echo " active"; else echo " admin"; ?>">ASSIGNMENT:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-taskpr']['info']['name'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-taskpr']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-taskpr']['info']['name']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-taskpr']['stage'] == '2') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-taskpr']['info']['infopage'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-taskpr']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="PROJECT LINK:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-taskpr']['info']['infopage']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-taskpr']['stage'] == '3') echo " active"; else echo " admin"; ?>">PROJECT LINK:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-taskpr']['info']['time'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage4" class="stage<?php if ($_SESSION['new-taskpr']['stage'] == '4') echo " active"; else echo " admin"; ?>" value="TIME:">
                <div class="content"><?php echo $_SESSION['new-taskpr']['info']['time']; ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-taskpr']['stage'] == '4') echo " active"; else echo " admin"; ?>">TIME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-taskpr']['info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage5" class="stage<?php if ($_SESSION['new-taskpr']['stage'] == '5') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-taskpr']['info']['description']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-taskpr']['stage'] == '5') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/task-link.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">LINK №:</div>
            <div class="content"><?php echo "#" . sprintf('%05d', Database::selectNextNewID('preset-task_links')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-task-link']['info']['type'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-task-link']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="TYPE:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-task-link']['info']['type']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-task-link']['stage'] == '1') echo " active"; else echo " admin"; ?>">TYPE:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-task-link']['info']['link'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-task-link']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="URL:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-task-link']['info']['link']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-task-link']['stage'] == '2') echo " active"; else echo " admin"; ?>">URL:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-task-link']['info']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-task-link']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-task-link']['info']['title']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-task-link']['stage'] == '3') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/info.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">PROJECT LINK PRESET №:</div>
            <div class="content"><?php echo "#" . sprintf('%03d', Database::selectNextNewID('preset-infopage')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-infopage']['info']['group'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-infopage']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="GROUP:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-infopage']['info']['group']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-assignmentpr']['stage'] == '1') echo " active"; else echo " admin"; ?>">GROUP:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-infopage']['info']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-infopage']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-infopage']['info']['title']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-infopage']['stage'] == '2') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-infopage']['info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-infopage']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-infopage']['info']['description']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-infopage']['stage'] == '3') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/product.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">PRODUCT №:</div>
            <div class="content"><?php echo "#" . sprintf('%02d', Database::selectNextNewID('product')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-product']['info']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-product']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-product']['info']['title']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-product']['stage'] == '1') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-product']['info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-product']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-product']['info']['description']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-product']['stage'] == '2') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/division.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">DIVISION №:</div>
            <div class="content"><?php echo "#" . sprintf('%03d', Database::selectNextNewID('division')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-division']['info']['department'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-division']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="DEPARTMENT:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-division']['info']['department']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-division']['stage'] == '1') echo " active"; else echo " admin"; ?>">DEPARTMENT:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-division']['info']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-division']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-division']['info']['title']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-division']['stage'] == '2') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-division']['info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage3" class="stage<?php if ($_SESSION['new-division']['stage'] == '3') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-division']['info']['description']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-division']['stage'] == '3') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/department.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">DEPARTMENT №:</div>
            <div class="content"><?php echo "#" . sprintf('%02d', Database::selectNextNewID('department')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-department']['info']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-department']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-department']['info']['title']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-department']['stage'] == '1') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-department']['info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-department']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-department']['info']['description']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-department']['stage'] == '2') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/infogroup.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">PROJECT LINK GROUP №:</div>
            <div class="content"><?php echo "#" . sprintf('%02d', Database::selectNextNewID('infopage_group')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-infogroup']['info']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-infogroup']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-infogroup']['info']['title']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-infogroup']['stage'] == '1') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-infogroup']['info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-infogroup']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-infogroup']['info']['description']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-infogroup']['stage'] == '2') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}

elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/linktype.php') { ?>
    <div class="info-bar">
        <div class="section line-right">
            <div class="stage admin">LINK TYPE №:</div>
            <div class="content"><?php echo "#" . sprintf('%02d', Database::selectNextNewID('link_type')); ?></div>
        </div> <?php
        if (isset($_SESSION['new-linktype']['info']['title'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage1" class="stage<?php if ($_SESSION['new-linktype']['stage'] == '1') echo " active"; else echo " admin"; ?>" value="NAME:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-linktype']['info']['title']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-linktype']['stage'] == '1') echo " active"; else echo " admin"; ?>">NAME:</div>
            </div> <?php
        }
        if (isset($_SESSION['new-linktype']['info']['description'])) { ?>
            <form method="post" class="section">
                <input type="submit" name="stage2" class="stage<?php if ($_SESSION['new-linktype']['stage'] == '2') echo " active"; else echo " admin"; ?>" value="DESCRIPTION:">
                <div class="content"><?php echo stringLengthCheck($_SESSION['new-linktype']['info']['description']); ?></div>
            </form> <?php
        }
        else { ?>
            <div class="section">
                <div class="stage<?php if ($_SESSION['new-linktype']['stage'] == '2') echo " active"; else echo " admin"; ?>">DESCRIPTION:</div>
            </div> <?php
        } ?>
    </div> <?php
}