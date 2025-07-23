<!doctype html>
<html lang="en">
<?php include 'components/head.php'; ?>
<?php include 'components/breadcrumb.php'; ?>
<?php
// header("Content-Type:application/json");
session_start();
ob_start();
require_once "dbcontroller.php";
require_once "services/projects_service.php";
$db_handle = new DBController();
$projectsService = new ProjectsService();
$user_check = $_SESSION['login_user'];
$userid = $_SESSION['login_user'][1];
$catalogs = $db_handle->runQuery("select * from `subcatalog`");
$tabs = $db_handle->runQuery("select * from `tabs`");
?>

<script>
    $(document).ready(function() {
        $('#ptable').DataTable();
    });
</script>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <a href="aboutus.php"><img class="img-zoom-resultindex" data-toggle="tooltip" data-placement="top" title="About Us" height="60px;" width="60px;" src="Image/logo.png"></a>

        <?php if ($_SESSION['login_user'][0] == 1)
            echo '<li class="breadcrumb-item"><a href="adtrade.php">Add Product</a></li>'
        ?>
        <li class="breadcrumb-item" aria-current="page"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
            </svg> Dashboard</li>
        <?php
        if (count($tabs) > 0) :
            foreach ($tabs as $tab) :
                $url = $tab['url'];
        ?>
                <li class="breadcrumb-item"><a href="<?php echo $url; ?>"><?php echo $tab['name']; ?></a></li>
        <?php
            endforeach;
        endif;
        ?>
    </ol>
</nav>
<div class="container overflow-hidden">
    <div class="row gy-1">
        <div class="col-6">
            <div class="p-3 border bg-dark">
                <form method="post" action="">
                    <select id="cat" method="post" name="cat" onchange="this.form.submit()">
                        <option value="Choose one">Catalogs</option>
                        <?php
                        if (count($catalogs) > 0) :
                            foreach ($catalogs as $cat) :
                        ?>
                                <option value="<?php echo $cat['id']; ?>">
                                    <?php

                                    $catname = $cat['name'];
                                    // $catname = $catname . (isset($cat['subcatagory']) ? '-' . $cat['subcatagory'] : '');
                                    echo $catname; ?>
                                </option>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                    <table id="ptable" class="table table-sm" style="color:#66a2ba;">
                        <thead>
                            <tr>
                                <th>
                                    Title
                                </th>
                                <th>
                                    Proposals Count
                                </th>
                                <th>
                                    Owner
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $catid = 1;
                            if (isset($_GET["cat"])) {
                                $catid = $_GET["cat"];
                            }
                            if (isset($_POST["cat"])) {
                                $catid = $_POST["cat"];
                            }
                            //                             $sqlprojects="select distinct count(proposals.id) as proposalscount, 
                            //   projects.id id,status.value as status, users.username as owner, 
                            //   projects.name,projects.descriptions,projects.budget, projects.timecreated, 
                            //   projects.stack from projects left join proposals on projects.id=proposals.pid 
                            //   join status on status.id=projects.statusid join users on users.id=projects.uid
                            //    where projects.catid= ".$catid."
                            //   group by proposals.pid;";
                            //   $projects = $db_handle->runQuery($sqlprojects);
                            $projects = $projectsService->getProjects();
                            if (count($projects) > 0) :
                                foreach ($projects as $project) :
                                    echo "<td><a href='projectdetails.php?id=" . $project['id'];
                                    echo "'>
                    " . $project['name'];
                                    echo "</a>";
                                    echo "</td><td>
                    " . $project['proposalscount'];
                                    echo "</td>";
                                    echo "</td><td>
                    " . $project['owner'];
                                    echo "</td>";
                                    echo "</div>
                </div>
                </td>
            </tr>";
                                endforeach;
                            else : echo "<tr>
                <td>Project Lists</td>
            </tr>";
                            endif ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <div class="col-6">
            <!-- TODO:include to break the page to /views-->
            <!-- TODO:api nav for APIHandler() -->
            <!-- TODO:json format encode -->
            <div class="p-3 border bg-dark"><?php include 'howto/howtolist.php'; ?></div>
        </div>
        <div class="col-6">
            <div class="p-3 border bg-dark"><?php include 'howto/howtolist.php'; ?></div>
        </div>

        <div class="col-6">
            <div class="p-3 border bg-dark">AI Data</div>
        </div>
        <div class="col-6">
            <div class="p-3 border bg-dark">Reviews</div>
        </div>
    </div>
    <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle" viewBox="0 0 16 16">
            <path d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.146 4.992c-1.212 0-1.927.92-1.927 2.502v1.06c0 1.571.703 2.462 1.927 2.462.979 0 1.641-.586 1.729-1.418h1.295v.093c-.1 1.448-1.354 2.467-3.03 2.467-2.091 0-3.269-1.336-3.269-3.603V7.482c0-2.261 1.201-3.638 3.27-3.638 1.681 0 2.935 1.054 3.029 2.572v.088H9.875c-.088-.879-.768-1.512-1.729-1.512" />
        </svg> 2025 iDIGUE
    </div>
</div>

</html>