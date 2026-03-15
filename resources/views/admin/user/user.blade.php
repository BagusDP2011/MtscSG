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
                    <th width="120">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>

                    <td>

                        <!-- EDIT BUTTON -->
                        <button class="btn btn-xs btn-primary"
                            data-toggle="modal"
                            data-target="#editUser{{ $user->user_id }}">
                            <i class="fa fa-edit"></i>
                        </button>

                        <!-- DELETE BUTTON -->
                        @if(!in_array($user->user_id,[1,2,3]))
                        <form action="{{ route('admin.user.delete',$user->user_id) }}"
                            method="POST"
                            style="display:inline-block"
                            onsubmit="return confirm('Are you sure want to delete this user?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endif

                    </td>

                </tr>

                <!-- INCLUDE EDIT MODAL -->
                @include('admin.user.formEdit')

                @endforeach
            </tbody>

        </table>
    </div>
</div>

@include('admin.user.formRegister')

@endsection

@section('bot')
<script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script>
$(function() {
    $('#user-table').DataTable();
});

$(function() {
    $('#form-item').validator();
});
</script>
@endsection