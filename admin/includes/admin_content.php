        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Blank Page
                            <small>Subheading</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                        
                        <?php
                        
                        $users = User::find_all();
                        foreach($users as $user){
                            echo $user->firstname . "<br>";
                        }
                        
                        $found_user = User::find_by_id(6);
                        $found_user->username = "Ahmed Kamal";
                        $found_user->firstname = "Ahmed";
                        $found_user->lastname = "Kamal";
//                        $found_user->update();
//                        $found_user->delete();
                        $found_user->save();
                        
                        $test = new User;
                        print_r($test);
                        echo "<br>";
                        
                        
//                        $user = new User();
//                        $user->username = "Ali Gomaa";
//                        $user->password = "123456";
//                        $user->firstname = "Ali";
//                        $user->lastname = "Gomaa";
//                        $user->create();
//                        $user->save();
                        
                        
//                        $photo = new Photo();
//                        $photo->title = "Hello";
//                        $photo->save();
                        
                        $photos = Photo::find_all();
                        foreach($photos as $photo){
                            echo $photo->title . "<br>";
                        }
                        
                        
                        $photo_by_id = Photo::find_by_id(1);
                        echo $photo_by_id->id . "<br>";
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        ?>                        
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
