<?php
$page = "old";
include "../includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "_header.php";
    $project = new Project(); ?>
    <div class="container-fluid text-center">
        <div class="row"> <?php
            // List of all projects
            if (!isset($_GET['p'])) {
                if (!isset($_GET['t']) || $_GET['t'] == "active") { ?>
                    <!-- Active projects -->
                    <div class="col-lg-12">
                        <div class="jumbotron table-responsive py-3">
                            <a class="btn btn-primary btn-lg" href="_projects.php?t=active" role="button">Active</a>
                            <a class="btn btn-primary btn-lg" href="_projects.php?t=pending" role="button">Pending</a>
                            <a class="btn btn-primary btn-lg" href="_projects.php?t=recent" role="button">Recent</a>
                            <h1 class="mb-4">Active Projects</h1>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Status Date</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Price</th>
                                </tr>
                                </thead>
                                <tbody> <?php
                                $rows = $project->selectAdminActiveProjectList();
                                if ($rows) {
                                    foreach ($rows as $row) { ?>
                                        <tr>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['status_name']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['date']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['days_left']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['client']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['platform_name']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['price'] . "$"; ?></a></td>
                                        </tr> <?php
                                    }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <?php
                }
                elseif ($_GET['t'] == "pending") { ?>
                    <!-- Pending projects -->
                    <div class="col-lg-12">
                        <div class="jumbotron table-responsive py-3">
                            <a class="btn btn-primary btn-lg" href="_projects.php?t=active" role="button">Active</a>
                            <a class="btn btn-primary btn-lg" href="_projects.php?t=pending" role="button">Pending</a>
                            <a class="btn btn-primary btn-lg" href="_projects.php?t=recent" role="button">Recent</a>
                            <h1 class="mb-4">Pending Projects</h1>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Status Date</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Price</th>
                                </tr>
                                </thead>
                                <tbody> <?php
                                $rows = $project->selectAdminPendingProjectList();
                                if ($rows) {
                                    foreach ($rows as $row) { ?>
                                        <tr>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['status_name']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['date']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['days_left']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['client']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['platform_name']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['price'] . "$"; ?></a></td>
                                        </tr> <?php
                                    }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <?php
                }
                elseif ($_GET['t'] == "recent") { ?>
                    <!-- Recent projects -->
                    <div class="col-lg-12">
                        <div class="jumbotron table-responsive py-3">
                            <a class="btn btn-primary btn-lg" href="_projects.php?t=active" role="button">Active</a>
                            <a class="btn btn-primary btn-lg" href="_projects.php?t=pending" role="button">Pending</a>
                            <a class="btn btn-primary btn-lg" href="_projects.php?t=recent" role="button">Recent</a>
                            <h1 class="mb-4">Recent Projects</h1>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Status Date</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Price</th>
                                </tr>
                                </thead>
                                <tbody> <?php
                                $rows = $project->selectAdminRecentProjectList();
                                if ($rows) {
                                    foreach ($rows as $row) { ?>
                                        <tr>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['status_name']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['date']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['days_left']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['client']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['platform_name']; ?></a></td>
                                            <td class="admin"><a href="_projects.php?p=<?php echo $row['id']; ?>"><?php echo $row['price'] . "$"; ?></a></td>
                                        </tr> <?php
                                    }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <?php
                }
            }
            // Selected project
            else {
                $projectData = $project->selectAdminProject();
                if ($projectData) {
                    $projectDrawings = $project->selectAdminProjectDrawingList();
                    $projectAudio = $project->selectAdminProjectAudioList();
                    $projectVisualScript = $project->selectAdminProjectVisualScript();
                    $projectVoiceoverScript = $project->selectAdminProjectVoiceoverScript();
                    $projectVoiceover = $project->selectAdminProjectVoiceover(); ?>
                    <div class="col-lg-12">
                        <div class="jumbotron py-3">
                            <h1><?php echo $projectData[0]['title']; ?></h1>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="jumbotron py-3">
                            <h4 class="mb-4">Project</h4>
                            <ul class="list-group">
                                <li class="list-group-item">Title: <?php echo $projectData[0]['title']; ?></li>
                                <li class="list-group-item">Platform: <?php echo $projectData[0]['platform_name']; ?></li>
                                <li class="list-group-item">Status: <?php echo $projectData[0]['status_name']; ?></li>
                                <li class="list-group-item">Deadline: <?php echo $projectData[0]['date']; ?></li>
                                <li class="list-group-item">Price: <?php echo $projectData[0]['price'] . "$"; ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="jumbotron py-3">
                            <h4 class="mb-4">Client</h4>
                            <ul class="list-group">
                                <li class="list-group-item">Client: <?php echo $projectData[0]['username']; ?></li>
                                <li class="list-group-item">Country: <?php echo $projectData[0]['country']; ?></li>
                                <li class="list-group-item">Platform: <?php echo $projectData[0]['platform_name']; ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="jumbotron table-responsive py-3">
                            <h4 class="mb-4">Project Files</h4>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th scope="col">Type</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody> <?php
                                if ($projectVoiceoverScript) {
                                    foreach ($projectVoiceoverScript as $voiceoverScript) { ?>
                                        <tr>
                                            <td class="admin"><a href="<?php echo $voiceoverScript['path']; ?>" target="_blank">Voiceover Script</a></td>
                                            <td class="admin"><a href="<?php echo $voiceoverScript['path']; ?>" target="_blank"><?php echo $voiceoverScript['username']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $voiceoverScript['path']; ?>" target="_blank"><?php echo $voiceoverScript['price'] . "$"; ?></a></td>
                                            <td class="admin"><a href="<?php echo $voiceoverScript['path']; ?>" target="_blank"><?php echo $voiceoverScript['status_name']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $voiceoverScript['path']; ?>" target="_blank"><?php echo $voiceoverScript['date']; ?></a></td>
                                        </tr> <?php
                                    }
                                }
                                if ($projectVisualScript) {
                                    foreach ($projectVisualScript as $visualScript) { ?>
                                        <tr>
                                            <td class="admin"><a href="<?php echo $visualScript['path']; ?>" target="_blank">Visual Script</a></td>
                                            <td class="admin"><a href="<?php echo $visualScript['path']; ?>" target="_blank"><?php echo $visualScript['username']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $visualScript['path']; ?>" target="_blank"><?php echo $visualScript['price']. "$"; ?></a></td>
                                            <td class="admin"><a href="<?php echo $visualScript['path']; ?>" target="_blank"><?php echo $visualScript['status_name']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $visualScript['path']; ?>" target="_blank"><?php echo $visualScript['date']; ?></a></td>
                                        </tr> <?php
                                    }
                                }
                                if ($projectVoiceover) {
                                    foreach ($projectVoiceover as $voiceover) { ?>
                                        <tr>
                                            <td class="admin"><a href="<?php echo $voiceover['path']; ?>" target="_blank">Voiceover</a></td>
                                            <td class="admin"><a href="<?php echo $voiceover['path']; ?>" target="_blank"><?php echo $voiceover['username']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $voiceover['path']; ?>" target="_blank"><?php echo $voiceover['price']. "$"; ?></a></td>
                                            <td class="admin"><a href="<?php echo $voiceover['path']; ?>" target="_blank"><?php echo $voiceover['status_name']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $voiceover['path']; ?>" target="_blank"><?php echo $voiceover['date']; ?></a></td>
                                        </tr> <?php
                                    }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="jumbotron table-responsive py-3">
                            <h4 class="mb-4">Audio</h4>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Type</th>
                                </tr>
                                </thead>
                                <tbody> <?php
                                if ($projectAudio) {
                                    foreach ($projectAudio as $audio) { ?>
                                        <tr>
                                            <td class="admin"><a href="<?php echo $audio['path']; ?>" target="_blank"><?php echo $audio['title']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $audio['path']; ?>" target="_blank"><?php echo $audio['type_name']; ?></a></td>
                                        </tr> <?php
                                    }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="jumbotron table-responsive py-3">
                            <h4 class="mb-4">Drawings</h4>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody> <?php
                                if ($projectDrawings) {
                                    foreach ($projectDrawings as $drawing) { ?>
                                        <tr>
                                            <td class="admin"><a href="<?php echo $drawing['path_file']; ?>" target="_blank"><?php echo $drawing['title']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $drawing['path_file']; ?>" target="_blank"><?php echo $drawing['type_name']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $drawing['path_file']; ?>" target="_blank"><?php echo $drawing['username']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $drawing['path_file']; ?>" target="_blank"><?php echo $drawing['price'] . "$"; ?></a></td>
                                            <td class="admin"><a href="<?php echo $drawing['path_file']; ?>" target="_blank"><?php echo $drawing['status_name']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $drawing['path_file']; ?>" target="_blank"><?php echo $drawing['date']; ?></a></td>
                                        </tr> <?php
                                    }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <?php
                }
            } ?>
        </div>
    </div> <?php
    require_once "_footer.php";
}
else require_once "login.php";