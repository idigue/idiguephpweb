<!DOCTYPE html>
<html>
<?php include 'components/head.php'; ?>
<?php include 'components/breadcrumb.php'; ?>

<?php
session_start();
require_once 'dbcontroller.php';
// $db = connect(dbhost, dbname, dbusername, dbpassword);
// $tabs = $db_handle->runQuery("select * from `tabs`");
$uid = $_SESSION['login_user'][0];
if (isset($_SESSION['login_user'])) {
    // $userdetails = getuserdetailsbyuid($db, $uid);
    $sqluserdetails = "select a.username, a.ifcustomer, a.password,u.techstack,u.email,u.address, u.phone  from `user` u, `accounts` a where u.id=a.uid and u.id= " . $uid;
    $userdetails = $db_handle->runQuery($sqluserdetails);
}
$total_price = 0;

$item_details = '';
$order_details = '
<div class="table-responsive" id="order_table">
	<table class="table table-dark table-sm">
		<tr>  
            <th>Product Name</th>  
            <th>Quantity</th>  
            <th>Price</th>  
            <th>Total</th>  
        </tr>
';

if (!empty($_SESSION["cart_item"])) {
    foreach ($_SESSION["cart_item"] as $keys => $values) {
        $order_details .= '
		<tr>
			<td>' . $values["name"] . '</td>
			<td>' . $values["quantity"] . '</td>
			<td align="right">$ ' . $values["price"] . '</td>
			<td align="right">$ ' . number_format($values["quantity"] * $values["price"], 2) . '</td>
		</tr>
		';
        $total_pricenotax = $total_price + ($values["quantity"] * $values["price"]);
        $total_price = $total_pricenotax + $total_pricenotax * 0.0725;
        $item_details .= $values["name"] . ', ';
    }
    $item_details = substr($item_details, 0, -2);
    $order_details .= '
	<tr>  
        <td colspan="3" align="right">Total After Tax</td>  
        <td align="right">$ ' . number_format($total_price, 2) . '</td>
    </tr>
	';
}

if ($_POST) {
    if (isset($_POST['go'])) {
        // updateuser($db);
        header("Location:/processorder.php");
        die;
    } else if (isset($_POST['addcoupon'])) {
        $code = $_POST['couponcode'];
        // $coupon = getcouponbycode($db, $code);
        $sqlcode = "select * from `coupon` 
  WHERE code = '" . $code . "'";
        $coupon = $db_handle->runQuery($sqlcode);
        $percent = $coupon['percent'];
        $_SESSION["percent"] = $percent;
        $total_price = $total_price * ((100 - $percent) / 100.00);
        $order_details .= '
	<tr>  
        <td colspan="3" align="right">Total After Coupon</td>  
        <td align="right">$ ' . number_format($total_price, 2) . '</td>
    </tr>
	';
    }
}
$order_details .= '</table>';
?>



<div class="container-fluid  p-3 my-3 bg-dark text-white">

    <body>
        <h3 align="center">Shipping Details</h3>
        <div class="panel panel-default">
            <div class="panel-heading">
                <form method="post" id="order_process_form" action="">
                    <div class="row">
                        <div class="col-md-8" style="border-right:1px solid #211a1a;">
                            <h4 align="center">Customer Details</h4>
                            <div class="form-group">
                                <label><b>Name</b></label>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo $userdetails[0]['name']; ?>" required />

                                <span id="error_customer_name" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label><b>Email Address</b></label>
                                <input type="email" name="email" id="email" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$"
                                    required class="form-control" value='<?php
                                                                            echo $userdetails[0]['email']; ?>' required />
                                <span id="error_email_address" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label><b>Phone number</b></label>
                                <input type="text" name="phone" id="phone" class="form-control" value='<?php
                                                                                                        echo $userdetails[0]['phone']; ?>' required />
                                <span id="error_phone_number" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label><b>Address</b></label>
                                <input type="text" name="address" id="address" class="form-control" value='<?php
                                                                                                            echo $userdetails[0]['address']; ?>' required></input>
                                <span id="error_customer_address" class="text-danger"></span>
                            </div>

                            <div align="center">
                                <input type="hidden" name="totalprice" value="<?php echo $total_price; ?>" />
                                <input type="hidden" name="currencycode" value="USD" />
                                <input type="hidden" name="itemdetails" value="<?php echo $item_details; ?>" />

                            </div>
                            <!-- Set up a container element for the button -->

                        </div>

                        <div class="col-md-4">
                            <h4 align="center">Order Details</h4>
                            <?php
                            echo $order_details;
                            ?>
                            <div> <input type="text" name="couponcode" id="couponcode" placeholder="Coupon Code" />
                                <div class='cart-action'><input type='submit' name="addcoupon" class='btn btn-primary float-left m-2' value='Add Coupon' />
                                </div>

                                <br><br>
                                <div class='cart-action'><input type='submit' name="go" class='btn btn-primary' value='Next' />

                                </div>

                </form>
            </div>
        </div>
    </body>
</div>

</html>