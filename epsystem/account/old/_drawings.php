<?php
$page = "old";
include "../includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "_header.php";
    $drawing = new Drawing();
    // List of all drawings
    if (!isset($_GET['d'])) {
        $drawings = $drawing->selectAdminDrawingList(); ?>
        <div class="container-fluid text-center">
            <div class="row">
                <div class="col-lg-12">
                    <div class="jumbotron table-responsive py-3"> <?php
                        foreach ($drawing->drawingTypes as $num => $type) { ?>
                            <a class="btn btn-primary btn-lg" href="<?php echo "_drawings.php?t=" . $num; ?>" role="button"><?php echo $type; ?></a> <?php
                        } ?>
                        <h1 class="mb-4"><?php echo $drawings[0]['type_name']; ?></h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Tags</th>
                                <th scope="col">Complexity</th>
                                <th scope="col">File</th>
                            </tr>
                            </thead>
                            <tbody> <?php
                            foreach ($drawings as $row) { ?>
                                <tr>
                                    <td class="admin"><a href="_drawings.php?d=<?php echo $row['title']; ?>"><?php echo $row['title']; ?></a></td>
                                    <td class="admin"><a href="_drawings.php?d=<?php echo $row['title']; ?>"><?php echo $row['tags']; ?></a></td>
                                    <td class="admin"><a href="_drawings.php?d=<?php echo $row['title']; ?>"><?php echo $row['complexity']; ?></a></td> <?php
                                    if ($row['path_file']) { ?>
                                        <td class="admin"><a href="<?php echo $row['path_file']; ?>" target="_blank">OPEN</a></td> <?php
                                    }
                                    else { ?>
                                        <td class="admin"><a href="_drawings.php?d=<?php echo $row['title']; ?>">-</a></td> <?php
                                    } ?>
                                </tr> <?php
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <?php
    }
    else {
        $drawingData = $drawing->selectAdminDrawing(); ?>
        <div class="container-fluid text-center">
            <div class="col-lg-12">
                <div class="jumbotron pt-5">
                    <h4 class="mb-4"><?php echo $drawingData[0]['title']; ?></h4> <?php
                    foreach ($drawingData as $data) {
                        if ($data['revision']) { ?>
                            <h4><?php echo "Revision " . $data['revision']; ?></h4>
                            <h5 class="mb-4"><?php echo "(" . $data['comment'] . ")"; ?></h5> <?php
                        } ?>
                        <div class="row">
                            <div class="col-lg-6 pb-3">
                                <iframe src="<?php echo $data['path_file'] . "preview"; ?>" width="100%" height="367"></iframe>
                            </div>
                            <div class="col-lg-6 pb-3">
                                <h4 class="my-3">Details</h4>
                                <ul class="list-group">
                                    <li class="list-group-item">Artist: <?php echo $data['username']; ?></li>
                                    <li class="list-group-item">Type: <?php echo $data['type_name']; ?></li>
                                    <li class="list-group-item">Tags: <?php echo $data['tags']; ?></li>
                                    <li class="list-group-item">Price: <?php echo $data['price']; ?></li>
                                </ul>
                                <h4 class="my-3">Projects</h4> <?php
                                $usageData = $drawing->selectAdminDrawingProjectUsages($data['drwid']);
                                if ($usageData) { ?>
                                    <ul class="list-group"> <?php
                                        foreach ($usageData as $data2) { ?>
                                            <li class="list-group-item"><?php echo $data2['title']; ?></li> <?php
                                        } ?>
                                    </ul> <?php
                                }
                                else { ?>
                                    <a>None</a> <?php
                                } ?>
                            </div>
                        </div> <?php
                    } ?>
                </div>
            </div>
        </div> <?php
    }
    require_once "_footer.php";
}
else require_once "login.php";