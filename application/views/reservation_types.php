<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>
	<div id="page-wrapper">
	<div class="container">
		<div style="    left: 0px;
    position: relative;
    width: 100%;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<fieldset>
				<legend>Create A New RC </b></legend>

<form action="<?php echo base_url();?>reservation/insert_into_db" method="post">

<div class="col-md-12 column ui-sortable">



	<script type="text/javascript">
					$(function () {
							$('.datetime').datetimepicker({
								autoclose: true,
								pickTime: false,

							});

							$("#issue-date").on("dp.change",function (e) {
					           $('#delivery-date').data("DateTimePicker").setMinDate(e.date);
					        });
					        $("#delivery-date").on("dp.change",function (e) {
					           $('#issue-date').data("DateTimePicker").setMaxDate(e.date);
					        });
							
					});
					</script>
</body>
</html>
