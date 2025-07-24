<!doctype html>
<html lang="en">
<?php include 'components/head.php'; ?>
<?php include 'components/breadcrumb.php'; ?>
<?php
$uid = 2;
$db_handle = new DBController();
if ($_POST) {
    if (isset($_POST['go'])) {
        if (isset($_SESSION['login_user'])) {
            $uid = $_SESSION['login_user'][0];
            //$user = getuserdetailsbyuid($db, $uid);
            $user = $db_handle->runQuery("select a.username, a.ifcustomer, a.password,u.techstack,u.email,u.address, u.phone  from `user` u, `accounts` a where u.id=a.uid and u.id=" . $uid);
        }
        $groupid = $_POST["ifcustomer"] == "on" ? 3 : 2; // 3 is customer, 2 is member
        $plainPassword = $_POST['password'];
        $password = password_hash($plainPassword, PASSWORD_DEFAULT);

        if (!isset($user)) {
            $sql = "insert into `users`";
            $sql .= "(`username`, `address`, `phone`, `techstack`, `password`, `groupid`, 
    `email`)";
            $sql .= "values(";
            $sql .= "'" . $_POST['username'] . "',";
            $sql .= "'" . $_POST['address'] . "',";
            $sql .= "'" . $_POST['phone'] . "',";
            $sql .= "'" . $_POST['techstack'] . "',";
            $sql .= "'" . $password . "',";
            $sql .= "'" . $groupid . "',";
            $sql .= "'" . $_POST['email'] . "'";
            $sql .= ");";
            $uid = $db_handle->runQuery($sql);
            if ($uid == 0) {
                echo "Error, username exist";
            } else {
                header("Location:/index.php");
                die;
            }
        } else {
            $sql = "update `users` ";
            $sql .= "SET `username` =";

            $sql .= "'" . $_POST['username'] . "',";
            $sql .= "`address`=" . "'" . $_POST['address'] . "',";
            $sql .= "`email`=" . "'" . $_POST['email'] . "',";
            $sql .= "`techstack`=" . "'" . $_POST['techstack'] . "',";
            $sql .= "`groupid`=" . "'" . $groupid . "',";
            $sql .= "`phone`=" . "'" . $_POST['phone'] . "',";
            $sql .= " `password` =" . "'" . $password  . "'";
            $sql .= " WHERE id= '" . $aid . "';";
            header("Location:/index.php");
            die;
        }
    } else {
        echo "Error";
        die;
    }
}

?>

<form name="adduserform" onsubmit="return validateForm()" method="post">
    <div class="login">
        <?php if (isset($uid)) { ?><h3 class="text-primary">Edit User</h3>
        <?php  } else { ?><h3 class="text-primary">New Member</h3><?php  } ?>

    </div>
    <table class="table table-dark" style="color:#66a2ba;">
        <tr>
            <td>
                <label><b>Username <span class="text-danger">*</span></b></label>
            </td>
            <td><input value="<?php echo $user[0]["username"]; ?>" type="text" placeholder="Username" id="username" name="username" required />
            </td>
        </tr>
        <tr>
            <td>
                <div class="password-field">
                    <label><b>Password<span class="text-danger">*</span></b></label>
            </td>
            <td><input value="<?php echo $user[0]["password"]; ?>" type="password" id="password" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required />
                <span><i id="toggler1" class="far fa-eye"></i></span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="password-field">
                    <label><b>Password Verify<span class="text-danger">*</span></b></label>
            </td>
            <td><input value="<?php echo $user[0]["password"]; ?>" type="password" id="passwordre" name="passwordre" placeholder="Password Verify" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required />
                <span><i id="toggler2" class="far fa-eye"></i></span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label><b>Email<span class="text-danger">*</span></b></label>
            </td>
            <td><input type="email" placeholder="Email" id="email" name="email" value="<?php echo $user[0]["email"]; ?>" required />
            </td>
        </tr>
        <tr>
            <td>
                <label><b>Phone</b></label>
            </td>
            <td><input type="text" placeholder="Phone" id="phone" name="phone" value="<?php echo $user[0]["phone"]; ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label><b>
                        Address </b></label>
            </td>
            <td><textarea placeholder="Address" id="address" name="address"><?php echo $user[0]["address"]; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <label><b>Tech Stacks </b></label>
            </td>
            <td><textarea placeholder="Stacks" id="techstack" name="techstack"><?php echo $user[0]["techstack"]; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <label><b>Want to post projects?</b></label>
            </td>
            <td><label class="switch">
                    <input type="checkbox" <?php if ($user[0]["ifcustomer"] == 1) echo "checked='checked'"; ?> name="ifcustomer" />
                    <span class="slider round"></span>
                </label>
            </td>
        </tr>
        <tr>
            <td><a href="index.php" class="btn btn-primary">Cancel</a>
                <button type="submit" name="go" class="btn btn-primary float-right m-2">
                    Ok
                </button>
            </td>
        </tr>
    </table>
</form>

<script>
    function validateForm() {
        let x = document.forms["adduserform"]["username"].value;
        let y = document.forms["adduserform"]["password"].value;
        let z = document.forms["adduserform"]["passwordre"].value;
        if (x == "" || y == "") {
            alert("Username and password must be filled out");
            document.getElementById('message').innerHTML = "Username and password must be filled out";
            return false;
        }
        if (y === z) {

        } else {
            document.getElementById('message').innerHTML = "Passwords do not match";
            return false;
        }

    }
    var password = document.getElementById('password');

    var toggler1 = document.getElementById('toggler1');

    showHidePassword = () => {
        if (password.type == 'password') {
            password.setAttribute('type', 'text');
            toggler1.classList.add('fa-eye-slash');
        } else {
            toggler1.classList.remove('fa-eye-slash');
            password.setAttribute('type', 'password');
        }
    };
    toggler1.addEventListener('click', showHidePassword);
    var passwordre = document.getElementById('passwordre');
    var toggler2 = document.getElementById('toggler2');
    showHidePasswordre = () => {
        if (passwordre.type == 'password') {
            passwordre.setAttribute('type', 'text');
            toggler2.classList.add('fa-eye-slash');
        } else {
            toggler2.classList.remove('fa-eye-slash');
            passwordre.setAttribute('type', 'password');
        }
    };
    toggler2.addEventListener('click', showHidePasswordre);

    function showpw(id) {
        var x = document.getElementById(id);
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

</html>