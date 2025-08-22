<!-- Modal -->
<div class="modal fade" id="modalLogoutConfirmation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Logout Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer border-0">
                <a href="../phpscripts/user-logout.php" class="btn btn-primary py-0 fw-light">Yes</a>
                <button type="button" class="btn btn-secondary py-0 fw-light" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEditProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content profile-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col">
                        <h4 class="custom-color text-center fw-bold">My Profile</h4>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col text-center">
                        <label for="fileToUpload">
                            <div class="profile-pic user-pic">
                                <span class="glyphicon glyphicon-camera"></span>
                                <span>Change Image</span>
                            </div>
                        </label>
                        <input type="File" name="fileToUpload" id="fileToUpload">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="userName" name="user_name"
                                placeholder="Full Name" value="<?php echo $user_data['user_name']; ?>">
                            <label for="userName">Full Name</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="userEmail" placeholder="Email"
                                value="<?php echo $user_data['user_email']; ?>" disabled>
                            <label for="userEmail">Email</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button type="button" class="btn btn-primary py-0 w-100" data-bs-toggle="modal"
                            data-bs-target="#modalChangePassword">Change Password</button>
                    </div>
                    <div class="col text-center">
                        <button type="button" class="btn btn-primary update-profile py-0 w-100">Update Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalChangePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body edit-info">
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="userOldPassword" placeholder="password">
                            <label for="userOldPassword">Old Password</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="userNewPassword" placeholder="password">
                            <label for="userNewPassword">New Password</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="userConfirmPassword" placeholder="password">
                            <label for="userConfirmPassword">Confirm New Password</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button type="button" role="button"
                            class="btn btn-success w-50 change-password py-0">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>