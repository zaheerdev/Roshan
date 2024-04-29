 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="<?= BASE_URL ?>" class="brand-link">
         <img src="<?= BASE_URL ?>assets/images/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">Roshan Tea</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="<?= ASSETS ?>adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
             </div>
             <div class="info">
                 <a href="#" class="d-block"><?= $this->session->userdata('user_session')->name; ?></a>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item">
                     <a href="<?= BASE_URL ?>" class="nav-link">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= BASE_URL ?>order/book_order" class="nav-link">
                         <i class="nav-icon fas fa-edit"></i>
                         <p>
                             Book Order
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= BASE_URL ?>order/deliver_order" class="nav-link">
                         <i class="nav-icon fas fa-edit"></i>
                         <p>
                             Deliver Order
                         </p>
                     </a>
                 </li>
				 <li class="nav-item">
                     <a href="<?= BASE_URL . 'product/all_products' ?>" class="nav-link">
                         <i class="nav-icon fas fa-edit"></i>
                         <p>
                             Products
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= BASE_URL . 'vendor/all_vendors' ?>" class="nav-link">
                         <i class="nav-icon fas fa-edit"></i>
                         <p>
                             Vendors
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= BASE_URL ?>records/due_payment" class="nav-link">
                         <i class="nav-icon fas fa-edit"></i>
                         <p>
                            Due Amount
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= BASE_URL ?>records" class="nav-link">
                         <i class="nav-icon fas fa-edit"></i>
                         <p>
                             Records
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= BASE_URL ?>expenses/all_expenses" class="nav-link">
                         <i class="nav-icon fas fa-edit"></i>
                         <p>
                            Expenses
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= BASE_URL ?>auth/logout" class="nav-link">
                         <i class="nav-icon fas fa-edit"></i>
                         <p>
                             Logout
                         </p>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
