<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('header'); ?>
<style type="text/css">
	@media print{
		.topic{
			display: block !important;
		}
	}
</style>
</head>
<body>
<div id="wrapper">
	<?php $this->load->view('menu') ?>
	<button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" >Print</button>
    <a class="form-actions btn btn-success non-printable" href="/qlt_report" style="float:right;" > Back </a>
		<div class="rest-selector col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <fieldset>
            <legend class="title-table non-printable">Illness Log Report</legend>
                    <?php $this->load->view('iln_report_menu_date'); ?>
            </fieldset>
        </div>
		<?php if (isset($illness)): ?>	
			<div class="centered">
                <div class="centered header-logo topic" style="display: none;"><img src="/assets/uploads/logos/<?php echo $hotel['logo']; ?>"/></div>
                <h1 class="centered topic" style="display: none;"> <?php echo $hotel['name']; ?> </h1>

                <h2 class="centered topic" style="display: none;"> Illness Log Report </h2>
                <h3 class="centered topic" style="display: none;"> from <?php echo $from; ?> to <?php echo $to; ?></h3>
                <?php $counter = 0; ?>
                <?php foreach ($illness as $guest): ?>
                    <?php $counter++; ?>
                <?php endforeach ?>
                <h4 class="centered"> Total of <?php echo $counter; ?></h4>
            </div>
			<br>
			<br>
			<br>
			<div class="centered">
				<table class="table table-striped table-bordered table-condensed real" style="width:1000px;">
					<tbody>
                        <tr>
                           	<th class="centered">No#</th>
                           	<th class="centered">Date</th>
                           	<th class="centered">Guest Name</th>
                           	<th class="centered">Room</th>
                           	<th class="centered">Tour Operator</th>
                           	<th class="centered">Diagnosis / Symptoms</th>
                            <th class="centered">Hotel Clinic Visit (*Yes / **No)</th>
                            <th class="centered">* If Yes - is MR available (Yes / No)</th>
                            <th class="centered">** If No - To who the symptoms were reported</th>
                            <th class="centered">Comments</th>
                            <th class="centered">Related IR#</th>
                            <th class="centered non-printable">Actoins</th>
                        </tr>
                        <?php $count = 1; ?>
                        <?php foreach ($illness as $guest): ?>
                            <tr class="item-row">
                                <td class="centered"><?php echo $count; ?></td>
                                <td class="centered"><?php echo $guest['dates']; ?></td>
                                <td class="centered"><?php echo $guest['guest']; ?></td>
                                <td class="centered"><?php echo $guest['room']; ?></td>
                                <td class="centered"><?php echo $guest['operator_name']; ?></td>
                                <td class="centered"><?php echo $guest['symptoms']; ?></td>
                                <td class="centered"><?php echo $guest['visit']; ?></td>
                                <td class="centered"><?php echo $guest['avaible']; ?></td>
                                <td class="centered"><?php echo $guest['reported']; ?></td>
                                <td class="centered"><?php echo $guest['comments']; ?></td>
                                <td class="centered"><?php echo $guest['ir']; ?></td>
                                <td class="non-printable">
                                    <a href="<?php echo base_url(); ?>illness/view/<?php echo $guest['iln_id'] ?> " class="btn btn-primary">View</a>
                                </td>
                            </tr>
                            <?php $count++; ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
			<?php endif; ?>
		</div>
	</body>
</html>