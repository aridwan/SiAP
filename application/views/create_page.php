<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SiAP Telkom</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/skins/_all-skins.min.css">
  <style type="text/css">
    .box{
      overflow-x: scroll;
    }
    .box-body{
      overflow-x: scroll;
    }
  </style>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Si</b>AP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Si</b>AP</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url('telkom2.png');?>">&nbsp&nbsp&nbsp&nbsp<span class="hidden-xs"><?php echo $_SESSION['username']['nama'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo base_url('index.php/auth/logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="<?php echo base_url('index.php/auth');?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php if($_SESSION['username']['role'] == 'Administrator'){?>
        <li>
          <a href="<?php echo base_url('index.php/laporan');?>">
            <i class="fa fa-book"></i> <span>Laporan</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('index.php/laporan/investasi');?>">
            <i class="fa fa-money"></i> <span>Laporan Investasi</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Data</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('index.php/crud/create');?>"><i class="fa fa-circle-o"></i> Tambah</a></li>
            <li><a href="<?php echo base_url('index.php/excel/importPage');?>"><i class="fa fa-circle-o"></i> Import</a></li>
            <li><a href="<?php echo base_url('index.php/excel/export');?>"><i class="fa fa-circle-o"></i> Export</a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo base_url('index.php/crud/userManagement');?>">
            <i class="fa fa-user"></i> <span>User Management</span>
          </a>
        </li>
      <?php }?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Access Point
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Home</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php if(isset($error)){?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error;?>
        </div>
      <?php }?>
      <div class="row">
        <div class="col-lg-12">
          
          <!-- /.box -->

          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <form action="<?php echo base_url('index.php/crud/insert');?>" class="form-horizontal" method="POST">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Merk</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="merk">
                          <option value="CISCO">CISCO</option>
                          <option value="HUAWEI">HUAWEI</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Tipe</label>
                      <div class="col-sm-9">
                        <select class="form-control" id="tipe" name="tipe">
                          <option value="AIR-AP18321-F-K9">AIR-AP18321-F-K9</option>
                          <option value="AIR-CAP3502I-C-K9">AIR-CAP3502I-C-K9</option>
                          <option value="AIR-CAP1602I-C-K9">AIR-CAP1602I-C-K9</option>
                          <option value="AIR-CAP3502E-C-K9">AIR-CAP3502E-C-K9</option>
                          <option value="AIR-CAP1602E-C-K9">AIR-CAP1602E-C-K9</option>
                          <option value="WA201DK-NE">WA201DK-NE</option>
                          <option value="WA251DT-NE">WA251DT-NE</option>
                          <option value="Unknown">Unknown</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Serial Number</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="serial-number" name="serial_number" required="required" >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Mac Address</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="mac-address" name="mac_address" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Status AP</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="status_ap">
                          <option value="Unknown">Unknown</option>
                          <option value="Baik">Baik</option>
                          <option value="Rusak">Rusak</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Site ID</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="drop-from" name="site_id" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Location type</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="location_type">
                          <option value="Unknown">Unknown</option>
                          <option value="Store">Store</option>
                          <option value="Store">Progress</option>
                          <option value="Store">Carried by Technician</option>
                          <option value="Installed">Installed</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Customer</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="location-type" name="customer" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="customer" name="alamat" >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Skema Bisnis</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="skema_bisnis">
                          <option value="WMS">WMS</option>
                          <option value="Wico">Wico</option>
                          <option value="Wico 2.0">Wico 2.0</option>
                          <option value="Basic">Basic</option>
                          <option value="Wista">Wista</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">SSID</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="skema-bisnis" name="ssid" >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Keterangan</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="ssi" name="keterangan" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Aktif</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="posisi-ap" name="tanggal_aktif" >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">No Order</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="tahun-aktif" name="no_order" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">STO</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="bulan-aktif" name="sto" >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">No Inet</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="sto" name="no_inet" >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">LME</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="lme">
                          <option value="pt1">PT1</option>                          
                          <option value="pt2">PT2</option>
                          <option value="pt3">PT3</option>                          
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Investasi</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" id="sto" name="investasi" >
                      </div>
                    </div>
                  </div>
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right" data-target="#myModal">Simpan</button>
                <div class="pull-right">&nbsp&nbsp&nbsp</div>
                <a href="<?php echo base_url();?>"><button type="button" class="btn btn-default pull-right">Batal</button></a>
              </div>
              <!-- /.box-footer -->

              <!-- modal -->
              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Peringatan</h4>
                    </div>
                    <div class="modal-body">
                      Apakah anda yakin akan mengubah data tersebut ?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                      <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2018 <a href="https://telkom.co.id">Telkom Indonesia</a>.</strong> (M. Arief Ridwan 940393)
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        
        <!-- /.control-sidebar-menu -->

        
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="https://adminlte.io/themes/AdminLTE/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="https://adminlte.io/themes/AdminLTE/dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
