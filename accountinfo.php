<!doctype html>
<html lang="en"> 
<?php include 'components/head.php'; ?>
<?php include 'components/breadcrumb.php'; ?>

<?php
if (isset($_SESSION['login_user'])) {
    $sqlgetuserdetailsbyuid = "SELECT * FROM `users` WHERE id = " . $_SESSION['login_user'][0];
    $user = $db_handle->runQuery($sqlgetuserdetailsbyuid);

?>

    <div class="text-center">
        <div id="accordion">
            <div class="card" style="background-color: #333;">
                <div class="card-header" id=<?php echo 'heading' ?>>

                    <button class="btn btn-link" data-toggle="collapse" data-target=<?php echo '#collapse' . $user['id']; ?> aria-expanded="true" aria-controls=<?php echo 'collapse' . $user['id']; ?>>
                        <h3><?php echo $user[0]['firstname']; ?>,<?php echo $user['lastname']; ?></h3>
                    </button>

                </div>
                <div id=<?php echo 'collapse' . $user[0]['id']; ?> class="collapse show" aria-labelledby=<?php echo 'heading' . $user['id']; ?> data-parent="#accordion">
                    <div class="card-body">
                        Email: <?php echo $user[0]['email']; ?>,<br>
                        Phone: <?php echo $user[0]['phone']; ?>,<br>
                        Address: <?php echo $user[0]['address']; ?>,
                        <?php echo $user[0]['city']; ?>,
                        <?php echo $user[0]['zip']; ?>,
                        <?php echo $user[0]['country']; ?>
                    </div>
                </div>
                <br><a href="aduser.php?id=<?php echo $uid; ?>"><i class="fa-solid fa-user-pen"></i></a>
            </div>
        </div>
    <?php

}
    ?>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/site.js" asp-append-version="true"></script>
    </body>

</html>