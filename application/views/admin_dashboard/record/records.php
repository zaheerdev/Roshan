<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Records</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Records</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <!-- /.card -->

          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Vendor ID</th>
                    <th>Order ID</th>
                    <th>Vendor Name</th>
                    <th>Seller Name</th>
                    <th>Product</th>
                    <th>Sub Total</th>
                    <th>Discount</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($records)) : ?>
                    <?php foreach ($records as $record) : ?>
                      <tr>
                        <td>RTA-<?= $record->id ?></td>
                        <td><?= $record->order_id ?></td>
                        <td><?= $record->vendor_name ?></td>
                        <td><?= $record->name ?></td>
                        <td><?= $record->product_name ?></td>
                        <td><?= $record->sub_total ?></td>
                        <td><?= $record->discount ?></td>
                        <td><?= $record->paid_amount ?></td>
                        <td><?= $record->due_amount ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>


<?php require_once(APPPATH . 'views/admin_dashboard/inc/footer.php'); ?>