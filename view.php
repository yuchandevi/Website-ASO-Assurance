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

    <!-- untuk date picker -->
    <link href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

    <!-- bikin clickable row -->
    <script type="text/javascript">
        $(document).ready(function() {

            $('#example tr').click(function() {
                var href = $(this).find("a").attr("href");
                if(href) {
                    window.location = href;
                }
            });

        });
    </script>
    <style type="text/css">
        .table-row{
            cursor:pointer;
        }
    </style>


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
            <h3 class="page-header"> View Data</h3>
            <div>
                <form class="form-inline" role="form" name="myForm" id="myForm" onSubmit="return validateForm()"  method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label class="control-label">Tanggal :</label></br>
                        <input id="hari" name="hari" size="16" type="text" class="form_date form-control">
                    </div><br/><p/>

                    <div>
                        <input type="submit" name="submit" class="btn btn-default"/>
                    </div>
                </form>
            </div><p/>

      <table class="table table-hover">
          <thead>
            <tr>
              <th>Paket</th>
              <th>Hari</th>
              <th>Jumlah Teknisi</th>
              <th>Close HI</th>
              <th>Sisa HI</th>
              <th>Produktivity</th>
              <th>Comply</th>
              <th>Not Comply</th>
              <th>Prosentase Comply</th>
              <th>Prosentase Not Comply</th>
            </tr>
          </thead>

          <tbody>
            <tr>
                <?php

                // koneksi ke database, username,password  dan namadatabase menyesuaikan
                      mysql_connect('localhost', 'root', '');
                      mysql_select_db('ta');

                        if(isset($_POST['submit'])){
                                $hari       = $_POST['hari'];
                                $time_nala  = strtotime($hari);
                                $today_date = date('Y-m-d',$time_nala);

                                // Perintah untuk menampilkan data
                                $queri = "Select * From insurance2 where hari = '$today_date'";
                                $hasil = mysql_query ($queri);

                                // perintah untuk membaca dan mengambil data dalam bentuk array
                                while ($data = mysql_fetch_array ($hasil)){
                                    $persen = 100;
                                    $persen_comply_yes = round(($data['comply_yes']/($data['comply_yes']+$data['comply_no']))*$persen);
                                    $persen_comply_no = round(($data['comply_no']/($data['comply_yes']+$data['comply_no']))*$persen);
                                    echo "
                                        <tr class='table-row clickable-row' id='aduh'>
                                            <td>".$data['paket']."</td>
                                            <td>".$data['hari']."</td>
                                            <td>
                                              <a
                                                href='#myModal'
                                                data-toggle='modal'
                                                data-id='".$data['paket']."+".$data['hari']."+".$data['close_HI']."'
                                              >".$data['jumlah_teknisi']."
                                            </td>
                                            <td>
                                            <a href=
                                            'halamanlink.php?hari=".$data['hari']."&paket=".$data['paket']."&close=true&comply=-'>".$data['close_HI']."</td>
                                            <td>
                                            <a href=
                                            'halamanlink.php?hari=".$data['hari']."&paket=".$data['paket']."&close=false&comply=-'>".$data['sisa_HI']."</td>
                                            <td>".$data['produktivity']."</td>
                                            <td>
                                            <a href=
                                            'halamanlink.php?hari=".$data['hari']."&paket=".$data['paket']."&close=true&comply=yes'>".$data['comply_yes']."</td>
                                            </td>
                                            <td>
                                            <a href=
                                            'halamanlink.php?hari=".$data['hari']."&paket=".$data['paket']."&close=true&comply=no'>".$data['comply_no']."</td>
                                            </td>
                                            <td>".$persen_comply_yes." % </td>
                                            <td>".$persen_comply_no." % </td>
                                        </tr>
                                    ";
                                }
                            }
              ?>
          </tr>
          </tbody>
        </table>

        <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-sm">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Masukkan Jumlah Teknisi : </h4>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="form-control" id="usr" placeholder="Jumlah teknisi...">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="submit_teknisi" data-dismiss="modal">Submit</button>
                        </div>
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
