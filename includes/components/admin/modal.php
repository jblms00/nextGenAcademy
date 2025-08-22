<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this?
            </div>
            <div class="modal-footer border-0 py-1">
                <button type="button" class="btn btn-secondary py-0" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary py-0" id="confirmDeleteBtn">Yes</button>
            </div>
        </div>
    </div>
</div>
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
<div class="modal fade" id="customizeApperanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Customize Appearance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="appearanceForm" enctype="multipart/form-data">
                    <div class="mb-3 text-center">
                        <h5 class="fw-semibold mb-0">Background Image</h5>
                        <div class="preview-bg-container"
                            data-current-bg-id="<?php echo $appearance['background']['id']; ?>">
                            <img src="../assets/images/<?php echo $appearance['background']['file_name']; ?>"
                                height="100%" width="80%" alt="Background Image">
                        </div>
                    </div>
                    <div class="mb-3">
                        <p class="fw-semibold mb-0">Upload Background Image</p>
                        <input type="file" name="backgroundImage" id="backgroundImage"
                            accept=".jpg, .jpeg, .gif, .webp">
                    </div>
                    <div class="mb-3 text-center">
                        <h5 class="fw-semibold mb-0">Logo</h5>
                        <div class="preview-logo-container"
                            data-current-logo-id="<?php echo $appearance['logo']['id']; ?>">
                            <img src="../assets/images/<?php echo $appearance['logo']['file_name']; ?>" height="300"
                                width="300" alt="Logo Image">
                        </div>
                    </div>
                    <div class="mb-3">
                        <p class="fw-semibold mb-0">Upload Logo</p>
                        <input type="file" name="logoImage" id="logoImage" accept=".png">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-25">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>