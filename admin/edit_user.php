<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) { redirect('login.php'); } ; ?>     
<!-- Modal -->
<?php include("includes/photo_library_modal.php"); ?>
<?php 

    if(empty($_GET['id'])) {
        redirect("users.php");
    }

    $user= User::find_by_id($_GET['id']);

    if(isset($_POST['update'])) {
        if($user) {

            $user->username   = $_POST['username'];
            $user->first_name = $_POST['first_name'];
            $user->last_name  = $_POST['last_name'];
            $user->password   = $_POST['password'];

            if(empty($_FILES['user_image'])) {
                $user->save();
                $session->message("The user has been updated");
                redirect("users.php");
            } else {
                $user->set_file($_FILES['user_image']);
                $user->save_user_and_image();
                $user->save();
                $session->message("The user has been updated");
                // redirect("edit_user.php?id={$user->id}");
                redirect("users.php");
            }

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
                        <div class="col-md-6">
                            <a href="#" data-toggle="modal" data-target="#photo-library"><img id="display_image" class="img-responsive" src="<?php echo $user->image_path_placeholder(); // echo "images/". $user->user_image; ?>" alt="user_image"></a>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            
                            <div class="col-md-6">
                                <h1 class="page-header">
                                    Edit User
                                    <small></small>
                                </h1>
                                <div class="form-group">
                                    <input type="file" name="user_image" id="">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" value="<?php echo $user->username; ?>" id="username" name="username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="first_name">First name</label>
                                    <input type="text" value="<?php echo $user->first_name; ?>" id="first_name" name="first_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last name</label>
                                    <input type="text" value="<?php echo $user->last_name; ?>" id="last_name" name="last_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" value="<?php echo $user->password; ?>" id="password" name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <a id="user-id" href="delete_user.php?id=<?php echo $user->id; ?>" class="btn btn-danger pull-left">Delete</a>
                                    <input type="submit" name="update" class="btn btn-primary pull-right" value="Update">
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