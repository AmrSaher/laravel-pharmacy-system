@extends('admin.layouts.app')

@section('title', 'Create New Doctor')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create new doctor</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6" style="text-align: right">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.doctors.index') }}">Doctors</a>
                        </li>
                        <li class="breadcrumb-item active">Create new doctor</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="{{ route('admin.doctors.store') }}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="pharmacy">Pharmacy</label>
                                    <select name="pharmacy" id="pharmacy" class="form-control">
                                        <option value="" selected>Select pharmacy</option>
                                        @foreach ($pharmacies as $pharmacy)
                                            <option value="{{ $pharmacy->id }}">{{ $pharmacy->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('pharmacy')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="user">User</label>
                                    <select name="user" id="user" class="form-control">
                                        <option value="" selected>Select user</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6"></div>
                <!--/.col (right) -->
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
