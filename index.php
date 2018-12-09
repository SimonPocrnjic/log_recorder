<?php include_once "includes/header.php";?>
<?php if (!Server\Classes\User::login_check($con)): ?>
    <div class="row justify-content-center" style="padding-top:50%;">
        <form class="col-4 bg-light text-dark p-3" style="margin-top:-25%;" method="POST" action="server/authcontroller.php" id="login">
            <div class="form-group">    
                <h4>Login</h4>
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
    <?php if($logged->authorizedUser()): ?>
        <?php require_once "server/logcontroller.php"; ?>
        <div class="card border-0 mt-5">
        <div class="card-header">
            Log Control
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="/?getlog=1">Hour</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/?getlog=2">Day</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Security Level</a>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="/?getlog=3&level=Emergency">Emergency</a>
                <a class="dropdown-item" href="/?getlog=3&level=Alert">Alert</a>
                <a class="dropdown-item" href="/?getlog=3&level=Critical">Critical</a>
                <a class="dropdown-item" href="/?getlog=3&level=Error">Error</a>
                <a class="dropdown-item" href="/?getlog=3&level=Warning">Warning</a>
                <a class="dropdown-item" href="/?getlog=3&level=Notice">Notice</a>
                <a class="dropdown-item" href="/?getlog=3&level=Informational">Informational</a>
                <a class="dropdown-item" href="/?getlog=3&level=Debug">Debug</a>
                </div>
            </li>
            <li class="nav-item">
                <form action="server/excel.php" method="post">
                    <input type="submit" name="export_excel" class="btn btn-success" value="Export to Excel"/>
                </form>
            </li>
        </ul>
        <div class="card-body">
        <p>Found: <?php echo count($getlogs) ?></p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Message</th>
                <th scope="col">Security Level</th>
                <th scope="col">Type</th>
                <th scope="col">User ID</th>
                <th scope="col">Project ID</th>
                <th scope="col">Created</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($getlogs as $log): ?>
                    <tr>
                        <td><?php echo $log['logmessage'] ?></td>
                        <td><?php echo $log['loglevel'] ?></td>
                        <td><?php echo $log['logtype'] ?></td>
                        <td><?php echo $log['user'] ?></td>
                        <td><?php echo $log['project'] ?></td>
                        <td><?php echo $log['logcreated'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        </div>
    <?php else: ?>

        <div class="card">
        <div class="card-header">
            Welcome <?php echo ucfirst($logged->username()) ?>
        </div>
        <div class="card-body">
            <h5 class="card-title">Dashboard</h5>
            <p class="card-text">Go to your projects page below.</p>
            <a href="/projects" class="btn btn-primary">My projects</a>
        </div>
        </div>
    <?php 
        endif;
    endif; 
    ?>
<?php include_once "includes/footer.php"; ?>