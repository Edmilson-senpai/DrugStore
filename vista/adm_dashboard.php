<?php
session_start();
if($_SESSION['us_tipo']==1||$_SESSION['us_tipo']==3){
    include_once 'layouts/header.php';
?>

  <title>Adm | Catalogo</title>
<?php
    include_once 'layouts/nav.php';
?>

  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../css/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <div class="content-wrapper" style="min-height: 1202.92px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
      <iframe title="powerbidashboards" width="1024" height="1060" src="https://app.powerbi.com/view?r=eyJrIjoiZjdiZjkzZTctMDIwNi00NzdmLWE5NzYtYTVkZmNjZjk1MGIwIiwidCI6ImM0YTY2YzM0LTJiYjctNDUxZi04YmUxLWIyYzI2YTQzMDE1OCIsImMiOjR9&pageName=d18e2708196c9b81dcb3" frameborder="0" allowFullScreen="true"></iframe>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- /.content -->
  </div>

<script src="../plugins/jquery/jquery.js"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="../js/charts.js"></script>
<script src="../js/demo.js"></script>
<script src="../js/pages/dashboard3.js"></script>

<?php
include_once 'layouts/footer.php';
}
else{
    header('Location: ../index.php');
}
?>
