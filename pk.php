koneksi<?php
include "db/koneksi.php";
$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='ambilbarang'){
    $data=mysqli_query($koneksi, "select * from barang");
    echo"<option>Kode Barang</option>";
    while($r=mysqli_fetch_array($data)){
        echo "<option value='$r[kode]'>$r[kode]</option>";
    }
}elseif($op=='ambildata'){
    $kode=$_GET['kode'];
    $dt=mysqli_query($koneksi, "select * from barang where kode='$kode'");
    $d=mysqli_fetch_array($dt);
    echo $d['nama']."|".$d['harga_jual']."|".$d['stok'];
}elseif($op=='barang'){
    $brg=mysqli_query($koneksi, "select * from sementara");
    echo "<thead>
            <tr>
                <td>Kode Barang</td>
                <td>Nama</td>
                <td>Harga</td>
                <td>Jumlah Beli</td>
                <td>Subtotal</td>
                <td>Tools</td>
            </tr>
        </thead>";
    $total=mysqli_fetch_array(mysqli_query($koneksi, "select sum(subtotal) as total from sementara"));
    while($r=mysqli_fetch_array($brg)){
        echo "<tr>
                <td>$r[kode]</td>
                <td>$r[nama]</td>
                <td>$r[harga]</td>
                <td><input type='text' name='jum' value='$r[jumlah]' class='span2'></td>
                <td>$r[subtotal]</td>
                <td><a href='pk.php?op=hapus&kode=$r[kode]' id='hapus'>Hapus</a></td>
            </tr>";
    }
    echo "<tr>
        <td colspan='3'>Total</td>
        <td colspan='4'>$total[total]</td>
    </tr>";
}elseif($op=='tambah'){
    $kode=$_GET['kode'];
    $nama=$_GET['nama'];
    $harga=$_GET['harga'];
    $jumlah=$_GET['jumlah'];
    $subtotal=$harga*$jumlah;
    
    $tambah=mysqli_query($koneksi, "INSERT into sementara (kode,nama,harga,jumlah,subtotal)
                        values ('$kode','$nama','$harga','$jumlah','$subtotal')");
    
    if($tambah){
        echo "sukses";
    }else{
        echo "ERROR";
    }
}elseif($op=='hapus'){
    $kode=$_GET['kode'];
    $del=mysqli_query($koneksi, "delete from sementara where kode='$kode'");
    if($del){
        echo "<script>window.location='index.php?page=penjualan&act=tambah';</script>";
    }else{
        echo "<script>alert('Hapus Data Berhasil');
            window.location='index.php?page=penjualan&act=tambah';</script>";
    }
}elseif($op=='proses'){
    $nota=$_GET['nota'];
    $tanggal=$_GET['tanggal'];
    $to=mysqli_fetch_array(mysqli_query($koneksi, "select sum(subtotal) as total from sementara"));
    $tot=$to['total'];
    $simpan=mysqli_query($koneksi, "insert into penjualan(no_nota,tanggal,total)
                        values ('$nota','$tanggal','$tot')");
    if($simpan){
        $query=mysqli_query($koneksi, "select * from sementara");
        while($r=mysqli_fetch_row($query)){
            mysqli_query($koneksi, "insert into detail_penjualan(no_nota,kode,harga,jumlah,subtotal)
                        values('$nota','$r[0]','$r[2]','$r[3]','$r[4]')");
            mysqli_query($koneksi, "update barang set stok=stok-'$r[3]'
                        where kode='$r[0]'");
        }
        //hapus seluruh isi tabel sementara
        mysqli_query($koneksi, "truncate table sementara");
        echo "sukses";
    }else{
        echo "ERROR";
    }
}
?>