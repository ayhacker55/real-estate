<?php include('header.php');

$db = mysqli_connect("localhost", "root", "", "real_estate") or die("Could not connect");

$limit = 10;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $limit;

// Filters
$where = "WHERE 1";
if (!empty($_GET['state'])) {
    $state = mysqli_real_escape_string($db, $_GET['state']);
    $where .= " AND state = '$state'";
}
if (!empty($_GET['city'])) {
    $city = mysqli_real_escape_string($db, $_GET['city']);
    $where .= " AND city LIKE '%$city%'";
}
if (!empty($_GET['created_at'])) {
    $created_at = mysqli_real_escape_string($db, $_GET['created_at']);
    $where .= " AND DATE(created_at) = '$created_at'";
}

// Get total records
$total_result = mysqli_query($db, "SELECT COUNT(*) as total FROM property $where");
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);

// Fetch paginated results
$query = "SELECT id, title, type, listing_type, price, status, state, city, gallery, publish, created_at 
          FROM property 
          $where 
          ORDER BY created_at DESC 
          LIMIT $offset, $limit";
$result = mysqli_query($db, $query);

// Nigeria's 37 states
$states = [
  'Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 'Cross River',
  'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'FCT', 'Gombe', 'Imo', 'Jigawa', 'Kaduna', 'Kano',
  'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun',
  'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara'
];
?>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Real Estate Listings</h3>
        </div>

        <!-- Filter Form -->
        <form method="GET" class="form-inline" style="margin: 10px;">
          <select name="state" class="form-control">
            <option value="">Select State</option>
            <?php foreach ($states as $s): ?>
              <option value="<?= $s ?>" <?= (isset($_GET['state']) && $_GET['state'] == $s) ? 'selected' : '' ?>><?= $s ?></option>
            <?php endforeach; ?>
          </select>
          <input type="text" name="city" placeholder="City" class="form-control" value="<?= htmlspecialchars($_GET['city'] ?? '') ?>">
          <input type="date" name="created_at" class="form-control" value="<?= htmlspecialchars($_GET['created_at'] ?? '') ?>">
          <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <!-- Table -->
        <div class="box-body table-responsive" style="max-height: 600px; overflow-y: auto;">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Type</th>
                <th>Listing</th>
                <th>Price</th>
                <th>Status</th>
                <th>State</th>
                <th>City</th>
                <th>Created At</th>
                <th>Publish</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $serial = $offset + 1; ?>
              <?php while ($row = mysqli_fetch_assoc($result)):
                $gallery = json_decode($row['gallery'], true);
                $image = (!empty($gallery) && is_array($gallery)) ? $gallery[0] : '';
                $created = date("Y-m-d", strtotime($row['created_at']));
                ?>
                <tr>
                  <td><?= $serial++ ?></td>
                  <td>
                    <?php if ($image): ?>
                      <img src="uploads/<?= htmlspecialchars($image) ?>" style="width: 100px; height: 70px; object-fit: cover;">
                    <?php else: ?>
                      <span class="text-muted">No image</span>
                    <?php endif; ?>
                  </td>
                  <td><?= htmlspecialchars($row['title']) ?></td>
                  <td><?= htmlspecialchars($row['type']) ?></td>
                  <td><?= htmlspecialchars($row['listing_type']) ?></td>
                  <td>&#8358;<?= number_format($row['price']) ?></td>
                  <td><?= htmlspecialchars($row['status']) ?></td>
                  <td><?= htmlspecialchars($row['state']) ?></td>
                  <td><?= htmlspecialchars($row['city']) ?></td>
                  <td><?= $created ?></td>
                  <td>
                    <?php
                      if ($row['publish'] == 'approved') {
                          echo '<span class="label label-success">Published</span>';
                      } elseif ($row['publish'] == 'rejected') {
                          echo '<span class="label label-danger">Rejected</span>';
                      } else {
                          echo '<span class="label label-warning">Not Published</span>';
                      }
                    ?>
                  </td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                        Actions <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a href="edit_property.php?id=<?= $row['id'] ?>"><i class="fa fa-pencil"></i> Edit</a></li>
                        <li><a href="delete_property.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this property?')"><i class="fa fa-trash text-danger"></i> Delete</a></li>
                       
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="box-footer clearfix">
          <ul class="pagination pagination-sm no-margin pull-right">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="<?= ($i == $page) ? 'active' : '' ?>">
                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>



    </div><!--/.col (left) -->
            <!-- right column -->
        
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
   
    </div><!-- ./wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- jQuery UI 1.11.2 -->
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>    
    <!-- Morris.js charts -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>
    <script src="seller.js?v=2"></script>
  </body>
</html>