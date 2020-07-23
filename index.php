<?php include("includes/header.php"); ?>

<?php 

    $page= !empty($_GET['page']) ? (int) $_GET['page'] : 1;

    $items_per_page= 2;

    $items_total_count= Photo::count_all();

    $paginate= new Paginate($page, $items_per_page, $items_total_count);

    $sql= "SELECT * FROM photos ";
    $sql .= " LIMIT {$items_per_page}";
    $sql .= " OFFSET {$paginate->offset()}";

    $photos= Photo::find_by_query($sql);

?>

<?php // $photos= Photo::find_all(); ?>
        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">
                <div class="thrumbails row">
                    <?php foreach($photos as $photo): ?>
                        <div class="col-xs-6 col-md-3">
                            <a class="thumbnail" href="photos.php?id=<?php echo $photo->id; ?>">
                                <img class="img-responsive photo_size" src="admin/<?php echo $photo->picture_path(); ?>" alt="">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                    
                <div class="row">
                    <ul class="pagination">
                        <?php 
                            if($paginate->page_total() > 1) {
                                if($paginate->has_next()) {
                        ?>
                        <li class="next"><a href="index.php?page=<?php echo $paginate->next(); ?>">Next</a></li>
                        <?php 
                                }
                            
                        ?>

                        <?php 
                        
                            for($i= 1; $i<= $paginate->page_total(); $i++) {
                                if($i == $paginate->current_page) {
                                    echo "<li class='active'><a href='index.php?page={$i}'>{$i}</a></li>";
                                } else {
                                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                                }
                            }
                        
                        ?>

                        

                        <?php 
                            if($paginate->has_previous()) {
                        ?>
                        <li class="previous"><a href="index.php?page=<?php echo $paginate->previous(); ?>">Previous</a></li>
                        <?php 
                            } }
                        ?>
                    </ul>
                </div>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <!-- <div class="col-md-4">
                
                <?php // include("includes/sidebar.php"); ?>

            </div> -->
        <!-- /.row -->

        <?php include("includes/footer.php"); ?>