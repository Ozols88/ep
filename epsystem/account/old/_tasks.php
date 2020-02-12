<?php
$page = "old";
include "../includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "_header.php";
    $projectObj = new Project();
    $drawingObj = new Drawing(); ?>
    <div class="container-fluid text-center">
        <div class="row"> <?php
            if (!isset($_GET['d'])) {
                $drawings = $drawingObj->selectAdminSubmittedDrawingList();
                if ($drawings) { ?>
                    <div class="col-lg-12">
                        <div class="jumbotron table-responsive py-3">
                            <h2 class="mb-4">Drawings</h2>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Status Time</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Price</th>
                                </tr>
                                </thead>
                                <tbody> <?php
                                foreach ($drawings as $drawing) {
                                    if ($drawing['id_project'])
                                        $link = "_projects.php?p=" . $drawing['id_project'];
                                    else
                                        $link = "_drawings.php?d=" . $drawing['title']; ?>
                                    <tr>
                                        <td class="admin"><a href="<?php echo $link; ?>"><?php echo $drawing['title']; ?></a></td>
                                        <td class="admin"><a href="<?php echo $link; ?>"><?php echo "No idea"; ?></a></td>
                                        <td class="admin"><a href="<?php echo $link; ?>"><?php echo $drawing['status_name']; ?></a></td>
                                        <td class="admin"><a href="<?php echo $link; ?>"><?php echo $drawing['time2']; ?></a></td>
                                        <td class="admin"><a href="<?php echo $link; ?>"><?php echo $drawing['username']; ?></a></td>
                                        <td class="admin"><a href="<?php echo $link; ?>"><?php echo $drawing['price'] . "$"; ?></a></td>
                                    </tr> <?php
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <?php
                }
                $voiceovers = $projectObj->selectAdminActiveVoiceoverList();
                if ($voiceovers) { ?>
                    <div class="col-lg-12">
                        <div class="jumbotron table-responsive py-3">
                            <h2 class="mb-4">Voiceovers</h2>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Status Time</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Price</th>
                                </tr>
                                </thead>
                                <tbody> <?php
                                foreach ($voiceovers as $voiceover) { ?>
                                    <tr>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $voiceover['id']; ?>"><?php echo $voiceover['title']; ?></a></td>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $voiceover['id']; ?>"><?php echo "No idea"; ?></a></td>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $voiceover['id']; ?>"><?php echo $voiceover['status_name']; ?></a></td>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $voiceover['id']; ?>"><?php echo $voiceover['time2']; ?></a></td>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $voiceover['id']; ?>"><?php echo $voiceover['username']; ?></a></td>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $voiceover['id']; ?>"><?php echo $voiceover['price'] . "$"; ?></a></td>
                                    </tr> <?php
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <?php
                }
                $scripts = $projectObj->selectAdminActiveScriptList();
                if ($scripts) { ?>
                    <div class="col-lg-12">
                        <div class="jumbotron table-responsive py-3">
                            <h2 class="mb-4">Scripts</h2>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Status Time</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Price</th>
                                </tr>
                                </thead>
                                <tbody> <?php
                                foreach ($scripts as $script) { ?>
                                    <tr>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $script['id']; ?>"><?php echo $script['title']; ?></a></td>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $script['id']; ?>"><?php echo "No idea"; ?></a></td>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $script['id']; ?>"><?php echo $script['status_name']; ?></a></td>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $script['id']; ?>"><?php echo $script['time2']; ?></a></td>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $script['id']; ?>"><?php echo $script['username']; ?></a></td>
                                        <td class="admin"><a href="_projects.php?p=<?php echo $script['id']; ?>"><?php echo $script['price'] . "$"; ?></a></td>
                                    </tr> <?php
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <?php
                }
            }
            else {
                $submissionData = $drawingObj->selectAdminSubmittedDrawing(); ?>
                <div class="container-fluid text-center">
                    <div class="col-lg-12">
                        <div class="jumbotron pt-5">
                            <h4 class="mb-4"><?php echo $submissionData[0]['title']; ?></h4>
                            <div class="row">
                                <div class="col-lg-6 pb-3">
                                    <iframe src="<?php echo $submissionData[0]['path_file'] . "preview"; ?>" width="100%" height="367"></iframe>
                                </div>
                                <div class="col-lg-6 pb-3">
                                    <h4 class="my-3">Details</h4>
                                    <ul class="list-group">
                                        <li class="list-group-item">Type: <?php echo $submissionData[0]['type_name']; ?></li>
                                        <li class="list-group-item">Complexity: <?php echo $submissionData[0]['complexity']; ?></li>
                                        <li class="list-group-item">Tags: <?php echo $submissionData[0]['tags']; ?></li>
                                        <li class="list-group-item">Price: <?php echo $submissionData[0]['price']; ?></li>
                                    </ul> <?php
                                    if ($submissionData[0]['revision']) { ?>
                                        <h4 class="my-3">Revision</h4>
                                        <ul class="list-group">
                                        <li class="list-group-item">Revision: <?php echo $submissionData[0]['revision']; ?></li>
                                        <li class="list-group-item">Comment: <?php echo $submissionData[0]['comment']; ?></li>
                                        </ul><?php
                                    } ?>
                                    <h4 class="my-3">Author</h4>
                                    <ul class="list-group">
                                        <li class="list-group-item">Artist: <?php echo $submissionData[0]['username']; ?></li>
                                        <li class="list-group-item">Qualification: <?php echo $submissionData[0]['qualification']; ?></li>
                                    </ul> <?php
                                    if ($submissionData[0]['project']) { ?>
                                        <h4 class="my-3">Project</h4>
                                        <ul class="list-group">
                                            <li class="list-group-item">Title: <?php echo $submissionData[0]['project']; ?></li>
                                            <li class="list-group-item">Deadline: <?php echo $submissionData[0]['days_left'] . " days"; ?></li>
                                        </ul> <?php
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <?php
            } ?>
        </div>
    </div> <?php
    require_once "_footer.php";
}
else require_once "login.php";
/*elseif ($account->types['artist']['bool'] == true && $account->currentType == 'artist') {
    require_once "includes/header_artist.php";
    $drawingObj = new Drawing();
    if (!isset($_GET['d'])) { */?><!--
        <div class="container-fluid text-center">
            <div class="row"><?php
/*                $drawings = $drawingObj->selectArtistAvailableDrawingList();
                if ($drawings) { */?>
                    <div class="col-lg-12">
                        <div class="jumbotron table-responsive py-3">
                            <h1 class="mb-4">To Do List</h1>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Complexity</th>
                                    <th scope="col">Project</th>
                                    <th scope="col">Price</th>
                                </tr>
                                </thead>
                                <tbody> <?php
/*                                foreach ($drawings as $drawing) { */?>
                                    <tr>
                                        <td class="artist"><a href="?d=<?php /*echo $drawing['id']; */?>"><?php /*echo $drawing['title']; */?></a></td>
                                        <td class="artist"><a href="?d=<?php /*echo $drawing['id']; */?>"><?php /*echo $drawing['type_name']; */?></a></td>
                                        <td class="artist"><a href="?d=<?php /*echo $drawing['id']; */?>"><?php /*echo $drawing['complexity']; */?></a></td>
                                        <td class="artist"><a href="?d=<?php /*echo $drawing['id']; */?>"><?php /*echo $drawing['project']; */?></a></td>
                                        <td class="artist"><a href="?d=<?php /*echo $drawing['id']; */?>"><?php /*echo $drawing['price'] . "$"; */?></a></td>
                                    </tr> <?php
/*                                } */?>
                                </tbody>
                            </table>
                        </div>
                    </div> <?php
/*                } */?>
            </div>
        </div> <?php
/*    }
    else { */?>
        <div class="container-fluid text-center">
            <div class="row"> <?php
/*                $drawing = $drawingObj->selectArtistDrawing();
                if ($drawing) { */?>
                    <div class="container-header text-center">
                        <div class="col-lg-12">
                            <div class="jumbotron pt-5">
                                <h1 class="mb-4"><?php /*echo $drawing[0]['title']; */?></h1>
                                <div class="row">
                                    <div class="col-lg-6 pb-3">
                                        <h4 class="my-3">Details</h4>
                                        <ul class="list-group">
                                            <li class="list-group-item">Type: <?php /*echo $drawing[0]['type_name']; */?></li>
                                            <li class="list-group-item">Complexity: <?php /*echo $drawing[0]['complexity']; */?></li>
                                            <li class="list-group-item">Price: <?php /*echo $drawing[0]['price'] . "$"; */?></li>
                                            <li class="list-group-item">Project: <?php /*echo $drawing[0]['project']; */?></li>
                                            <li class="list-group-item">Time: <?php /*echo $drawing[0]['date']; */?></li>
                                        </ul> <?php
/*                                        if ($drawing[0]['revision']) { */?>
                                            <h4 class="my-3">Revision</h4>
                                            <ul class="list-group">
                                            <li class="list-group-item">Revision: <?php /*echo $drawing[0]['revision']; */?></li>
                                            <li class="list-group-item">Comment: <?php /*echo $drawing[0]['comment']; */?></li>
                                            </ul><?php
/*                                        } */?>
                                    </div>
                                    <div class="col-lg-6 pb-3">
                                        <h4 class="my-3">Description</h4>
                                        <p class="text-left"><?php /*echo $drawing[0]['description']; */?></p>
                                    </div> <?php
/*                                    $examples = $drawingObj->selectArtistDrawingExamples();
                                    if ($examples) {
                                        foreach ($examples as $example) { */?>
                                            <div class="col-lg-6 pb-3">
                                                <iframe src="<?php /*echo $example['image']; */?>" width="100%" height="367"></iframe>
                                                <p class=""><?php /*echo $example['sort'] . ". " . $example['description']; */?></p>
                                            </div> <?php
/*                                        }
                                    } */?>
                                </div>
                            </div>
                        </div>
                    </div> <?php
/*                } */?>
            </div>
        </div> --><?php
/*    }
    require_once "_footer.php";
}*/