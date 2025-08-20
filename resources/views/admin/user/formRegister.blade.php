<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4" style="padding: 24px;">
            <form id="form-item" method="POST" action="{{ route('admin.register') }}" class="form-horizontal" data-toggle="validator">
                @csrf
                @method('POST')

                <div class="modal-header">
                    <h4 class="modal-title">Add New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body px-4 py-3">
                    <input type="hidden" id="id" name="id">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required minlength="6">
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Repeat Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required data-match="#password" data-match-error="Passwords do not match">
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="{{ asset('assets/plugins/validator/validator.min.js') }}"></script>

