<?php

    require "../config/config.php";
    session_start();

    if (!empty($_SESSION['id']) || !empty($_SESSION['logged_in'])){

        if($_POST){

            $title = $_POST['title'];
            $content = $_POST['content'];

            

            if($_FILES['image']['name'] == ''){

               
                $stmt = $pdo->prepare("INSERT INTO `posts` (title,content) VALUES (:title,:content)");
                $result = $stmt->execute(
                    array(
                        ":title"=>$title,
                        ":content"=>$content,
                    )
                    );
                if($result){
                    header('location:starter.php');
                }

            }else{

                
                $targetFile = "image/".$_FILES['image']['name'];
                $fileType = pathinfo($targetFile,PATHINFO_EXTENSION);

                if( $fileType == 'jpg' || $fileType == 'png' || $fileType == 'jpeg' ){
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'],$targetFile))
                    {

                        $stmt = $pdo->prepare("INSERT INTO `posts` (title,content,image) VALUES (:title,:content,:image)");
                        $result = $stmt->execute(
                            array(
                                ":title"=>$title,
                                ":content"=>$content,
                                ":image"=>$_FILES['image']['name'],
                            )
                            );
                        
                            if($result){

                                header("location:starter.php");

                            }
                        
                    }

                    
                }else{
                    
                    echo "<script> alert('image  type must be jpg, png or jpeg'); </script>";
                    
                }

                


            }

        }


    }else{
        
        echo "<script> alert('You need to login first');window.location.href='login.php'; </script>";
    }
?>

<?php include('content/header.html') ?>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Post Here</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Enter Post Title">
                  </div>
                  <div class="form-group">
                    <label for="Content">Content</label>
                    <textarea name="content" class="form-control" id="" cols="30" rows=""></textarea>
                  </div>
                  <div class="form-group">
                    <label for="image">File input</label>
                    
                    <div>
                    <input type="file" name="image">
                    </div>
                      
                    </div>
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="starter.php" class="btn btn-success">Home</a>
                </div>
              </form>
            </div>
            <!-- /.card -->

            

          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
</section>

<?php include('content/footer.html')?>