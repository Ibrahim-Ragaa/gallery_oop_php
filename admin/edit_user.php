<?php include("includes/header.php"); ?>
<?php include("includes/photo_library_modal.php"); ?>

<?php 
if(!$session->is_signed_in()){redirect("login.php");}
?>

<?php

if(empty($_GET['id'])){
    redirect("usres.php");
}else{
    $user = User::find_by_id($_GET['id']);
}

if(isset($_POST['update_user'])){
    if($user){
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];
        $user->firstname = $_POST['firstname'];
        $user->lastname = $_POST['lastname'];
                
        if(empty($_FILES['image_name']['name'])){
            $user->save();
            redirect("edit_user.php?id=$user->id");
        }else{
            $user->set_image($_FILES['image_name']);
            $user->save_image();
            redirect("edit_user.php?id=$user->id");
        }
        
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
                <h1 class="page-header">User<small>Subheading</small></h1>

                <div class="col-md-6 user-image-box">
                    <a href="#" data-toggle="modal" data-target="#photo-library">
                        <img class="image-responsive" id="ibrahim1" src="<?php echo $user->image_path_placeholder(); ?>" alt="">
                    </a>
                </div>
                        
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" name="image_name" class="">
                        </div>
                        <div class="form-group">
                            <label for="caption">User Name</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>">
                        </div>
                        <div class="form-group">
                            <label for="caption">Password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $user->password; ?>">
                        </div>
                        <div class="form-group">
                            <label for="caption">First Name</label>
                            <input type="text" name="firstname" class="form-control" value="<?php echo $user->firstname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="caption">Last Name</label>
                            <input type="text" name="lastname" class="form-control" value="<?php echo $user->lastname; ?>">
                        </div><br>
                        <div class="form-group">
                            <a id="user_id" class="btn btn-danger" href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a>
                            <input type="submit" name="update_user" class="btn btn-primary pull-right" value="Update">
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