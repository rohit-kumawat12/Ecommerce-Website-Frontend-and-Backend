<?php
    require('top.inc.php');

    $msg='';
    $categories='';
    if(isset($_GET['id']) && $_GET['id']!='')
    {
        $id=get_safe_value($con,$_GET['id']);   
        $res=mysqli_query($con,"SELECT * FROM categories WHERE id='$id'");
        $check=mysqli_num_rows($res);
        if($check>0){
        $row=mysqli_fetch_assoc($res);
        $categories=$row['categories'];
        }else{
            header('location:categories.php');
            die();
        }
    }


    if(isset($_POST['submit'])){
        $categories=get_safe_value($con,$_POST['categories']);

        $res=mysqli_query($con,"SELECT * FROM categories WHERE categories='$categories' AND deleted='NO'");
        $check=mysqli_num_rows($res);
        if($check>0 )
        {
            if(isset($_GET['id']) && $_GET['id']!='')
            {
                $getData=mysqli_fetch_assoc($res);
                if($id==$getData['id'])
                {

                }else{
                    $msg="Categories Already Exist";
                }
            }else{
            $msg="Categories Already Exist";
            }
        }

    if($msg=='')
    {
        
        if(isset($_GET['id']) && $_GET['id']!='')
        {
            mysqli_query($con,"UPDATE categories SET categories='$categories' WHERE id='$id'");
        }else{
            mysqli_query($con,"INSERT INTO categories(categories,status,deleted) value ('$categories','1','NO')");
        }
        header('location:categories.php');
        die();
    }
    }

    
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Categories</strong><small> Form</small></div>
                        <form method="POST">
                        <div class="card-body card-block">
                           <div class="form-group"><label for="categories" class=" form-control-label">Categories</label><input type="text" name="categories" placeholder="Enter Categorie name" class="form-control" value="<?php echo $categories ?>" required></div>
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
         