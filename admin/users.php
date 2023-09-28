<?php include("includes/header.php"); ?>

<?php 
if(!$session->is_signed_in()){redirect("login.php");}
?>

<?php

$users = User::find_all();

?>






        <!-- Navigation -->

<?php include("includes/top_nav.php"); ?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<?php include("includes/side_nav.php"); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Photos
                            <small>Subheading</small>
                        </h1>
                        
                        <div class="col-md-12">                            
                            <a href="add_user.php" class="btn btn-primary">Add User</a>
                            <table class="table table-hover">  
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($users as $user) : ?>
                                    <tr>
                                        <td><?php echo $user->id; ?></td>
                                        <td><img class="user-image" src="<?php echo $user->image_path_placeholder(); ?>" alt=""></td>
                                        <td><?php echo $user->username; ?></td>
                                        <td><?php echo $user->firstname; ?></td>
                                        <td><?php echo $user->lastname; ?></td>
                                        <td><a href='edit_user.php?id=<?php echo $user->id; ?>'>Edit</a></td>
                                        <td><a href='delete_user.php?id=<?php echo $user->id; ?>'>Delete</a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                </table>
                        </div>
                    
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>