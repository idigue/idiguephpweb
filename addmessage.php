<!doctype html>
<html lang="en">
<?php include 'components/head.php'; ?>
<?php include 'components/breadcrumb.php'; ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="messages.php?pid=<?php echo $pid ?>">Messages</a></li>
        <li class="breadcrumb-item" aria-current="page">Add Message</li>
    </ol>
</nav>
<?php
$pid = 0;
if (!empty($_GET["pid"])) {
    $pid = intval($_GET["pid"]);
    $project_array = $projectsService->getProject($id);
}
if (isset($_SESSION['login_user'])) {
    $user = $_SESSION['login_user'];
    $user_check = $user[0];
} else {
    $user_check = 2;
}
?>

<body>

    <h3><i class="fa fa-envelope-open" aria-hidden="true"></i>
        <?php echo $project_array["name"] ?></h3>
    <form method="post">
        <h2 class="text-primary">Add Message</h2>
        <div class="mb-3">
            <label class="col-sm-3 col-form-label">Title</label>
            <input size="60" type="text" name="title" />
        </div>
        <br>
        <div class="mb-3">
            <label class="col-sm-3 col-form-label">Contents</label>
            <textarea cols="60" rows="10" name="contents"></textarea>
        </div>
        <button type="submit" name="go" class="btn btn-primary float-right m-2">
            Add
        </button>
        <a href="messages.php?pid=<?php echo $pid ?>" class="btn btn-primary"> Back to Messages</a>
        </div>
    </form>
    <?php
    if ($_POST) {
        if (isset($_POST['go'])) {
            // AddMessage($db, $user_check, $pid);
            $sql = "insert into `messages`";
            $sql .= "(`title`,  `contents`, `uid`,`projectid`)";
            $sql .= "values(";
            $sql .= "'" . $_POST['title'] . "',";
            $sql .= "'" . htmlspecialchars($_POST['contents'], ENT_QUOTES | ENT_HTML5) . "',";
            $sql .= "'" . $user_check . "',";
            $sql .= "'" . $pid . "'";
            $sql .= ");";
            $result = $db_handle->runQuery($sql);
            if ($result == "success") {
                header("Location:/messages.php?pid=$pid");
                die;
            } else {
                echo "Error";
            }
        } else {

            header("Location:/messages.php?pid=$pid");
            die;
        }
    }
    ?>
</body>

</html>