<?php include("includes/init.php"); ?>
<?php if(!$session->is_signed_in()) { redirect('login.php'); } ; ?>
<?php 

    if(empty($_GET['id'])) {
        redirect("photos.php");
    }

    $user= User::find_by_id($_GET['id']);

    if($user) {
        $user->delete();
        $session->message("The {$user->username} user has been deleted");
        redirect("users.php");
    } else {
        redirect("users.php");
    }
    
?>