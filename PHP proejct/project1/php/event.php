<?php
require("./MyUtils.class.php");
require("./MMysql.class.php");

MyUtils::login();
MyUtils::permission(3);
echo MyUtils::html_header("Event","..","../css/mystyle","../js/event.js");
echo MyUtils::html_nav("active","","");
$mysql = new MMysql();
$sql = "SELECT e.`name` as eventname , e.datestart as edatestart, e.dateend as edateend, e.numberallowed as eallow, se.idsession as ids, "
."se.`name` as sessionname , se.startdate as sstartdate, se.enddate as senddate, se.numberallowed as sallow, v.`name` as vname, v.capacity"
." FROM `event` e  LEFT JOIN `session` se ON se.`event` = e.idevent LEFT JOIN venue v ON v.idvenue = e.venue ORDER BY edatestart";
$res = $mysql->doSql($sql);
$r1 = $mysql->doSql("SELECT session FROM registration WHERE attendee = ".$_SESSION['id']);
$r2 = $mysql->doSql("SELECT session FROM attendee_session WHERE attendee = ".$_SESSION['id']);

$s1 = array_column($r1, 'session');
$s2 = array_column($r2, 'session');
$att_session = array_merge($s1,$s2);
?>
<div class="main">
	<div class="container">
		<h3>List of events</h3>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<th>No</th>
				<th>Event Name</th>
				<th>Event date start</th>
				<th>Event date end</th>
				<th>Event allow number</th>
				<th>Session Name</th>
				<th>Session date start</th>
				<th>Session date end</th>
				<th>Session allow number</th>
				<th>Venue name</th>
				<th>Venue capacity</th>
				<th>Operation</th>
			</thead>
			<tbody>
			<?php foreach($res as $key=>$a): ?>
				<tr>
					<td><?php echo $key+1; ?></td>
					<td><?php echo $a['eventname']; ?></td>
					<td><?php echo $a['edatestart']; ?></td>
					<td><?php echo $a['edateend']; ?></td>
					<td><?php echo $a['eallow']; ?></td>
					<td><?php echo $a['sessionname']; ?></td>
					<td><?php echo $a['sstartdate']; ?></td>
					<td><?php echo $a['senddate']; ?></td>
					<td><?php echo $a['sallow']; ?></td>
					<td><?php echo $a['vname']; ?></td>
					<td><?php echo $a['capacity']; ?></td>
					<td>
						<?php if($_SESSION['role'] == 3 && $a['sessionname'] != '' 
									&& !in_array($a['ids'], $att_session) ): ?>
							<button class="btn btn-primary apply" data-id="<?php echo $a['ids']; ?>">Apply</button>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</div>

<?php 
echo MyUtils::html_footer();
?>