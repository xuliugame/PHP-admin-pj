<?php
require("./MyUtils.class.php");
require("./MMysql.class.php");

MyUtils::login();
MyUtils::permission(3);
echo MyUtils::html_header("Registration","..","","../js/event.js");
echo MyUtils::html_nav("","active","");

$mysql = new MMysql();
$role = $_SESSION['role'];
$res = '';
$sql = "";
$sessions = $mysql->select("session");
if($role == 3){
	$attendee = $_SESSION['id'];
	$sql = "SELECT re.idregistration,re.accept as status , se.`name` as sessionname, se.startdate as sestart, se.enddate as seend, a.`name` as attname FROM registration re LEFT JOIN `session` se ON re.session = se.idsession LEFT JOIN attendee a ON a.idattendee = re.attendee WHERE re.attendee = '".$attendee."'";
}else if($role == 2) {
	$attendee = $_SESSION['id'];
	$sql = "SELECT re.idregistration,re.accept as status , se.`name` as sessionname, se.startdate as sestart, se.enddate as seend, a.`name` as attname FROM registration re LEFT JOIN `session` se ON re.session = se.idsession LEFT JOIN attendee a ON a.idattendee = re.attendee WHERE re.session IN (SELECT idsession FROM `session` se, manager_event me WHERE se.`event` = me.`event` AND me.`manager` = '".$attendee."')";
}else if($role == 1) {
	$sql = "SELECT re.idregistration,re.accept as status , se.`name` as sessionname, se.startdate as sestart, se.enddate as seend, a.`name` as attname FROM registration re LEFT JOIN `session` se ON re.session = se.idsession LEFT JOIN attendee a ON a.idattendee = re.attendee ";
}
$res = $mysql->doSql($sql);

?>

<div class="main">
	<div class="container">
		<h3>List of Registeration</h3>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<th>No</th>
				<th>Session Name</th>
				<th>Session date start</th>
				<th>Session date end</th>
				<th>Apply name</th>
				<th>Apply status</th>
				<th>Operation</th>
			</thead>
			<tbody>
			<?php foreach($res as $key=>$a): ?>
				<tr>
					<td><?php echo $key+1; ?></td>
					<td><?php echo $a['sessionname']; ?></td>
					<td class="sestart<?php echo $a['idregistration'] ?>"><?php echo $a['sestart']; ?></td>
					<td class="seend<?php echo $a['idregistration'] ?>"><?php echo $a['seend']; ?></td>
					<td><?php echo $a['attname']; ?></td>
					<td><?php if($a['status'] == 0){echo "waitting";}else{echo "accepted";} ?></td>
					<td>
						<?php if(isset($_SESSION['role']) && ($_SESSION['role'] ==1 || $_SESSION['role'] == 2) && $a['status'] == 0 ): ?>
							<button class="btn btn-primary accRe" data-id="<?php echo $a['idregistration']; ?>">Accept</button>
						<?php endif; ?>
						<?php if($a['status'] == 0 ): ?>
							<button class="btn btn-info editRe" data-id="<?php echo $a['idregistration'] ?>">edit</button>
						<?php endif; ?>
						<button class="btn btn-warning deletRe" data-id="<?php echo $a['idregistration'] ?>">delete</button>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</div>

<!-- Modal -->
<div class="modal fade" id="editApplyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Apply</h4>
      </div>
      <div class="modal-body">
        <form action="./registration_handle.php" id="editApplyForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
	            <input type="hidden" name="m" value="editapply">
	            <input type="hidden" name="idregistration" value="" id="idregistration">
	            <div class="form-group">
	                <label class="col-sm-3 control-label"></i>session name</label>
	                <div class="col-sm-9">
	                	<select class="form-control" name="session">
	                    <?php foreach($sessions as $se): ?>
		                    <option value="<?php echo $se['idsession']; ?>"><?php echo $se['name']; ?></option>
		                <?php endforeach;?>
		                </select>
	                </div>
	            </div>
	        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editApplySubmit">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- edit apply end-->


<?php 
echo MyUtils::html_footer();
?>