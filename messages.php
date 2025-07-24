<!doctype html>
<html lang="en">
<?php include 'components/head.php'; ?>
<?php include 'components/breadcrumb.php'; ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="addmessage.php?pid=<?php echo $pid ?>">Add A Message</a></li>
            <li class="breadcrumb-item" aria-current="page">Messages</li>
        </ol>
    </nav>
<?php
require_once 'config.php';
require_once 'connect.php';
require_once 'dbcontroller.php';
$pid = 0;
if (!empty($_GET["pid"])) {
    $pid = intval($_GET["pid"]);
    if ($db instanceof mysqli) {
        $sqlfetchmessagesbypid = "SELECT * FROM `messages` WHERE projectid = $pid";
        $sqlfetcgprojectsbyuid = "SELECT * FROM `projects` WHERE id = $pid";
        $messages = $db_handle->runQuery($sqlfetchmessagesbypid);
        $project_array  = $db_handle->runQuery($sqlfetchprojectsbypid);
    }
}


?>

<body>
    

    <h3><i class="fa fa-envelope-open" aria-hidden="true"></i>
        <?php echo $project_array["name"] ?></h3>

    <table class="table table-sm" style="color:#66a2ba;">
        <thead>
            <tr>

                <th>
                    Title
                </th>
                <th width='50%'>
                    Contents
                </th>
                <th>
                    Author
                </th>
                <th>
                    Time
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($messages) > 0) :
                foreach ($messages as $message) :
            ?>
                    <tr>

                        <td><?php echo $message['title']; ?></td>
                        <td width='50%'>
                            <?php echo $message['contents']; ?></td>
                        <td><?php echo $message['author']; ?></td>
                        <td><?php echo $message['time']; ?></td>

                        </div>
                        </td>
                    </tr>
                <?php endforeach;
            else : ?> <tr>
                    <td>no messages</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>

    </div>
</body>

</html>