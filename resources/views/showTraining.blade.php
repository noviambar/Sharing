@extends('layouts.master')

@section('content')
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
                        <li class="breadcrumb-item"><a href="{{route('training')}}">Data Training</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container mt-5">
            <div class="pull-right">
                @if(auth()->user()->role == 'admin')
                    <a href="{{route('logActivity', $file->id)}}" class="btn btn-outline-info"><i
                            class="fa fa-info"></i> Detail</a>
                @endif
                @if(auth()->user()->id == $file->user_id)
                    <a href="{{route('training.delete', $file->id)}}" class="btn btn-outline-danger"><i
                            class="fa fa-trash-alt"></i> Delete</a>
                @endif
                <a href="{{route('training.edit', $file->id)}}" class="btn btn-outline-primary"><i
                        class="fa fa-edit"></i> Edit</a>
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
@endsection
