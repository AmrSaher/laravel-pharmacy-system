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
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Enter user name" />
                                    @error('name')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="Enter user email" />
                                    @error('email')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Enter user password" />
                                    @error('password')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="cpassword">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="cpassword"
                                        placeholder="Confirm user password" />
                                </div>
                                <div class="form-group">
                                    <label for="national_id">National ID</label>
                                    <input type="number" name="national_id" class="form-control" id="national_id"
                                        placeholder="Enter user national id" />
                                    @error('national_id')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="male" selected>Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date_of_birth">Date of birth</label>
                                    <input type="date" name="date_of_birth" class="form-control" id="date_of_birth"
                                        placeholder="Enter user birth" />
                                </div>
                                {{-- <div class="form-group">
                                    <label for="image">Profile Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image">
                                            <label class="custom-file-label" for="image">Choose image</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <label for="mobile_number">Mobile number</label>
                                    <input type="number" name="mobile_number" class="form-control" id="mobile_number"
                                        placeholder="Enter user mobile number" />
                                    @error('mobile_number')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
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
