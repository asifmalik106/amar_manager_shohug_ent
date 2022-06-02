<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header"><?php echo $products['allProducts']; ?></h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

             <table class="table table-striped table-bordered" cellspacing="0" id="productList">
                <thead>
                    <tr>
                        <td><?php echo $products['id']; ?></td>
                        <td><?php echo $products['productName']; ?></td>
                        <td><?php echo $products['category']; ?></td>
                        <td><?php echo $products['unit']; ?></td>
                        <td><?php echo $products['description']; ?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                         while( $row = $data['data']['product']->fetch_assoc() )
                         {
                            echo "<tr>";
                            echo "<td>".$row['productID']."</a></td>";
                            echo "<td><a href=\"".BASE_URL."admin/product/".$row['productID']."\">".$row['productName']."</td>";
                            echo "<td>".$row['categoryName']."</td>";
                            echo "<td>".$row['categoryUnit']."</td>";
                            echo "<td>".$row['productDescription']."</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /#page-wrapper -->
</body>