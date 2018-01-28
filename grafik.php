<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>ASO ASSURANCE</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>

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

    <!-- untuk date picker -->
    <link href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    
    <!-- untuk barchart -->
    <script type="text/javascript" src="chart/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="chart/bootstrap/js/bootstrap.min.js"></script>
    
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
      <section id="main-content">
          <section class="wrapper">
            <!--mulai code-->

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">View Grafik</h1>
                </div>
            </div>

            <form class="form-inline" role="form" name="myForm" id="myForm" onSubmit="return validateForm()"  method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label class="control-label">Bulan : </label>
                    <input id="hari" name="hari" size="16" type="text" value=""  class="form_date form-control">
                </div>

                <div class="btn-group">
                    <input class="btn btn-default" id="paket" name="paket" type="text" value="Pilih Paket..." size="30" readonly/>
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                       <li><a tabindex="-1" >BDB-1 (Putra Timur Jaya)</a></li>
                       <li><a tabindex="-1" >BDB-2 (Rajawali)</a></li>
                       <li><a tabindex="-1" >BDB-3 (Wredata Mitra Telematika)</a></li>
                       <li><a tabindex="-1" >BDB-4 (Fajar Mitra Krida Abadi)</a></li>
                       <li><a tabindex="-1" >BDT-1 (Dadali Citra Mandiri)</a></li>
                       <li><a tabindex="-1" >BDT-2 (BANGTELINDO)</a></li>
                       <li><a tabindex="-1" >BDT-3 (Adimas Cipta Karya Pratama)</a></li>
                    </ul>
                </div>
                
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-default"/>
                </div>
                
            </form>
            <br/>
            
            <!-- you need to include the shieldui css and js assets in order for the charts to work -->
            <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
            <script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
            
            <?php 
                mysql_connect('localhost', 'root', '');
                mysql_select_db('ta');
                
                if(isset($_POST['submit'])){
                    $hari       = $_POST['hari'];
                    $paket      = $_POST['paket'];
                    
                    if($hari != null){
                        $time_nala  = strtotime($hari);
                        $bulan = date('m',$time_nala);
                        $tahun = date('Y',$time_nala);

                        // Perintah untuk menampilkan data
                        $queri = "SELECT * FROM insurance2 WHERE YEAR(hari) = '$tahun' AND MONTH(hari) = '$bulan' AND paket = '$paket'" ;  

                        $hasil = MySQL_query ($queri);

                        if(mysql_num_rows($hasil) != 0){
                            // perintah untuk membaca dan mengambil data dalam bentuk array
                            $produktivity = array();
                            $tanggal = array();
                            $bulan = date('F Y',$time_nala);
                            while ($data = mysql_fetch_array ($hasil)){
                                $paket = $data['paket'];
                                $produktivity[] = floatval($data['produktivity']);
                                $tanggal[] = $data['hari'];
                                $teknisi[] = floatval($data['jumlah_teknisi']);
                                $close[] = floatval($data['close_HI']);
                                $sisa[] = floatval($data['sisa_HI']);
                            }
                        }else{
                            echo 
                                "
                                <p/>
                                <div class='alert alert-danger alert-dismissable'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    <strong>Fail !</strong> Data tidak ditemukan.
                                </div>";
                        }
                    }else{
                        echo 
                            "
                            <p/>
                            <div class='alert alert-danger alert-dismissable'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>Fail !</strong> Anda belum memilih tanggal.
                            </div>";
                    }
                }
            ?>

            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
              google.charts.load('current', {'packages':['bar']});
              google.charts.setOnLoadCallback(drawChart);

              // ini data dari PHP
              var paket = <?php echo json_encode($paket); ?>;
              var data1 = <?php echo json_encode($produktivity); ?>;
              var data2 = <?php echo json_encode($teknisi); ?>;
              var tanggal = <?php echo json_encode($tanggal); ?>;
              var bulan = <?php echo json_encode($bulan); ?>;
              var close = <?php echo json_encode($close); ?>;
              var sisa = <?php echo json_encode($sisa); ?>;
              
              // ini buat bikin chart nya
              function drawChart() {

                // ini buat chart productivity-teknisi
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Tanggal');
                
                data.addColumn('number', 'Productivity');
                data.addColumn('number', 'Teknisi');
                
                for (var i = 0; i < tanggal.length; i++) {
                  data.addRows([[tanggal[i], parseFloat(data1[i]), parseFloat(data2[i])]]);
                }

                var options = {
                  chart: {
                    title: paket+' - '+bulan
                  }
                };

                // ini untuk nampilin chart yang udah di setting ke HTML nya
                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                chart.draw(data, google.charts.Bar.convertOptions(options));

                // ini buat chart sisa-close
                var data_close = new google.visualization.DataTable();
                data_close.addColumn('string', 'Tanggal');
                data_close.addColumn('number', 'Close');
                data_close.addColumn('number', 'Sisa');
                
                for (var i = 0; i < tanggal.length; i++) {
                  data_close.addRows([[tanggal[i], parseInt(close[i]), parseInt(sisa[i])]]);
                }

                var options_close = {
                  chart: {
                    title: paket+' - '+bulan
                  }
                };

                var chart2 = new google.charts.Bar(document.getElementById('columnchart_close'));

                chart2.draw(data_close, google.charts.Bar.convertOptions(options_close));
              }
            </script>
            
            <!-- /.panel -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Grafik Produktivity
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-lg-12">
                      <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
                    </div>
                </div>
              </div>

              <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Grafik Close-Sisa
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="col-lg-12">
                      <div id="columnchart_close" style="width: 800px; height: 500px;"></div>
                    </div>
                </div>
              </div>      
              
          </section>
      </section>

      <!--main content end-->
      
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
  <script src="assets/js/zabuto_calendar.js"></script>  
  
  <script type="application/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });
        
            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
                ]
            });
        });
        
        
        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>

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
        $('.form_date').datetimepicker({
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            useCurrent:true,
            format:'yyyy-MM',
            allowInputToggle:false,
            sideBySide:true,
            viewMode:'months',
            widgetPositioning:{
                horizontal:'auto',
                vertical:'auto'
            }
        });

        $(function(){
            $(".dropdown-menu li a").click(function(){
                $(".btn-group input").text($(this).text());
                $(".btn-group input").val($(this).text());
            });
        });
    </script>
  

  </body>
</html>
