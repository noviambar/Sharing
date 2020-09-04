<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sharing Knowledge</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="brand-link">
            <span class="brand-text font-weight-light">Sharing Knowledge</span>

        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block">{{auth()->user()->name}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Document
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('meeting')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Meeting Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('training')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Training Report</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a href="{{route('register')}}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Register</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('profile')}}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Data Karyawan</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-times"></i>
                            <p>Logout</p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>View</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item">Document</li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container mt-5">
                <div class="pull-right">
                    <a href="{{route('meeting.delete', $file->id)}}" class="btn btn-outline-danger"><i class="fa fa-plus"></i> Delete</a>
                    @if(auth()->user()->role == 'admin')
                        <a href="{{route('logActivity', $file->id)}}" class="btn btn-outline-info"><i class="fa fa-info"> Detail</i></a>
                    @endif
                    <a href="{{route('meeting.edit', $file->id)}}" class="btn btn-outline-primary"><i class="fa fa-edit"> Edit</i></a>
                </div>
                <form action="#" enctype="multipart/form-data">
                    <h3 class="text-center mb-5"></h3>
                    @csrf
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Jenis Dokumen</label>
                        <input type="text" name="jenis_doc" class="form-control"
                               value="{{old('jenis_doc') ?? $file->jenis_doc }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{old('title') ?? $file->title }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="deskripsi" rows="5" cols="40" class="form-control deskripsi"
                                  readonly>{{old('deskripsi') ?? $file->deskripsi }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>File</label>
                        <input type="text" name="namaFile" class="form-control"
                               value="{{old('namaFile') ?? $file->namaFile }}" readonly>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/js/demo.js"></script>
<!-- TinyMCE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.4.2/tinymce.min.js"></script>
<script type= "text/javascript">tinymce.init({
        selector: 'textarea',
        readonly: 1,
        min_height: 400,
        element_format: 'html',
        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
    });
</script>

</body>
</html>
