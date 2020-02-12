<?php
$page = "projects";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php";
    $project = new Project();
    $pending = $project->selectPendingProjectList(); // only to get count
    $active = $project->selectActiveProjectList(); // only to get count
    $completed = $project->selectCompletedProjectList(); // only to get count
    $canceled = $project->selectCanceledProjectList(); // only to get count
    $count = [
        "ACTIVE" => count($active)
    ];
    if ($account->type == 1) { ?>
        <div class="menu">
        <div class="head-up-display-bar">
            <span><?php echo $project::getHeadUp(); ?></span>
        </div> <?php
        if (!isset($_GET['p'])) {
            if (isset($project::$menu) && isset($project::$menu['level-1'])) { ?>
                <div class="navbar level-1"> <?php
                foreach ($project::$menu['level-1'] as $menuLvl1ItemName => $menuLvl1Item) { ?>
                    <div class="container-button">
                        <a href="<?php echo "?t=" . $menuLvl1Item['link']; ?>" class="button<?php if ($menuLvl1Item['admin']) echo " admin-menu"; if (isset($_GET['t']) && $_GET['t'] == $menuLvl1Item['link']) echo " active-menu"; if (isset($menuLvl1Item['locked']) && $menuLvl1Item['locked'] == true) echo " locked"; ?>">
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
            }
            if (isset($_GET['t']) && $_GET['t'] == "new") { ?>
                
                </div> <?php
            }
            elseif (isset($_GET['t']) && $_GET['t'] == "active") { ?>
                <form class="info-bar<?php if (count($active) <= 10) echo " with-space"; ?>">
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
                        <span>REACTIVATED</span>
                        <div class="count">0</div>
                    </div>
                    <div class="section">
                        <div class="count total">1</div>
                        <span>TOTAL PROJECTS</span>
                    </div>
                </form> <?php
                if (count($active) > 10) { ?>
                    <hr>
                    <form class="search-bar">
                        <div class="section">
                            <input type="text" name="id" class="input-id" placeholder="Enter №">
                            <input type="text" name="project" class="input-project" placeholder="Enter Project Name">
                            <div class="custom-select">
                                <select name="type" class="input-type" required>
                                    <option value="">All</option>
                                    <option value="Animated Video">Animated Video</option>
                                </select>
                            </div>
                            <input type="text" name="client" class="input-client" placeholder="Enter Client Name">
                            <button type="button" onclick="searchTable()" class="search-button"></button>
                        </div>
                        <div class="section">
                            <button type="button" class="filter-button">PRIORITIZE</button>
                            <button type="button" class="filter-button">FILTER OPTION 2</button>
                            <button type="button" class="filter-button">FILTER OPTION 3</button>
                            <button type="button" class="filter-button">FILTER OPTION 4</button>
                        </div>
                        <div class="section">
                            <button type="button" class="reset-button"></button>
                        </div>
                    </form> <?php
                } ?>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head id">№</div>
                        <div class="head project">Project Name</div>
                        <div class="head type">Project Type</div>
                        <div class="head client">Client</div>
                        <div class="head assignments">Completed Assignments</div>
                        <div class="head time" onclick="sortTable('.head.time', '.cell.time a b')">Time Spent</div>
                        <div class="head value" onclick="sortTable('.head.value', '.cell.value a strong')">Value</div>
                        <div class="head open">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($active) {
                        foreach ($active as $row) { ?>
                            <div class="row">
                                <div class="cell id"><a href="<?php echo $_SERVER['PHP_SELF'] . "?p=" . $row['project_id']; ?>"><?php echo "#" . sprintf('%04d', $row['project_id']); ?></a></div>
                                <div class="cell project"><a href="projects.php?p=<?php echo $row['project_id']; ?>"><?php echo $row['project_title']; ?></a></div>
                                <div class="cell type"><a href="projects.php?p=<?php echo $row['project_id']; ?>"><?php echo $row['project_type']; ?></a></div>
                                <div class="cell client"><a href="projects.php?p=<?php echo $row['project_id']; ?>"><?php echo $row['client_username']; ?></a></div>
                                <div class="cell assignments"><a href="projects.php?p=<?php echo $row['project_id']; ?>"><?php echo "0 / 1"; ?></a></div>
                                <div class="cell time"><a href="projects.php?p=<?php echo $row['project_id']; ?>"><?php echo ""; ?> Hours</a></div>
                                <div class="cell value"><a href="projects.php?p=<?php echo $row['project_id']; ?>">€<span><?php echo ""; ?></span></a></div>
                                <div class="cell open"><a href="projects.php?p=<?php echo $row['project_id']; ?>" class="open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['t']) && $_GET['t'] == "pending") {
                if (isset($pending) && count($pending) > 10) { ?>
                    <form class="info-bar">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                    <hr>
                    <form class="search-bar">
                        <div class="section">
                            <input type="text" name="id" class="input-id" placeholder="Enter №">
                            <input type="text" name="project" class="input-project" placeholder="Enter Project Name">
                            <div class="custom-select">
                                <select name="type" class="input-type" required>
                                    <option value="">All</option>
                                    <option value="Animated Video">Animated Video</option>
                                    <option value="TO BE FILLED">TO BE FILLED</option>
                                </select>
                            </div>
                            <input type="text" name="client" class="input-client" placeholder="Enter Client Name">
                            <button type="button" onclick="searchTable()" class="search-button"></button>
                        </div>
                        <div class="section">
                            <button type="button" class="filter-button">PRIORITIZE</button>
                            <button type="button" class="filter-button">FILTER OPTION 2</button>
                            <button type="button" class="filter-button">FILTER OPTION 3</button>
                            <button type="button" class="filter-button">FILTER OPTION 4</button>
                        </div>
                        <div class="section">
                            <button type="button" class="reset-button"></button>
                        </div>
                    </form> <?php
                }
                else { ?>
                    <form class="info-bar with-space">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                     <?php
                } ?>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head id">№</div>
                        <div class="head project">Project Name</div>
                        <div class="head type">Project Type</div>
                        <div class="head client">Client</div>
                        <div class="head pending-for">Pending For</div>
                        <div class="head pending-reason">Pending Reason</div>
                        <div class="head time" onclick="sortTable('.head.time', '.cell.time a b')">Time Spent</div>
                        <div class="head value" onclick="sortTable('.head.value', '.cell.value a strong')">Value</div>
                        <div class="head open">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($pending) {
                        foreach ($pending as $row) { ?>
                            <div class="row">
                                <div class="cell id"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "#" . sprintf('%04d', $row['id']); ?></a></div>
                                <div class="cell project"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></div>
                                <div class="cell type"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "TO BE FILLED"; ?></a></div>
                                <div class="cell client"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['client']; ?></a></div>
                                <div class="cell pending-for"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "X Days"; ?></a></div>
                                <div class="cell pending-reason"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "Whyyy?"; ?></a></div>
                                <div class="cell time"><a href="projects.php?p=<?php echo $row['id']; ?>"><b><?php echo $row['days_left']; ?></b> Days</a></div>
                                <div class="cell value"><a href="projects.php?p=<?php echo $row['id']; ?>">$<span><?php echo $row['price']; ?></span></a></div>
                                <div class="cell open"><a href="projects.php?p=<?php echo $row['id']; ?>" class="open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['t']) && $_GET['t'] == "completed") {
                if (isset($completed) && count($completed) > 10) { ?>
                    <form class="info-bar">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                    <hr>
                    <form class="search-bar">
                        <div class="section">
                            <input type="text" name="id" class="input-id" placeholder="Enter №">
                            <input type="text" name="project" class="input-project" placeholder="Enter Project Name">
                            <div class="custom-select">
                                <select name="type" class="input-type" required>
                                    <option value="">All</option>
                                    <option value="Animated Video">Animated Video</option>
                                    <option value="TO BE FILLED">TO BE FILLED</option>
                                </select>
                            </div>
                            <input type="text" name="client" class="input-client" placeholder="Enter Client Name">
                            <button type="button" onclick="searchTable()" class="search-button"></button>
                        </div>
                        <div class="section">
                            <button type="button" class="filter-button">PRIORITIZE</button>
                            <button type="button" class="filter-button">FILTER OPTION 2</button>
                            <button type="button" class="filter-button">FILTER OPTION 3</button>
                            <button type="button" class="filter-button">FILTER OPTION 4</button>
                        </div>
                        <div class="section">
                            <button type="button" class="reset-button"></button>
                        </div>
                    </form> <?php
                }
                else { ?>
                    <form class="info-bar with-space">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                    <?php
                } ?>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head id">№</div>
                        <div class="head project">Project Name</div>
                        <div class="head type">Project Type</div>
                        <div class="head client">Client</div>
                        <div class="head start-date">Start Date</div>
                        <div class="head finish-date">Finish Date</div>
                        <div class="head completed-in">Completed In</div>
                        <div class="head value" onclick="sortTable('.head.value', '.cell.value a span')">Value</div>
                        <div class="head open">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($completed) {
                        foreach ($completed as $row) { ?>
                            <div class="row">
                                <div class="cell id"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "#" . sprintf('%04d', $row['id']); ?></a></div>
                                <div class="cell project"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></div>
                                <div class="cell type"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "TO BE FILLED"; ?></a></div>
                                <div class="cell client"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['client']; ?></a></div>
                                <div class="cell start-date"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "Date"; ?></a></div>
                                <div class="cell finish-date"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "Date"; ?></a></div>
                                <div class="cell completed-in"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "X"; ?> Days</a></div>
                                <div class="cell value"><a href="projects.php?p=<?php echo $row['id']; ?>">$<span><?php echo $row['price']; ?></span></a></div>
                                <div class="cell open"><a href="projects.php?p=<?php echo $row['id']; ?>" class="open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['t']) && $_GET['t'] == "canceled") {
                if (isset($canceled) && count($canceled) > 10) { ?>
                    <form class="info-bar">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                    <hr>
                    <form class="search-bar">
                        <div class="section">
                            <input type="text" name="id" class="input-id" placeholder="Enter №">
                            <input type="text" name="project" class="input-project" placeholder="Enter Project Name">
                            <div class="custom-select">
                                <select name="type" class="input-type" required>
                                    <option value="">All</option>
                                    <option value="Animated Video">Animated Video</option>
                                    <option value="TO BE FILLED">TO BE FILLED</option>
                                </select>
                            </div>
                            <input type="text" name="client" class="input-client" placeholder="Enter Client Name">
                            <button type="button" onclick="searchTable()" class="search-button"></button>
                        </div>
                        <div class="section">
                            <button type="button" class="filter-button">PRIORITIZE</button>
                            <button type="button" class="filter-button">FILTER OPTION 2</button>
                            <button type="button" class="filter-button">FILTER OPTION 3</button>
                            <button type="button" class="filter-button">FILTER OPTION 4</button>
                        </div>
                        <div class="section">
                            <button type="button" class="reset-button"></button>
                        </div>
                    </form> <?php
                }
                else { ?>
                    <form class="info-bar with-space">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                    <?php
                } ?>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head id">№</div>
                        <div class="head project">Project Name</div>
                        <div class="head type">Project Type</div>
                        <div class="head client">Client</div>
                        <div class="head cancellation-reason">Cancellation Reason</div>
                        <div class="head cancel-date">Cancel Date</div>
                        <div class="head value" onclick="sortTable('.head.value', '.cell.value a span')">Value</div>
                        <div class="head open">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($canceled) {
                        foreach ($canceled as $row) { ?>
                            <div class="row">
                                <div class="cell id"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "#" . sprintf('%04d', $row['id']); ?></a></div>
                                <div class="cell project"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></div>
                                <div class="cell type"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "TO BE FILLED"; ?></a></div>
                                <div class="cell client"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['client']; ?></a></div>
                                <div class="cell cancellation-reason"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "Whyyy?"; ?></a></div>
                                <div class="cell cancel-date"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "Date"; ?></a></div>
                                <div class="cell value"><a href="projects.php?p=<?php echo $row['id']; ?>">$<span><?php echo $row['price']; ?></span></a></div>
                                <div class="cell open"><a href="projects.php?p=<?php echo $row['id']; ?>" class="open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['t']) && $_GET['t'] == "admin") { ?>
                </div> <?php
            }
        }
        else {
            $projectData = $project->selectAdminProject();
            if (isset($project::$projectMenu) && isset($project::$projectMenu['level-1'])) { ?>
                <div class="navbar level-1<?php if (!isset($_GET['t'])) echo " unselected" ?>"> <?php
                foreach ($project::$projectMenu['level-1'] as $menuLvl1ItemName => $menuLvl1Item) {
                    if ($menuLvl1Item['locked'] || isset($_GET['preview']) && $menuLvl1ItemName != "INFO" && $menuLvl1ItemName != "PRODUCTION")
                        $locked = true;
                    else
                        $locked = false;
                    // maybe count here?
                    $href = "?p=" . $_GET['p'] . "&t=" . $menuLvl1Item['default-link'];
                    if (isset($_GET['preview']))
                        $href .= "&preview";
                    ?>

                    <div class="container-button">
                        <a<?php if (!$locked) { ?> href="<?php echo $href; ?>"<?php } ?> class="button<?php if ($menuLvl1Item['admin']) echo " admin-menu"; if (isset($_GET['t']) && $_GET['t'] == $menuLvl1Item['link']) echo " active-menu"; if ($locked) echo " locked"; ?>">
                            <span><?php echo $menuLvl1ItemName; ?></span> <?php
                            if ($locked) { ?>
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
                                    <a href="<?php echo "?p=" . $_GET['p'] . "&t=" . $menuLvl1Item['link']; ?>" class="enter-button"><?php echo $menuLvl1Item['home']['link']; ?></a>
                                    <span class="note"><?php echo $menuLvl1Item['home']['note']; ?></span>
                                </div>
                            </div> <?php
                        } ?>
                    </div> <?php
                } ?>
                </div> <?php
                if (isset($_GET['t'])) {
                    foreach ($project::$projectMenu['level-1'] as $menuLvl1Item) {
                        if ($_GET['t'] == $menuLvl1Item['link'] && isset($menuLvl1Item['level-2'])) { ?>
                            <div class="navbar level-2<?php if ($menuLvl1Item['admin']) echo " admin"; ?>"> <?php
                            foreach ($menuLvl1Item['level-2'] as $menuLvl2ItemName => $menuLvl2Item) {
                                if ($menuLvl2Item['locked'] || isset($_GET['preview']) && $menuLvl2ItemName != "OPERATIONS")
                                    $locked = true;
                                else
                                    $locked = false;
                                // maybe count here?
                                $href = "?p=" . $_GET['p'] . "&t=" . $_GET['t'] . "&m=" . $menuLvl2Item['default-link'];
                                if (isset($_GET['preview']))
                                    $href .= "&preview";
                                ?>

                                <div class="container-button">
                                    <a<?php if (!$locked) { ?> href="<?php echo $href; ?>"<?php } ?> class="button<?php if ($menuLvl2Item['admin']) echo " admin-menu"; if (isset($_GET['m']) && $_GET['m'] == $menuLvl2Item['link']) echo " active-menu"; if ($locked) echo " locked"; ?>">
                                        <span><?php echo $menuLvl2ItemName; ?></span> <?php
                                        if ($locked) { ?>
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
                                <div class="navbar level-3<?php if ($menuLvl2Item['admin']) echo " admin"; ?>"> <?php
                                foreach ($menuLvl3 as $menuLvl3ItemName => $menuLvl3Item) {
                                    if ($menuLvl3Item['locked'] || isset($_GET['preview']) && $menuLvl3ItemName != "COLORS")
                                        $locked = true;
                                    else
                                        $locked = false;
                                    // maybe count here?
                                    $href = "?p=" . $_GET['p'] . "&t=" . $_GET['t'] . "&m=" . $_GET['m'] . "&b=" . $menuLvl3Item['default-link'];
                                    if (isset($_GET['preview']))
                                        $href .= "&preview";
                                    ?>

                                    <div class="container-button">
                                        <a<?php if (!$locked) { ?> href="<?php echo $href; ?>"<?php } ?> class="button<?php if ($menuLvl3Item['admin']) echo " admin-menu"; if (isset($_GET['b']) && $_GET['b'] == $menuLvl3Item['link']) echo " active-menu"; if ($locked) echo " locked"; ?>">
                                            <span><?php echo $menuLvl3ItemName; ?></span> <?php
                                            if ($locked) { ?>
                                                <div class="lock"></div> <?php
                                            }
                                            elseif (isset($count[$menuLvl3ItemName])) { ?>
                                                <div class="count"><?php echo $count[$menuLvl3ItemName]; ?></div> <?php
                                            } ?>
                                        </a>
                                    </div> <?php
                                    if (isset($_GET['b']) && isset($menuLvl3Item['level-4']))
                                        if ($_GET['b'] == $menuLvl3Item['link'])
                                            $menuLvl4 = $menuLvl3Item['level-4'];
                                } ?>
                                </div> <?php
                                if (isset($_GET['b']) && isset($menuLvl4)) { ?>
                                    <div class="navbar level-4<?php if ($menuLvl3Item['admin']) echo " admin"; ?>"> <?php
                                        foreach ($menuLvl4 as $menuLvl4ItemName => $menuLvl4Item) {
                                            if ($menuLvl4Item['locked'] || isset($_GET['preview']) && $menuLvl4ItemName != "ASSIGNMENT")
                                                $locked = true;
                                            else
                                                $locked = false;
                                            // maybe count here?
                                            $href = "?p=" . $_GET['p'] . "&t=" . $_GET['t'] . "&m=" . $_GET['m'] . "&b=" . $_GET['b'] . "&x=" . $menuLvl4Item['default-link'];
                                            if (isset($_GET['preview']))
                                                $href .= "&preview";
                                            ?>

                                            <div class="container-button">
                                                <a<?php if (!$locked) { ?> href="<?php echo $href; ?>"<?php } ?> class="button<?php if ($menuLvl4Item['admin']) echo " admin-menu"; if (isset($_GET['x']) && $_GET['x'] == $menuLvl4Item['link']) echo " active-menu"; if ($locked) echo " locked"; ?>">
                                                    <span><?php echo $menuLvl4ItemName; ?></span> <?php
                                                    if ($locked) { ?>
                                                        <div class="lock"></div> <?php
                                                    }
                                                    elseif (isset($count[$menuLvl4ItemName])) { ?>
                                                        <div class="count"><?php echo $count[$menuLvl4ItemName]; ?></div> <?php
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
            } ?>
            </div> <?php
            if (isset($_GET['preview'])) { ?>
                <div class="decision-bar">
                    <div class="button">MAYBE LATER</div>
                    <div class="button">ACCEPT</div>
                    <div class="button">NOT INTERESTED</div>
                </div> <?php
            }
        }
    }
    elseif ($account->type == 2) { ?>
        <div class="menu">
        <div class="head-up-display-bar">
            <span><?php echo $project::getHeadUp(); ?></span>
        </div> <?php
        if (!isset($_GET['p'])) {
            if (isset($project::$menu) && isset($project::$menu['level-1'])) { ?>
                <div class="navbar level-1"> <?php
                    foreach ($project::$menu['level-1'] as $menuLvl1ItemName => $menuLvl1Item) { ?>
                        <div class="container-button">
                            <a href="<?php echo "?t=" . $menuLvl1Item['link']; ?>" class="button<?php if ($menuLvl1Item['admin']) echo " admin-menu"; if (isset($_GET['t']) && $_GET['t'] == $menuLvl1Item['link']) echo " active-menu"; ?>">
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
            }
            if (isset($_GET['t']) && $_GET['t'] == "active") { ?>
                <form class="info-bar<?php if (count($active) <= 10) echo " with-space"; ?>">
                    <div class="section">
                        <span>LAST</span>
                        <button type="button" class="hours-button">12h</button>
                        <button type="button" class="hours-button active">24h</button>
                        <button type="button" class="hours-button">48h</button>
                    </div>
                    <div class="section">
                        <span>NEW ADDED</span>
                        <div class="count">+15</div>
                    </div>
                    <div class="section">
                        <span>REACTIVATED</span>
                        <div class="count">+8</div>
                    </div>
                    <div class="spacer"></div>
                    <div class="section">
                        <div class="count total">100</div>
                        <span>TOTAL PROJECTS</span>
                    </div>
                </form> <?php
                if (count($active) > 10) { ?>
                    <hr>
                    <form class="search-bar">
                        <div class="section">
                            <input type="text" name="id" class="input-id" placeholder="Enter №">
                            <input type="text" name="project" class="input-project" placeholder="Enter Project Name">
                            <div class="custom-select">
                                <select name="type" class="input-type" required>
                                    <option value="">All</option>
                                    <option value="Animated Video">Animated Video</option>
                                    <option value="TO BE FILLED">TO BE FILLED</option>
                                </select>
                            </div>
                            <input type="text" name="client" class="input-client" placeholder="Enter Client Name">
                            <button type="button" onclick="searchTable()" class="search-button"></button>
                        </div>
                        <div class="section">
                            <button type="button" class="filter-button">PRIORITIZE</button>
                            <button type="button" class="filter-button">FILTER OPTION 2</button>
                            <button type="button" class="filter-button">FILTER OPTION 3</button>
                            <button type="button" class="filter-button">FILTER OPTION 4</button>
                        </div>
                        <div class="section">
                            <button type="button" class="reset-button"></button>
                        </div>
                    </form> <?php
                } ?>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head id">№</div>
                        <div class="head project">Project</div>
                        <div class="head type">Type</div>
                        <div class="head client">Client</div>
                        <div class="head progress">Oper.</div>
                        <div class="head progress">Res.</div>
                        <div class="head progress">Vis.</div>
                        <div class="head progress">Creat.</div>
                        <div class="head progress">Des.</div>
                        <div class="head progress">Anim.</div>
                        <div class="head progress">Aud.</div>
                        <div class="head progress">Ext.</div>
                        <div class="head progress">Enha.</div>
                        <div class="head progress">Appr.</div>
                        <div class="head deadline" onclick="sortTable('.head.deadline', '.cell.deadline a b')">Deadline In</div>
                        <div class="head price" onclick="sortTable('.head.price', '.cell.price a strong')">Price</div>
                        <div class="head open">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($active) {
                        foreach ($active as $row) { ?>
                            <div class="row">
                                <div class="cell id"><a href="<?php echo $_SERVER['PHP_SELF'] . "?p=" . $row['id']; ?>"><?php echo "#" . sprintf('%04d', $row['id']); ?></a></div>
                                <div class="cell project"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></div>
                                <div class="cell type"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "TO BE FILLED"; ?></a></div>
                                <div class="cell client"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['client']; ?></a></div>
                                <div class="cell progress"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "0/5"; ?></a></div>
                                <div class="cell progress"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "0/5"; ?></a></div>
                                <div class="cell progress"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "0/5"; ?></a></div>
                                <div class="cell progress"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "0/5"; ?></a></div>
                                <div class="cell progress"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "0/5"; ?></a></div>
                                <div class="cell progress"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "0/5"; ?></a></div>
                                <div class="cell progress"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "0/5"; ?></a></div>
                                <div class="cell progress"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "0/5"; ?></a></div>
                                <div class="cell progress"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "0/5"; ?></a></div>
                                <div class="cell progress"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "0/5"; ?></a></div>
                                <div class="cell deadline"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['days_left']; ?> Days</a></div>
                                <div class="cell price"><a href="projects.php?p=<?php echo $row['id']; ?>">$<span><?php echo $row['price']; ?></span></a></div>
                                <div class="cell open"><a href="projects.php?p=<?php echo $row['id']; ?>" class="open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['t']) && $_GET['t'] == "pending") {
                if (count($pending) > 10) { ?>
                    <form class="info-bar">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                    <hr>
                    <form class="search-bar">
                        <div class="section">
                            <input type="text" name="id" class="input-id" placeholder="Enter №">
                            <input type="text" name="project" class="input-project" placeholder="Enter Project Name">
                            <div class="custom-select">
                                <select name="type" class="input-type" required>
                                    <option value="">All</option>
                                    <option value="Animated Video">Animated Video</option>
                                    <option value="TO BE FILLED">TO BE FILLED</option>
                                </select>
                            </div>
                            <input type="text" name="client" class="input-client" placeholder="Enter Client Name">
                            <button type="button" onclick="searchTable()" class="search-button"></button>
                        </div>
                        <div class="section">
                            <button type="button" class="filter-button">PRIORITIZE</button>
                            <button type="button" class="filter-button">FILTER OPTION 2</button>
                            <button type="button" class="filter-button">FILTER OPTION 3</button>
                            <button type="button" class="filter-button">FILTER OPTION 4</button>
                        </div>
                        <div class="section">
                            <button type="button" class="reset-button"></button>
                        </div>
                    </form> <?php
                }
                else { ?>
                    <form class="info-bar with-space">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                    <?php
                } ?>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head id">№</div>
                        <div class="head project">Project</div>
                        <div class="head type">Type</div>
                        <div class="head client">Client</div>
                        <div class="head pending-for">Pending For</div>
                        <div class="head pending-reason">Pending Reason</div>
                        <div class="head deadline" onclick="sortTable('.head.deadline', '.cell.deadline a b')">Deadline In</div>
                        <div class="head price" onclick="sortTable('.head.price', '.cell.price a strong')">Price</div>
                        <div class="head open">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($pending) {
                        foreach ($pending as $row) { ?>
                            <div class="row">
                                <div class="cell id"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "#" . sprintf('%04d', $row['id']); ?></a></div>
                                <div class="cell project"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></div>
                                <div class="cell type"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "TO BE FILLED"; ?></a></div>
                                <div class="cell client"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['client']; ?></a></div>
                                <div class="cell pending-for"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "X Days"; ?></a></div>
                                <div class="cell pending-reason"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "Whyyy?"; ?></a></div>
                                <div class="cell deadline"><a href="projects.php?p=<?php echo $row['id']; ?>"><b><?php echo $row['days_left']; ?></b> Days</a></div>
                                <div class="cell price"><a href="projects.php?p=<?php echo $row['id']; ?>">$<span><?php echo $row['price']; ?></span></a></div>
                                <div class="cell open"><a href="projects.php?p=<?php echo $row['id']; ?>" class="open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['t']) && $_GET['t'] == "completed") {
                if (count($completed) > 10) { ?>
                    <form class="info-bar">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                    <hr>
                    <form class="search-bar">
                        <div class="section">
                            <input type="text" name="id" class="input-id" placeholder="Enter №">
                            <input type="text" name="project" class="input-project" placeholder="Enter Project Name">
                            <div class="custom-select">
                                <select name="type" class="input-type" required>
                                    <option value="">All</option>
                                    <option value="Animated Video">Animated Video</option>
                                    <option value="TO BE FILLED">TO BE FILLED</option>
                                </select>
                            </div>
                            <input type="text" name="client" class="input-client" placeholder="Enter Client Name">
                            <button type="button" onclick="searchTable()" class="search-button"></button>
                        </div>
                        <div class="section">
                            <button type="button" class="filter-button">PRIORITIZE</button>
                            <button type="button" class="filter-button">FILTER OPTION 2</button>
                            <button type="button" class="filter-button">FILTER OPTION 3</button>
                            <button type="button" class="filter-button">FILTER OPTION 4</button>
                        </div>
                        <div class="section">
                            <button type="button" class="reset-button"></button>
                        </div>
                    </form> <?php
                }
                else { ?>
                    <form class="info-bar with-space">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                    <?php
                } ?>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head id">№</div>
                        <div class="head project">Project</div>
                        <div class="head type">Type</div>
                        <div class="head client">Client</div>
                        <div class="head start-date">Start Date</div>
                        <div class="head finish-date">Finish Date</div>
                        <div class="head completed-in">Completed In</div>
                        <div class="head price" onclick="sortTable('.head.price', '.cell.price a span')">Price</div>
                        <div class="head open">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($completed) {
                        foreach ($completed as $row) { ?>
                            <div class="row">
                                <div class="cell id"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "#" . sprintf('%04d', $row['id']); ?></a></div>
                                <div class="cell project"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></div>
                                <div class="cell type"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "TO BE FILLED"; ?></a></div>
                                <div class="cell client"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['client']; ?></a></div>
                                <div class="cell start-date"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "Date"; ?></a></div>
                                <div class="cell finish-date"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "Date"; ?></a></div>
                                <div class="cell completed-in"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "X"; ?> Days</a></div>
                                <div class="cell price"><a href="projects.php?p=<?php echo $row['id']; ?>">$<span><?php echo $row['price']; ?></span></a></div>
                                <div class="cell open"><a href="projects.php?p=<?php echo $row['id']; ?>" class="open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
            elseif (isset($_GET['t']) && $_GET['t'] == "canceled") {
                if (count($canceled) > 10) { ?>
                    <form class="info-bar">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                    <hr>
                    <form class="search-bar">
                        <div class="section">
                            <input type="text" name="id" class="input-id" placeholder="Enter №">
                            <input type="text" name="project" class="input-project" placeholder="Enter Project Name">
                            <div class="custom-select">
                                <select name="type" class="input-type" required>
                                    <option value="">All</option>
                                    <option value="Animated Video">Animated Video</option>
                                    <option value="TO BE FILLED">TO BE FILLED</option>
                                </select>
                            </div>
                            <input type="text" name="client" class="input-client" placeholder="Enter Client Name">
                            <button type="button" onclick="searchTable()" class="search-button"></button>
                        </div>
                        <div class="section">
                            <button type="button" class="filter-button">PRIORITIZE</button>
                            <button type="button" class="filter-button">FILTER OPTION 2</button>
                            <button type="button" class="filter-button">FILTER OPTION 3</button>
                            <button type="button" class="filter-button">FILTER OPTION 4</button>
                        </div>
                        <div class="section">
                            <button type="button" class="reset-button"></button>
                        </div>
                    </form> <?php
                }
                else { ?>
                    <form class="info-bar with-space">
                        <div class="section">
                            <span>LAST</span>
                            <button type="button" class="hours-button">12h</button>
                            <button type="button" class="hours-button active">24h</button>
                            <button type="button" class="hours-button">48h</button>
                        </div>
                        <div class="section">
                            <span>NEW ADDED</span>
                            <div class="count">+15</div>
                        </div>
                        <div class="section">
                            <span>REACTIVATED</span>
                            <div class="count">+8</div>
                        </div>
                        <div class="spacer"></div>
                        <div class="section">
                            <div class="count total">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                    </form>
                    <?php
                } ?>
                <div class="table-header-container">
                    <div class="header-extension"></div>
                    <div class="header">
                        <div class="head id">№</div>
                        <div class="head project">Project</div>
                        <div class="head type">Type</div>
                        <div class="head client">Client</div>
                        <div class="head cancellation-reason">Cancellation Reason</div>
                        <div class="head cancel-date">Cancel Date</div>
                        <div class="head price" onclick="sortTable('.head.price', '.cell.price a span')">Price</div>
                        <div class="head open">Open</div>
                    </div>
                    <div class="header-extension"></div>
                </div>
                </div>
                <div class="table"> <?php
                    if ($canceled) {
                        foreach ($canceled as $row) { ?>
                            <div class="row">
                                <div class="cell id"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "#" . sprintf('%04d', $row['id']); ?></a></div>
                                <div class="cell project"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></div>
                                <div class="cell type"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "TO BE FILLED"; ?></a></div>
                                <div class="cell client"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['client']; ?></a></div>
                                <div class="cell cancellation-reason"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "Whyyy?"; ?></a></div>
                                <div class="cell cancel-date"><a href="projects.php?p=<?php echo $row['id']; ?>"><?php echo "Date"; ?></a></div>
                                <div class="cell price"><a href="projects.php?p=<?php echo $row['id']; ?>">$<span><?php echo $row['price']; ?></span></a></div>
                                <div class="cell open"><a href="projects.php?p=<?php echo $row['id']; ?>" class="open-button">Open</a></div>
                            </div> <?php
                        }
                    } ?>
                </div> <?php
            }
        }
        else {
            $projectData = $project->selectAdminProject();
            if (isset($project::$projectMenu) && isset($project::$projectMenu['level-1'])) { ?>
                <div class="navbar level-1"> <?php
                    foreach ($project::$projectMenu['level-1'] as $menuLvl1ItemName => $menuLvl1Item) { ?>
                        <div class="container-button">
                            <a href="<?php echo "?p=" . $_GET['p'] . "&t=" . $menuLvl1Item['default-link']; ?>" class="button<?php if ($menuLvl1Item['admin']) echo " admin-menu"; if (isset($_GET['t']) && $_GET['t'] == $menuLvl1Item['link']) echo " active-menu"; ?>">
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
                                        <a href="<?php echo "?p=" . $_GET['p'] . "&t=" . $menuLvl1Item['link']; ?>" class="enter-button"><?php echo $menuLvl1Item['home']['link']; ?></a>
                                        <span class="note"><?php echo $menuLvl1Item['home']['note']; ?></span>
                                    </div>
                                </div> <?php
                            } ?>
                        </div> <?php
                    } ?>
                </div> <?php
                if (isset($_GET['t'])) {
                    foreach ($project::$projectMenu['level-1'] as $menuLvl1Item) {
                        if ($_GET['t'] == $menuLvl1Item['link'] && isset($menuLvl1Item['level-2'])) { ?>
                            <div class="navbar level-2"> <?php
                                foreach ($menuLvl1Item['level-2'] as $menuLvl2ItemName => $menuLvl2Item) { ?>
                                    <div class="container-button">
                                        <a href="<?php echo "?p=" . $_GET['p'] . "&t=" . $_GET['t'] . "&m=" . $menuLvl2Item['default-link']; ?>" class="button<?php if ($menuLvl2Item['admin']) echo " admin-menu"; if (isset($_GET['m']) && $_GET['m'] == $menuLvl2Item['link']) echo " active-menu"; ?>">
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
                                        if ($_GET['m'] == $menuLvl2Item['link'])
                                            $menuLvl3 = $menuLvl2Item['level-3'];
                                } ?>
                            </div> <?php
                            if (isset($_GET['m']) && isset($menuLvl3)) { ?>
                                <div class="navbar level-3"> <?php
                                    foreach ($menuLvl3 as $menuLvl3ItemName => $menuLvl3Item) { ?>
                                        <div class="container-button">
                                            <a href="<?php echo "?p=" . $_GET['p'] . "&t=" . $_GET['t'] . "&m=" . $_GET['m'] . "&b=" . $menuLvl3Item['default-link']; ?>" class="button<?php if ($menuLvl3Item['admin']) echo " admin-menu"; if (isset($_GET['b']) && $_GET['b'] == $menuLvl3Item['link']) echo " active-menu"; ?>">
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
                if (isset($_GET['b']) && $_GET['b'] == "colors") { ?>
                    <div class="navbar level-4">
                        <div class="container-button">
                            <a href="<?php echo "?p=" . $_GET['p'] . "&t=" . $_GET['t'] . "&m=" . $_GET['m'] . "&b=" . $_GET['b'] . "&x=assignment"; ?>" class="button<?php if (isset($_GET['x']) && $_GET['x'] == "assignment") echo " active-menu"; ?>">
                                <span>Assignment</span>
                            </a>
                        </div>
                        <div class="container-button">
                            <a href="<?php echo "?p=" . $_GET['p'] . "&t=" . $_GET['t'] . "&m=" . $_GET['m'] . "&b=" . $_GET['b'] . "&x=task-1"; ?>" class="button<?php if (isset($_GET['x']) && $_GET['x'] == "task-1") echo " active-menu"; ?>">
                                <span>Task #1</span>
                            </a>
                        </div>
                        <div class="container-button">
                            <a href="<?php echo "?p=" . $_GET['p'] . "&t=" . $_GET['t'] . "&m=" . $_GET['m'] . "&b=" . $_GET['b'] . "&x=task-2"; ?>" class="button<?php if (isset($_GET['x']) && $_GET['x'] == "task-2") echo " active-menu"; ?>">
                                <span>Task #2</span>
                            </a>
                        </div>
                        <div class="container-button">
                            <a href="<?php echo "?p=" . $_GET['p'] . "&t=" . $_GET['t'] . "&m=" . $_GET['m'] . "&b=" . $_GET['b'] . "&x=task-3"; ?>" class="button<?php if (isset($_GET['x']) && $_GET['x'] == "task-3") echo " active-menu"; ?>">
                                <span>Task #3</span>
                            </a>
                        </div>
                        <div class="container-button">
                            <a href="<?php echo "?p=" . $_GET['p'] . "&t=" . $_GET['t'] . "&m=" . $_GET['m'] . "&b=" . $_GET['b'] . "&x=task-4"; ?>" class="button<?php if (isset($_GET['x']) && $_GET['x'] == "task-4") echo " active-menu"; ?>">
                                <span>Task #4</span>
                            </a>
                        </div>
                        <div class="container-button">
                            <a href="<?php echo "?p=" . $_GET['p'] . "&t=" . $_GET['t'] . "&m=" . $_GET['m'] . "&b=" . $_GET['b'] . "&x=task-5"; ?>" class="button<?php if (isset($_GET['x']) && $_GET['x'] == "task-5") echo " active-menu"; ?>">
                                <span>Task #5</span>
                            </a>
                        </div>
                    </div> <?php
                }
            } ?>
            </div> <?php
        }
    }
    require_once "includes/footer.php";
}
else require_once "login.php";