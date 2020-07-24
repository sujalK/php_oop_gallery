<?php include("includes/header.php"); ?>

<?php 

    require_once("admin/includes/init.php");

    $photo= Photo::find_by_id($_GET['id']);

    if(isset($_POST['submit'])) {

        $author = trim(htmlspecialchars($_POST['author']));
        $body   = trim(htmlspecialchars($_POST['body']));

        $new_comment= Comment::create_comment($photo->id, $author, $body);

        if($new_comment) {
            $new_comment->save();
            redirect("photos.php?id={$photo->id}");
        } else {
            $message= "There was some problems while saving.";
        }

    } else {
        $author = '';
        $body   = '';
    }
    
    $comments= Comment::find_the_comments($photo->id);

    // echo "<pre>";
    //     print_r($comments);
    // echo "</pre>";

?>

        <div class="row">
            <!-- Blog Post Content Column -->
            <div class="col-lg-12">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo $photo->title; ?></h1>
                
                <!-- Author -->
                <p class="lead">
                    by <a href="#">Sujal Khatiwada</a>
                </p>

                <hr>

                <!-- Preview Image -->
                <img style="width: 60%; height: 50%" class="img-responsive" src="<?php echo "admin/images/". $photo->filename; ?>" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?php echo $photo->caption; ?></p>
                <p><?php echo $photo->description; ?></p>
                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                

                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" id="author" class="form-control" name="author">
                        </div>
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>


                <!-- Comment -->
                <h2 style='margin-bottom: 2.2rem !important;'>Comments</h2>
                <?php 
                    foreach($comments as $comment):
                        // $sql     = "SELECT id, filename FROM photos WHERE id={$comment->photo_id} LIMIT 1";
                        $sql= "SELECT filename FROM photos p 
                                JOIN 
                                comments c 
                                ON 
                                p.id= $comment->photo_id";
                        
                        $photo = Photo::find_by_query($sql);
                ?>
                <div class="media" style='margin-bottom: 2.2rem !important;'>
                    <a class="pull-left" href="#">
                        <img class="media-object" style='width: 62px;' src="<?php echo "admin/images/". $photo[0]->filename; ?>" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment->author; ?>
                            <!-- <small>August 25, 2014 at 9:30 PM</small> -->
                        </h4>
                        <?php echo $comment->body; ?>
                    </div>
                        
                </div>
                <?php endforeach; ?>
            </div>
        </div>

            <!-- Blog Sidebar Widgets Column -->
            <!-- <div class="col-md-4">

                <?php // include("includes/sidebar.php"); ?>

            </div> -->
            <!-- /.row -->

<?php include("includes/footer.php"); ?>
