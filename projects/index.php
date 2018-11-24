<?php 
    include "../includes/header.php";
    require_once "../server/projectcontroller.php";
    
?>
<?php if ($logged->login_check($con)): ?>
    <div class="row justify-content-center" style="padding-top:50%;">
        <form class="col-4 bg-light text-dark p-3" style="margin-top:-25%;" method="POST" action="<?php $_SERVER["PHP_SELF"];?>">
            <div class="form-group">    
                <h4>Login to dashboard</h4>
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
                <input type="submit" value="Login" class="btn btn-primary" name="newproj">
            </div>
        </form>
    </div>
<?php else: ?>
    <?php  header("Location: "); ?>


<?php endif; ?>


<?php include "../includes/footer.php"; ?>