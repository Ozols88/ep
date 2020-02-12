<?php
$page = "old";
include "../includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "_header.php";
    $audioObj = new Audio();
    $audio = $audioObj->selectAdminAudioList(); ?>
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-lg-12">
                <div class="jumbotron table-responsive py-3"> <?php
                    foreach ($audioObj->audioTypes as $num => $type) { ?>
                        <a class="btn btn-primary btn-lg" href="<?php echo "_audio.php?t=" . $num; ?>" role="button"><?php echo $type; ?></a> <?php
                    } ?>
                    <h1 class="mb-4"><?php echo $audio[0]['type_name']; ?></h1>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Type</th>
                            <th scope="col">Length</th>
                            <th scope="col">Tags</th>
                        </tr>
                        </thead>
                        <tbody> <?php
                        foreach ($audio as $aud) { ?>
                            <tr>
                                <td class="admin"><a href="_audio.php?t=<?php echo $_GET['t']; ?>&a=<?php echo $aud['id']; ?>"><?php echo $aud['title']; ?></a></td>
                                <td class="admin"><a href="_audio.php?t=<?php echo $_GET['t']; ?>&a=<?php echo $aud['id']; ?>"><?php echo $aud['type_name']; ?></a></td>
                                <td class="admin"><a href="_audio.php?t=<?php echo $_GET['t']; ?>&a=<?php echo $aud['id']; ?>"><?php echo $aud['length']; ?></a></td>
                                <td class="admin"><a href="_audio.php?t=<?php echo $_GET['t']; ?>&a=<?php echo $aud['id']; ?>"><?php echo $aud['tags']; ?></a></td>
                            </tr> <?php
                        } ?>
                        </tbody>
                    </table> <?php
                    if (isset($_GET['a'])) {
                        $data = $audioObj->selectAdminAudio(); ?>
                        <iframe src="<?php echo $data[0]['path'] . "preview"; ?>" width="100%" height="75px"></iframe> <?php
                    } ?>
                </div>
            </div>
        </div>
    </div> <?php
    require_once "_footer.php";
}
else require_once "login.php";