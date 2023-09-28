<?php include("includes/header.php"); ?>

<?php 
if(!$session->is_signed_in()){redirect("login.php");}
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
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="info-box-update pull-right">
                                <input type="submit" name="add_user" class="btn btn-primary" value="Add User">
                            </div>
                        </div>
<?php
$add_user = new User;
if(isset($_POST['add_user'])){    
        $image_name = $_FILES['image']['name'];
        $tmp_path = $_FILES['image']['tmp_name'];
        $target_path = SITE_ROOT.DS.'admin'.DS."images".DS.$image_name;
        echo $image_name."<br>".$tmp_path."<br>".$target_path;
        move_uploaded_file($tmp_path,$target_path);    
}
?>
                        </form>
                        
                    
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>