<?php 
    include "includes/header.php"; 
    require_once "server/usercontrol.php";    
?> 
        <form class="bg-light text-dark p-3" method="POST" action="" id="createuser">
            <div class='row'>
                <div class="form-group col-lg-2">    
                    <h4>Create User</h4>
                </div>
                <div class="form-group col-lg-3">
                    <input class="form-control" type="text" name="username" placeholder="username">
                </div>
                <div class="form-group col-lg-3">
                    <input class="form-control" type="email" name="email" placeholder="email">
                </div>
                <div class="form-group col-lg-3">
                    <input class="form-control" type="password" name="password" placeholder="password">
                </div>
                <div class="form-group col-lg-1">
                    <input type="submit" value="Create" class="btn btn-primary" name="createuser">
                </div>
            </div>
        </form>

    <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">User ID</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Created</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?php echo $user['userid'] ?></td>
                        <td><?php echo $user['username'] ?></td>
                        <td><?php echo $user['useremail'] ?></td>
                        <td><?php echo $user['usercreated'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
<?php include "includes/footer.php" ?>