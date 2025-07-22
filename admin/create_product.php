if(isset{$_POST['create_product']}){

    $product_name = $_POST['name'];
    $product_description = $_POST['description'];
    $product_price = $_POST['price'];
    $product_special_offer = $_POST['offer'];
    $product_category = $_POST['category'];
    $product_color = $_POST['color'];

    $image1 =$_FILES['image1']['tnp_name']; 
    $image2 =$_FILES['image2']['tnp_name']; 
    $image3 =$_FILES['image3']['tnp_name'];
    $image4 =$_FILES['image4']['tnp_name'];
    //$file_name = $_FILES['image1']['name'];

    $image_name1 = $product_name."1.jpeg"; //white shoes1.jpeg
    $image_name2 = $product_name."2.jpeg"; //white shoes2.jpeg
    $image_name3 = $product_name."3.jpeg";
    $image_name4 = $product_name."4.jpeg";
    
    //upload images
    move_uploaded_file($image1,"../asset/imgs/".$image_name1);
    move_uploaded_file($image2,"../asset/imgs/".$image_name2);
    move_uploaded_file($image3,"../asset/imgs/".$image_name3);
    move_uploaded_file($image4,"../asset/imgs/".$image_name4);

    //create a new user
    $stmt = $conn->prepare("INSERT INTO products (product_name,product_description,product_price,$product_special_offer,
                                                  product_image,product_image2,product_image3,product_image4.
                                                  $product_category,$product_color)
                                                  VALUES (?,?,?,?,?,?,?,?,?,?)");
    



    $stmt->bind_param('ssssssssss',$product_name,$product_description,$product_price,$product_special_offer,
                                $image_name1,$image_name2,$image_name3,$image_name4,$product_category,$product_color);      
     if($stme->execute()){
        header('location: products.php?product_created=Product has been created successfully');
     }else{
         header('location: products.php?product_failed=Error occured, try again');
     }


}

?>
