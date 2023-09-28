<?php include("includes/header.php"); ?>

<?php 
if(!$session->is_signed_in()){redirect("login.php");}
?>

<?php

$add_user = new User;
if(isset($_POST['add_user'])){
    if($add_user){
        $add_user->username = $_POST['username'];
        $add_user->password = $_POST['password'];
        $add_user->firstname = $_POST['firstname'];
        $add_user->lastname = $_POST['lastname'];
        $add_user->set_image($_FILES['image']);
        $add_user->upload_image();
        $add_user->save();
        redirect("users.php");
    }
}




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
                            Photo
                            <small>Subheading</small>
                        </h1>
                        
                        <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="file" name="image" class="">
                            </div>
                            <div class="form-group">
                                <label for="caption">User Name</label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="caption">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="caption">First Name</label>
                                <input type="text" name="firstname" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="caption">Last Name</label>
                                <input type="text" name="lastname" class="form-control">
                            </div><br>
                            <div class="info-box-update pull-right">
                                <input type="submit" name="add_user" class="btn btn-primary" value="Add User">
                            </div>
                        </div>
                        </form>
                        
                    
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>