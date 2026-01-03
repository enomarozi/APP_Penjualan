<section id="content" class="flex-grow-1 p-4 mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Change Password</h4>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="formChangePassword" method="POST">
                
                <div class="mb-3">
                    <label for="old_password" class="form-label">Old Password</label>
                    <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Enter old password" required>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password" required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>

            </form>
        </div>
    </div>
</section>