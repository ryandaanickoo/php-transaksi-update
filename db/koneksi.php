<?php
$koneksi = mysqli_connect("localhost", "root", "", "transaksi");

if(mysqli_connect_error()){
    echo"errorrrrrr" . mysqli_connect_error();
}