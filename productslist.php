<?php include 'components/head.php'; ?>
<?php include 'components/breadcrumb.php'; ?>
<?php

if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("select p.id id, p.code code, p.name name, p.descriptions descriptions, p.price price, i.photofilepath,p.imageid imageid from product p,image i where p.imageid = i.id and p.ifactive=1 and  p.code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 'id' => $productByCode[0]["id"], 'descriptions' => $productByCode[0]["descriptions"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'photofilepath' => $productByCode[0]["photofilepath"], 'price' => $productByCode[0]["price"]));

                if (!empty($_SESSION["cart_item"])) {
                    if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productByCode[0]["code"] == $k) {
                                if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }

            break;
        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    foreach ($v as $kn => $vn) {
                        if ($_GET["code"] == $vn) {
                            unset($_SESSION["cart_item"][$k]);
                        }
                        if (empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                    }
                }
            }
            break;
        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
$catalogs = $db_handle->runQuery("select * from `catalog` where isparent=0 and parentcatalogid=2");
$subcatalogs = $db_handle->runQuery("select * from `subcatalog`");
if (isset($_GET["filter"])) {
    $filter = $_GET["filter"];

    $getproductbycatidsql = "select p.id id, p.code code, 
p.name name, p.descriptions descriptions,p.code code, p.price price, 
p.imageid imageid, i.photofilepath,p.imageid2 imageid2,p.imageid3 imageid3 from product p,image i where p.imageid = i.id and p.ifactive=1 and p.subcatid=" . $filter;
} else if (isset($_POST["cat"])) {
    $catid = $_POST["cat"];


    $getproductbycatidsql = "select p.id id, p.code code, 
p.name name, p.descriptions descriptions,p.code code, p.price price, 
p.imageid imageid, i.photofilepath,p.imageid2 imageid2,p.imageid3 imageid3 from product p,image i where p.imageid = i.id and p.ifactive=1 and p.catid=" . $catid;
} else {
    $catid = $_POST["cat"];


    $getproductbycatidsql = "select p.id id, p.code code, 
p.name name, p.descriptions descriptions,p.code code, p.price price, 
p.imageid imageid, i.photofilepath,p.imageid2 imageid2,p.imageid3 imageid3 from product p,image i where p.imageid = i.id and p.ifactive=1 and i.photofilepath!='' order by p.id desc";
}
?>
<!doctype html>
<html lang="en">


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/site.js" asp-append-version="true"></script>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <a href="aboutus.php"><img class="img-zoom-resultindex" data-toggle="tooltip" data-placement="top" title="About Us" height="60px;" width="60px;" src="Image/logo.png"></a>

        <?php if ($_SESSION['login_user'][0] == 1)
            echo '<li class="breadcrumb-item"><a href="adtrade.php">Add Product</a></li>'
        ?>
        <li class="breadcrumb-item" aria-current="page"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
            </svg> Gift Shop</li>

    </ol>
