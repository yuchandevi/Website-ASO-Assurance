<!-- 
<form name="myForm" id="myForm" onSubmit="return validateForm()" action="import.php" method="post" enctype="multipart/form-data">
    <input type="file" id="filepegawaiall" name="filepegawaiall" />
    <input type="submit" name="submit" value="Import" /><br/>
    <label><input type="checkbox" name="drop" value="1" /> <u>Kosongkan tabel sql terlebih dahulu.</u> </label>
</form>
 
<script type="text/javascript">
    // validasi form (hanya file .xls yang diijinkan)
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }
 
        if(!hasExtension('filepegawaiall', ['.xls'])){
            alert("Hanya file XLS (Excel 2003) yang diijinkan.");
            return false;
        }
    }
</script>
-->

<!DOCTYPE html>
<html>
  
  <head>
  	
  	<!--bootstrap-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <title>Form Asurance Performance</title>
  </head>

  <body>
    
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!--membuat header-->
    <div style="background-color:red;color:white;padding:20px; ">
        <!--<div style="display: inline;">
          <img src="New-Logo-TA-2016.png" alt="HTML5 Icon" width="128" height="128">
        </div>-->
        <div style="display: inline;">
          <h1><center>Telkom Akses</center></h1>
          <center>Performance Assurance</center>
        </div>  
    </div>
    
    <p>
    </p>

    <form class="form-inline" role="form" name="myForm" id="myForm" onSubmit="return validateForm()"  method="post" enctype="multipart/form-data">

      <div class="form-group">
      	<label class="sr-only" for="inputfile">File input</label>
      	<input type="file" id="filepegawaiall" name="filepegawaiall" />
      	<!-- <form name="myForm" id="myForm" onSubmit="return validateForm()"  method="post" enctype="multipart/form-data"> -->
      </div>

      <input type="submit" name="submit" class="btnbtn-default"/><br/>
      <label><input type="checkbox" name="drop" value="1" /> <u>Kosongkan tabel sql terlebih dahulu.</u> </label>

          <?php
            
            // koneksi ke database, username,password  dan namadatabase menyesuaikan 
            mysql_connect('localhost', 'root', '');
            mysql_select_db('ta');
             
            // memanggil file excel_reader
            require "excel_reader.php";

            $hasil = null;
             
            // jika tombol import ditekan
            if(isset($_POST['submit'])){
             
              $target = basename($_FILES['filepegawaiall']['name']) ;
              move_uploaded_file($_FILES['filepegawaiall']['tmp_name'], $target);
           
              // tambahkan baris berikut untuk mencegah error is not readable
              chmod($_FILES['filepegawaiall']['name'],0777);
              
              $data = new Spreadsheet_Excel_Reader($_FILES['filepegawaiall']['name'],false);
              
              // menghitung jumlah baris file xls
              $baris = $data->rowcount($sheet_index=0);
              
              // jika kosongkan data dicentang jalankan kode berikut
              $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
              if($drop == 1){
                // kosongkan tabel pegawai
                $truncate ="TRUNCATE TABLE insurance2";
                mysql_query($truncate);
              };
                
              // import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
              for ($i=2; $i<=$baris; $i++)
              {
                // membaca data (kolom ke-1 sd terakhir)
                $paket            = $data->val($i, 1);
                $pt               = $data->val($i, 2);
                $hari             = $data->val($i, 3);
                $jumlah_teknisi   = $data->val($i, 4);
                $saldoH_1         = $data->val($i, 5);
                $saldo_HI         = $data->val($i, 6);
                $close_HI         = $data->val($i, 7);
                $sisa_HI          = $data->val($i, 8);
                $produktivity     = $data->val($i, 9);
                $comply           = $data->val($i, 10);
             
                // setelah data dibaca, masukkan ke tabel pegawai sql
                $query = "INSERT into insurance2 (paket,pt,hari,jumlah_teknisi,saldoH_1,saldo_HI,close_HI,sisa_HI,produktivity,comply)values('$paket','$pt','$hari','$jumlah_teknisi','$saldoH_1','$saldo_HI','$close_HI','$sisa_HI','$produktivity','$comply')";
                $hasil = mysql_query($query);
              }
                
              // hapus file xls yang udah dibaca
              //unlink($_FILES['filepegawaiall']['name']);
            }
          ?>

          <?php
            if($hasil == null){
                // jika import gagal
                die(mysql_error());
            }else{
                // jika impor berhasil
                echo "<br> Data berhasil diimpor.";
            }
          ?>

      </form>

      <script type="text/javascript">
          // validasi form (hanya file .xls yang diijinkan)
          function validateForm()
          {
              function hasExtension(inputID, exts) {
                  var fileName = document.getElementById(inputID).value;
                  return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
              }
       
              if(!hasExtension('filepegawaiall', ['.xls'])){
                  alert("Hanya file XLS (Excel 2003) yang diijinkan.");
                  return false;
              }
          }
      </script>
    
    </div>  

    <p>
    </p>
    
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

    		</tr>
    	</thead>
    	
    	<tbody>
    		<tr>
    		<?php  
			// Perintah untuk menampilkan data
			$queri="Select * From insurance2" ;  //menampikan SEMUA data dari tabel siswa

			$hasil=MySQL_query ($queri);    //fungsi untuk SQL

			// perintah untuk membaca dan mengambil data dalam bentuk array
			while ($data = mysql_fetch_array ($hasil)){
			//$id = $data['id_pegawai'];
			echo "    
			        <tr>
				        <td>".$data['paket']."</td>
				        <td>".$data['hari']."</td>
				        <td>".$data['jumlah_teknisi']."</td>
				        <td>".$data['close_HI']."</td>
                <td>".$data['sisa_HI']."</td>
                <td>".$data['produktivity']."</td>
                <td>".$data['comply']."</td>
			        </tr> 
			";        
			}

			?>
			</tr>
    	</tbody>
   

    </table>
  </body>
</html>