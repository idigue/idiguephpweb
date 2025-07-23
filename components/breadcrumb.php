<div class="topnav">
  <?php
  if (isset($_SESSION['login_user'])) {
    $uname = $_SESSION['login_user'][1];
  } else {
    $uname = 'Anonymous';
  }
$base="https://idigue.com/"
  ?>

  <a href="https://idigue.com/index.php" data-toggle="tooltip"   data-placement="top" title="Home" class="forcast">Hello,
    <?php echo $uname ?>
    <?php if (!empty($_SESSION["cart_item"])) {

    ?>
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
      </svg>
    <?php
      $items = is_array($_SESSION['cart_item']) ? count($_SESSION['cart_item']) : 0;
      echo $items . " item(s)";
    }
    ?>
  </a>


  <div id="myLinksAdmin">

    <div style="color:red;"><?php echo $user ?></div>
    </a>
    <?php if (isset($_SESSION['login_user'])) :
      echo '<a href="edituserdetails.php">Update User Information</a>';
    endif;
    ?>
    <?php if ($_SESSION['login_user'][0] == 1):
      echo '<a href="admin.php">Admin </a>';
      echo '<a href="adtrade.php">Add Products </a>';
      echo '<a href="upload.php">Tools Uploadsql </a>';
    endif;
    ?>
  </div>

  <a href="javascript:void(0);" data-toggle="tooltip"   data-placement="top" title="Menu" class="icon" onclick="funmenu()">
    <i class="fa-solid fa-list"></i>
  </a>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
    <form action="https://idigue.com/searchresult.php" method="post">
      <div class="searchicon"><input type="text" name="searchkey" />
        <button type="submit" class="btn btn-primary float-right m-2" value="Search">
          <svg xmlns='http://www.w3.org/2000/svg' width=16 height=16 fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0' />
          </svg>
        </button>
      </div>
    </form>
    <a href="https://idigue.com/image.php"><i class="fa-solid fa-image"></i></a>
    <a href="https://idigue.com/aduser.php"  data-toggle="tooltip"   data-placement="top" title="Membership" ><i class="fa-solid fa-user-plus"></i></a>
    <a href="https://idigue.com/productslist.php"  data-toggle="tooltip"   data-placement="top" title="Gift Shop" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
            </svg></a>
    
    <a href="aboutus.php"  data-toggle="tooltip"   data-placement="top" title="About Us" ><i class="fa-solid fa-circle-info"></i></a>
    <?php if (isset($_SESSION['login_user'])) :
      echo '<a href="logout.php"  data-toggle="tooltip"   data-placement="top" title="Logout"><i class="fa-solid fa-right-to-bracket"></i></a>'; ?>
    <?php else:
      
    endif;
    ?>
  </div>
  <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
  <a href="https://idigue.com/userspace.php" data-toggle="tooltip"   data-placement="top" title="Developer Space" class="iconsupply" onclick="funmenuadmin()">
    <i class="fa-solid fa-rss"  aria-hidden="true"></i>
  </a>
  <a href="https://idigue.com/login.php" data-toggle="tooltip"   data-placement="top" title="Contractor Login" class="iconlogin" onclick="funmenuadmin()">
    <i class="fa-solid fa-user"></i>
  </a>

</div>
<script>
  function funmenuadmin() {
    var x = document.getElementById("myLinksAdmin");
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }

  function funmenu() {
    var x = document.getElementById("myLinks");
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }
</script>