<!doctype html>
<html lang="en">
<?php include 'components/head.php'; ?>
 <?php include 'components/breadcrumb.php'; ?>
<body>
    <?php
    require_once 'dbcontroller.php';

    if (isset($_SESSION['login_user'])) {
        $uid = $_SESSION['login_user'][0];
        $sqlgetordersbyuid = "SELECT * FROM `orders` WHERE uid = " . $uid;
        $orders = $db_handle->runQuery($sqlgetordersbyuid);
    }


    ?>
   
    <table class="table table-sm" style="color:#66a2ba;">
        <thead>
            <tr>
                <th>
                    Order Id
                </th>

                <th width='50%'>
                    Item Details
                </th>
                <th>
                    Total Price
                </th>
                <th>
                    Currency
                </th>
                <th>
                    Status
                </th>
                <th>
                    Time
                </th>

            </tr>
        </thead>
        <?php
        if (count($orders) > 0) :
            foreach ($orders as $order) :
                echo "
                            <tr><td><a href='orderinfodetails.php?id=" . $order['id'];
                echo "'>#ord22" . $order['id'];
                echo "</a></td><td>                               
    " . $order['itemdetails'];
                echo "</td>
<td>" . $order['totalprice'];

                echo "</td><td>" . $order['currencycode'];
                echo "</td><td> "
                    . $order['status'];
                echo "</td><td> "
                    . $order['createdtime'];
                echo "
</td></tr>";
            endforeach;
        else : echo "
<td>not found</td>
";
        endif;
        ?>

    </table>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/site.js" asp-append-version="true"></script>
</body>

</html>