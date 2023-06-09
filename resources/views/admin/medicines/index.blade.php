@extends('admin.layouts.app')

@section('title', 'Medicines')

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
                    <h1 class="m-0">Medicines</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 d-flex" style="gap: 10px; justify-content: flex-end;">
                    <a href="/admin/export/medicines" class="btn btn-dark">Download excel file</a>
                    <a href="{{ route('admin.medicines.create') }}" class="btn btn-success">Create new medicine</a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <table id="medicines-table" class="display">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($medicines as $medicine)
                    <tr>
                        <td>{{ $medicine->id }}</td>
                        <td>
                            <img src="{{ $medicine->image_path }}" alt="medicine image"
                                 style="width: 100px;">
                        </td>
                        <td>{{ $medicine->name }}</td>
                        <td>{{ $medicine->description }}</td>
                        <td>{{ ($medicine->price / 100) . '$' }}</td>
                        <td>{{ $medicine->category->name }}</td>
                        <td style="display: flex; flex-wrap: wrap; gap: 10px;">
                            <a href="{{ route('admin.medicines.edit', ['medicine' => $medicine->id]) }}"
                               class="btn btn-primary">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.medicines.destroy', ['medicine' => $medicine->id]) }}"
                                  id="delete-medicine-form-{{ $medicine->id }}" style="display: none;">
                                @csrf
                                @method('delete')
                            </form>
                            <a href="#" class="btn btn-danger"
                               onclick="if (confirm('Are you sure ?')) document.getElementById('delete-medicine-form-{{ $medicine->id }}').submit()">
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
        let table = new DataTable('#medicines-table', {})
    </script>
@endsection
