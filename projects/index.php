<?php 
    include "../includes/header.php";
    require_once "../server/projectcontroller.php";
    
    if($logged->authorizedUser()){
        $projects = $project->getAllProjs($con);
    } else {
        $projects = $project->getUserProjs($con, $logged);
    }
?>
<?php if ($logged->login_check($con)): ?>
    <?php 
        if(isset($_GET['project']) && !empty($_GET['project'])):
            include_once "getproject.php";
        else:    
    ?>
    <?php if(!$logged->authorizedUser()): ?>
        <form class="col bg-light text-dark p-3" method="POST" action="">
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
    <?php else: ?>
        <div class="card-header">
            Users Projects
        </div>
    <?php endif; ?>
            <?php if($projects == false):?>
            <li class="list-group-item">No projects were found!</li>
            <?php else: ?>
                <table class="table table-striped mt-5">
                    <thead>
                        <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Files</th>
                        <th scope="col">File List</th>
                        <th scope="col">Created</th>
                        <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $proj): ?>
                            <tr>    
                                <td><?php echo $proj['projtitle'] ?></td>
                                <td><?php echo count(getFileList($proj['projpath'])) ?></td>
                                <td>
                                    <a class="btn btn-primary" href="?project=<?php echo $proj['projid'] ?>">Open</a>
                                </td>
                                <td><?php echo $proj['projcreated'] ?></td>
                                <td>
                                    <form action="" method="POST">
                                        <input type="hidden" value="<?php echo $proj['projtitle'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $proj['projid'] ?>" name="id">
                                        <?php if($logged->authorizedUser()): ?>
                                            <input type="hidden" value="<?php echo $proj['projuser'] ?>" name="userid">
                                        <?php endif; ?>
                                        <input type="submit" class="btn btn-danger" name="delproj" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endif;?>
    <?php endif;?>

<?php else: ?>
    <?php  header("Location: "); ?>


<?php endif; ?>


<?php include "../includes/footer.php"; ?>