</nav>
<div id="shopping-cart">
    <?php
    if (isset($_SESSION["cart_item"])) {
        $total_quantity = 0;
        $total_price = 0;
    ?>
        <table class="table table-dark table-sm">
            <tr>

                <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Descriptions
                        </th>
                        <th>
                            Code
                        </th>
                        <th>
                            Quantity
                        </th>
                        <th>
                            Unit Price
                        </th>
                        <th>
                            Price
                        </th>
                        <th>
                            Remove
                        </th>

                    </tr>
                </thead>
            </tr>
            <?php

            foreach ($_SESSION["cart_item"] as $item) {
                $item_price = $item["quantity"] * $item["price"];
                $taxtotal = $item["quantity"] * $item["price"] * 0.0725;
            ?>
                <tr>
                    <td><a href='tradedetails.php?id=<?php echo $item["id"]; ?>'><img src=<?php echo $item["photofilepath"]; ?> class="img-thumbnail" height="100px;" width="100px;" alt="image"></a><?php echo $item["name"]; ?></td>
                    <td><?php echo substr($item["descriptions"], 0, 22); ?></td>
                    <td><?php echo $item["code"]; ?></td>
                    <td><?php echo $item["quantity"]; ?></td>
                    <td><?php echo "$ " . $item["price"]; ?></td>
                    <td><?php echo "$ " . number_format($item_price, 2); ?></td>
                    <td><a href='productslist.php?action=remove&code=<?php echo $item["code"]; ?>' class="btnRemoveAction">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                            </svg></a></td>
                </tr>
            <?php
                $total_quantity += $item["quantity"];
                $total_pricenotax += ($item["price"] * $item["quantity"]);
                $total_price += $total_pricenotax + $taxtotal;
            }
            ?>

            <tr>
                <td colspan="2" align="right">Total After Tax:</td>
                <td align="right"><?php echo $total_quantity; ?></td>
                <td align="right" colspan="2"><strong><?php echo "$ " . number_format($total_price, 2); ?></strong></td>
                <td></td>
            </tr>
        </table>
        <div align="right">
            <a href="productslist.php?action=empty" class="btn btn-secondary" id="clear_cart">
                <span class="glyphicon glyphicon-trash"></span> Clear
            </a>
            <a href="orderdetails.php" class="btn btn-primary" id="check_out_cart">
                <span class="glyphicon glyphicon-shopping-cart"></span> Check Out
            </a>
        </div>
    <?php
    }
    ?>




</div>


<form method="post" action="">

    <select id="cat" method="post" name="cat" onchange="this.form.submit()">
        <option value="Choose one">Category</option>
        <?php
        if (count($catalogs) > 0) :
            foreach ($catalogs as $cat) :
        ?>
                <option value="<?php echo $cat['id']; ?>">
                    <?php
                    $catname = $cat['name'];
                    echo $catname; ?>
                </option>
        <?php
            endforeach;
        endif;
        ?>
    </select><span> &nbsp; &nbsp;</span>
    <input type="text" size="25" name="searchkey" /><span>&nbsp;</span>
    <button type="submit" class="btn btn-primary float-right m-2">
        <svg xmlns='http://www.w3.org/2000/svg' width=16 height=16 fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0' />
        </svg>
    </button>

