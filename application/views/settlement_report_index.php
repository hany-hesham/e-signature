<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header');?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu'); ?>
      <nav class="navbar navbar-inverse" id="forms-subnav">
        <ul class="nav navbar-nav navbar-left navbar-user" style="width:100%;">
            <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'quality')? 'active' : '' ?>"><a href="/settlement/report_all">Settlement Amount Per Hotel</a></li>
            <li class="<?php echo (isset($submenu['active']) && $submenu['active'] == 'quality')? 'active' : '' ?>"><a href="/settlement/report_hotel">Settlement Amount All Hotels</a></li>
        </ul>
      </nav>
    </div>
  </body>
</html>