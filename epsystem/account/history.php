<?php
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php";
    $drawingObj = new Drawing();
    $projectObj = new Project(); ?>
    <div class="container-fluid text-center">
        <div class="row"> <?php
            if (!isset($_GET['d']) && !isset($_GET['p'])) {
                if (!isset($_GET['t']) || $_GET['t'] == "projects") {
                    $projects = $projectObj->selectAdminPastProjectList();
                    if ($projects) { ?>
                        <div class="col-lg-12">
                            <div class="jumbotron table-responsive py-3">
                                <a class="btn btn-primary btn-lg" href="history.php?t=projects" role="button">Projects</a>
                                <a class="btn btn-primary btn-lg" href="history.php?t=drawings" role="button">Drawings</a>
                                <h1 class="mb-4">Project History</h1>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Status Date</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Platform</th>
                                        <th scope="col">Price</th>
                                    </tr>
                                    </thead>
                                    <tbody> <?php
                                    foreach ($projects as $project) { ?>
                                        <tr>
                                            <td class="admin"><a href="history.php?p=<?php echo $project['id']; ?>"><?php echo $project['title']; ?></a></td>
                                            <td class="admin"><a href="history.php?p=<?php echo $project['id']; ?>"><?php echo $project['status_name']; ?></a></td>
                                            <td class="admin"><a href="history.php?p=<?php echo $project['id']; ?>"><?php echo $project['date']; ?></a></td>
                                            <td class="admin"><a href="history.php?p=<?php echo $project['id']; ?>"><?php echo $project['client']; ?></a></td>
                                            <td class="admin"><a href="history.php?p=<?php echo $project['id']; ?>"><?php echo $project['platform_name']; ?></a></td>
                                            <td class="admin"><a href="history.php?p=<?php echo $project['id']; ?>"><?php echo $project['price'] . "$"; ?></a></td>
                                        </tr> <?php
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <?php
                    }
                }
                elseif ($_GET['t'] == "drawings") {
                    $drawings = $drawingObj->selectAdminPastDrawingList();
                    if ($drawings) { ?>
                        <div class="col-lg-12">
                            <div class="jumbotron table-responsive py-3">
                                <a class="btn btn-primary btn-lg" href="history.php?t=projects" role="button">Projects</a>
                                <a class="btn btn-primary btn-lg" href="history.php?t=drawings" role="button">Drawings</a>
                                <h1 class="mb-4">Drawing History</h1>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Complexity</th>
                                        <th scope="col">Project</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Price</th>
                                    </tr>
                                    </thead>
                                    <tbody> <?php
                                    foreach ($drawings as $drawing) { ?>
                                        <tr>
                                            <td class="admin"><a href="history.php?d=<?php echo $drawing['id']; ?>"><?php echo $drawing['title_rev']; ?></a></td>
                                            <td class="admin"><a href="history.php?d=<?php echo $drawing['id']; ?>"><?php echo $drawing['type_name']; ?></a></td>
                                            <td class="admin"><a href="history.php?d=<?php echo $drawing['id']; ?>"><?php echo $drawing['complexity']; ?></a></td>
                                            <td class="admin"><a href="history.php?d=<?php echo $drawing['id']; ?>"><?php echo $drawing['project']; ?></a></td>
                                            <td class="admin"><a href="history.php?d=<?php echo $drawing['id']; ?>"><?php echo $drawing['date']; ?></a></td>
                                            <td class="admin"><a href="history.php?d=<?php echo $drawing['id']; ?>"><?php echo $drawing['price'] . "$"; ?></a></td>
                                        </tr> <?php
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <?php
                    }
                }
            }
            elseif (isset($_GET['d']) && !isset($_GET['p'])) {
                $drawing = $drawingObj->selectArtistCompletedDrawing(); ?>
                <div class="col-lg-12">
                    <div class="jumbotron pt-5">
                        <h4 class="mb-4"><?php echo $drawing[0]['title']; ?></h4>
                        <div class="row">
                            <div class="col-lg-6 pb-3">
                                <iframe src="<?php echo $drawing[0]['path_file'] . "preview"; ?>" width="100%" height="367"></iframe>
                            </div>
                            <div class="col-lg-6 pb-3">
                                <h4 class="my-3">Details</h4>
                                <ul class="list-group">
                                    <li class="list-group-item">Type: <?php echo $drawing[0]['type_name']; ?></li>
                                    <li class="list-group-item">Complexity: <?php echo $drawing[0]['complexity']; ?></li>
                                    <li class="list-group-item">Tags: <?php echo $drawing[0]['tags']; ?></li>
                                    <li class="list-group-item">Price: <?php echo $drawing[0]['price']; ?></li>
                                </ul> <?php
                                if ($drawing[0]['revision']) { ?>
                                    <h4 class="my-3">Revision</h4>
                                    <ul class="list-group">
                                    <li class="list-group-item">Revision: <?php echo $drawing[0]['revision']; ?></li>
                                    <li class="list-group-item">Comment: <?php echo $drawing[0]['comment']; ?></li>
                                    </ul><?php
                                } ?>
                                <h4 class="my-3">Author</h4>
                                <ul class="list-group">
                                    <li class="list-group-item">Artist: <?php echo $drawing[0]['username']; ?></li>
                                    <li class="list-group-item">Qualification: <?php echo $drawing[0]['qualification']; ?></li>
                                </ul> <?php
                                if ($drawing[0]['project']) { ?>
                                    <h4 class="my-3">Project</h4>
                                    <ul class="list-group">
                                        <li class="list-group-item">Title: <?php echo $drawing[0]['project']; ?></li>
                                        <li class="list-group-item">Deadline: <?php echo $drawing[0]['deadline2']; ?></li>
                                    </ul> <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </div> <?php
            }
            elseif (!isset($_GET['d']) && isset($_GET['p'])) {
                $projectData = $projectObj->selectAdminProject();
                if ($projectData) {
                    $drawings = $projectObj->selectAdminProjectDrawingList();
                    $audio = $projectObj->selectAdminProjectAudioList();
                    $visualScripts = $projectObj->selectAdminProjectVisualScript();
                    $voiceoverScripts = $projectObj->selectAdminProjectVoiceoverScript();
                    $voiceovers = $projectObj->selectAdminProjectVoiceover(); ?>
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
                            <h4 class="mb-4">Scripts and Voiceovers</h4>
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
                                if ($voiceoverScripts) {
                                    foreach ($voiceoverScripts as $script) { ?>
                                        <tr>
                                            <td class="admin"><a href="<?php echo $script['path']; ?>" target="_blank">Voiceover Script</a></td>
                                            <td class="admin"><a href="<?php echo $script['path']; ?>" target="_blank"><?php echo $script['username']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $script['path']; ?>" target="_blank"><?php echo $script['price'] . "$"; ?></a></td>
                                            <td class="admin"><a href="<?php echo $script['path']; ?>" target="_blank"><?php echo $script['status_name']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $script['path']; ?>" target="_blank"><?php echo $script['date']; ?></a></td>
                                        </tr> <?php
                                    }
                                }
                                if ($visualScripts) {
                                    foreach ($visualScripts as $script) { ?>
                                        <tr>
                                            <td class="admin"><a href="<?php echo $script['path']; ?>" target="_blank">Visual Script</a></td>
                                            <td class="admin"><a href="<?php echo $script['path']; ?>" target="_blank"><?php echo $script['username']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $script['path']; ?>" target="_blank"><?php echo $script['price']. "$"; ?></a></td>
                                            <td class="admin"><a href="<?php echo $script['path']; ?>" target="_blank"><?php echo $script['status_name']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $script['path']; ?>" target="_blank"><?php echo $script['date']; ?></a></td>
                                        </tr> <?php
                                    }
                                }
                                if ($voiceovers) {
                                    foreach ($voiceovers as $voiceover) { ?>
                                        <tr>
                                            <td class="admin"><a href="<?php echo $voiceover['path']; ?>" target="_blank">Voiceover</a></td>
                                            <td class="admin"><a href="<?php echo $voiceover['path']; ?>" target="_blank"><?php echo $voiceover['username']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $script['path']; ?>" target="_blank"><?php echo $script['price']. "$"; ?></a></td>
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
                                if ($audio) {
                                    foreach ($audio as $aud) { ?>
                                        <tr>
                                            <td class="admin"><a href="<?php echo $aud['path']; ?>" target="_blank"><?php echo $aud['title']; ?></a></td>
                                            <td class="admin"><a href="<?php echo $aud['path']; ?>" target="_blank"><?php echo $aud['type_name']; ?></a></td>
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
                                if ($drawings) {
                                    foreach ($drawings as $drawing) { ?>
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
    require_once "includes/_footer.php";
}
elseif ($account->types['artist']['bool'] == true && $account->currentType == 'artist') {
    require_once "includes/header_artist.php";
    $drawing = new Drawing(); ?>
    <div class="container-fluid text-center">
        <div class="row"> <?php
            if (!isset($_GET['d'])) {
                $rows = $drawing->selectArtistCompletedDrawingList($account->id);
                if ($rows) { ?>
                    <div class="col-lg-12">
                        <div class="jumbotron table-responsive py-3">
                            <h1 class="mb-4">History</h1>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Complexity</th>
                                    <th scope="col">Project</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Price</th>
                                </tr>
                                </thead>
                                <tbody> <?php
                                foreach ($rows as $row) { ?>
                                    <tr>
                                        <td class="artist"><a href="history.php?d=<?php echo $row['id']; ?>"><?php echo $row['title_rev']; ?></a></td>
                                        <td class="artist"><a href="history.php?d=<?php echo $row['id']; ?>"><?php echo $row['type_name']; ?></a></td>
                                        <td class="artist"><a href="history.php?d=<?php echo $row['id']; ?>"><?php echo $row['complexity']; ?></a></td>
                                        <td class="artist"><a href="history.php?d=<?php echo $row['id']; ?>"><?php echo $row['project']; ?></a></td>
                                        <td class="artist"><a href="history.php?d=<?php echo $row['id']; ?>"><?php echo $row['date']; ?></a></td>
                                        <td class="artist"><a href="history.php?d=<?php echo $row['id']; ?>"><?php echo $row['price'] . "$"; ?></a></td>
                                    </tr> <?php
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <?php
                }
            }
            else {
                $rows = $drawing->selectArtistCompletedDrawing();
                if ($rows) { ?>
                    <div class="container-header text-center">
                        <div class="col-lg-12">
                            <div class="jumbotron pt-5">
                                <h4 class="mb-4"><?php echo $rows[0]['title']; ?></h4>
                                <div class="row">
                                    <div class="col-lg-6 pb-3">
                                        <iframe src="<?php echo $rows[0]['path_preview']; ?>" width="100%" height="367"></iframe>
                                    </div>
                                    <div class="col-lg-6 pb-3">
                                        <h4 class="my-3">Details</h4>
                                        <ul class="list-group">
                                            <li class="list-group-item">Type: <?php echo $rows[0]['type_name']; ?></li>
                                            <li class="list-group-item">Complexity: <?php echo $rows[0]['complexity']; ?></li>
                                            <li class="list-group-item">Tags: <?php echo $rows[0]['tags']; ?></li>
                                            <li class="list-group-item">Price: <?php echo $rows[0]['price'] . "$"; ?></li>
                                            <li class="list-group-item">Project: <?php echo $rows[0]['project']; ?></li>
                                            <li class="list-group-item">Time: <?php echo $rows[0]['date']; ?></li>
                                        </ul> <?php
                                        if ($rows[0]['revision']) { ?>
                                            <h4 class="my-3">Revision</h4>
                                            <ul class="list-group">
                                            <li class="list-group-item">Revision: <?php echo $rows[0]['revision']; ?></li>
                                            <li class="list-group-item">Comment: <?php echo $rows[0]['comment']; ?></li>
                                            </ul><?php
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <?php
                }
            } ?>
        </div>
    </div> <?php
    require_once "includes/_footer.php";
}
else require_once "login.php";