</form>
<table class="table table-sm" style="color:#66a2ba;">
    <tbody>
        <tr>
            <td>
                <?php
                $catid = 4;
                $code = 0;
                $searchkey = '';
                $product_array = $db_handle->runQuery($getproductbycatidsql);
                if (count($product_array) > 0) {
                    foreach ($product_array as $key => $value) {
                        $url = "productslist.php?action=add&code=" . $product_array[$key]['code'];
                        echo "<form method='post' action=$url";
                        echo ">";
                        echo "";
                        echo "<div>";
                        // var_dump($url);
                        if (!empty($product_array[$key]['photofilepath'])) {
                            echo "<a href='tradedetails.php?id=" . $product_array[$key]['id'];
                            echo "'>";
                            echo "<img id=" . $product_array[$key]['photofilepath'];
                            echo " onclick='setImage(this.id)' src=" . $product_array[$key]['photofilepath'];
                            echo " class='rounded-circle' height='150px;' width='150px;' alt='image'>";

                            echo "</a>";
                            echo "</div>";
                            echo "<div class='product-title'>	";
                            echo "<a href='tradedetails.php?id=" . $product_array[$key]['id'];
                            echo "'>";
                            echo "" . $product_array[$key]['name'];
                            echo "</a>";
                            echo "</div>";
                            // echo "<div class='product-details'>" . $product_array[$key]['descriptions'];
                            // echo "</div>";
                            echo "<div class='product-price'>$" . $product_array[$key]['price'];
                            echo "</div><br>";
                            echo "<div class='product-details'><input type='text' name='quantity' value='1' size='2' /><span> &nbsp; &nbsp;</span><button type='submit' class='btn btn-primary'><i class='fa-solid fa-cart-plus'></i> Add to Cart</button></div>";
                            //echo "<div class='cart-actionadd'></div>";
                            // echo "<div class='cart-actionadd'><a href='editTrade.php?id=" . $product_array[$key]['id'];
                            // echo "'>";
                            // if ($_SESSION['login_user'][0] == 1) {
                            //     echo "edit";
                            //     echo "</a></div>";
                            // }
                        }
                        echo "</form>";
                    }
                }
                if (isset($_POST["searchkey"])) {
                    $searchkey = $_POST["searchkey"];
                    $getproductbycatidsql = "select p.id id, p.code code, 
            p.name name, p.descriptions descriptions,p.code code, p.price price, 
            p.imageid imageid,i.photofilepath, p.imageid2 imageid2,p.imageid3 imageid3 from product p,image i where p.imageid = i.id and p.ifactive=1 and p.name like '%" . $searchkey . "%'";
                    $product_array = $db_handle->runQuery($getproductbycatidsql);
                    if (count($product_array) > 0) {
                        foreach ($product_array as $key => $value) {
                            $url = "productslist.php?action=add&code=" . $product_array[$key]['code'];
                            echo "<form method='post' action=$url";
                            echo ">";
                            echo "";
                            echo "<div>";
                            // var_dump($getproductbycatidsql);
                            if (!empty($product_array[$key]['photofilepath'])) {
                                echo "<a href='tradedetails.php?id=" . $product_array[$key]['id'];
                                echo "'>";
                                echo "<img id=" . $product_array[$key]['photofilepath'];
                                echo " onclick='setImage(this.id)' src=" . $product_array[$key]['photofilepath'];
                                echo " class='rounded-circle' height='150px;' width='150px;' alt='image'>";
                                echo "</a>";
                                echo "</div>";
                                echo "<div class='product-tile-footer'>	";
                                echo "<a href='tradedetails.php?id=" . $product_array[$key]['id'];
                                echo "'></div>";
                                echo "<div class='product-title'>" . $product_array[$key]['name'];
                                echo "</a>";
                                echo "</div>";
                                // echo "<div class='product-details'>" . $product_array[$key]['descriptions'];
                                // echo "</div>";
                                echo "<div class='product-price'>$" . $product_array[$key]['price'];
                                echo "</div><br>";
                                echo "<div class='product-details'><input type='text' name='quantity' value='1' size='2' /><span> &nbsp; &nbsp;</span><button type='submit' class='btn btn-primary'><i class='fa-solid fa-cart-plus'></i>Add to Cart</button></div>";
                                //echo "<div class='cart-actionadd'></div>";
                                // echo "<div class='cart-actionadd'> <a href='editTrade.php?id=" . $product_array[$key]['id'];
                                // echo "'>";
                                // if ($_SESSION['login_user'][0] == 1) {
                                //     echo "edit";
                                //     echo "</a></div>";
                                // }
                            }
                            echo "</form>";
                        }
                    }
                } ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle" viewBox="0 0 16 16">
                        <path d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.146 4.992c-1.212 0-1.927.92-1.927 2.502v1.06c0 1.571.703 2.462 1.927 2.462.979 0 1.641-.586 1.729-1.418h1.295v.093c-.1 1.448-1.354 2.467-3.03 2.467-2.091 0-3.269-1.336-3.269-3.603V7.482c0-2.261 1.201-3.638 3.27-3.638 1.681 0 2.935 1.054 3.029 2.572v.088H9.875c-.088-.879-.768-1.512-1.729-1.512" />
                    </svg> 2025 iDIGUE
                </div>
            </td>
        </tr>
    </tbody>
</table>


