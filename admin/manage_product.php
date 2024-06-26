<?php
    require('top.inc.php');

    $msg='';
    $categories_id='';
    $name='';
    $mrp='';
    $price='';
    $qty='';
    $image='';
    $short_desc='';
    $description='';
    $meta_title='';
    $meta_desc='';
    $meta_keyword='';

    $image_required='required';
    if(isset($_GET['id']) && $_GET['id']!='')
    {
        $image_required='';
        $id=get_safe_value($con,$_GET['id']);   
        $res=mysqli_query($con,"SELECT * FROM product WHERE id='$id'");
        $check=mysqli_num_rows($res);
        if($check>0){
        $row=mysqli_fetch_assoc($res);
        $categories_id=$row['categories_id'];
        $name=$row['name'];
        $mrp=$row['mrp'];
        $price=$row['price'];
        $qty=$row['qty'];
        $image=$row['image'];
        $short_desc=$row['short_desc'];
        $description=$row['description'];
        $meta_title=$row['meta_title'];
        $meta_desc=$row['meta_desc'];
        $meta_keyword=$row['meta_keyword'];
        }else{
            header('location:product.php');
            die();
        }
    }


    if(isset($_POST['submit'])){
        $categories_id=get_safe_value($con,$_POST['categories_id']);
        $name=get_safe_value($con,$_POST['name']);
        $mrp=get_safe_value($con,$_POST['mrp']);
        $price=get_safe_value($con,$_POST['price']);
        $qty=get_safe_value($con,$_POST['qty']);
        $short_desc=get_safe_value($con,$_POST['short_desc']);
        $description=get_safe_value($con,$_POST['description']);
        $meta_title=get_safe_value($con,$_POST['meta_title']);
        $meta_desc=get_safe_value($con,$_POST['meta_desc']);
        $meta_keyword=get_safe_value($con,$_POST['meta_keyword']);

        

        $res=mysqli_query($con,"SELECT * FROM product WHERE name='$name' AND deleted='NO'");
        $check=mysqli_num_rows($res);
        if($check>0 )
        {
            if(isset($_GET['id']) && $_GET['id']!='')
            {
                $getData=mysqli_fetch_assoc($res);
                if($id==$getData['id'])
                {

                }else{
                    $msg="Product Already Exist";
                }
            }else{
            $msg="Product Already Exist";
            }
        }

    // if($_FILES['image']['type']!='' && ($_FILES['image']['type']!='image/png' || $_FILES['image']['type']!='image/jpg' || $_FILES['image']['type']!='image/jpeg')){
    //     $msg='Please select only png,jpg and jpeg format ';
    // }
        
    if($msg=='')
    {
        
        if(isset($_GET['id']) && $_GET['id']!='')
        {
            if($_FILES['image']['name']!=''){
                $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
                $update_sql="UPDATE product SET categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword',image='$image' WHERE id='$id'";
            }else{
                $update_sql="UPDATE product SET categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword' WHERE id='$id'";
            }
            mysqli_query($con,$update_sql);
        }else{
            $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
            mysqli_query($con,"INSERT INTO product(categories_id,name,mrp,price,qty,short_desc,description,meta_title,meta_desc,meta_keyword,status,deleted,image) value ('$categories_id','$name','$mrp','$price','$qty','$short_desc','$description','$meta_title','$meta_desc','$meta_keyword','1','NO','$image')");
        }
        header('location:product.php');
        die();
    }
    }

    
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Product</strong><small> Form</small></div>
                        <form method="POST" enctype="multipart/form-data">
                        <div class="card-body card-block">
                           <div class="form-group">
                            <label for="categories" class=" form-control-label">Categories</label>
                            <select class=" form-control" name="categories_id">
                                <option value="">Select Categories</option>
                                <?php
                                $res=mysqli_query($con,"SELECT id,categories,deleted FROM categories WHERE deleted='NO' ORDER BY categories ASC");
                                while($row=mysqli_fetch_assoc($res)){
                                    if($row['id']==$categories_id){
                                        echo "<option selected value=".$row['id'].">".$row['categories']."</option>";
                                    }else{
                                        echo "<option value=".$row['id'].">".$row['categories']."</option>";
                                    }

                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product" class=" form-control-label">Product Name</label>
                            <input type="text" name="name" placeholder="Enter Product name" class="form-control" value="<?php echo $name ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="product" class=" form-control-label">MRP</label>
                            <input type="text" name="mrp" placeholder="Enter Product MRP" class="form-control" value="<?php echo $mrp ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="product" class=" form-control-label">Price</label>
                            <input type="text" name="price" placeholder="Enter Product Price" class="form-control" value="<?php echo $price ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="product" class=" form-control-label">QTY</label>
                            <input type="text" name="qty" placeholder="Enter qty" class="form-control" value="<?php echo $qty ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="product" class=" form-control-label">Image</label>
                            <input type="file" name="image" class="form-control" <?php echo $image_required; ?>>
                        </div>

                        <div class="form-group">
                            <label for="product" class=" form-control-label">Short Description</label>
                            <textarea name="short_desc" placeholder="Enter Product Short Description" class="form-control" required><?php echo $short_desc ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product" class=" form-control-label">Description</label>
                            <textarea name="description" placeholder="Enter Product Description" class="form-control" required><?php echo $description ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product" class=" form-control-label">Meta Title</label>
                            <textarea name="meta_title" placeholder="Enter Product Meta Title" class="form-control"><?php echo $meta_title ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product" class=" form-control-label">Meta Description</label>
                            <textarea name="meta_desc" placeholder="Enter Product Meta Description" class="form-control"><?php echo $meta_desc ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product" class=" form-control-label">Meta Keyword</label>
                            <textarea name="meta_keyword" placeholder="Enter Product Meta Keyword" class="form-control"><?php echo $meta_keyword ?></textarea>
                        </div>

                           <button type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                           <span id="payment-button-amount" name="submit">Submit</span>
                           </button>
                           <div class="field_error"><?php echo $msg; ?></div>
                        </div>
                        </form>
                     </div> 
                  </div>
               </div>
            </div>
         </div>          
<?php
    require('footer.inc.php');
?>
         