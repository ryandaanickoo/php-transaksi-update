<!DOCTYPE html>
    <html>
        <head>
            <title>Transaki Penjualan</title>
            <link rel="stylesheet" href="css/bootstrap.css">
            <script src="js/jquery.js"></script>
            <script src="js/jquery.ui.datepicker.js"></script>
            <script>
                //mendeksripsikan variabel yang akan digunakan
                var nota;
                var tanggal;
                var kode;
                var nama;
                var harga;
                var jumlah;
                var stok;
                $(function(){
                    //meload file pk dengan operator ambil barang dimana nantinya
                    //isinya akan masuk di combo box
                    $("#kode").load("pk.php","op=ambilbarang");
                    
                    //meload isi tabel
                    $("#barang").load("pk.php","op=barang");
                    
                    //mengkosongkan input text dengan masing2 id berikut
                    $("#nama").val("");
                    $("#harga").val("");
                    $("#jumlah").val("");
                    $("#stok").val("");
                                
                    //jika ada perubahan di kode barang
                    $("#kode").change(function(){
                        kode=$("#kode").val();
                        
                        //tampilkan status loading dan animasinya
                        $("#status").html("loading. . .");
                        $("#loading").show();
                        
                        //lakukan pengiriman data
                        $.ajax({
                            url:"proses.php",
                            data:"op=ambildata&kode="+kode,
                            cache:false,
                            success:function(msg){
                                data=msg.split("|");
                                
                                //masukan isi data ke masing - masing field
                                $("#nama").val(data[0]);
                                $("#harga").val(data[1]);
                                $("#stok").val(data[3]);
                                $("#jumlah").focus();
                                //hilangkan status animasi dan loading
                                $("#status").html("");
                                $("#loading").hide();
                            }
                        });
                    });
                    
                    //jika tombol tambah di klik
                    $("#tambah").click(function(){
                        kode=$("#kode").val();
                        stok=$("#stok").val();
                        jumlah=$("#jumlah").val();
                        if(kode=="Kode Barang"){
                            alert("Kode Barang Harus diisi");
                            exit();
                        }else if(jumlah > stok){
                            alert("Stok tidak terpenuhi");
                            $("#jumlah").focus();
                            exit();
                        }else if(jumlah < 1){
                            alert("Jumlah beli tidak boleh 0");
                            $("#jumlah").focus();
                            exit();
                        }
                        nama=$("#nama").val();
                        harga=$("#harga").val();
                        
                                                
                        $("#status").html("sedang diproses. . .");
                        $("#loading").show();
                        
                        $.ajax({
                            url:"pk.php",
                            data:"op=tambah&kode="+kode+"&nama="+nama+"&harga="+harga+"&jumlah="+jumlah,
                            cache:false,
                            success:function(msg){
                                if(msg=="sukses"){
                                    $("#status").html("Berhasil disimpan. . .");
                                }else{
                                    $("#status").html("OR. . .");
                                }
                                $("#loading").hide();
                                $("#nama").val("");
                                $("#harga").val("");
                                $("#jumlah").val("");
                                $("#stok").val("");
                                $("#kode").load("pk.php","op=ambilbarang");
                                $("#barang").load("pk.php","op=barang");
                            }
                        });
                    });
                    
                    //jika tombol proses diklik
                    $("#proses").click(function(){
                        nota=$("#nota").val();
                        tanggal=$("#tanggal").val();
                        $.ajax({
                            url:"pk.php",
                            data:"op=proses&nota="+nota+"&tanggal="+tanggal,
                            cache:false,
                            success:function(msg){
                                if(msg=='sukses'){
                                    $("#status").html('Transaksi Pembelian berhasil');
                                    alert('Transaksi Berhasil');
                                    exit();
                                }else{
                                    $("#status").html('Transaksi Gagal');
                                    alert('Transaksi Gagal');
                                    exit();
                                }
                                $("#kode").load("pk.php","op=ambilbarang");
                                $("#barang").load("pk.php","op=barang");
                                $("#loading").hide();
                                $("#nama").val("");
                                $("#harga").val("");
                                $("#jumlah").val("");
                                $("#stok").val("");
                            }
                        })
                    })
                });
            </script>
        </head>
        <body>
            <div class="container">
                <?php
                include "db/koneksi.php";
                $p=isset($_GET['act'])?$_GET['act']:null;
                switch($p){
                    default:
                        echo "<table class='table table-bordered'>
                            <tr>
                                <td colspan='3'><a href='?page=penjualan&act=tambah' class='btn btn-primary'>Input Transaksi</a></td>
                            </tr>
                                <tr>
                                    <td>No.Nota</td>
                                    <td>Tanggal</td>
                                    <td>Jumlah</td>
                                    <td>Tools</td>
                                </tr>";
                                $query=mysqli_query($koneksi, "select * from penjualan");
                                while($r=mysqli_fetch_array($query)){
                                    echo "<tr>
                                            <td><a href='?page=penjualan&act=detail&nota=$r[no_nota]'>$r[no_nota]</a></td>
                                            <td>$r[tanggal]</td>
                                            <td>$r[total]</td>
                                            <td><a href='?page=penjualan&act=detail&nota=$r[no_nota]'>Cetak Nota</a></td>
                                        </tr>";
                                }
                                echo"</table>";
                        
                        break;
                    case "tambah":
                        $tgl=date('Y-m-d');
                        //untuk autonumber di nota
                        $auto=mysqli_query($koneksi, "select * from penjualan order by no_nota desc limit 1");
                        $no=mysqli_fetch_array($auto);
                        $angka=$no['no_nota']+1;
                        echo "<div class='navbar-form pull-right'>
                                No. Nota : <input type='text' id='nota' value='$angka' readonly>
                                <input type='text' id='tanggal' value='$tgl' readonly>   
                            </div>";
                            
                            echo'<legend>Transaksi Penjualan</legend>
                            <label>Kode Barang</label>
                            <select id="kode"></select>
                            <input type="text" id="nama" placeholder="Nama Barang" readonly>
                            <input type="text" id="harga" placeholder="Harga" class="span2" readonly>
                            <input type="text" id="stok" placeholder="stok" class="span1" readonly>
                            <input type="text" id="jumlah" placeholder="Jumlah Beli" class="span1">
                            <button id="tambah" class="btn">Tambah</button>
                            
                            <span id="status"></span>
                            <table id="barang" class="table table-bordered">
                                    
                            </table>
                            <div class="form-actions">
                                <button id="proses">Proses</button>
                            </div>';
                        break;
                    case "detail":
                        echo "<legend>Nota Penjualan</legend>";
                        $nota=$_GET['nota'];
                        $query=mysqli_query($koneksi, "select penjualan.no_nota,detail_penjualan.kode,barang.nama,
                                           detail_penjualan.harga,detail_penjualan.jumlah,detail_penjualan.subtotal
                                           from detail_penjualan,penjualan,barang
                                           where penjualan.no_nota=detail_penjualan.no_nota and barang.kode=detail_penjualan.kode
                                           and detail_penjualan.no_nota='$nota'");
                        $nomor=mysqli_fetch_array(mysqli_query($koneksi, "select * from penjualan where no_nota='$nota'"));
                        echo "<div class='navbar-form pull-right'>
                                Nota : <input type='text' value='$nomor[no_nota]' disabled>
                                <input type='text' value='$nomor[tanggal]' disabled>
                            </div>";
                        echo "<table class='table table-hover'>
                                <thead>
                                    <tr>
                                        <td>Kode Barang</td>
                                        <td>Nama</td>
                                        <td>Harga</td>
                                        <td>Jumlah</td>
                                        <td>Subtotal</td>
                                    </tr>
                                </thead>";
                                while($r=mysqli_fetch_row($query)){
                                    echo "<tr>
                                            <td>$r[1]</td>
                                            <td>$r[2]</td>
                                            <td>$r[3]</td>
                                            <td>$r[4]</td>
                                            <td>$r[5]</td>
                                        </tr>";
                                }
                                echo "<tr>
                                        <td colspan='4'><h4 align='right'>Total</h4></td>
                                        <td colspan='5'><h4>$nomor[total]</h4></td>
                                    </tr>
                                    </table>";
                        break;
                }
                ?>
            </div>
        </body>
    </html>