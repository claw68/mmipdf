<style>
	.judgesignature {
		border-spacing: 20px 0px;
	}
	.judgesignature td {
		text-align: center;
		padding: 0 15px;
	}
	.tabsignature {
		border-spacing: 20px 0px;
	}
	.tabsignature td {
		text-align: center;
		padding: 0 15px;
	}
	.topborder {
		border-top: 1px solid black;
	}
	table#grid td, table#grid th {
		text-align: center;
	}
</style>
<p>Final Ranks</p>
<div>
	<p><?php $out = Array('m'=>'Male','f'=>'Female'); echo $out[$gender]; ?> Category</p>
	<table id="grid">
		<tr>
			<th>Contestant</th>
			<?php foreach($event as $row){ ?>
				<th><?php echo $row->event_name; ?></th>
			<?php } ?>
			<th>Total</th>
			<th>Rank</th>
		</tr>
		<?php foreach($responce->rows as $row) { ?>
		<tr>
			<?php foreach($row['cell'] as $cell ) { ?>
			<td><?php echo $cell; ?></td>
			<?php } ?>
		</tr>
		<?php } ?>
	</table>
</div>
<div>Certified True and Correct:</div>
<br>
<br>
<?php $perbatch = 4;
$i = 0;
while($i < sizeof($judge)){
?>
<table class="judgesignature">
	<tr>
	<?php 
	$last = $i + $perbatch;
	for($first = $i;($first <= $last && $first < sizeof($judge)); $first++){ $row = $judge[$first]; ?>
		<td class="topborder" style="width: 170px;"><?php echo $row->print_name?></td>
	<?php } ?>
	</tr>
	<tr>
	<?php 
	for($first = $i;($first <= $last && $first < sizeof($judge)); $first++){ $row = $judge[$first]; ?>
		<td><?php echo $row->judge_name?></td>
	<?php } $i = $first; ?>
	</tr>
</table>
<br>
<br>
<br>
<?php } ?>
<table class="tabsignature">
	<tr>
		<td style="width:43%"></td>
		<td style="width:24%" class="topborder">Rozanne Tuesday G. Flores</td>
		<td style="width:43%"></td>
	</tr>
	<tr>
		<td style="width:43%"></td>
		<td style="width:24%">Head Tabulator</td>
		<td style="width:43%"></td>
	</tr>
</table>