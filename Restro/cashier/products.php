<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $adn = "DELETE FROM rpos_productos WHERE prod_id = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=products.php");
    } else {
        $err = "Try Again Later";
    }
}
require_once('partials/_head.php');
?>

<body>
<!-- Sidenav -->
<?php
require_once('partials/_sidebar.php');
?>
<!-- Main content -->
<div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <!-- Header -->
    <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
        <span class="mask bg-gradient-dark opacity-8"></span>
        <div class="container-fluid">
            <div class="header-body">
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--8">
        <!-- Table -->
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        Alimentos
                        <!-- <a href="add_product.php" class="btn btn-outline-success">
                            <i class="fas fa-utensils"></i>
                            Add New Product
                        </a> -->
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">IMAGEN</th>
                                <th scope="col">CÓDIGO DE PRODUCTO</th>
                                <th scope="col">NOMBRE</th>
                                <th scope="col">PRECIO</th>
                                <th scope="col">ACCIÓN</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ret = "SELECT * FROM rpos_productos ORDER BY created_at DESC";
                            $stmt = $mysqli->prepare($ret);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            while ($prod = $res->fetch_object()) {
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        if ($prod->prod_img) {
                                            echo "<img src='../admin/assets/img/products/$prod->prod_img' height='60' width='60' class='img-thumbnail'>";
                                        } else {
                                            echo "<img src='../admin/assets/img/products/default.jpg' height='60' width='60' class='img-thumbnail'>";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $prod->prod_code; ?></td>
                                    <td><?php echo $prod->prod_nombre; ?></td>
                                    <td><?php echo $prod->prod_precio; ?>Bs</td>
                                    <td>
                                        <a href="update_product.php?update=<?php echo $prod->prod_id; ?>">
                                            <button class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                                Actualizar
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php
        require_once('partials/_footer.php');
        ?>
    </div>
</div>
<!-- Argon Scripts -->
<?php
require_once('partials/_scripts.php');
?>
</body>

</html>
