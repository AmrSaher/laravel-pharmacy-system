@extends('admin.layouts.app')

@section('title', 'Users')

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
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 d-flex" style="gap: 10px; justify-content: flex-end;">
                    <a href="/admin/export/users" class="btn btn-dark">Download excel file</a>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-success">Create new user</a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <table id="users-table" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>National ID</th>
                        <th>Gender</th>
                        <th>Date of birth</th>
                        <th>Mobile number</th>
                        <th>Created at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <img src="" alt="user image"
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->national_id }}</td>
                            <td>{{ $user->gender }}</td>
                            <td>{{ $user->date_of_birth }}</td>
                            <td>{{ $user->mobile_number }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                            <td style="display: flex; flex-wrap: wrap; gap: 10px;">
                                <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" class="btn btn-primary">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', ['user' => $user->id]) }}"
                                    id="delete-user-form-{{ $user->id }}" style="display: none;">
                                    @csrf
                                    @method('delete')
                                </form>
                                <a href="#" class="btn btn-danger"
                                    onclick="if (confirm('Are you sure ?')) document.getElementById('delete-user-form-{{ $user->id }}').submit()">
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
        let table = new DataTable('#users-table', {})
    </script>
@endsection
