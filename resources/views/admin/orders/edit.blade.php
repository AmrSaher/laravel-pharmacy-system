@extends('admin.layouts.app')

@section('title', 'Edit Order')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit order</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6" style="text-align: right">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.orders.index') }}">Orders</a>
                        </li>
                        <li class="breadcrumb-item active">Edit order</li>
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
                        <form action="{{ route('admin.orders.update', ['order' => $order->id]) }}" method="POST">
                            @csrf
                            @method('put')

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="doctor">Doctor</label>
                                    <select name="doctor" id="doctor" class="form-control">
                                        <option value="" {{ is_null($order->doctor_id) ? 'selected' : '' }}>Select doctor</option>
                                        @foreach ($doctors as $doctor)
                                            <option {{ $doctor->id == $order->doctor_id ? 'selected' : '' }}
                                                value="{{ $doctor->id }}">{{ $doctor->user->name }} -> {{ $doctor->user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('doctor')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        @foreach ($statuses as $status)
                                            <option {{ $status == $order->status ? 'selected' : '' }} value="{{ $status }}">
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <span class="text-danger w-100">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    Update
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
