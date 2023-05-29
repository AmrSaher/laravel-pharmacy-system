@extends('admin.layouts.app')

@section('title', 'Governorates')

@section('content')
    @if (Session::has('message'))
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        <script>
            let notyf = new Notyf()
            
            notyf.open({
                type: '{{ Session::get("message")["type"] }}',
                message: '{{ Session::get("message")["message"] }}',
                duration: 3000
            })
        </script>
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Governorates</h1>
                </div><!-- /.col -->
                <div class="col-sm-6" style="text-align: right;">
                    <a href="{{ route('admin.governorates.create') }}" class="btn btn-success">Create new governorate</a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <table id="pharmacies-table" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($governorates as $governorate)
                        <tr>
                            <td>{{ $governorate->id }}</td>
                            <td>{{ $governorate->name }}</td>
                            <td>
                                <a href="{{ route('admin.governorates.edit', ['governorate' => $governorate->id]) }}" class="btn btn-primary">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.governorates.destroy', ['governorate' => $governorate->id]) }}" id="delete-governorate-form-{{ $governorate->id }}" style="display: none;">
                                    @csrf
                                    @method('delete')
                                </form>
                                <a href="#" class="btn btn-danger" onclick="if (confirm('Are you sure ?')) document.getElementById('delete-governorate-form-{{ $governorate->id }}').submit()">
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
        let table = new DataTable('#pharmacies-table', {})
    </script>
@endsection