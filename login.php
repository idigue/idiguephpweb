<!doctype html>
<html lang="en">
<?php include 'components/head.php'; ?>
<?php include 'components/breadcrumb.php'; ?>
<?php
ob_start();
session_start();
require_once 'dbcontroller.php';
$db_handle = new DBController();
if ($_POST) {
  if (isset($_POST['go'])) {
    // $username = $_POST['username'];
    // $username = mysqli_real_escape_string($db, $username);
    // $plainPassword = mysqli_real_escape_string($db, $password);
    $sql = "SELECT * FROM users u WHERE u.username = '" . $_POST["username"] . "'";
    $users = $db_handle->runQuery($sql);
    $user = $users[0];
    if (isset($user) and password_verify($_POST['password'], $user['password'])) {
      $uid = $user['id'];
      $username = $user['username'];
      $groupid = $user['groupid'];
      $user = array($uid, $username, $groupid);
      $_SESSION['login_user'] = $user;
      header("Location:/index.php");
      exit;
    }
  }
} 
?>

<body>
  <div class="login">
    <h2>Memeber Login</h2>
    <form method="post">
      <label for="username">
        <i class="fas fa-user"></i>
      </label>
      <input type="text" name="username" placeholder="Username" id="username" required><br><br>
      <label for="password">
        <i class="fas fa-lock"></i>
      </label>
      <input type="password" name="password" placeholder="Password" id="password" required>
      <span><i id="toggler1" class="far fa-eye"></i></span>&nbsp; &nbsp; &nbsp;
      <input type="submit" name="go" value="Login">

      <br><br><br><a href="aduser.php">New Member</a>
    </form>
  </div>
</body>
<script>
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
</script>

</html>