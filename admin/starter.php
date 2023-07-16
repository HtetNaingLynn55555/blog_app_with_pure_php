<?php

    require "../config/config.php";
    session_start();
    

    if( !empty($_SESSION['id']) && !empty($_SESSION['logged_in']) ){

        if(!empty($_GET['pageNum'])){
            $pageNum = $_GET['pageNum'];

        }else{
            $pageNum = 1;
        }

        $numOfRecord = 1;
        $offset = ($pageNum -1) * $numOfRecord;

        $stmt = $pdo->prepare("SELECT * FROM `posts` ORDER BY id");
        $stmt->execute();

        $rawData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalPageNum = ceil(count($rawData)/$numOfRecord);

        $stmt = $pdo->prepare("SELECT * FROM `posts` LIMIT $offset,$numOfRecord");
        $stmt->execute();
        $postsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        

    }else{
        echo "<script> alert('You need to login first'); window.location.href='login.php' </script>";
    }

?>

<?php include('content/header.html') ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <a href="create.php" class="btn btn-outline-success mb-1"> Create New Post</a>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">id</th>
                <th scope="col">title</th>
                <th scope="col">description</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                
                <?php if($postsData){
                    $i = 1;
                    foreach($postsData as $postData){
                        
                ?>
                <tr>
                <th scope="row"><?php echo $i;?></th>
                <td><?php echo $postData['title'] ?></td>
                <td> <?php echo $postData['content'] ?></td>
                <td>

                    <a href="details.php?id=<?php echo $postData['id'];?>" class="btn btn-warning">Details</a>
                    <a href="edit.php?id=<?php echo $postData['id'];?>" class="btn btn-success">Edit</a>
                    <a href="delete.php?id=<?php echo $postData['id'];?>" class="btn btn-danger">Delete</a>

                </td>
                </tr>

                <?php 
                    $i++;
                }}?>

            </tbody>
        </table>
        
        </div>
        <!-- /.row -->
        <nav aria-label="Page navigation example" style="float: right;">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="?pageNum=1">First</a></li>
            <li class="page-item <?php if($pageNum <= 1){echo "disabled";} ?>">
                <a class="page-link" href="<?php if($pageNum <=1){echo '#';}else{echo '?pageNum='.($pageNum-1);} ?>">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#"> <?php echo $pageNum ?></a></li>
            <li class="page-item <?php if($totalPageNum <= $pageNum){ echo "disabled";} ?>">
            <a class="page-link" href="<?php if($totalPageNum <= $pageNum){echo"#";}else{echo "?pageNum=".($pageNum+1);} ?>">Next</a>
            </li>
            <li class="page-item"><a class="page-link" href="?pageNum=<?php echo $totalPageNum ?>">Last</a></li>
        </ul> 
      </div><!-- /.container-fluid -->

     
      </nav>

    </div>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  </div>
 
<?php include('content/footer.html') ?>