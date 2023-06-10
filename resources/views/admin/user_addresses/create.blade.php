@extends('admin.layouts.app')

@section('title', 'Create New User Address')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create new user address</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6" style="text-align: right">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.user_addresses.index') }}">User Addresses</a>
                        </li>
                        <li class="breadcrumb-item active">Create new user address</li>
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
                        <form action="{{ route('admin.user_addresses.store') }}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="flat_number">Flat Number</label>
                                    <input type="number" name="flat_number" class="form-control" id="flat_number"
                                           placeholder="Enter flat number" min="1" />
                                    @error('flat_number')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="floor_number">Floor Number</label>
                                    <input type="number" name="floor_number" class="form-control" id="floor_number"
                                           placeholder="Enter floor number" min="1" />
                                    @error('floor_number')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="building_number">Building Number</label>
                                    <input type="number" name="building_number" class="form-control" id="building_number"
                                           placeholder="Enter building number" min="1" />
                                    @error('building_number')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="street_name">Street Name</label>
                                    <input type="text" name="street_name" class="form-control" id="street_name"
                                           placeholder="Enter street name" />
                                    @error('street_name')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="area_id">Area ID</label>
                                    <input type="text" name="area_id" class="form-control" id="area_id"
                                           placeholder="Enter area id" />
                                    @error('area_id')
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
                                <div class="form-group">
                                    <label for="governorate">Governorate</label>
                                    <select name="governorate" id="governorate" class="form-control">
                                        <option value="" selected>Select governorate</option>
                                        @foreach ($governorates as $governorate)
                                            <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('governorate')
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
