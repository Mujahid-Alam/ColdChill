<?php include "include/dbconnect.php";   ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ColdChill</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a href="" class="navbar-brand">Cold Chill</a>
            <form action="index.php" class="d-flex mx-auto">
            <input type="search" name="" class="form-control" placeholder="Search">
            <a href="" class="btn btn-success bg-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
</svg></a>
            
            
            </form>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="" class="nav-link">About</a></li>
                <li class="nav-item"><a href="#" class="nav-link " data-bs-toggle="modal" data-bs-target="#add_cat">Add Category</a></li>
                <li class="nav-item"><a href="#" data-bs-toggle="modal" data-bs-target="#add_recipe" class="nav-link">Add Recipe</a></li>
                <li class="nav-item"><a href="" class="nav-link">Orders</a></li>
            </ul>
        </div>

    </nav>






    <!--   here is all about add _category         -->


    <div class="modal fade" id="add_cat">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">Insert Into Category</div>
                <div class="modal-body">
                    <form action="index.php " method="post">
                        <div class="mb-3">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="mb-2">
                            <input type="submit" name="send_cat" class="btn btn-success float-end">

                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>


    <?php
    if (isset($_POST['send_cat'])) {
        $title = $_POST['title'];

        $query = mysqli_query($connect, "INSERT INTO categories (title) value('$title')");
        if ($query) {
            redirect('index');
        }
    }
    ?>
    <!-- end of category work  -->


    <!-- start product insertion -->
<div class="modal fade" id="add_recipe">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
               <div class="mb-3">
               <label for="">Name</label>
                <input type="text" name="name" class="form-control">
                </div>
                <div class="mb-3">
                <label for="">Price</label>
                <input type="text" name="price" class="form-control">
                </div>
                <div class="mb-3">
                <label for="">Image</label>
                <input type="file" name="image" class="form-control" >
                </div>
                <div class="mb-3">
                <label for="">Category_id</label>
                <select name="category_id" class="form-control">  

                <?php 
                $calling_cat = mysqli_query($connect, "SELECT * FROM  categories");
                while($row= mysqli_fetch_array($calling_cat)){
                
                ?>
                 <option value="<?=$row['id'];?>"><?=$row['title'];?></option>
                 <?php   }  ?>
                 </select>

                </div>
                <div class="mb-3">
                <input type="submit" name="send_food" class="btn btn-info float-end">
                </div>
            </form>

                    <?php  
                    
                    if(isset($_POST['send_food'])){
                        $title = $_POST['name'];
                        $price = $_POST['price'];
                        $category_id = $_POST['category_id'];


                        $image = $_FILES['image']['name'];

                        $tmp_name = $_FILES['image']['tmp_name'];
                        move_uploaded_file($tmp_name,"images/$image");
                        $query = mysqli_query($connect, "INSERT INTO foods(f_name, f_price, image, category_id) value ('$title','$price','$image','$category_id')");

                       # $query = mysqli_query($connect, "INSERT INTO foods(f_name,f_price,image, category_id) value('$title','$price','$image','$category_id')");
                        
                        redirect('index');

                    }
                                           
                    ?>

            </div>
        </div>
    </div>
</div>



    <!-- end of the product -->
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-2">
                <div class="list-group list-group-flush">
                    <a href="" class="list-group-item list-group-item-action bg-info text-white ">Categories</a>


                    <?php
                    $calling_cat = mysqli_query($connect, "SELECT * FROM categories");
                    while ($row = mysqli_fetch_array($calling_cat)) {

                    ?>
                        <a href="" class="list-group-item list-group-item-action"><?= $row['title']; ?></a>


                    <?php }  ?>


                </div>
            </div>
            <div class="col-lg-7">
                <div class="row g-1">


                <?php 
                 $calling_food = mysqli_query($connect, "select * from foods");
                 while($row = mysqli_fetch_array($calling_food)){
                
                
                ?>
                    <div class="col-lg-2">
                        <div class="card mb-3">
                            <img src="images/<?= $row['image'];?>" alt="" class="card-img-top" style="height: 170px; object-fit:cover;" >
                            <div class="card-body px-1">
                                <h3 class="h5">Rs <?= $row['f_price'];?></h3>
                                <h4 class="small font-wieght-bold"> <?= $row['f_name'] ;?></h4>
                                <a href="orderkarlo.php?food_id=<?=$row['f_id'];?>" class="btn btn-success btn-sm btn-block w-100 mx-auto">Buy</a>
                            </div>
                        </div>
                    </div>
                <?php  }  ?>
                </div>
            </div>
            <div class="col-lg-3">
                <table class="table table-sm table-borderless table-striped">
                    <tr class="table-primary">
                        <th>S.No</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                    $total= 0;
                    $orders = mysqli_query($connect, "SELECT * FROM orderss join foods on orderss.f_id=foods.f_id");
                        while($row = mysqli_fetch_array($orders)):

                        $total += ($row['f_price'] * $row['qty']);
                        ?>

                    <tr>
                        <td><?=$row['f_id'];?></td>
                        <td><?=$row['f_name'];?></td>                        
                        <td><?=$row['qty'];?></td>
                        <td><?=$row['f_price'] * $row['qty'];?></td>
                        
                        <td>  <a href="index.php?o_id=<?=$row['id'];?>" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg></a></td>
                    </tr>
                    <?php endwhile; ?>

                </table>
<div class="card bg-warning">
<div class="card-body">
<h1>Rs <?= $total;?>/-</h1>
<a href="" class="btn btn-dark">Order Now</a>
</div>
</div>
            </div>

        </div>
    </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>

<?php 

if(isset($_GET['o_id'])){
    $key = $_GET['o_id'];

    $query = mysqli_query($connect, "DELETE FROM orderss WHERE id = '$key'");
    redirect('index');
}

?>