<!doctype html>
    <html>
        <head>
            <title>SEMBAKO MOKLET</title>
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/bootstrap.css">
        </head>
        <body>
            <div id="container">
            <header>
                <h1>TOKO SEMBAKO MOKLET</h1>
            </header>
            <!--menu -->
            <nav>
                <ul>
                    <li><a href="index.php">Master</a>
                        <ul>
                            <li><a href="?page=barang">Barang</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Transaksi</a>
                        <ul>
                            <li><a href="?page=penjualan">Penjualan</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <br>
            <div class="container">
                    <?php
                    include "db/koneksi.php";
                    $p=isset($_GET['page'])?$_GET['page']:null;
                    switch($p){
                        default:
                            
                            break;
                        case "barang":
                            include "barang.php";
                            break;                       
                        case "penjualan":
                            include "transaksi.php";
                            break;
                    }
                    ?>
            </div>
            </body>
    </html>