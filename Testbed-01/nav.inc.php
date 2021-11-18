<?php 
session_start();

require_once "authCookieSessionValidate.php";

?>

<nav class="navbar navbar-expand-lg navbar-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
      aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex collapse navbar-collapse" id="navbarToggler">
      <div class="me-auto">
        <ul class="navbar-nav p-2">
          <li class="nav-item nav-home">
            <a class="nav-link" href="./index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./gameslist.php">Games</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./about.php">About</a>
          </li>
        </ul>
      </div>
      <div class="p-2">
        <ul class="navbar-nav">
          <li class="nav-item">
            <!--<a class="nav-link" href="./account.php">Account</a>-->
            <?php
                if ($isLoggedIn){ 
                    echo "<a class='nav-link' href='./account.php'>Account</a>";
                }
            ?>
          </li>
          <li class="nav-item">
            <?php
                if (! $isLoggedIn){ 
                    echo "<a class='nav-link' href='./register.php'>Register</a>";
                }
            ?>
          </li>
          <li class="nav-item">
            <!-- <a class="nav-link" href="./login.php">Login</a> -->
            <?php
                if (! $isLoggedIn){ 
                    echo "<button type='button' class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#loginModal'>Login</button>";
                }
                else{
                    echo "<button type='button' class='btn btn-secondary logout' name='logout'>Logout</button>";
                }
            ?>
            <!--
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#loginModal">
              Login
            </button>
            -->
          </li>
        </ul>
      </div>
    </div>
  </nav>