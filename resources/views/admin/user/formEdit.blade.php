<div class="modal fade" id="editUser{{ $user->user_id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.user.edit',$user->user_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text"
                            name="name"
                            class="form-control"
                            value="{{ $user->name }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email"
                            name="email"
                            class="form-control"
                            value="{{ $user->email }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                            <option value="staff" {{ $user->role=='staff'?'selected':'' }}>Staff</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>

            </form>

        </div>
    </div>
</div>