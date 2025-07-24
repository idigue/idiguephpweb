<!doctype html>
<html lang="en">
<?php include 'components/head.php'; ?>
<?php include 'components/breadcrumb.php'; ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Projects</a></li>
        <li class="breadcrumb-item"> <a href="messages.php?pid=<?php echo $id ?>" data-toggle="tooltip" data-placement="top" title="Messages" class="iconmessages" onclick="funmenu()">
                <i class="fa fa-commenting fa-sm" aria-hidden="true"></i>
            </a>
        </li>
        <li class="breadcrumb-item"> <a href="addproposal.php?pid=<?php echo $id ?>" data-toggle="tooltip" data-placement="top" title="Proposal" class="iconmessages" onclick="funmenu()">
                <i class="fa fa-file-text fa-sm" aria-hidden="true"></i>
            </a>
        </li>
    </ol>
</nav>
<span id='message' style="color:red;"><?php echo $message ?></span>

<?php
require_once 'services/projects_service.php';
require_once 'services/messages_service.php';
require_once "services/projects_service.php";
require_once "services/projects_proposals_service.php";
$projectsService = new ProjectsService();
$messagesService = new MessagesService();
$projectProposalsService = new ProjectProposalsService();
$id = $_GET['id'];
$uid = "2";
if (isset($_SESSION['login_user'])) {
    $uid = $_SESSION['login_user'][0];
}
$project_array = $projectsService->getProject($id);
$messages = $messagesService->getProjectMessages($db, $id);
$proposals = $projectProposalsService->getProjectProposals($db, $id);
if ($_POST) {
    if (isset($_POST['confirm'])) {
        $pid = $_POST['pid'];
        if (!isset($_POST['proposalid'])) {
            $message = "No proposal selected";
        } else {
            $status = $_POST['status'];
            if ($status == "new" && isset($_POST['proposalid'])) {
                var_dump($_POST['proposalid']);
                $proposalid = $_POST['proposalid'];
                // selectproposal($db, $pid, $proposalid);
                header("Location:/projectdetails.php?id=$pid");
                die;
            } else {
                header("Location:/projectdetails.php?id=$pid");
                die;
            }
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col">
            <h3>Project Title: <?php echo $project_array->name?></h3>
        </div>
    </div>
    <div class="row">

        <div class="col">
            Status: <?php echo $project_array->status ?>
        </div>
        <div class="col">
            Budget: <?php echo $project_array->budget?> $
        </div>
        <div class="col">
            Time: <?php echo $project_array->timecreated ?>
        </div>
        <div class="col">
            Category: <?php echo $project_array->cat ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            Details: <?php echo $project_array->descriptions ?>
        </div>

        <div class="col">
            Stack: <?php echo $project_array->stack ?>
        </div>
    </div>
</div>
</div>
<br>

<div style="width: 80%;padding: 35px; margin:10px;">
    <h3>Proposals</h3>
    <form method="post">
        <table class="table table-sm" style="color:#66a2ba;">
            <thead>
                <tr>
                    <th>
                        Screenshots
                    <th>
                        Name
                    </th>
                    <th>
                        Price(USD)
                    </th>
                    <th>
                        Timeframe
                    </th>
                    <th>
                        Author
                    </th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if (count($proposals) > 0) :
                        foreach ($proposals as $proposal) :
                            $attids = $proposal->attids;
                            $imgs = explode(",", $attids);
                    ?>

                            <td><?php
                                for ($i = 1; $i < count($imgs); $i++) { ?>
                                    <a href='images.php?pimageid=<?php echo $imgs[$i]; ?>'>
                                        <img src='images.php?pimageid=<?php echo $imgs[$i]; ?>'
                                            class='img-fluid' width='30%' height='30%'
                                            alt='image'></a>
                                <?php
                                } ?>
                            </td>
                            <td><a href="proposaldetails.php?id=<?php echo $proposal["id"] ?>"><?php echo $proposal["name"]; ?></a></td>
                            <input type="hidden" name="pid" value="<?php echo $proposal["projectid"] ?>">
                            <input type="hidden" name="proposalid" value="<?php echo $proposal["id"] ?>">
                            <input type="hidden" name="status" value="<?php echo $project_array["status"] ?>">

                            <td><?php echo $proposal->price; ?></td>
                            <td><?php echo $proposal->timeframe; ?></td>
                            <td><?php echo $proposal->author; ?></td>
                            <td>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <input type="radio" aria-label="Accept">
                                    </div>

                                </div>

                            </td>
                </tr>
            <?php endforeach;
                    else : ?> <tr>
                <td>no proposals</td>
            </tr>
        <?php endif ?>
        <tr>
            <?php if ($project_array->status == "new") : ?>
                <td><button type="submit" name="confirm" class="btn btn-success">Confirm Selection</button></td>
            <?php else : ?>
                <td>
                    <a href="processprojectorder.php?id=<?php echo $id ?>" class="btn btn-info"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                        </svg></a>
                </td>
            <?php endif ?>
        </tr>
            </tbody>
        </table>

    </form>
</div>
</body>

</html>