@extends('admin.layouts.app')

@section('title', 'User Addresses')

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
                    <h1 class="m-0">User Addresses</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 d-flex" style="gap: 10px; justify-content: flex-end;">
                    <a href="/admin/export/user_addresses" class="btn btn-dark">Download excel file</a>
                    <a href="{{ route('admin.user_addresses.create') }}" class="btn btn-success">Create new user address</a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <table id="user-addresses-table" class="display">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Flat Number</th>
                    <th>Floor Number</th>
                    <th>Building Number</th>
                    <th>Street Name</th>
                    <th>Area ID</th>
                    <th>User</th>
                    <th>Governorate</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($userAddresses as $userAddress)
                    <tr>
                        <td>{{ $userAddress->id }}</td>
                        <td>{{ $userAddress->flat_number }}</td>
                        <td>{{ $userAddress->floor_number }}</td>
                        <td>{{ $userAddress->building_number }}</td>
                        <td>{{ $userAddress->street_name }}</td>
                        <td>{{ $userAddress->area_id }}</td>
                        <td>{{ $userAddress->user->name }}</td>
                        <td>{{ $userAddress->governorate->name }}</td>
                        <td style="display: flex; flex-wrap: wrap; gap: 10px;">
                            <a href="{{ route('admin.user_addresses.edit', ['user_address' => $userAddress->id]) }}"
                               class="btn btn-primary">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.user_addresses.destroy', ['user_address' => $userAddress->id]) }}"
                                  id="delete-user-address-form-{{ $userAddress->id }}" style="display: none;">
                                @csrf
                                @method('delete')
                            </form>
                            <a href="#" class="btn btn-danger"
                               onclick="if (confirm('Are you sure ?')) document.getElementById('delete-user-address-form-{{ $userAddress->id }}').submit()">
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
        let table = new DataTable('#user-addresses-table', {})
    </script>
@endsection
