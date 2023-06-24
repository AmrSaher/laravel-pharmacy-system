@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
    @if (Session::has('message'))
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        <script>
            let notyf = new Notyf()

            notyf.open({
                type: '{{ Session::get('message')['type'] }}',
                message: '{{ Session::get('message')['message'] }}',
                duration: 3000
            })
        </script>
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Orders</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 d-flex" style="gap: 10px; justify-content: flex-end;">
                    <a href="/admin/export/orders" class="btn btn-dark">Download excel file</a>
                    <a href="{{ route('admin.orders.create') }}" class="btn btn-success">Create new order</a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <table id="orders-table" class="display">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Flat Number</th>
                    <th>Floor Number</th>
                    <th>Building Number</th>
                    <th>Street Name</th>
                    <th>Area ID</th>
                    <th>Governorate</th>
                    <th>User</th>
                    <th>Doctor</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->userAddress->flat_number }}</td>
                        <td>{{ $order->userAddress->floor_number }}</td>
                        <td>{{ $order->userAddress->building_number }}</td>
                        <td>{{ $order->userAddress->street_name }}</td>
                        <td>{{ $order->userAddress->area_id }}</td>
                        <td>{{ $order->userAddress->governorate->name }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->doctor?->user->name }}</td>
                        <td>
                            <span class="bg-warning px-2 py-1 text-sm rounded">{{ $order->status }}</span>
                        </td>
                        <td style="display: flex; flex-wrap: wrap; gap: 10px;">
                            <a href="{{ route('admin.orders.show', ['order' => $order->id]) }}"
                               class="btn btn-success">
                               <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.orders.edit', ['order' => $order->id]) }}"
                               class="btn btn-primary">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.orders.destroy', ['order' => $order->id]) }}"
                                  id="delete-order-form-{{ $order->id }}" style="display: none;">
                                @csrf
                                @method('delete')
                            </form>
                            <a href="#" class="btn btn-danger"
                               onclick="if (confirm('Are you sure ?')) document.getElementById('delete-order-form-{{ $order->id }}').submit()">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('extra-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
@endsection

@section('extra-js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        let table = new DataTable('#orders-table', {})
    </script>
@endsection
