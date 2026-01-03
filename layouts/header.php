<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid d-flex" style="padding: 0;">
    	<img src="assets/images/spiderman.jpg" width="220" height="50" style="margin-right:10px; border-right:2px solid #ffffff; padding-right:10px;">
        <button class="btn btn-light btn-sm" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>
        <div class="flex-grow-1"></div>
        <div class="dropdown me-3">
            <a class="btn btn-link text-white text-decoration-none dropdown-toggle d-flex align-items-center p-0" 
               href="#" role="button" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle" style="font-size: 2rem;"></i>  
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                <li><a class="dropdown-item" href="setting.php">Setting</a></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>

    </div>
</nav>