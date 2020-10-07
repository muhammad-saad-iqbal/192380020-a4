<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

<title>Add Movie</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <?php
                
                    //Check if form submitted
                    if(isset($_POST['submit'])){
                        //Perform Validation
                        $errors = [];
                        if(empty($_POST['title'])){
                            $error[] = "Title cannot be empty";
                        }
                        else{
                            $title = $_POST['title'];
                        }

                        if(empty($_POST['movierating'])){
                            $error[] = "Movie Rating name cannot be empty";
                        }
                        else{
                           $movier = $_POST['movierating'];
                        }

                        if(empty($_POST['releasedate'])){
                            $error[] = "Release date cannot be empty";
                        }
                        else{
                           $date = $_POST['releasedate'];
                        }

                        //Check if file is selected
                        if(isset($_FILES["uploadfile"])){
                            $target_directory = "images/";
                            $file_tmp_name = $_FILES['uploadfile']['tmp_name'];
                            $file_name = $_FILES['uploadfile']['name'];
                            $file_size = $_FILES['uploadfile']['size'];
                            $file_type = $_FILES['uploadfile']['type'];
                            $target_file = $target_directory . $file_name;
                            $allowed_types = ['image/jpg', 'image/jpg', 'image/jpg', 'image/jpg'];
                            $uploadError = 0;
                            //Check if file type is allowed
                            if(in_array($file_type, $allowed_types)){
                                //Check Size
                                if($file_size > 51002){
                                    exit("Too large file size. File size cannot exceed 512");
                                }
                                else{
                                    //Check if file already exists
                                    if(file_exists($target_file)){
                                        $errors[] = "File Already Exists!";
                                        $uploadError = 1;
                                    }
                                    //now move the file to the directory
                                    move_uploaded_file($file_tmp_name,$target_file);
                                    if($_FILES['uploadfile']['error']>0){
                                        $errors[] = "File cannot be uploaded due to error";
                                        $uploadError = 1;
                                    }
                                }
                            }
                            else{
                                exit("<div class = 'alert alert-danger'> Invalid File Type </div>");
                            }


                        }
                        else{
                            $error[] = "Please Select an image file";
                        }

                        if(empty($errors)){
                            //Connect to db
                            require_once "database/connection.php";
                            $dbc = db_connect();
                            $sql = "INSERT INTO movies VALUES (NULL,'$title','$movierating','$releasedate','$target_file')";
                            $result = mysqli_query($dbc,$sql);
                            if(!$result){
                                echo "<div class = 'alert alert-danger'> Cannot Add Movie: " . mysqli_error($dbc) . "</div>";
                            }
                            else{
                                echo "<div class = 'alert alert-success'>Movie Added Successfully. 
                                    
                                </div>";
                                db_close($dbc);
                            }
                        }
                        else{
                            foreach($errors as $error){
                                echo "<div class = 'alert alert-danger'>$error</div>";
                            }
                        }

                    }
                    else{
                        echo "<div class = 'alert alert-danger'>Form is not submitted!</div>";        
                    }
                ?>
            </div>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
