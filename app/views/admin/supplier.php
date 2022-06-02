<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header"><?php echo $supplier['suppliers']; ?></h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

             <table class="table table-striped table-bordered" cellspacing="0" id="supplierList">
                <thead>
                    <tr>
                        <td><?php echo $supplier['id']; ?></td>
                        <td><?php echo $supplier['suppliersName']; ?></td>
                        <td><?php echo $supplier['contactNo']; ?></td>
                        <td><?php echo $supplier['invoices']; ?></td>
                        <td><?php echo $supplier['limit']; ?></td>
                        <td><?php echo $supplier['balance']; ?></td>
                        <td><?php echo $supplier['status']; ?></td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        foreach($data['data'] as $row){
                            if($row['limit']==0){
                                $row['status'] = "N/A";
                            }else{
                                $row['status'] = (($row['limit']+$row['balance'])/$row['limit'])*100;
                                $row['status'] = $row['status'].'%';
                            }
                            echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            echo "<td><a href=\"".BASE_URL."admin/supplier/".$row['id']."\">".$row['name']."</a></td>";
                            echo "<td>".$row['contact']."</td>";
                            echo "<td>".$row['invoiceCount']."</td>";
                            echo "<td>".$row['limit']."</td>";
                            echo "<td>".$row['balance']."</td>";
                            echo "<td>".$row['status']."</td>";
                          echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /#page-wrapper -->
</body>