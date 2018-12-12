<?php
    if($project->getProject($con, $_GET['project'])):
        require_once "../server/filecontroller.php";
        $dirname = str_replace(' ', '_',  $project->getTitle());
        //$dirpath = "../users/".$logged->username()."/".$dirname."/";
        $dirpath = $project->getDir();
        $filelist = getFileList($dirpath);
?>
<table class="table table-striped mt-5">
 <thead>
 <?php if($logged->id() == $project->getUserid()): ?>
 <tr>
            
                            <td>Upload file</td>
                            <td colspan="4">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" onchange="readInput(this)" name="file" id="file" aria-describedby="inputGroupFile">
                                            <label class="custom-file-label" for="file">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <input class="btn btn-outline-secondary" type="submit" name="upload" value="Upload" id="inputGroupFile">
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                       <?php endif; ?>
                       <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Size</th>
                        <th scope="col">Last modified</th>
                        <?php if($logged->id() == $project->getUserid() || $logged->authorizedUser()): ?>
                            <th scope="col">Delete</th>
                        <?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($filelist as $file): 
                                $dirfullname = str_replace('/', ' ', $file['name']);
                                $dirarray = explode(" ", rtrim($dirfullname));
                                $dirname = end($dirarray);
                        ?>
                            <tr>
                                <td><?php echo $dirname ?></td>
                                <td><?php echo $file['type'] ?></td>
                                <td><?php echo $file['size']." Bytes" ?></td>
                                <td><?php echo date('d-m-Y H:i:s', $file['lastmod']) ?></td>
                                <?php if($logged->id() == $project->getUserid() || $logged->authorizedUser()): ?>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" value="<?php echo $dirname ?>" name="filename">
                                        <input type="submit" name="delfile" class="btn btn-danger" value="Delete">
                                    </form>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <a href="<?php echo URL."projects" ?>">Back to project list</a>
    <?php endif;?>