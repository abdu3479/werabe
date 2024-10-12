<?php
include('connect.php'); 
include('connect2.php'); 


if(isset($_POST["btncreate"]))
{

$username = $_POST['txtusername'];
$name = $_POST['txtfullname'];
$password = $_POST['txtpassword'];
$phone = $_POST['txtphone'];

$file_type = $_FILES['avatar']['type']; //returns the mimetype
$allowed = array("image/jpg", "image/gif","image/jpeg", "image/webp","image/png");
if(!in_array($file_type, $allowed)) {
$_SESSION['error'] ='Only jpg,jpeg,Webp, gif, and png files are allowed. ';

// exit();

}else{
$image= addslashes(file_get_contents($_FILES['avatar']['tmp_name']));
$image_name= addslashes($_FILES['avatar']['name']);
$image_size= getimagesize($_FILES['avatar']['tmp_name']);
move_uploaded_file($_FILES["avatar"]["tmp_name"],"uploadImage/Profile/" . $_FILES["avatar"]["name"]);
$location="uploadImage/Profile/" . $_FILES["avatar"]["name"];

///check if username already exist
$stmt = $dbh->prepare("SELECT * FROM users WHERE username=?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user) {
$_SESSION['error'] ='Username Already Exist in our Database ';

} else {
//Add User details
$sql = 'INSERT INTO users(username,password,phone,fullname,photo) VALUES(:username,:password,:phone,:fullname,:photo)';
$statement = $dbh->prepare($sql);
$statement->execute([
':username' => $username,
':password' => $password,
':phone' => $phone,
':fullname' => $name,
':photo' => $location

]);
if ($statement){
$_SESSION['success'] ='User Added Successfully';
header("Location: user-record.php");
}else{
$_SESSION['error'] ='Problem Adding User';
}
}
}
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>New User</title>
<link rel="shortcut icon" href="../<?php  ?>" type="image/x-icon" />
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
<style>

    .it{
        background-image: linear-gradient(to top, #30cfd0 0%, #330867 100%);
        max-width: 400Px;

    }
    @import url(https://fonts.googleapis.com/css?family=Righteous);

*, *:before, *:after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  position: relative;
  }

html, body {
  height: 50%;
  }
  body {
    text-align: center;
    background-color: hsla(230,40%,50%,1);
    }
  body:before {
    content: '';
    display: inline-block;
    vertical-align: middle;
    font-size: 0;
    height: 100%;
    }

h1 {
  display: inline-block;
  color: white;
  font-family: 'Righteous', serif;
  font-size: 6em; 
  text-shadow: .03em .03em 0 hsla(230,40%,50%,1);
  }
  h1:after {
    content: attr(data-shadow);
    position: absolute;
    top: .06em; left: .06em;
    z-index: -1;
    text-shadow: none;
    background-image:
      linear-gradient(
        45deg,
        transparent 45%,
        hsla(48,20%,90%,1) 45%,
        hsla(48,20%,90%,1) 55%,
        transparent 0
        );
    background-size: .05em .05em;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  
    animation: shad-anim 15s linear infinite;
    }

@keyframes shad-anim {
  0% {background-position: 0 0}
  0% {background-position: 100% -100%}
  }
  form {
  width: 450px;
  height: 350px;
  padding: 50px;
  background-color: lightblue;
 
  box-shadow: 10px 10px 5px 12px lightblue;
  box-shadow: 10px 10px 5px black inset;
  }
  .row{
    box-shadow: 10px 10px 5px 12px skyblue;
    width: 600px;
    height: 450px;
    background-color: red;
  }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed" style ="background-image: linear-gradient(to right bottom, green 30%,
  black 50%, blue 20%);">




 <center>
 
<div class="row">
<h1 data-shadow='dang!'>upload-exist!</h1>
<div class="mt-8" style="margin:10px;pading:10px;" >
    <div class="it">
<form  action="" method="POST" enctype="multipart/form-data">
<div class="card-body">


<div class="form-group">
<label for="exampleInputEmail1">username </label>
<input type="text" class="form-control" name="txtusername" id="exampleInputEmail1"
 size="50" value="" placeholder="Enter Username">
</div>
<div class="form-group">
<label for="exampleInputEmail1">Fullname </label>
<input type="text" class="form-control" name="txtfullname" id="exampleInputEmail1" 
size="50" value="" placeholder="Enter Fullname">
</div>
<div class="form-group">
<label for="exampleInputPassword1">type</label>
<input type="text" class="form-control" name="txtpassword" id="exampleInputPassword1" 
size="50" value="" placeholder="Enter type">
</div>

<div class="form-group">
<label for="exampleInputEmail1">phone </label>
<input type="tel" class="form-control" name="txtphone" id="txtphone" 
size="50" value="" placeholder="Enter Phone">
</div>
<div class="form-group">
<label for="exampleInputPassword1">Image</label>
<p class="text-center">
<input type="file" name="avatar" id="avatar" required class="form-control form-control-sm rounded-0"
 accept="image/png,image/jpeg,image/jpg" onChange="display_img(this)">
</p>

</div>

</div>
<!-- /.card-body -->

<div class="card-footer">
<button type="submit" name="btncreate" class="btn btn-primary">Create User</button>
</div>
</form>
</div>
</div>
</div>
</center>
</div>

</div>
<!-- /.row -->
<!-- Main row -->
<div class="row-xl-6">
<!-- Left col --><!-- /.Left col -->
<!-- right col (We are only adding the ID to make the widgets sortable)--><!-- right col -->
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">

<div class="float-right d-none d-sm-inline-block">

</div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>

<link rel="stylesheet" href="popup_style.css">
<?php if(!empty($_SESSION['success'])) {  ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
<div class="popup__background"></div>
<div class="popup__content">
<h3 class="popup__content__title">
<strong>Success</strong>
</h1>
<p><?php echo $_SESSION['success']; ?></p>
<p>
<button class="button button--success" data-for="js_success-popup">Close</button>
</p>
</div>
</div>
<?php unset($_SESSION["success"]);
} ?>
<?php if(!empty($_SESSION['error'])) {  ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
<div class="popup__background"></div>
<div class="popup__content">
<h3 class="popup__content__title">
<strong>Error</strong>
</h1>
<p><?php echo $_SESSION['error']; ?></p>
<p>
<button class="button button--error" data-for="js_error-popup">Close</button>
</p>
</div>
</div>
<?php unset($_SESSION["error"]);  } ?>
<script>
var addButtonTrigger = function addButtonTrigger(el) {
el.addEventListener('click', function () {
var popupEl = document.querySelector('.' + el.dataset.for);
popupEl.classList.toggle('popup--visible');
});
};

Array.from(document.querySelectorAll('button[data-for]')).
forEach(addButtonTrigger);
</script>
<script>
function display_img(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();
reader.onload = function (e) {
$('#logo-img').attr('src', e.target.result);
}

reader.readAsDataURL(input.files[0]);
}
}

</script>
</body>
</html>
