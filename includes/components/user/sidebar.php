<div class="sidebar animation-left">
    <div class="logo-details">
        <i class="fa-solid fa-graduation-cap d-none"></i>
        <div class="logo-name">NextGenAcademy</div>
        <i class="fa-solid fa-bars" id="btn"></i>
    </div>
    <ul class="nav-list">
        <li>
            <a href="lessons">
                <i class="fa-solid fa-book"></i>
                <span class="links-name">Lessons</span>
            </a>
            <span class="tooltip">Lessons</span>
        </li>
        <li>
            <a href="messages">
                <i class="fa-solid fa-envelope"></i>
                <span class="links-name">Messages</span>
            </a>
            <span class="tooltip">Messages</span>
        </li>
        <li>
            <a href="communityForum">
                <i class="fa-solid fa-envelopes-bulk"></i>
                <span class="links-name">Community Forum</span>
            </a>
            <span class="tooltip">Community Forum</span>
        </li>
        <li>
            <a href="#" data-bs-toggle="modal" data-bs-target="#modalLogoutConfirmation">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span class="links-name">Logout</span>
            </a>
        </li>
    </ul>
</div>
<section class="position-sticky animation-right">
    <div class="profile-container ms-auto p-1 px-3 rounded-3 d-inline-flex align-items-center"
        style="background-color: var(--bg-color5); cursor: pointer;" data-bs-toggle="modal"
        data-bs-target="#modalEditProfile">
        <img src="../assets/images/usersProfile/<?php echo $userPhoto; ?>" class="rounded-circle object-fit-cover"
            height="30" width="30" alt="img">
        <span class="ms-2 fw-bold text-light"><?php echo $first_name; ?></span>
    </div>
</section>