</html><?php
        session_start();
        ob_start();
        require_once("dbcontroller.php");
        $db_handle = new DBController();
        if (!empty($_GET["action"])) {
            switch ($_GET["action"]) {
                case "add":
                    if (!empty($_POST["quantity"])) {
                        $productByCode = $db_handle->runQuery("select p.id id, p.code code, p.name name, p.descriptions descriptions, p.price price, i.photofilepath,p.imageid imageid from product p,image i where p.imageid = i.id and p.ifactive=1 and  p.code='" . $_GET["code"] . "'");
                        $itemArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 'id' => $productByCode[0]["id"], 'descriptions' => $productByCode[0]["descriptions"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'photofilepath' => $productByCode[0]["photofilepath"], 'price' => $productByCode[0]["price"]));

                        if (!empty($_SESSION["cart_item"])) {
                            if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
                                foreach ($_SESSION["cart_item"] as $k => $v) {
                                    if ($productByCode[0]["code"] == $k) {
                                        if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                            $_SESSION["cart_item"][$k]["quantity"] = 0;
                                        }
                                        $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                    }
                                }
                            } else {
                                $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                            }
                        } else {
                            $_SESSION["cart_item"] = $itemArray;
                        }
                    }

                    break;
                case "remove":
                    if (!empty($_SESSION["cart_item"])) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            foreach ($v as $kn => $vn) {
                                if ($_GET["code"] == $vn) {
                                    unset($_SESSION["cart_item"][$k]);
                                }
                                if (empty($_SESSION["cart_item"]))
                                    unset($_SESSION["cart_item"]);
                            }
                        }
                    }
                    break;
                case "empty":
                    unset($_SESSION["cart_item"]);
                    break;
            }
        }
        $catalogs = $db_handle->runQuery("select * from `catalog` where isparent=0 and parentcatalogid=2");
        $subcatalogs = $db_handle->runQuery("select * from `subcatalog`");
        if (isset($_GET["filter"])) {
            $filter = $_GET["filter"];

            $getproductbycatidsql = "select p.id id, p.code code, 
p.name name, p.descriptions descriptions,p.code code, p.price price, 
p.imageid imageid, i.photofilepath,p.imageid2 imageid2,p.imageid3 imageid3 from product p,image i where p.imageid = i.id and p.ifactive=1 and p.subcatid=" . $filter;
        } else if (isset($_POST["cat"])) {
            $catid = $_POST["cat"];


            $getproductbycatidsql = "select p.id id, p.code code, 
p.name name, p.descriptions descriptions,p.code code, p.price price, 
p.imageid imageid, i.photofilepath,p.imageid2 imageid2,p.imageid3 imageid3 from product p,image i where p.imageid = i.id and p.ifactive=1 and p.catid=" . $catid;
        } else {
            $catid = $_POST["cat"];


            $getproductbycatidsql = "select p.id id, p.code code, 
p.name name, p.descriptions descriptions,p.code code, p.price price, 
p.imageid imageid, i.photofilepath,p.imageid2 imageid2,p.imageid3 imageid3 from product p,image i where p.imageid = i.id and p.ifactive=1 and i.photofilepath!='' order by p.id desc";
        }
        ?>
<!doctype html>
<html lang="en">
<?php include 'head.php'; ?>
<?php include 'breadcrumb.php'; ?>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/site.js" asp-append-version="true"></script>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <a href="aboutus.php"><img class="img-zoom-resultindex" data-toggle="tooltip" data-placement="top" title="About Us" height="60px;" width="60px;" src="Image/logo.png"></a>

        <?php if ($_SESSION['login_user'][0] == 1)
            echo '<li class="breadcrumb-item"><a href="adtrade.php">Add Product</a></li>'
        ?>
        <li class="breadcrumb-item" aria-current="page"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
            </svg> Gift Shop</li>

    </ol>
