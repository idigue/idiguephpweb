<!doctype html>
<html lang="en">
<?php include 'components/head.php'; ?>
<?php include 'breadcrumb.php'; ?>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/site.js" asp-append-version="true"></script>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <a href="privacy.php"><img class="img-zoom-resultindex" height="100px;" width="100px;" src="Image/logo.png"></a>

        <li class="breadcrumb-item"><a href="orderlogs.php">Order History</a></li>
        <li class="breadcrumb-item"><a href="accountinfo.php">Account Details</a></li>
        <li class="breadcrumb-item"><a href="return.php">Returns</a></li>
        <li class="breadcrumb-item"><a href="assistant.php">iDIGUE Assistant</a></li>
        <li class="breadcrumb-item"><a href="privacy.php"> Privacy</a></li>
    </ol>
</nav>

<body>

    <?php

    if ($_POST) {
        $sql = "insert into `clientissues`";
        $sql .= "(`createdtime`, `firstname`, `lastname`,`email`,`notes`)";
        $sql .= "values(";
        $sql .= "'" . date("Y-m-d H:i:s") . "',";
        $sql .= "'" . $_POST['firstname']  . "',";
        $sql .= "'" . $_POST['lastname']  . "',";
        $sql .= "'" . $_POST['email']  . "',";
        $sql .= "'" . $_POST['notes'] . "'";
        $sql .= ");";
        if (isset($_POST['go'])) {
            $message = $_POST['firstname'] . ',  ' . $_POST['lastname'] . ', ' . $_POST['notes'];;
            $from = $_POST['email'];
            mail($to, $subject, $message, $from);
            $result = $db_handle->runQuery($sql);
            if ($result == "success") {
                header("Location:/index.php?msg=MessageReceived");
                die;
            }
        }
    }



    ?>

    <form method="post">
        <div class="text-left">

            <h5>
                Please allow 24-48 hours, for faster response email to idigueio@gmail.com <br>
            </h5>
        </div>

        <h2 class="text-primary">Contact Us</h2>
        <table class="table table-sm" style="color:#66a2ba;">
            <span id='message' style="color:red;"></span>
            <tr>
                <td>
                    <label><b>First Name <span class="text-danger">*</span></b></label>
                </td>
                <td><input type="text" size=50 placeholder="Firstname" id="firstname" name="firstname" required />
                </td>
            </tr>
            <tr>
                <td>
                    <label><b>Last Name <span class="text-danger">*</span></b></label>
                </td>
                <td><input type="text" size=50 placeholder="Lastname" id="lastname" name="lastname" required />
                </td>
            </tr>
            <tr>
                <td>
                    <label><b>Email<span class="text-danger">*</span></b></label>
                </td>
                <td><input type="email" size=50 placeholder="Email" id="email" name="email" required />
                </td>
            </tr>
            <tr>
                <td>
                    <label><b>Notes</b></label>
                </td>
                <td><textarea cols="50" placeholder="Notes" rows="5" name="notes"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="index.php" class="btn btn-primary">Cancel</a>
                    <button type="submit" name="go" class="btn btn-primary float-right m-2">
                        Done
                    </button>
                </td>

            </tr>
        </table>
        <div class="text-center">
            <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle" viewBox="0 0 16 16">
                    <path d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.146 4.992c-1.212 0-1.927.92-1.927 2.502v1.06c0 1.571.703 2.462 1.927 2.462.979 0 1.641-.586 1.729-1.418h1.295v.093c-.1 1.448-1.354 2.467-3.03 2.467-2.091 0-3.269-1.336-3.269-3.603V7.482c0-2.261 1.201-3.638 3.27-3.638 1.681 0 2.935 1.054 3.029 2.572v.088H9.875c-.088-.879-.768-1.512-1.729-1.512" />
                </svg> 2025 iDIGUE</p>
        </div>
    </form>
</body>

</html>