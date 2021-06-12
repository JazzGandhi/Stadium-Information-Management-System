<?php echo'
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row" style="background-image: linear-gradient(120deg, #AA3339, #e24826);">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo-mini" href="index.php">
          <img src="../images/logo-mini.png" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-right">
			<li class="nav-item">
				<div class="nav-link" href="#">
					<span class="profile-text">Hello '. $_SESSION["username"]. '! Your CUID is ' . $_SESSION["cuid"].' </span>
					 <i class="mdi mdi-account-circle"></i>
				</div>
			</li>
        </ul>        
      </div>
    </nav>
    <div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewSchedule.php">
              <i class="menu-icon mdi mdi-book"></i>
              <span class="menu-title">View Schedule</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewSystem.php">
              <i class="menu-icon mdi mdi-bulletin-board"></i>
              <span class="menu-title">View System</span>
            </a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="../Logout.php">
              <i class="menu-icon mdi mdi-exit-to-app"></i>
              <span class="menu-title">Logout</span>
            </a>
          </li>		  
        </ul>
		
      </nav>'
?>