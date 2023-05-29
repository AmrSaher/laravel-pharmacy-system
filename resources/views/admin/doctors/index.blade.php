@extends('admin.layouts.app')

@section('title', 'Doctors')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Doctors</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 d-flex" style="gap: 10px; justify-content: flex-end;">
                <a href="/admin/export/doctors" class="btn btn-dark">Download excel file</a>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-success">Create new doctor</a>
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
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>National ID</th>
                    <th>Pharmacy</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctors as $doctor)
                    <tr>
                        <td>{{ $doctor->id }}</td>
                        <td>
                            <img src="{{ $doctor->user->profile_image }}" alt="user image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                        </td>
                        <td>{{ $doctor->user->name }}</td>
                        <td>{{ $doctor->user->email }}</td>
                        <td>{{ $doctor->user->national_id }}</td>
                        <td>{{ $doctor->pharmacy->name }}</td>
                        <td>{{ $doctor->status }}</td>
                        <td>{{ $doctor->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('admin.doctors.edit', ['doctor' => $doctor->id]) }}" class="btn btn-primary">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.doctors.destroy', ['doctor' => $doctor->id]) }}" id="delete-doctor-form-{{ $doctor->id }}" style="display: none;">
                                @csrf
                                @method('delete')
                            </form>
                            <a href="#" class="btn btn-danger" onclick="if (confirm('Are you sure ?')) document.getElementById('delete-doctor-form-{{ $doctor->id }}').submit()">
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