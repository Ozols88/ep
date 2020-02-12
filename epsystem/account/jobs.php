<?php
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php";
    $drawing = new Drawing();
    if (!isset($_GET['s'])) { ?>
        <div class="container-fluid text-center">
            <div class="row">
                <div class="col-lg-12">
                    <div class="jumbotron table-responsive py-3">
                        <h1 class="mb-4">Jobs</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Artist</th>
                                <th scope="col">Status</th>
                                <th scope="col">Time</th>
                                <th scope="col">Project</th>
                            </tr>
                            </thead>
                            <tbody> <?php
                            $rows = $drawing->selectAdminActiveDrawingList();
                            foreach ($rows as $row) { ?>
                                <tr>
                                    <td class="admin"><a href="resources.php?d=<?php echo $row['title']; ?>"><?php echo $row['title']; ?></a></td>
                                    <td class="admin"><a href="resources.php?d=<?php echo $row['title']; ?>"><?php echo $row['username']; ?></a></td>
                                    <td class="admin"><a href="resources.php?d=<?php echo $row['title']; ?>"><?php echo $row['status_name']; ?></a></td>
                                    <td class="admin"><a href="resources.php?d=<?php echo $row['title']; ?>"><?php echo $row['time2']; ?></a></td>
                                    <td class="admin"><a href="resources.php?d=<?php echo $row['title']; ?>"><?php echo $row['project']; ?></a></td>
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
        $submissionData = $drawing->selectAdminActiveDrawing(); ?>
        <div class="container-fluid text-center">
            <div class="col-lg-12">
                <div class="jumbotron pt-5">
                    <h4 class="mb-4"><?php echo $submissionData[0]['title']; ?></h4>
                    <div class="row">
                        <div class="col-lg-6 pb-3">
                            <iframe src="<?php echo $submissionData[0]['path_file'] . "preview"; ?>" width="100%" height="367"></iframe>
                            <button type="button" class="btn btn-success mt-5">Accept</button>
                            <button type="button" class="btn btn-danger mt-5">Revise</button>
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
    }
    require_once "includes/footer.php";
}
else require_once "login.php";