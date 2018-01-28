<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>ASO ASSURANCE</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">

    <!-- untuk date picker -->
    <link href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

    
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b>ASO ASSURANCE</b></a>
            <!--logo end-->
            
      </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                  <li>
                      <a href="coba_masukin_php.php"><i class="fa fa-upload fa-fw"></i> Upload</a>
                  </li>
                  <li>
                      <a href="view.php"><i class="fa fa-book fa-fw"></i> View</a>
                  </li>
                  <li>
                      <a href="grafik.php"><i class="fa fa-bar-chart-o fa-fw"></i> Charts</a>
                  </li>
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
       
            <!--membuat header-->
            <section id="main-content">
              <section class="wrapper">
              <h1 class="page-header">View Detail Data</h1>
              

            <table class='table table-hover' id="example">
          <thead>
            <tr>
              <th>Incident</th>
              <th>Customer Name</th>
              <th>Reported Date</th>
              <th>Status Date</th>
              <?php
                $close = $_GET['close'];
                if ($close == "true") {
                  echo "<th>Status Comply</th>";
                }
              ?>
                  <th>Daerah</th>
                  <th>Tanggal</th>
            </tr>
          </thead>
          
          <tbody>
            <tr>
            <?php 

            mysql_connect('localhost', 'root', '');
            mysql_select_db('ta');

            $hari = $_GET['hari'];
            $paket = $_GET['paket'];
            $close = $_GET['close'];
            $comply = $_GET['comply'];
                  
                  //echo $hari;
                  //echo $paket;

              // Perintah untuk menampilkan data
            
            if ($close == "true" && $comply == "-") {
              $query = "SELECT * FROM nossa WHERE daerah = '$paket' and tanggal = '$hari'";
              $hasil = MySQL_query ($query);    
              while ($data = mysql_fetch_array ($hasil)){
                echo "    
                        <tr class='table-row clickable-row'>
                          <td>".$data['incident']."</td>
                          <td>".preg_replace("![^a-z0-9]+!i", " ", $data['customer_name'])."</td>
                          <td>".$data['repoted_date']."</td>
                          <td>".$data['status_date']."</td>
                          <td>".$data['comply']."</td>
                          <td>".$data['daerah']."</td>
                          <td>".$data['tanggal']."</td>
                        </tr> 
                ";        
              } 
            }else if ($close == "false" && $comply == "-"){
              $query = "SELECT * FROM nossa_sisa WHERE daerah = '$paket' and tanggal = '$hari'";
              $hasil = MySQL_query ($query);    
              while ($data = mysql_fetch_array ($hasil)){
                echo "    
                        <tr class='table-row clickable-row'>
                          <td>".$data['incident']."</td>
                          <td>".preg_replace("![^a-z0-9]+!i", " ", $data['customer_name'])."</td>
                          <td>".$data['repoted_date']."</td>
                          <td>".$data['status_date']."</td>
                          <td>".$data['daerah']."</td>
                          <td>".$data['tanggal']."</td>
                        </tr> 
                ";        
              } 
            }

            if ($close == "true" && $comply == "yes") {
              $query = "SELECT * FROM nossa WHERE daerah = '$paket' and tanggal = '$hari' and comply = 'yes'";
              $hasil = MySQL_query ($query);    
              while ($data = mysql_fetch_array ($hasil)){
                echo "    
                        <tr class='table-row clickable-row'>
                          <td>".$data['incident']."</td>
                          <td>".preg_replace("![^a-z0-9]+!i", " ", $data['customer_name'])."</td>
                          <td>".$data['repoted_date']."</td>
                          <td>".$data['status_date']."</td>
                          <td>".$data['comply']."</td>
                          <td>".$data['daerah']."</td>
                          <td>".$data['tanggal']."</td>
                        </tr> 
                ";        
              } 
            }else if ($close == "true" && $comply == "no"){
              $query = "SELECT * FROM nossa WHERE daerah = '$paket' and tanggal = '$hari' and comply = 'no'";
              $hasil = MySQL_query ($query);    
              while ($data = mysql_fetch_array ($hasil)){
                echo "    
                        <tr class='table-row clickable-row'>
                          <td>".$data['incident']."</td>
                          <td>".preg_replace("![^a-z0-9]+!i", " ", $data['customer_name'])."</td>
                          <td>".$data['repoted_date']."</td>
                          <td>".$data['status_date']."</td>
                          <td>".$data['comply']."</td>
                          <td>".$data['daerah']."</td>
                          <td>".$data['tanggal']."</td>
                        </tr> 
                ";        
              } 
            }
          
          ?>
          </tr>
          </tbody>
        </table>
        
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- datepicker -->
    <script type="text/javascript" src="bootstrap-datetimepicker-master/sample in bootstrap v2/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
  <script type="text/javascript" src="bootstrap-datetimepicker-master/sample in bootstrap v2/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  <script type="text/javascript" src="bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
  <script type="text/javascript">
    $('.form_datetime').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
    });
    $('.form_date').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0,
      format:'yyyy-mm-dd'
    });
    $('.form_time').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 1,
      minView: 0,
      maxView: 1,
      forceParse: 0
    });
  </script>
  <script type="text/javascript">
    // validasi form (hanya file .xls yang diijinkan)
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
            //window.location.reload();
        }

        if(!hasExtension('fileclose', ['.xls'])){
            alert("Hanya file XLS (Excel 2003) yang diijinkan untuk file close.");
            return false;
        }

        if(!hasExtension('filesisa', ['.xls'])){
            alert("Hanya file XLS (Excel 2003) yang diijinkan untuk file sisa.");
            return false;
        }
    }
  </script>
  <script type="text/javascript">
    var myRoomNumber;

    $('#aduh td a').click(function() {
       myRoomNumber = $(this).attr('data-id');
    });

    $(document).delegate("#submit_teknisi", "click", function(event){
        var x = document.getElementById("usr").value;
        var y = myRoomNumber;
        $.post('script.php', { num: x, numa : y }, function(result) {
          alert(result);
              window.location.reload();
      });
    });
  </script>


  </body>
</html>
