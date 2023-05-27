@extends('admin.layouts.app') 

@section('title', 'Create New Pharmacy')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create new pharmacy</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6" style="text-align: right">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.pharmacies.index') }}"
                            >Pharmacies</a
                        >
                    </li>
                    <li class="breadcrumb-item active">Create new pharmacy</li>
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
                    <form action="{{ route('admin.pharmacies.store') }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label for="name"
                                    >Name</label
                                >
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    id="name"
                                    placeholder="Enter pharmacy name"
                                />
                                @error('name')
                                    <span class="text-danger w-100">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="priority"
                                    >Priority</label
                                >
                                <input
                                    type="number"
                                    name="priority"
                                    class="form-control"
                                    id="priority"
                                    placeholder="Enter pharmacy priority"
                                />
                                @error('priority')
                                    <span class="text-danger w-100">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="owner"
                                    >Owner</label
                                >
                                <select name="owner" id="owner" class="form-control">
                                    <option value="" selected>Select owner</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} -> {{ $user->email }}</option>
                                    @endforeach
                                </select>
                                @error('owner')
                                    <span class="text-danger w-100">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="governorate"
                                    >Governorate</label
                                >
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
