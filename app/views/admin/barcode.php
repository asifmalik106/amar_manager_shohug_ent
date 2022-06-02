<body>
    <?php include 'asset/includes/sidebar.php';?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Barcode</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
      
      
       <div class="row">
         
          
          <form class="form-inline">
            <div class="form-group">
              <select class="form-control" id="selectProduct">
                <?php
                  foreach($data['data']['product'] as $row)
                   echo "<option barcode='".$row['barcode']."'  batch='".$row['batch']."'  saleUnit='".$row['saleUnit']."' value='".$row['productID']."' name='".$row['productName']."'>".$row['productID']." - ".$row['productName']."</option>"
                ?>
              </select>
            </div>
            <div class="form-group">
              <select class="form-control" id="selectBatch">

              </select>
            </div>
            
          </form>
        </div>
      <div class="row">
        <table border="1">
          <tr>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
          </tr>
          
                    <tr>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
          </tr>
                   <tr>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
          </tr>
                   <tr>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
          </tr>
                   <tr>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
          </tr>
                   <tr>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
          </tr>
                    <tr>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
          </tr>
                   <tr>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
          </tr>
                   <tr>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
            <td><svg class="printBARCODE"></svg><p class="name" align="center"></p></td>
          </tr>
        </table>
      </div>
    </div>
    <!-- /#page-wrapper -->
</body>