</nav>
<div id="shopping-cart">
    <?php
    if (isset($_SESSION["cart_item"])) {
        $total_quantity = 0;
        $total_price = 0;
    ?>
        <table class="table table-dark table-sm">
            <tr>

                <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Descriptions
                        </th>
                        <th>
                            Code
                        </th>
                        <th>
                            Quantity
                        </th>
                        <th>
                            Unit Price
                        </th>
                        <th>
                            Price
                        </th>
                        <th>
                            Remove
                        </th>

                    </tr>
                </thead>
            </tr>
            <?php

            foreach ($_SESSION["cart_item"] as $item) {
                $item_price = $item["quantity"] * $item["price"];
                $taxtotal = $item["quantity"] * $item["price"] * 0.0725;
            ?>
                <tr>
                    <td><a href='tradedetails.php?id=<?php echo $item["id"]; ?>'><img src=<?php echo $item["photofilepath"]; ?> class="img-thumbnail" height="100px;" width="100px;" alt="image"></a><?php echo $item["name"]; ?></td>
                    <td><?php echo substr($item["descriptions"], 0, 22); ?></td>
                    <td><?php echo $item["code"]; ?></td>
                    <td><?php echo $item["quantity"]; ?></td>
                    <td><?php echo "$ " . $item["price"]; ?></td>
                    <td><?php echo "$ " . number_format($item_price, 2); ?></td>
                    <td><a href='productslist.php?action=remove&code=<?php echo $item["code"]; ?>' class="btnRemoveAction">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                            </svg></a></td>
                </tr>
            <?php
                $total_quantity += $item["quantity"];
                $total_pricenotax += ($item["price"] * $item["quantity"]);
                $total_price += $total_pricenotax + $taxtotal;
            }
            ?>

            <tr>
                <td colspan="2" align="right">Total After Tax:</td>
                <td align="right"><?php echo $total_quantity; ?></td>
                <td align="right" colspan="2"><strong><?php echo "$ " . number_format($total_price, 2); ?></strong></td>
                <td></td>
            </tr>
        </table>
        <div align="right">
            <a href="productslist.php?action=empty" class="btn btn-secondary" id="clear_cart">
                <span class="glyphicon glyphicon-trash"></span> Clear
            </a>
            <a href="orderdetails.php" class="btn btn-primary" id="check_out_cart">
                <span class="glyphicon glyphicon-shopping-cart"></span> Check Out
            </a>
        </div>
    <?php
    }
    ?>




</div>


<form method="post" action="">

    <select id="cat" method="post" name="cat" onchange="this.form.submit()">
        <option value="Choose one">Category</option>
        <?php
        if (count($catalogs) > 0) :
            foreach ($catalogs as $cat) :
        ?>
                <option value="<?php echo $cat['id']; ?>">
                    <?php
                    $catname = $cat['name'];
                    echo $catname; ?>
                </option>
        <?php
            endforeach;
        endif;
        ?>
    </select><span> &nbsp; &nbsp;</span>
    <input type="text" size="25" name="searchkey" /><span>&nbsp;</span>
    <button type="submit" class="btn btn-primary float-right m-2">
        <svg xmlns='http://www.w3.org/2000/svg' width=16 height=16 fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0' />
        </svg>
    </button>

