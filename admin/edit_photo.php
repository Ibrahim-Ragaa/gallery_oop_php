<?php include("includes/header.php"); ?>

<?php 
if(!$session->is_signed_in()){redirect("login.php");}
?>

<?php

if(empty($_GET['id'])){
    redirect("photos.php");
}else{
    $edit_photo = Photo::find_by_id($_GET['id']);
}

if(isset($_POST['update'])){
    if($edit_photo){
        $edit_photo->title = $_POST['title'];
        $edit_photo->description = $_POST['description'];
        $edit_photo->save();
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
                        
                        <form action="" method="post">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="caption">Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo $edit_photo->title; ?>">
                            </div>
                            <div class="form-group">
                                <label for="caption">Caption</label>
                                <input type="text" name="caption" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="caption">Alternate Text</label>
                                <input type="text" name="alternate_caption" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="caption">Description</label>
                            <textarea class="form-control" name="description" id="" cols="30" rows="10"><?php echo $edit_photo->description; ?></textarea>
                            </div>
                        </div>
                        
                        <!--by edwin-->
                        <div class="col-md-4" >
                            <div  class="photo-info-box">                                
                                <div class="info-box-header">
                                   <h4>Save <span id="toggle" class="glyphicon glyphicon-menu-up pull-right"></span></h4>
                                </div>
                                <div class="inside">
                                    <div class="box-inner">
                                        <p class="text">
                                            <span class="glyphicon glyphicon-calendar"></span> Uploaded on: April 22, 2030 @ 5:26
                                        </p>
                                        <p class="text ">
                                            Photo Id: <span class="data photo_id_box"><?php echo $edit_photo->id; ?></span>
                                        </p>
                                        <p class="text">
                                            Filename: <span class="data"><?php echo $edit_photo->image_name; ?></span>
                                        </p>
                                        <p class="text">
                                            File Type: <span class="data"><?php echo $edit_photo->type; ?></span>
                                        </p>
                                        <p class="text">
                                            File Size: <span class="data"><?php echo $edit_photo->size; ?></span>
                                        </p>
                                    </div>
                                    <div class="info-box-footer clearfix">
                                        <div class="info-box-delete pull-left">
                                            <a  href="delete_photo.php?id=<?php echo $edit_photo->id; ?>" class="btn btn-danger btn-lg ">Delete</a>
                                        </div>
                                        <div class="info-box-update pull-right ">
                                            <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end by edwin-->
                        </form>
                        
                    
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>