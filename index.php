<?php include_once "includes/header.php";?>
<?php if (!Server\Classes\User::login_check($con)): ?>
    <div class="row justify-content-center" style="padding-top:50%;">
        <form class="col-4 bg-light text-dark p-3" style="margin-top:-25%;" method="POST" action="server/authcontrol.php" id="login">
            <div class="form-group">    
                <h4>Login to dashboard</h4>
            </div>
            <div class="form-group">
                <label for="username">User:</label>
                <input class="form-control" type="text" name="username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input class="form-control" type="password" name="password">
            </div>
            <div class="text-right">
                <input type="submit" value="Login" class="btn btn-primary" name="login">
            </div>
        </form>
    </div>
<?php else: ?>
    <p>Logged user: <?php echo $logged->username(); ?></p>
    <p><a href="projects">My projects</a></p>
    <form method="POST" action="server/authcontrol.php">
        <input type="submit" name="logout" value="Logout">
    </form>
    
<?php endif; ?>
<?php include_once "includes/header.php"; ?>