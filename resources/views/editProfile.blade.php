@extends('layouts.master')

@section('content')
    <div class="container">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">User Profile</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Setting</li>
                        </ol>
                    </div><!-- /.col -->

                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">{{Auth::User()->name}}</h3>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Nama</b> <a class="float-right">{{Auth::User()->name}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{Auth::User()->email}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Posisi</b> <a class="float-right">{{Auth::User()->role}}</a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /.row -->
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link" href="{{route('home.editPassword',auth()->user()->id)}}" data-toggle="tab">Settings</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content"></div>
                                <div class="tab-pane" id="settings">
                                    <form action="{{route('home.update', Auth()->user()->id)}}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" name= "name" class="form-control" id="name" placeholder="Name" value="{{ old('name') ?? auth()->user()->name }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name= "email" class="form-control" id="email" placeholder="Email@gmail.com" value="{{ old('name') ?? auth()->user()->email }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Posisi</label>
                                            <div class="col-sm-10">
                                                <input type="text" name= "role" class="form-control" id="role" placeholder="role" value="{{ auth()->user()->role }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-outline-danger">Edit</button>
                                            </div>
                                        </div>
                                        <ul class="nav nav-pills">
                                            <a href="{{route('home.editPassword')}}" class="btn btn-outline-success"><i class="fa fa-user-edit"></i> Change Password</a>
                                        </ul>

                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    </div>
@endsection
