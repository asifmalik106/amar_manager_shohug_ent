<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Customers</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">

             <table class="table table-striped table-bordered" cellspacing="0" id="customerList">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Customer Name</td>
                        <td>Contact No.</td>
                        <td>Invoices</td>
                        <td>Limit</td>
                        <td>Balance</td>
                        <td>Status</td>
                        <td>Action</td>
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
                            echo "<td><a href=\"".BASE_URL."admin/customer/".$row['id']."\">".$row['name']."</a></td>";
                            echo "<td>".$row['contact']."</td>";
                            echo "<td>".$row['invoiceCount']."</td>";
                            echo "<td>".$row['limit']."</td>";
                            echo "<td>".$row['balance']."</td>";
                            echo "<td>".$row['status']."</td>";
                            
                            echo "<td>
                    <a href=\"#\" title=\"Edit Category\" data-toggle=\"modal\" data-target=\"#editModal\">
                    <i class=\"fa fa-edit fa-lg edit\"></i></a>
                    <a href=\"#\" data-toggle=\"modal\" data-target=\"#deleteModal\">
                    <i class=\"fa fa-times fa-lg delete\" title=\"Delete category\"></i></a>
                    </td>";
                    echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /#page-wrapper -->
</body>