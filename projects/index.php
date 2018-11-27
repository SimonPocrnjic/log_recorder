<?php 
    include "../includes/header.php";
    require_once "../server/projectcontroller.php";
    $projects = $project->getuserProjs($con, $logged);
?>
<?php if ($logged->login_check($con)): ?>
    <div class="row justify-content-center">
        <form class="col-4 bg-light text-dark p-3" method="POST" action="<?php $_SERVER["PHP_SELF"];?>">
            <div class="form-group">    
                <h4>Create new project</h4>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input class="form-control" type="text" name="title">
            </div>
            <div class="form-group">
                <label for="desc">Description:</label>
                <textarea class="form-control" name="desc"></textarea>
            </div>
            <div class="text-right">
                <input type="submit" value="Create" class="btn btn-primary" name="newproj">
            </div>
        </form>
    </div>
    <div class="row justify-content-center">
        <ul class="col-4 list-group-item">
             <?php if($projects == false):?>
            <li class="list-group-item">No projects were found!</li>
            <?php else: ?>
                <?php foreach ($projects as $proj): ?>
                   <li class="list-group-item"><?php echo $proj['projtitle'] ?></li>
                <?php 
                 endforeach;
            endif;
            ?>
        </ul>
    </div>

<?php else: ?>
    <?php  header("Location: "); ?>


<?php endif; ?>


<?php include "../includes/footer.php"; ?>