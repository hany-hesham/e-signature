<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="navbar-header" style="height: "> 
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/welcome">e-Signature</a>
  </div>
  <div class="collapse navbar-collapse navbar-ex1-collapse" >
    <ul class="nav navbar-nav side-nav" style="font-size: 12px; width: 110px">
      <?php if ((isset($role_id) && ($role_id == 12 || $role_id == 13 || $role_id == 81 || $role_id == 88 || $role_id == 94 || $role_id == 96 || $role_id == 114)) || (isset($is_fc) && $is_fc) || (isset($is_corp) && $is_corp) || (isset($department_id) && ($department_id == 2)) || (isset($is_cluster) && $is_cluster) || (isset($is_rater) && $is_rater) || (isset($is_admin) && $is_admin) || isset($username)): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'forms')? 'active' : '' ?>">
          <a href="/forms">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'forms')? 'fa-arrow-circle-right' : 'fa-dot-circle-o'?>"></i>
            Assets Movement
          </a>
        </li>
      <?php endif; ?>
      <?php if ((isset($role_id) && ($role_id == 12 || $role_id == 13 || $role_id == 81 || $role_id == 88 || $role_id == 94 || $role_id == 96 || $role_id == 114)) || (isset($is_fc) && $is_fc) || (isset($is_corp) && $is_corp) || (isset($department_id) && ($department_id == 2)) || (isset($is_cluster) && $is_cluster) || (isset($is_rater) && $is_rater) || (isset($is_admin) && $is_admin) || isset($username)): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'plans')? 'active' : '' ?>">
          <a href="/plans">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'plans')? 'fa-arrow-circle-right' : 'fa-dot-circle-o'?>"></i>
            Plan List Approval (Project &amp; Replacement)
          </a>
        </li>
      <?php endif; ?>
      <?php if ((isset($user_id) && ($user_id == 307)) || (isset($role_id) && ($role_id == 12 || $role_id == 13 || $role_id == 81 || $role_id == 88 || $role_id == 94 || $role_id == 96 || $role_id == 114)) || (isset($is_fc) && $is_fc) || (isset($is_corp) && $is_corp) || (isset($department_id) && ($department_id == 2)) || (isset($is_cluster) && $is_cluster) || (isset($is_rater) && $is_rater) || (isset($is_admin) && $is_admin) || isset($username)): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'projects')? 'active' : '' ?>">
          <a href="/projects">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active']=='projects')? 'fa-arrow-circle-right':'fa-dot-circle-o'?>"></i>
            Projects &amp; Replacement
          </a>
        </li>
      <?php endif; ?>
      <?php if ((isset($is_fc) && $is_fc) || (isset($is_corp) && $is_corp) || (isset($department_id) && ($department_id == 2)) || (isset($is_cluster) && $is_cluster) || (isset($is_rater) && $is_rater) || (isset($is_admin) && $is_admin) || (isset($username))): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'Maintenance Center')? 'active' : '' ?>">
          <a href="/workshop">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'Maintenance Center')?'fa-arrow-circle-right':'fa-dot-circle-o'?>"></i>
            Maintenance Center
          </a>
        </li>
      <?php endif; ?>
      <?php if ((isset($is_fc) && $is_fc) || (isset($is_corp) && $is_corp) || (isset($department_id) && ($department_id == 2)) || (isset($is_cluster) && $is_cluster) || (isset($is_rater) && $is_rater) || (isset($is_admin) && $is_admin) || (isset($username))): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'policies')? 'active' : '' ?> dropdown">
          <a href="/policies">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'policies')? 'fa-minus-square' : 'fa-plus-square' ?>"></i>
            Policies
          </a>
        </li>
      <?php endif; ?>
      <?php if ((isset($user_id) && ($user_id == 316 || $user_id == 317)) || (isset($role_id) && ($role_id == 60 || $role_id == 61)) || (isset($is_fc) && $is_fc) || (isset($is_corp) && $is_corp) || (isset($department_id) && ($department_id == 2)) || (isset($is_cluster) && $is_cluster) || (isset($is_rater) && $is_rater) || (isset($is_admin) && $is_admin) || (isset($username))): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'reserve')? 'active' : '' ?> dropdown">
          <a href="/reserve">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'reserve')? 'fa-minus-square' : 'fa-plus-square' ?>"></i>
            Reservation
          </a>
        </li>
      <?php endif; ?>
      <?php if ((isset($is_fc) && $is_fc) || (isset($is_corp) && $is_corp) || (isset($department_id) && ($department_id == 2)) || (isset($is_cluster) && $is_cluster) || (isset($is_rater) && $is_rater) || (isset($is_admin) && $is_admin) || (isset($username))): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'hr')? 'active' : '' ?> dropdown">
          <a href="/hr">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'hr')? 'fa-minus-square' : 'fa-plus-square' ?>"></i>
            Human Resources
          </a>
        </li>
      <?php endif; ?>
      <?php if ((isset($user_id) && ($user_id == 316 || $user_id == 317)) || (isset($role_id) && ($role_id == 57 || $role_id == 59)) || (isset($is_fc) && $is_fc) || (isset($is_corp) && $is_corp) || (isset($department_id) && ($department_id == 2)) || (isset($is_cluster) && $is_cluster) || (isset($is_rater) && $is_rater) || (isset($is_admin) && $is_admin) || (isset($username))): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'financial')? 'active' : '' ?> dropdown">
          <a href="/financial">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'financial')? 'fa-minus-square' : 'fa-plus-square' ?>"></i>
            Financial
          </a>
        </li>
      <?php endif; ?>
      <?php if ((isset($role_id) && ($role_id == 60 || $role_id == 61)) || (isset($is_fc) && $is_fc) || (isset($is_corp) && $is_corp) || (isset($department_id) && ($department_id == 2)) || (isset($is_cluster) && $is_cluster) || (isset($is_rater) && $is_rater) || (isset($is_admin) && $is_admin) || (isset($username))): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'frontoffice')? 'active' : '' ?> dropdown">
          <a href="/frontoffice">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'frontoffice')? 'fa-minus-square' : 'fa-plus-square' ?>"></i>
            Front Office
          </a>
        </li>
      <?php endif; ?>
      <?php if ((isset($is_UK) && $is_UK) || (isset($is_claim) && $is_claim) || (isset($is_corp) && $is_corp) || (isset($department_id) && ($department_id == 2)) || (isset($is_cluster) && $is_cluster) || (isset($is_rater) && $is_rater) || (isset($is_admin) && $is_admin)){?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'quality')? 'active' : '' ?> dropdown">
          <a href="/quality">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'quality')? 'fa-minus-square' : 'fa-plus-square' ?>"></i>
            Quality
          </a>
        </li>
      <?php endif; ?>
      <?php if ((isset($is_fc) && $is_fc) || (isset($is_cluster) && $is_cluster) || (isset($is_rater) && $is_rater) || (isset($is_cairo) && $is_cairo) || (isset($is_sky) && $is_sky) || (isset($is_admin) && $is_admin)): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'rating')? 'active' : '' ?> dropdown">
          <a href="/rating">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'rating')? 'fa-minus-square' : 'fa-plus-square' ?>"></i>
            Exchange Rate
          </a>
        </li>
      <?php endif; ?>
      <?php if ((isset($role_id) && ($role_id == 12 || $role_id == 13 || $role_id == 81 || $role_id == 88 || $role_id == 94 || $role_id == 96 || $role_id == 114 || $role_id == 128 || $role_id == 132|| $role_id == 135 || $role_id == 1 || $role_id == 2)) || (isset($is_admin) && $is_admin)): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'madars')? 'active' : '' ?> dropdown">
          <a href="/madars">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'madars')? 'fa-minus-square' : 'fa-plus-square' ?>"></i>
            Madar
          </a>
        </li>
      <?php endif; ?>
      <?php if (isset($user_id) && ($user_id == 1 || $user_id == 217 || $user_id == 2 || $user_id == 55 || $user_id == 250)): ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active'] == 'char_report')? 'active' : '' ?>">
          <a href="/char_report">
            <i class="fa <?php echo (isset($menu['active']) && $menu['active'] == 'char_report')?'fa-arrow-circle-right':'fa-dot-circle-o'?>"></i>
            Chairman Monthly Report
          </a>
        </li>
      <?php endif; ?>
    </ul>
    <ul class="nav navbar-nav navbar-right navbar-user">
      <?php if (isset($is_admin) && $is_admin): ?>
        <li><a href="/backend" class="top-sm-btn"><i class="fa fa-cogs"></i> Settings</a></li>
      <?php endif ?>
      <?php if (isset($username)): ?>
        <li><a href="/reports" class="top-sm-btn"><i class="fa fa-list-alt"></i> Reports</a></li>
        <li class="dropdown user-dropdown">
          <a href="#" class="dropdown-toggle top-sm-btn" data-toggle="dropdown">
            <i class="fa fa-user glyphicon glyphicon-user"></i> 
            <?php echo $username; ?>
            <span><b class="caret"></b></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="/auth/change_password"><i class="fa fa-lock"></i> Change Password</a></li>
            <li class="divider"></li>
            <li><a href="/auth/logout"><i class="fa fa-power-off"></i> Log Out</a></li>
          </ul>
        </li>
        <!--<?php if (isset($counter)): ?>
          <li class="dropdown user-dropdown">
            <a href="/chairman_approval" class="dropdown-toggle top-sm-btn" data-toggle="dropdown">
              <i class="fa fa-globe fa-lg"></i>
              <span class="circle" style="background-color: red; color: #ffffff; font-size: 18px; font-weight: bolder;">
                <?php echo $counter; ?>
              </span>
            </a>
            <ul class="dropdown-menu centerd" style="text-align: center; width: 200px;">
              <?php foreach($forms as $form ){?>
                <li>
                  <?php echo $form['state']['name'] ?>
                  <a href="<?php echo base_url(); ?><?php echo $form['state']['link'] ?><?php echo $form[$form['state']['variable']] ?>" class="btn btn-primary">View</a>
                </li>
              <?php } ?>
            </ul>
          </li>
        <?php endif; ?>-->
      <?php else: ?>
        <li class="dropdown user-dropdown">
          <ul class="dropdown-menu">
            <li><a href="/auth/login"><i class="fa fa-users"></i> Login</a></li>
          </ul>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>