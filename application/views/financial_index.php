<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header');?>
  </head>
  <body>
    <?php $this->load->view('menu'); ?>
    <div class="navbar-header" style="position:relative; margin-left: 500px; margin-top: -10px;">
      <div class="navbar navbar-inverse">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Financial<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/contract">Contracts</a></li>
              <li><a href="/shop_renting">Shop Renting Prior Approval</a></li>
              <li><a href="/Shop_license">Tenants Shop License</a></li>
              <li><a href="/out_go">Out Going</a></li>
              <li><a href="/gate">Gate Pass</a></li>
              <li><a href="/out_service">Retired Items</a></li>
              <li><a href="/fin_report"><span style="color: red;">Reports</span></a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </body>
</html>