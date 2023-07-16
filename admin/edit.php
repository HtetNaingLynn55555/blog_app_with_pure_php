<?php
    require '../config/config.php';
    session_start();

    if(empty($_SESSION['id']) && empty($_SESSION['logged_in'])){
        echo "<script> alert('You need to login first'); window.location.href='login.php' </script>";
    }else{

        if(!empty($_POST)){

            $id = $_POST['id'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            if( $_FILES['image']['name'] == '' ){
               
                $stmt = $pdo->prepare("UPDATE `posts` SET title='$title', content='$content' WHERE id='$id'");
                $stmt->execute();
                header('location:starter.php');

            }else{
                
                $image = $_FILES['image']['name'];
                $targetFile = 'image/'.$_FILES['image']['name'];
                $fileType = pathinfo($targetFile,PATHINFO_EXTENSION);
               
                if( $fileType == 'jpg' || $fileType == 'jpeg' || $fileType == 'png'){

                    if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){

                        $stmt = $pdo->prepare("UPDATE `posts` SET title='$title' , content='$content' , image='$image' ");
                        $stmt->execute();
                        header("location:starter.php");

                    }

                }else{
                    echo "<script> alert('Image must be jpg,png or jpeg'); window.location.href='starter.php' </script>";
                }

            }


        }else{

            $id = $_GET['id'];
            
            $stmt = $pdo->prepare("SELECT * FROM `posts` WHERE id='$id'");
            $stmt->execute();
            $postData = $stmt->fetch(PDO::FETCH_ASSOC);      

        }

    }

?>

<?php include('content/header.html');?>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Post Here</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <input type="hidden" name="id" value="<?php echo $postData['id'] ?>">
                  <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $postData['title'] ;?>" placeholder="Enter Post Title">
                  </div>
                  <div class="form-group">
                    <label for="Content">Content</label>
                    <textarea name="content" class="form-control" id="" cols="30" rows="">
                        <?php echo $postData['content'] ?>
                    </textarea>
                  </div>
                  <div class="form-group">

                    <?php if( $postData['image'] != '' ){?>

                    <img src="image/<?php echo $postData['image']?>" width="100px;" height="auto;">

                    <?php } ?>
                    <br>
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

<?php include('content/footer.html');?>