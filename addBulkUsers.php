<?php
require_once "lib/Session.php";
require_once "classes/Users.php";

spl_autoload_register(function($classes){
    include 'classes/'.$classes.".php";
});

Session::init();
Session::CheckSession();

if(Session::get('roleid') != 1){
    die("only admin allowed.");
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_FILES['filename'])) {

        $users = new Users();

            $handle = fopen($_FILES['filename']['tmp_name'], "r");
            $headers = fgetcsv($handle, 1000, ",");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                if(isset($users)) {
                    $userAdd = $users->addBulkUsersByAdmin($data);
                    echo $userAdd;
                }
            }
            fclose($handle);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
    include 'inc/header.php';
    ?>
    <div class="card ">
        <div class="card-header">
            <h3 class='text-center'>Add Bulk Users</h3>
        </div>
        <div class="cad-body">
            <div style="width:600px; margin:0px auto">

                <form class="" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group pt-3">
                        <input type="file" name="filename" accept=".csv" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-success">Upload csv file</button>
                    </div>

                    <span><small>Note: headers in order is(Name,Username,Email,Password,Mobile,RoleId,IsActive,Created,Updated).</small></span>
                </form>
            </div>


        </div>
    </div>
<?php
    include 'inc/footer.php';
}
?>