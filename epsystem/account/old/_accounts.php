<?php
$page = "old";
include "../includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "_header.php";
//    if ($account->types['admin']['bool'] == true && $account->currentType == 'admin') {
    if (!isset($_GET['a'])) { ?>
        <div class="container-fluid text-center">
            <div class="row">
                <div class="col-lg-12">
                    <div class="jumbotron table-responsive py-3">
                        <h1 class="mb-4">All Accounts</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Username</th>
                            </tr>
                            </thead>
                            <tbody> <?php
                            $accs = $account->selectAdminAccountList();
                            foreach ($accs as $acc) { ?>
                                <tr>
                                    <td class="admin"><a href="_accounts.php?a=<?php echo $acc['id']; ?>"><?php echo $acc['username']; ?></a></td>
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
        if (!isset($_GET['edit'])) {
            $accountData = $account->selectAdminAccount(); ?>
            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="jumbotron py-3">
                            <a class="btn btn-primary btn-lg float-left" href="_accounts.php?a=<?php echo $accountData[0]['id']; ?>&edit" role="button">Edit</a>
                            <h1 class="test"><?php echo $accountData[0]['username']; ?></h1>
                            <button type="button" class="btn btn-danger float-right" name="remove">Remove</button>
                        </div>
                    </div>
                    <div class="col-lg-6 pb-3">
                        <div class="jumbotron py-3">
                            <h4 class="my-3">General</h4>
                            <ul class="list-group">
                                <li class="list-group-item">Username: <?php echo $accountData[0]['username']; ?></li>
                                <li class="list-group-item">E-mail: <?php echo $accountData[0]['email']; ?></li>
                                <li class="list-group-item">Name: <?php echo $accountData[0]['fname'] . " " . $accountData[0]['lname']; ?></li>
                            </ul>
                            <h4 class="my-3">Additional</h4>
                            <ul class="list-group">
                                <li class="list-group-item">Country: <?php echo $accountData[0]['country']; ?></li>
                                <li class="list-group-item">Registration: <?php echo $accountData[0]['reg_time']; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <?php
        }
        else {
            //editpage
        }
    }
//    }
    /*    elseif ($account->types['artist']['bool'] == true && $account->currentType == 'artist') {
            $accountData = $account->selectArtistAccount(); */?><!--
        <div class="container-fluid text-center">
            <div class="row">
                <div class="col-lg-12">
                    <div class="jumbotron py-3">
                        <h1>My Account</h1>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="jumbotron py-3">
                        <h4 class="mb-4">Details</h4>
                        <ul class="list-group">
                            <li class="list-group-item">Username: <?php /*echo $accountData[0]['username']; */?></li>
                            <li class="list-group-item">Password: </li>
                            <li class="list-group-item">E-mail: <?php /*echo $accountData[0]['email']; */?></li>
                            <li class="list-group-item">First Name: <?php /*echo $accountData[0]['fname']; */?></li>
                            <li class="list-group-item">Last Name: <?php /*echo $accountData[0]['lname']; */?></li>
                            <li class="list-group-item">Country: <?php /*echo $accountData[0]['country']; */?></li>
                            <li class="list-group-item">Registration: <?php /*echo $accountData[0]['reg_time']; */?></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="jumbotron py-3">
                        <h4 class="mb-4">Change Data</h4>
                        <h5 class="my-3">Change E-mail</h5>
                        <form>
                            <div class="form-row">
                                <div class="col">
                                    <input class="form-control" aria-label="E-mail" placeholder="E-mail" value="<?php /*echo $accountData[0]['email']; */?>" readonly>
                                </div>
                                <div class="col">
                                    <input class="form-control" name="email" aria-label="New E-mail" placeholder="New E-mail">
                                </div>
                                <div class="col-auto">
                                    <input type="submit" name="email_change" class="btn btn-success text-center" value="Submit">
                                </div>
                            </div>
                        </form>
                        <h5 class="my-3">Change Password</h5>
                        <form>
                            <div class="form-row">
                                <div class="col">
                                    <input class="form-control" name="password_old" aria-label="Old Password" placeholder="Old Password">
                                </div>
                                <div class="col">
                                    <input class="form-control" name="password_new" aria-label="New Password" placeholder="New Password">
                                </div>
                                <div class="col">
                                    <input class="form-control" name="password_repeat" aria-label="New Password" placeholder="New Password">
                                </div>
                                <div class="col-auto">
                                    <input type="submit" name="password_change" class="btn btn-success text-center" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --><?php
    /*    }*/
    require_once "../old/_footer.php";
}
else require_once "login.php";