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
      <section id="main-content">
        <section class="wrapper">
          <h3 class="page-header"> Upload File</h3>
                  
            <div>
              <form class="form-inline" role="form" name="myForm" id="myForm" onSubmit="return validateForm()"  method="post" enctype="multipart/form-data">

                  <div class="form-group">
                    <label for="fileclose">Input File Close</label>
                    <input type="file" id="fileclose" name="fileclose" />
                  </div><br/><p/>

                  <div class="form-group">
                    <label for="filesisa">Input File Sisa</label>
                    <input type="file" id="filesisa" name="filesisa" />
                  </div><br/><br/>

          <div class="form-group">
              <label class="control-label">Tanggal :</label></br>
            <input id="hari" name="hari" size="16" type="text" value=""  class="form_date form-control">
          </div><br/><p/>

          <div>
            <label>
              <input type="checkbox" name="drop" value="1" /> <u>Kosongkan tabel sql terlebih dahulu.</u>
            </label>
          </div><p/>

          <div>
            <input type="submit" name="submit" class="btn btn-default"/>
          </div>

                <?php
                    // koneksi ke database, username,password  dan namadatabase menyesuaikan
                  mysql_connect('localhost', 'root', '');
                  mysql_select_db('ta');

                  // memanggil file excel_reader
                  require "excel_reader.php";

                  $hasil = null;

                  // jika tombol import ditekan
                  if(isset($_POST['submit'])){

                      // jika kosongkan data dicentang jalankan kode berikut
                  $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
                  if($drop == 1){
                      // kosongkan tabel pegawai
                      $truncate ="TRUNCATE TABLE insurance2";
                      mysql_query($truncate);
                      $truncate ="TRUNCATE TABLE nossa";
                      mysql_query($truncate);
                      $truncate ="TRUNCATE TABLE nossa_sisa";
                      mysql_query($truncate);
                  };

                      $target_close   = basename($_FILES['fileclose']['name']);
                      $target_sisa  = basename($_FILES['filesisa']['name']);
                $hari       = $_POST['hari'];
                $time_nala    = strtotime($hari);
                $hari       = date('Y-m-d',$time_nala);

                $result_close   = mysql_query("
                  SELECT count(*) as total from nossa where comply = 'yes' and tanggal = '$hari'");
                $data       = mysql_fetch_assoc($result_close);
                $comply_close = $data['total'];

                $result_sisa    = mysql_query("
                  SELECT count(*) as total from nossa_sisa where tanggal = '$hari'");
                $data    = mysql_fetch_assoc($result_sisa);
                $comply_sisa  = $data['total'];

                if($comply_close == 0 && $comply_sisa == 0){
                  $target_close = basename($_FILES['fileclose']['name']) ;
                        move_uploaded_file($_FILES['fileclose']['tmp_name'], $target_close);

                        // tambahkan baris berikut untuk mencegah error is not readable
                        chmod($_FILES['fileclose']['name'],0777);

                        $data = new Spreadsheet_Excel_Reader($_FILES['fileclose']['name'],false);

                        // menghitung jumlah baris file xls
                        $baris_close = $data->rowcount($sheet_index=0);

                        // import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
                        for ($i=2; $i<=$baris_close; $i++){
                          // membaca data (kolom ke-1 sd terakhir)
                          $incident                 = $data->val($i, 1);
                          $customer_name                = $data->val($i, 2);
                          $summary                  = $data->val($i, 3);
                          $owner_group            = $data->val($i, 4);
                          $owner                  = $data->val($i, 5);
                          $last_update_work_log           = $data->val($i, 6);
                          $last_work_log_date           = $data->val($i, 7);
                          $source                 = $data->val($i, 8);
                          $segment              = $data->val($i, 9);
                          $channel                  = $data->val($i, 10);
                          $customer_segment             = $data->val($i, 11);
                          $service_id                 = $data->val($i, 12);
                          $service_no                 = $data->val($i, 13);
                          $service_type               = $data->val($i, 14);
                          $top_priority               = $data->val($i, 15);
                          $slg                    = $data->val($i, 16);
                          $technology                 = $data->val($i, 17);
                          $datek                  = $data->val($i, 18);
                          $rk_name                  = $data->val($i, 19);
                          $induk_gamas                = $data->val($i, 20);
                          $repoted_date               = $data->val($i, 21);
                          $ttr_customer               = $data->val($i, 22);
                          $ttr_nasional               = $data->val($i, 23);
                          $ttr_regional               = $data->val($i, 24);
                          $ttr_witel                = $data->val($i, 25);
                          $ttr_mitra                = $data->val($i, 26);
                          $ttr_agent                = $data->val($i, 27);
                          $status                   = $data->val($i, 28);
                          $osm_resolved_code            = $data->val($i, 29);
                          $last_update_ticket             = $data->val($i, 30);
                          $status_date                = $data->val($i, 31);
                          $close_reopen_by              = $data->val($i, 32);
                          $resolved_by                = $data->val($i, 33);
                          $workzone                 = $data->val($i, 34);
                          $witel                  = $data->val($i, 35);
                          $regional                 = $data->val($i, 36);
                          $incident_symptom             = $data->val($i, 37);
                          $solution_segment             = $data->val($i, 38);
                          $actual_solution              = $data->val($i, 39);

                          // perhitungan interval hari untuk menentukan comply no comply
                      $time     = strtotime($repoted_date);
                      $start_date = date('Y-m-d',$time);

                      $hari     = $_POST['hari'];
                      $time_nala  = strtotime($hari);
                      $today_date = date('Y-m-d',$time_nala);
                      $time_nala  = strtotime($today_date);

                      $datediff   = $time_nala - $time;
                      $selisih_hari = floor($datediff / (60 * 60 * 24));

                          if($selisih_hari < 3){
                            $comply = "yes";
                          }else{
                            $comply = "no";
                          }

                          //pilih daerah berdasarkan STO
                  if ($workzone == "CMI" ||
                    $workzone == "NJG" ||
                    $workzone == "CLL" ||
                    $workzone == "CKW" ||
                    $workzone == "BTJ" ||
                    $workzone == "PDL" ||
                    $workzone == "CPT" ||
                    $workzone == "GNH"){
                    $daerah = "BDB-1 (Putra Timur Jaya)";
                  }else if ($workzone == "RJW"){
                    $daerah = "BDB-2 (Rajawali)";
                  }else if ($workzone == "CSA" ||
                    $workzone == "GGK" ||
                    $workzone == "HGM" ||
                    $workzone == "LEM"){
                    $daerah = "BDB-3 (Wredata Mitra Telematika)";
                  }else if ($workzone == "TLE" ||
                    $workzone == "KPO" ||
                    $workzone == "SOR" ||
                    $workzone == "CWD" ||
                    $workzone == "BJN" ||
                    $workzone == "BJA" ||
                    $workzone == "BDK" ||
                    $workzone == "PLN" ||
                    $workzone == "TGA" ||
                    $workzone == "PNL"){
                    $daerah = "BDB-4 (Fajar Mitra Krida Abadi)";
                  }else if ($workzone == "CCD" ||
                    $workzone == "ANI" ||
                    $workzone == "DGO"){
                    $daerah = "BDT-1 (Dadali Citra Mandiri)";
                  }else if ($workzone == "CTR" ||
                    $workzone == "LBG" ||
                    $workzone == "TRG" ||
                    $workzone == "CJA"){
                    $daerah = "BDT-2 (BANGTELINDO)";
                  }else if ($workzone == "UBR" ||
                    $workzone == "RCK" ||
                    $workzone == "SMD" ||
                    $workzone == "TAS" ||
                    $workzone == "MJY" ||
                    $workzone == "CCL"){
                    $daerah = "BDT-3 (Adimas Cipta Karya Pratama)";
                  }

                          // setelah data dibaca, masukkan ke tabel pegawai sql
                          $query = "INSERT into nossa (
                          incident,
                          customer_name,
                          summary,
                          owner_group,
                          owner,
                          last_updated_work_log,
                          last_work_log_date,
                          source,
                          segment,
                          channel,
                          customer_segment,
                          service_id,
                          service_no,
                          service_type,
                          top_priority,
                          slg,
                          technology,
                          datek,
                          rk_name,
                          induk_gamas,
                          repoted_date,
                          ttr_customer,
                          ttr_nasional,
                          ttr_regional,
                          ttr_witel,
                          ttr_mitra,
                          ttr_agent,
                          status,
                          osm_resolved_code,
                          last_update_ticket,
                          status_date,
                          closed_reopen_by,
                          resolved_by,
                          workzone,
                          witel,
                          regional,
                          incident_symptom,
                          solution_segment,
                          actual_solution,
                          comply,
                          daerah,
                          tanggal)
                          values(
                          '$incident',
                          '$customer_name',
                          '$summary',
                          '$owner_group',
                          '$owner',
                          '$last_update_work_log',
                          '$last_work_log_date',
                          '$source',
                          '$segment',
                          '$channel',
                          '$customer_segment',
                          '$service_id',
                          '$service_no',
                          '$service_type',
                          '$top_priority',
                          '$slg',
                          '$technology',
                          '$datek',
                          '$rk_name',
                          '$induk_gamas',
                          '$repoted_date',
                          '$ttr_customer',
                          '$ttr_nasional',
                          '$ttr_regional',
                          '$ttr_witel',
                          '$ttr_mitra',
                          '$ttr_agent',
                          '$status',
                          '$osm_resolved_code',
                          '$last_update_ticket',
                          '$status_date',
                          '$close_reopen_by',
                          '$resolved_by',
                          '$workzone',
                          '$witel',
                          '$regional',
                          '$incident_symptom',
                          '$solution_segment',
                          '$actual_solution',
                          '$comply',
                          '$daerah',
                          '$hari')";
                          $hasil = mysql_query($query);
                        }

                        // algoritma masukin data ke table sisa

                        $target_sisa = basename($_FILES['filesisa']['name']) ;
                        move_uploaded_file($_FILES['filesisa']['tmp_name'], $target_sisa);

                        // tambahkan baris berikut untuk mencegah error is not readable
                        chmod($_FILES['filesisa']['name'],0777);

                        $data = new Spreadsheet_Excel_Reader($_FILES['filesisa']['name'],false);

                        // menghitung jumlah baris file xls
                        $baris_sisa = $data->rowcount($sheet_index=0);

                        // import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
                        for ($i=2; $i<=$baris_sisa; $i++){
                          // membaca data (kolom ke-1 sd terakhir)
                          $incident                 = $data->val($i, 1);
                          $customer_name                = $data->val($i, 2);
                          $summary                  = $data->val($i, 3);
                          $owner_group            = $data->val($i, 4);
                          $owner                  = $data->val($i, 5);
                          $last_update_work_log           = $data->val($i, 6);
                          $last_work_log_date           = $data->val($i, 7);
                          $source                 = $data->val($i, 8);
                          $segment              = $data->val($i, 9);
                          $channel                  = $data->val($i, 10);
                          $customer_segment             = $data->val($i, 11);
                          $service_id                 = $data->val($i, 12);
                          $service_no                 = $data->val($i, 13);
                          $service_type               = $data->val($i, 14);
                          $top_priority               = $data->val($i, 15);
                          $slg                    = $data->val($i, 16);
                          $technology                 = $data->val($i, 17);
                          $datek                  = $data->val($i, 18);
                          $rk_name                  = $data->val($i, 19);
                          $induk_gamas                = $data->val($i, 20);
                          $repoted_date               = $data->val($i, 21);
                          $ttr_customer               = $data->val($i, 22);
                          $ttr_nasional               = $data->val($i, 23);
                          $ttr_regional               = $data->val($i, 24);
                          $ttr_witel                = $data->val($i, 25);
                          $ttr_mitra                = $data->val($i, 26);
                          $ttr_agent                = $data->val($i, 27);
                          $status                   = $data->val($i, 28);
                          $osm_resolved_code            = $data->val($i, 29);
                          $last_update_ticket             = $data->val($i, 30);
                          $status_date                = $data->val($i, 31);
                          $close_reopen_by              = $data->val($i, 32);
                          $resolved_by                = $data->val($i, 33);
                          $workzone                 = $data->val($i, 34);
                          $witel                  = $data->val($i, 35);
                          $regional                 = $data->val($i, 36);
                          $incident_symptom             = $data->val($i, 37);
                          $solution_segment             = $data->val($i, 38);
                          $actual_solution              = $data->val($i, 39);

                          //pilih daerah berdasarkan STO
                  if ($workzone == "CMI" ||
                    $workzone == "NJG" ||
                    $workzone == "CLL" ||
                    $workzone == "CKW" ||
                    $workzone == "BTJ" ||
                    $workzone == "PDL" ||
                    $workzone == "CPT" ||
                    $workzone == "GNH"){
                    $daerah = "BDB-1 (Putra Timur Jaya)";
                  }else if ($workzone == "RJW"){
                    $daerah = "BDB-2 (Rajawali)";
                  }else if ($workzone == "CSA" ||
                    $workzone == "GGK" ||
                    $workzone == "HGM" ||
                    $workzone == "LEM"){
                    $daerah = "BDB-3 (Wredata Mitra Telematika)";
                  }else if ($workzone == "TLE" ||
                    $workzone == "KPO" ||
                    $workzone == "SOR" ||
                    $workzone == "CWD" ||
                    $workzone == "BJN" ||
                    $workzone == "BJA" ||
                    $workzone == "BDK" ||
                    $workzone == "PLN" ||
                    $workzone == "TGA" ||
                    $workzone == "PNL"){
                    $daerah = "BDB-4 (Fajar Mitra Krida Abadi)";
                  }else if ($workzone == "CCD" ||
                    $workzone == "ANI" ||
                    $workzone == "DGO"){
                    $daerah = "BDT-1 (Dadali Citra Mandiri)";
                  }else if ($workzone == "CTR" ||
                    $workzone == "LBG" ||
                    $workzone == "TRG" ||
                    $workzone == "CJA"){
                    $daerah = "BDT-2 (BANGTELINDO)";
                  }else if ($workzone == "UBR" ||
                    $workzone == "RCK" ||
                    $workzone == "SMD" ||
                    $workzone == "TAS" ||
                    $workzone == "MJY" ||
                    $workzone == "CCL"){
                    $daerah = "BDT-3 (Adimas Cipta Karya Pratama)";
                  }

                          // setelah data dibaca, masukkan ke tabel pegawai sql
                          $query = "INSERT into nossa_sisa (
                          incident,
                          customer_name,
                          summary,
                          owner_group,
                          owner,
                          last_updated_work_log,
                          last_work_log_date,
                          source,
                          segment,
                          channel,
                          customer_segment,
                          service_id,
                          service_no,
                          service_type,
                          top_priority,
                          slg,
                          technology,
                          datek,
                          rk_name,
                          induk_gamas,
                          repoted_date,
                          ttr_customer,
                          ttr_nasional,
                          ttr_regional,
                          ttr_witel,
                          ttr_mitra,
                          ttr_agent,
                          status,
                          osm_resolved_code,
                          last_update_ticket,
                          status_date,
                          closed_reopen_by,
                          resolved_by,
                          workzone,
                          witel,
                          regional,
                          incident_symptom,
                          solution_segment,
                          actual_solution,
                          daerah,
                          tanggal)
                          values(
                          '$incident',
                          '$customer_name',
                          '$summary',
                          '$owner_group',
                          '$owner',
                          '$last_update_work_log',
                          '$last_work_log_date',
                          '$source',
                          '$segment',
                          '$channel',
                          '$customer_segment',
                          '$service_id',
                          '$service_no',
                          '$service_type',
                          '$top_priority',
                          '$slg',
                          '$technology',
                          '$datek',
                          '$rk_name',
                          '$induk_gamas',
                          '$repoted_date',
                          '$ttr_customer',
                          '$ttr_nasional',
                          '$ttr_regional',
                          '$ttr_witel',
                          '$ttr_mitra',
                          '$ttr_agent',
                          '$status',
                          '$osm_resolved_code',
                          '$last_update_ticket',
                          '$status_date',
                          '$close_reopen_by',
                          '$resolved_by',
                          '$workzone',
                          '$witel',
                          '$regional',
                          '$incident_symptom',
                          '$solution_segment',
                          '$actual_solution',
                          '$daerah',
                          '$hari')";
                          $hasil2 = mysql_query($query);
                        }

                        // bikin data untuk data BDB-1
                        $paket      = "BDB-1 (Putra Timur Jaya)";
                        $hari       = $_POST['hari'];
                        $time     = strtotime($hari);
                        $hari     = date('Y-m-d',$time);
                        $jumlah_teknisi = 0;

                        $queri_close_BDB1   = "SELECT COUNT(*) as total_close FROM nossa WHERE daerah = '$paket' AND tanggal = '$hari'";
                        $hasil_close_BDB1   = mysql_query ($queri_close_BDB1);
                        $data         = mysql_fetch_assoc($hasil_close_BDB1);
                        $close_HI       = $data['total_close'];

                        $queri_sisa_BDB1  = "SELECT COUNT(*) as total_sisa FROM nossa_sisa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_sisa_BDB1  = mysql_query ($queri_sisa_BDB1);
                $data         = mysql_fetch_assoc($hasil_sisa_BDB1);
                $sisa_HI        = $data['total_sisa'];

                $produktivity   = 0;

                $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'yes' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_yes = $data['total'];

                  $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'no' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_no  = $data['total'];

                        $query =
                        "INSERT into insurance2 (
                        paket,
                        hari,
                        jumlah_teknisi,
                        close_HI,
                        sisa_HI,
                        produktivity,
                        comply_yes,
                        comply_no
                        )
                        values(
                        '$paket',
                        '$hari',
                        '$jumlah_teknisi',
                        '$close_HI',
                        '$sisa_HI',
                        '$produktivity',
                        '$comply_yes',
                        '$comply_no'
                        );";
                        $hasil2 = mysql_query($query);

                        // bikin data untuk data BDB-2
                        $paket      = "BDB-2 (Rajawali)";
                  $hari       = $_POST['hari'];
                  $time     = strtotime($hari);
                  $hari     = date('Y-m-d',$time);
                  $jumlah_teknisi = 0;

                        $queri_close_BDB1   = "
                          SELECT COUNT(*) as total_close FROM nossa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_close_BDB1   = mysql_query ($queri_close_BDB1);
                $data         = mysql_fetch_assoc($hasil_close_BDB1);
                $close_HI       = $data['total_close'];

                $queri_sisa_BDB1  = "
                          SELECT COUNT(*) as total_sisa FROM nossa_sisa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_sisa_BDB1  = mysql_query ($queri_sisa_BDB1);
                $data         = mysql_fetch_assoc($hasil_sisa_BDB1);
                $sisa_HI        = $data['total_sisa'];

                $produktivity   = 0;

                $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'yes' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_yes = $data['total'];

                  $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'no' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_no  = $data['total'];

                        $query =
                        "INSERT into insurance2 (
                        paket,
                        hari,
                        jumlah_teknisi,
                        close_HI,
                        sisa_HI,
                        produktivity,
                        comply_yes,
                        comply_no
                        )
                        values(
                        '$paket',
                        '$hari',
                        '$jumlah_teknisi',
                        '$close_HI',
                        '$sisa_HI',
                        '$produktivity',
                        '$comply_yes',
                        '$comply_no'
                        );";
                        $hasil2 = mysql_query($query);

                        // bikin data untuk data BDB-3
                        $paket      = "BDB-3 (Wredata Mitra Telematika)";
                  $hari       = $_POST['hari'];
                  $time     = strtotime($hari);
                  $hari     = date('Y-m-d',$time);
                  $jumlah_teknisi = 0;

                        $queri_close_BDB1   = "
                          SELECT COUNT(*) as total_close FROM nossa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_close_BDB1   = mysql_query ($queri_close_BDB1);
                $data         = mysql_fetch_assoc($hasil_close_BDB1);
                $close_HI       = $data['total_close'];

                $queri_sisa_BDB1  = "
                          SELECT COUNT(*) as total_sisa FROM nossa_sisa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_sisa_BDB1  = mysql_query ($queri_sisa_BDB1);
                $data         = mysql_fetch_assoc($hasil_sisa_BDB1);
                $sisa_HI        = $data['total_sisa'];

                $produktivity   = 0;

                $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'yes' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_yes = $data['total'];

                  $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'no' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_no  = $data['total'];

                        $query =
                        "INSERT into insurance2 (
                        paket,
                        hari,
                        jumlah_teknisi,
                        close_HI,
                        sisa_HI,
                        produktivity,
                        comply_yes,
                        comply_no
                        )
                        values(
                        '$paket',
                        '$hari',
                        '$jumlah_teknisi',
                        '$close_HI',
                        '$sisa_HI',
                        '$produktivity',
                        '$comply_yes',
                        '$comply_no'
                        );";
                        $hasil2 = mysql_query($query);

                        // bikin data untuk data BDB-4
                        $paket      = "BDB-4 (Fajar Mitra Krida Abadi)";
                  $hari       = $_POST['hari'];
                  $time     = strtotime($hari);
                  $hari     = date('Y-m-d',$time);
                  $jumlah_teknisi = 0;

                        $queri_close_BDB1   = "
                          SELECT COUNT(*) as total_close FROM nossa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_close_BDB1   = mysql_query ($queri_close_BDB1);
                $data         = mysql_fetch_assoc($hasil_close_BDB1);
                $close_HI       = $data['total_close'];

                $queri_sisa_BDB1  = "
                          SELECT COUNT(*) as total_sisa FROM nossa_sisa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_sisa_BDB1  = mysql_query ($queri_sisa_BDB1);
                $data         = mysql_fetch_assoc($hasil_sisa_BDB1);
                $sisa_HI        = $data['total_sisa'];

                $produktivity   = 0;

                $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'yes' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_yes = $data['total'];

                  $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'no' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_no  = $data['total'];

                        $query =
                        "INSERT into insurance2 (
                        paket,
                        hari,
                        jumlah_teknisi,
                        close_HI,
                        sisa_HI,
                        produktivity,
                        comply_yes,
                        comply_no
                        )
                        values(
                        '$paket',
                        '$hari',
                        '$jumlah_teknisi',
                        '$close_HI',
                        '$sisa_HI',
                        '$produktivity',
                        '$comply_yes',
                        '$comply_no'
                        );";
                        $hasil2 = mysql_query($query);

                        // bikin data untuk data BDT-1
                        $paket      = "BDT-1 (Dadali Citra Mandiri)";
                  $hari       = $_POST['hari'];
                  $time     = strtotime($hari);
                  $hari     = date('Y-m-d',$time);
                  $jumlah_teknisi = 0;

                        $queri_close_BDB1   = "
                          SELECT COUNT(*) as total_close FROM nossa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_close_BDB1   = mysql_query ($queri_close_BDB1);
                $data         = mysql_fetch_assoc($hasil_close_BDB1);
                $close_HI       = $data['total_close'];

                $queri_sisa_BDB1  = "
                          SELECT COUNT(*) as total_sisa FROM nossa_sisa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_sisa_BDB1  = mysql_query ($queri_sisa_BDB1);
                $data         = mysql_fetch_assoc($hasil_sisa_BDB1);
                $sisa_HI        = $data['total_sisa'];

                $produktivity   = 0;

                $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'yes' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_yes = $data['total'];

                  $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'no' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_no  = $data['total'];

                        $query =
                        "INSERT into insurance2 (
                        paket,
                        hari,
                        jumlah_teknisi,
                        close_HI,
                        sisa_HI,
                        produktivity,
                        comply_yes,
                        comply_no
                        )
                        values(
                        '$paket',
                        '$hari',
                        '$jumlah_teknisi',
                        '$close_HI',
                        '$sisa_HI',
                        '$produktivity',
                        '$comply_yes',
                        '$comply_no'
                        );";
                        $hasil2 = mysql_query($query);

                        // bikin data untuk data BDT-2
                        $paket      = "BDT-2 (BANGTELINDO)";
                  $hari       = $_POST['hari'];
                  $time     = strtotime($hari);
                  $hari     = date('Y-m-d',$time);
                  $jumlah_teknisi = 0;

                        $queri_close_BDB1   = "
                          SELECT COUNT(*) as total_close FROM nossa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_close_BDB1   = mysql_query ($queri_close_BDB1);
                $data         = mysql_fetch_assoc($hasil_close_BDB1);
                $close_HI       = $data['total_close'];

                $queri_sisa_BDB1  = "
                          SELECT COUNT(*) as total_sisa FROM nossa_sisa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_sisa_BDB1  = mysql_query ($queri_sisa_BDB1);
                $data         = mysql_fetch_assoc($hasil_sisa_BDB1);
                $sisa_HI        = $data['total_sisa'];

                $produktivity   = 0;

                $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'yes' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_yes = $data['total'];

                  $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'no' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_no  = $data['total'];

                        $query =
                        "INSERT into insurance2 (
                        paket,
                        hari,
                        jumlah_teknisi,
                        close_HI,
                        sisa_HI,
                        produktivity,
                        comply_yes,
                        comply_no
                        )
                        values(
                        '$paket',
                        '$hari',
                        '$jumlah_teknisi',
                        '$close_HI',
                        '$sisa_HI',
                        '$produktivity',
                        '$comply_yes',
                        '$comply_no'
                        );";
                        $hasil2 = mysql_query($query);

                        // bikin data untuk data BDT-3
                        $paket      = "BDT-3 (Adimas Cipta Karya Pratama)";
                  $hari       = $_POST['hari'];
                  $time     = strtotime($hari);
                  $hari     = date('Y-m-d',$time);
                  $jumlah_teknisi = 0;

                        $queri_close_BDB1   = "
                          SELECT COUNT(*) as total_close FROM nossa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_close_BDB1   = mysql_query ($queri_close_BDB1);
                $data         = mysql_fetch_assoc($hasil_close_BDB1);
                $close_HI       = $data['total_close'];

                $queri_sisa_BDB1  = "
                          SELECT COUNT(*) as total_sisa FROM nossa_sisa WHERE daerah = '$paket' AND tanggal = '$hari'";
                $hasil_sisa_BDB1  = mysql_query ($queri_sisa_BDB1);
                $data         = mysql_fetch_assoc($hasil_sisa_BDB1);
                $sisa_HI        = $data['total_sisa'];

                $produktivity   = 0;

                $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'yes' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_yes = $data['total'];

                  $result     = mysql_query(
                  "SELECT count(*) as total from nossa where comply = 'no' and tanggal = '$hari' and daerah = '$paket'");
                  $data     = mysql_fetch_assoc($result);
                  $comply_no  = $data['total'];

                        $query =
                        "INSERT into insurance2 (
                        paket,
                        hari,
                        jumlah_teknisi,
                        close_HI,
                        sisa_HI,
                        produktivity,
                        comply_yes,
                        comply_no
                        )
                        values(
                        '$paket',
                        '$hari',
                        '$jumlah_teknisi',
                        '$close_HI',
                        '$sisa_HI',
                        '$produktivity',
                        '$comply_yes',
                        '$comply_no'
                        );";
                        $hasil2 = mysql_query($query);

                // hapus file xls yang udah dibaca
                //unlink($_FILES['filepegawaiall']['name']);

                      if($hasil == null && $hasil2 == null){
                      echo
                      "
                      <p/>
                      <div class='alert alert-danger alert-dismissable'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Fail!</strong> Input ke database gagal.
                      </div>";
                  }else{
                      echo
                      "
                      <p/>
                      <div class='alert alert-success alert-dismissable'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Input ke database berhasil.
                      </div>";
                  }
                    }else{
                    echo
                    "
                    <p/>
                    <div class='alert alert-danger alert-dismissable'>
                      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Fail!</strong> Data sudah pernah ada.
                    </div>";
                }
                unset($_POST);
              unset($_REQUEST);
              }
                ?>
              </form>
          <div><p/>

        <table class='table table-hover' id="example">
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
            </tr>
          </thead>

          <tbody>
            <tr>
              <?php
                unset($_POST);
              unset($_REQUEST);

                // Perintah untuk menampilkan data
              $queri = "SELECT * FROM insurance2" ;
              $hasil = mysql_query ($queri);

              // perintah untuk membaca dan mengambil data dalam bentuk array
              while ($data = mysql_fetch_array ($hasil)){
                echo "
                      <tr class='table-row clickable-row' id='aduh'>
                        <td>".$data['paket']."</td>
                        <td>".$data['hari']."</td>
                        <td>
                          ".$data['jumlah_teknisi']."
                        </td>
                        <td>".$data['close_HI']."</td>
                        <td>".$data['sisa_HI']."</td>
                        <td>".$data['produktivity']."</td>
                        <td>".$data['comply_yes']."</td>
                        <td>".$data['comply_no']."</td>
                      </tr>
                ";
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

        </div>
        <!-- /#page-wrapper -->

    </div>
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
