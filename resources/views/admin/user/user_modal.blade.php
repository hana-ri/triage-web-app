<div class="modal modal-blur fade" id="modal-user" tabindex="-1" aria-labelledby="user-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="user-modal-label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="form-user" class="">
                    <input type="hidden" name="id">
                    <div class="info-fields">
                        <div class="mb-3">
                            <label class="form-label">Fullname</label>
                            <input type="text" name="name" class="form-control" name="example-text-input" placeholder="Jhon doe">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" name="example-text-input" placeholder="jhon.doe@example.com">
                        </div>
                    </div>
                    <div class="mb-3 password-fields">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" name="example-text-input" placeholder="Password">
                    </div>
                    <div class="mb-3 password-fields">
                        <label class="form-label">Password confirmation</label>
                        <input type="password" name="password_confirmation" class="form-control" name="example-text-input" placeholder="Password confirmation">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-user" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
