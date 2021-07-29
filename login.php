<?php
include_once('config/google_oauth_config.php');
include 'inc/header.php';
Session::CheckLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    if(isset($users)) $userLog = $users->userLoginAuthotication($_POST);
}
if (isset($userLog)) {
  echo $userLog;
}

$logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}
?>
<link rel="stylesheet" href="assets/googleBtnStyle.css">

<div class="card ">
  <div class="card-header">
          <h3 class='text-center'><i class="fas fa-sign-in-alt mr-2"></i>User login</h3>
        </div>
        <div class="card-body">


            <div style="width:450px; margin:0px auto">

            <form class="" action="" method="post">
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="email" name="email"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password"  class="form-control">
                </div>
                <div class="form-group">
                  <button type="submit" name="login" class="btn btn-success">Login</button>
                </div>


            </form>

                <div class="container">
                    <div class="well">
                        <?php if (isset($googleAuthUrl)): ?>
                            <form action="<?php echo $googleAuthUrl; ?>" method="post">
                                <button type="submit" class="loginBtn loginBtn--google">
                                    Login with Google
                                </button>
                            </form>
                        <?php else: ?>
                            <h3>Successfully! Authenticated</h3>
                        <?php endif ?>
                    </div>
                </div>
          </div>
        </div>
      </div>



  <?php
  include 'inc/footer.php';

  ?>
