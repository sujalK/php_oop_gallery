<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) { redirect('login.php'); } ; ?>     
<?php 

    // $user= User::find_by_id($_GET['create']);

    $user= new User();

    if(isset($_POST['create'])) {  
        if($user) {

            $user->username   = $_POST['username'];
            $user->first_name = $_POST['first_name'];
            $user->last_name  = $_POST['last_name'];
            $user->password   = password_hash($_POST['password'], PASSWORD_BCRYPT);
            
            $user->set_file($_FILES['user_image']);
            $user->save_user_and_image();
            $session->message("The user {$user->username} has been added!");
            $user->save();
            redirect("users.php");
            
        }
    }

?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            
            <?php include("includes/top_nav.php"); ?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include("includes/side_nav.php"); ?> 

            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="col-md-6 col-md-offset-3">
                                <h1 class="page-header">
                                    Edit User
                                    <small></small>
                                </h1>
                                <div class="form-group">
                                    <input type="file" name="user_image" id="">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" name="username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="first_name">First name</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last name</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="text" id="password" name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="create" class="btn btn-primary pull-right">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>