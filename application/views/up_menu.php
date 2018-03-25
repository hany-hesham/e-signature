<!-- Sidebar -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/index">e-Signature</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse" >
   <ul class="nav navbar-nav navbar-right navbar-user">
    <?php if (isset($is_owning_company) && $is_owning_company): ?>
      <li><a href="/reports" class="top-sm-btn"><i class="fa fa-list-alt"></i> Reports</a></li>
    <?php endif ?>
    <?php if (isset($is_admin) && $is_admin): ?>
      <li><a href="/reports" class="top-sm-btn"><i class="fa fa-list-alt"></i> Reports</a></li>
      <li><a href="/backend" class="top-sm-btn"><i class="fa fa-cogs"></i> Settings</a></li>
    <?php endif ?>
    <?php if (isset($username)): ?>
      <li class="dropdown user-dropdown">
        <a href="#" class="dropdown-toggle top-sm-btn" data-toggle="dropdown"><i class="fa fa-user glyphicon glyphicon-user"></i> <?php echo $username; ?><span><b class="caret"></b></span></a>
        <ul class="dropdown-menu">
          <li><a href="/auth/change_password"><i class="fa fa-lock"></i> Change Password</a></li>
          <li class="divider"></li>
          <li><a href="/auth/logout"><i class="fa fa-power-off"></i> Log Out</a></li>
        </ul>
      </li>
    <?php else: ?>
      <li><a href="/auth/login"><i class="fa fa-users"></i> Login</a></li>
    <?php endif; ?>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
