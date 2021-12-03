<?php 
session_start();

require_once "authCookieSessionValidate.php";

include_once "Cart.inc.php";
$userName = $_SESSION['lname'];
$cart = new Cart;

?>

<nav class="navbar navbar-expand-lg navbar-dark">
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
    aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarToggler">
    <div class="me-auto">
      <div class="d-flex navbar-nav p-2 align-items-lg-center">
        <a title="Home" class="nav-link brand" aria-current="page" href="./index.php">GamesDéx</a>
        <a class="nav-link" href="./gameslist.php">Games</a>
        <a class="nav-link" href="./about.php">About</a>
      </div>
    </div>
      <div class="d-flex navbar-nav p-2 align-items-lg-center">
          <?php
              if ($cart->total_items() > 0){ 
                  echo "<a style='text-decoration:none; color:#FFFFFF' href='./viewCart.php'> <img alt='Shopping Cart' src='images/cart.png'>"; 
                  echo " (";
                  echo ($cart->total_items() > 0)?$cart->total_items().' Items':'Empty';
                  echo ") ";
                  echo "</a>";
                  
              }
          ?>
          <?php
              if ($isLoggedIn){ 
                  echo "<a class='nav-link nav-acc' href='./account.php'>Welcome Back, " . $userName . "</a>";
              }
          ?>

          <?php
              if (! $isLoggedIn){ 
                  echo "<a class='nav-link' href='./register.php'>Register</a>";
              }
          ?>
          <?php
              if (! $isLoggedIn){ 
                  echo "<button type='button' class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#loginModal'>Login</button>";
              }
              else{
                  echo "<button type='button' class='btn btn-secondary logout' name='logout'>Logout</button>";
              }
          ?>
      </div>
  </div>
</nav>

 <!-- Modal-->
<div class="modal fade " id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-container">
      <div class="modal-header">
        <h5 class="modal-title" id="loginmodalTitle">Member Login</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="doLogin.php" method="post">
          <!-- Login details -->
          <div class="row login-row">
            <div class="col">
              <label for="email" class="form-label">Enter your email address:</label>
              <input type="email" class="form-control" aria-label="First name" id="email" name="email">
            </div>
          </div>
          <div class="row login-row">
            <div class="col">
              <label for="pwd_" class="form-label">Enter your password:</label>
              <input type="password" class="form-control" aria-label="Last name" id="pwd_" name="pwd_">
            </div>

          </div>

          <button type="submit" class="btn btn-light login-btn">Login</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>