<nav class="navbar navbar-inverse" id="forms-subnav">
  <ul class="nav navbar-nav navbar-left navbar-user">
      <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'madar')? 'active' : '' ?>"><a href="/madar">Madar Project</a></li>

    <?php if ($owning_company || $is_admin): ?>
      <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'owning')? 'active' : '' ?>"><a href="/madar_owning">Owning Company Form</a></li>
    <?php endif; ?>
  </ul>
</nav>