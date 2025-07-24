<?php
session_start();
require_once 'dbcontroller.php';

$tid =1;
$aid = 38;
if(isset($_SESSION['login_user'])){
    $uid = $_SESSION['login_user'][0];
}
$message = '';
if(isset($_GET['tid'])){
    $tid = $_GET['tid'];
}   
    $sqlfetchprojectsbyuid = "SELECT * FROM `projects` WHERE aid = $uid";
    $sqlffetchproposalsbyuid = "SELECT * FROM `proposals` WHERE aid = $uid";
    $sqlfetchbalancebyuid = "SELECT balance FROM `users` WHERE id = $uid";
    $db_handle = new DBController();
    $projects = $db_handle->runQuery($sqlfetchprojectsbyuid);
    $proposals= $db_handle->runQuery($sqlffetchproposalsbyuid);
    $user = $db_handle->runQuery($sqlfetchbalancebyuid);

    ?>
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
<span id='message' style="color:red;"><?php echo $message?></span>
<div class="container">
  <div class="row row-cols-4">
    <div class="col"><a href="userspace.php?tid=1">Project Status</a></div>
    <div class="col"><a href="userspace.php?tid=2">Proposals</a></div>
    <div class="col"><a href="userspace.php?tid=3">Balance</a></div>
    <a href="aduser.php"><div class="col">Profile</div></a>
  </div>
</div>
<?php if ($tid == 1) : ?>
    <h3>Project Status</h3>
    <div style="width: 80%;padding: 35px; margin:10px;">
        <table class="table table-sm" style="color:#66a2ba;">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Status</th>
                    <th>Timeframe</th>
                    <th>Budget(USD)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($projects) > 0) :
                    foreach ($projects as $project) :
                ?>
                        <tr>
                            <td><a href="projectdetails.php?id=<?php echo $project["id"]?>"><?php echo $project["name"]; ?></a></td>
                            <td><?php echo $project["status"]; ?></td>
                            <td><?php echo $project["timeframe"]; ?></td>
                            <td><?php echo $project["budget"]; ?></td>
                        </tr>
                    <?php endforeach;
                else : ?> 
                    <tr><td colspan="4">No projects found.</td></tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
<?php elseif ($tid == 2) : ?>       
    <h3>Proposals</h3>
    <div style="width: 80%;padding: 35px; margin:10px;">
        <table class="table table-sm" style="color:#66a2ba;">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Proposal Name</th>
                    <th>Price(USD)</th>
                    <th>Timeframe</th>
                    <th>Author</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($proposals) > 0) :
                    foreach ($proposals as $proposal) :
                ?>
                        <tr>
                            <td><a href="projectdetails.php?id=<?php echo $proposal["projectid"]?>"><?php echo $proposal["name"]; ?></a></td>
                            <td><?php echo $proposal["name"]; ?></td>
                            <td><?php echo $proposal["price"]; ?></td>
                            <td><?php echo $proposal["timeframe"]; ?></td>
                            <td><?php echo $proposal["author"]; ?></td>
                        </tr>
                    <?php endforeach;
                else : ?> 
                    <tr><td colspan="5">No proposals found.</td></tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
<?php elseif ($tid == 3) : ?>
    <h3>Balance</h3>
    <div style="width: 80%;padding: 35px; margin:10px;">
        <table class="table table-sm" style="color:#66a2ba;">
            <thead>
                <tr>
                    <th>Current Balance (USD)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $user["balance"]; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
<?php endif; ?>
</div>

</div>
         
    
   
</body>

</html>