</form>
<table class="table table-sm" style="color:#66a2ba;">
    <tbody>
        <tr>
            <td>
                <?php
                $catid = 4;
                $code = 0;
                $searchkey = '';
                $product_array = $db_handle->runQuery($getproductbycatidsql);
                if (count($product_array) > 0) {
                    foreach ($product_array as $key => $value) {
                        $url = "productslist.php?action=add&code=" . $product_array[$key]['code'];
                        echo "<form method='post' action=$url";
                        echo ">";
                        echo "";
                        echo "<div>";
                        // var_dump($url);
                        if (!empty($product_array[$key]['photofilepath'])) {
                            echo "<a href='tradedetails.php?id=" . $product_array[$key]['id'];
                            echo "'>";
                            echo "<img id=" . $product_array[$key]['photofilepath'];
                            echo " onclick='setImage(this.id)' src=" . $product_array[$key]['photofilepath'];
                            echo " class='rounded-circle' height='150px;' width='150px;' alt='image'>";

                            echo "</a>";
                            echo "</div>";
                            echo "<div class='product-title'>	";
                            echo "<a href='tradedetails.php?id=" . $product_array[$key]['id'];
                            echo "'>";
                            echo "" . $product_array[$key]['name'];
                            echo "</a>";
                            echo "</div>";
                            // echo "<div class='product-details'>" . $product_array[$key]['descriptions'];
                            // echo "</div>";
                            echo "<div class='product-price'>$" . $product_array[$key]['price'];
                            echo "</div><br>";
                            echo "<div class='product-details'><input type='text' name='quantity' value='1' size='2' /><span> &nbsp; &nbsp;</span><button type='submit' class='btn btn-primary'><i class='fa-solid fa-cart-plus'></i> Add to Cart</button></div>";
                            //echo "<div class='cart-actionadd'></div>";
                            // echo "<div class='cart-actionadd'><a href='editTrade.php?id=" . $product_array[$key]['id'];
                            // echo "'>";
                            // if ($_SESSION['login_user'][0] == 1) {
                            //     echo "edit";
                            //     echo "</a></div>";
                            // }
                        }
                        echo "</form>";
                    }
                }
                if (isset($_POST["searchkey"])) {
                    $searchkey = $_POST["searchkey"];
                    $getproductbycatidsql = "select p.id id, p.code code, 
            p.name name, p.descriptions descriptions,p.code code, p.price price, 
            p.imageid imageid,i.photofilepath, p.imageid2 imageid2,p.imageid3 imageid3 from product p,image i where p.imageid = i.id and p.ifactive=1 and p.name like '%" . $searchkey . "%'";
                    $product_array = $db_handle->runQuery($getproductbycatidsql);
                    if (count($product_array) > 0) {
                        foreach ($product_array as $key => $value) {
                            $url = "productslist.php?action=add&code=" . $product_array[$key]['code'];
                            echo "<form method='post' action=$url";
                            echo ">";
                            echo "";
                            echo "<div>";
                            // var_dump($getproductbycatidsql);
                            if (!empty($product_array[$key]['photofilepath'])) {
                                echo "<a href='tradedetails.php?id=" . $product_array[$key]['id'];
                                echo "'>";
                                echo "<img id=" . $product_array[$key]['photofilepath'];
                                echo " onclick='setImage(this.id)' src=" . $product_array[$key]['photofilepath'];
                                echo " class='rounded-circle' height='150px;' width='150px;' alt='image'>";
                                echo "</a>";
                                echo "</div>";
                                echo "<div class='product-tile-footer'>	";
                                echo "<a href='tradedetails.php?id=" . $product_array[$key]['id'];
                                echo "'></div>";
                                echo "<div class='product-title'>" . $product_array[$key]['name'];
                                echo "</a>";
                                echo "</div>";
                                // echo "<div class='product-details'>" . $product_array[$key]['descriptions'];
                                // echo "</div>";
                                echo "<div class='product-price'>$" . $product_array[$key]['price'];
                                echo "</div><br>";
                                echo "<div class='product-details'><input type='text' name='quantity' value='1' size='2' /><span> &nbsp; &nbsp;</span><button type='submit' class='btn btn-primary'><i class='fa-solid fa-cart-plus'></i>Add to Cart</button></div>";
                                //echo "<div class='cart-actionadd'></div>";
                                // echo "<div class='cart-actionadd'> <a href='editTrade.php?id=" . $product_array[$key]['id'];
                                // echo "'>";
                                // if ($_SESSION['login_user'][0] == 1) {
                                //     echo "edit";
                                //     echo "</a></div>";
                                // }
                            }
                            echo "</form>";
                        }
                    }
                } ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle" viewBox="0 0 16 16">
                        <path d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.146 4.992c-1.212 0-1.927.92-1.927 2.502v1.06c0 1.571.703 2.462 1.927 2.462.979 0 1.641-.586 1.729-1.418h1.295v.093c-.1 1.448-1.354 2.467-3.03 2.467-2.091 0-3.269-1.336-3.269-3.603V7.482c0-2.261 1.201-3.638 3.27-3.638 1.681 0 2.935 1.054 3.029 2.572v.088H9.875c-.088-.879-.768-1.512-1.729-1.512" />
                    </svg> 2025 iDIGUE
                </div>
            </td>
        </tr>
    </tbody>
</table>


</html>