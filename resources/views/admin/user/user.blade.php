@extends('layouts.master')

@section('top')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">List of System Users</h3>
        <div class="box-tools">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-form">
                <i class="fa fa-plus"></i> Add User
            </button>
        </div>
    </div>

    <div class="box-body">
        <table id="user-table" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('admin.user.formRegister')
@endsection

@section('bot')
<!-- DataTables -->
<script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script type="text/javascript">
    $(function() {
        $('#user-table').DataTable();
    });
    $(function() {
        $('#form-item').validator();
    });
</script>

@endsection