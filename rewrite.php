<?php
   // error_reporting(0);
    session_start();
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>New Blog Post Template | PrepBootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'> -->
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <!-- Custom styles for this template -->
  <link href="css/main.css" rel="stylesheet">
  <link href="css/login-register.css" rel="stylesheet" />
    <script type="text/javascript" src="js-2/jquery-1.10.2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script type="text/javascript" src="bootstrap-2/js/bootstrap.min.js"></script>
</head>
<body>

<?php include 'navbar-2.php'; ?>
<?php        if($_SESSION["name"]) {?>


<!-- New Blog Post - START -->
    <div class="container">
    <div class="row" id="row_style">
        <h4 class="text-center">Submit new post</h4>
        <div class="col-md-12   col-md-offset-12">
                <form method="POST">
                <div class="form-group">
                
                    <input type="text" id="title_edit"  name="blog_title" class="form-control" placeholder="Title">
                </div>
                    <textarea id="editor" name="blog_story" cols="30" rows="10"></textarea>
                    <br>
               
                <div class="row md-center" style="margin:10%;">
               
                    <button onclick="testing()" class="btn btn-primary" id="submit" name="update_button">Submit new post</button>
               
                    <div style="margin-top: 2%;"></div>
                    <button onclick="testing()" class="btn btn-danger" id="submit" ><a href="user_profile.php">Cancel</a></button>
                 
                </div>
                <div class="form-group">
                    
                </div>
            </form>
            </div>
        </div>

        </div>
    </div>
</div>

<style>
    #row_style {
        margin-top: 30px;
    }

    #submit {
        display: block;
        margin: auto;
    }
</style>

<!-- you need to include the shieldui css and js assets in order for the charts to work -->
<link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>

<script>
    $(function () {
        $("#editor").shieldEditor({
            height: 260
        });
    })
	
	function testing(){
		var textGet=document.getElementById("editor").value;
		console.log(textGet);
		
	}
</script>
<!-- New Blog Post - END -->

</div>

            <?php
            
            require_once 'modules/Parsedown.php';
            $Parsedown = new Parsedown();
            
      
            $full_content = "";
            include 'connect.php';
            
            $statement =  $con->prepare("SELECT * FROM `blog_user` WHERE blog_id=? and user_name=?");
            $story_id = $_GET['edit-blog'];
            $user_name = $_SESSION['id'];
            
            $statement->bind_param("ss",$story_id,$user_name);
            
            $statement->execute();
            
            $result = $statement->get_result();            
            

            if(mysqli_num_rows($result) > 0)  {
                while($row = $result->fetch_assoc()){                                  //return true;  
                    $full_content = $row['blog_story'];
                    $_SESSION['blog_id'] = $row['blog_id'];
                   
                    $test= $row['blog_id'];
                    echo "<script> console.log($test); </script>";
                    $full_content=mysqli_real_escape_string($con, $full_content);
                    $full_title=mysqli_real_escape_string($con, $row['blog_title']);
                    echo '<script>document.getElementById("title_edit").value = "'.$full_title.'";</script>';
                    echo '<script>document.getElementById("editor").value = "'.$full_content.'";</script>';
                    
                }       
            }  
            if(isset($_POST['update_button'])){
               
                
            
                // inserting data
                $sql = "UPDATE `blog_user` SET `blog_title`=?, `date_update`=NOW() , `blog_story` =? WHERE `blog_id`=?;";
                $statement = $con->prepare($sql);
                $blog_story = $_POST["blog_story"];
                $blog_title = $_POST["blog_title"];
                $user_id = $_SESSION["id"];
                $insert_data =$blog_story;
        
                $blog_id = $_SESSION['blog_id'];          
                $today = date("Y-m-d h:i:s");
                $statement->bind_param("sss",$blog_title,$insert_data,$blog_id);

                if ($statement->execute()) {
                    
                    echo "<script>window.location.href='user_profile.php';</script>";
                    exit;
                    
                } 
                else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }

            }
            ?><?php
    ?><?php
    }
        else {
        header("Location:index.php");
        };
    ?>

</body>
</html>