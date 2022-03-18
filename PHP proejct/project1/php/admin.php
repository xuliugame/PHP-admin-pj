<?php
	require("./MyUtils.class.php");
	require("./MMysql.class.php");
	require("./Venue.class.php");

	MyUtils::login();
	MyUtils::permission(2);
	//session_start();

	echo MyUtils::html_header("Admin","..","","../js/admin.js");
	echo MyUtils::html_nav("","","active");
?>
<?php 
	$role = $_SESSION['role'];
	$idattendee = $_SESSION['id'];
	
	//var_dump($_SESSION['uid']);
	//var_dump($idattendee);
	//die();
	$mysql = new MMysql();
	$venues=array();
	$events=array();
	$sessions=array();
	$attendees=array();
	$users=array();
	$attendee1= $mysql->doSql("SELECT idattendee, `name` as attname from attendee where role =3");
	$manager1= $mysql->doSql("SELECT idattendee, `name` as attname from attendee where role =2");
	if($role == 2){
		$events = $mysql->doSql("SELECT e.* FROM `event` e, manager_event me WHERE e.idevent = me.`event` AND me.manager = '".$idattendee."'");
		$sessions = $mysql->doSql("SELECT s.* FROM `session` s WHERE s.event IN ( SELECT e.idevent FROM `event` e, manager_event me WHERE e.idevent = me.`event` AND me.manager ='".$idattendee."' ) ");
		$attendees = $mysql->doSql("SELECT a.idattendee, a.`name` as attname,s.`idsession` as ids,s.`name` as  sessionname, r.`name` as rolename FROM attendee_session attss LEFT JOIN attendee a ON attss.attendee = a.idattendee  LEFT JOIN `session` s ON attss.`session` = s.idsession
		 INNER JOIN `role` r ON r.idrole = a.role WHERE s.`event` IN ( SELECT e.idevent FROM `event` e, manager_event me WHERE e.idevent = me.`event` AND me.manager ='".$idattendee."' )");

		//var_dump($events);
		//var_dump($sessions);
		//var_dump($attendees);
	}else{
		$users = $mysql->doSql("SELECT at.*, r.`name` as rolename FROM attendee at LEFT JOIN `role` r ON at.role = r.idrole");
		$venues = Venue::GetAll();//$mysql->select("venue");
		$events = $mysql->select("event");
		$sessions = $mysql->select("session");
		$attendees = $mysql->doSql("SELECT a.idattendee, a.`name` as attname,s.`name` as  sessionname,s.`idsession` as  ids, r.`name` as rolename FROM attendee_session attss LEFT JOIN attendee a ON attss.attendee = a.idattendee LEFT JOIN `session` s ON attss.`session` = s.idsession LEFT JOIN `role` r ON r.idrole = a.role UNION  SELECT a.idattendee, a.`name` as attname,e.`name` as  sessionname,e.`idevent` as  ids, r.`name` as rolename FROM manager_event me LEFT JOIN attendee a ON me.manager = a.idattendee LEFT JOIN `event` e ON me.`event` = e.idevent LEFT JOIN `role` r ON r.idrole = a.role");
		//var_dump($users);
		//var_dump($venues);
		//var_dump($events);
		//var_dump($sessions);
		//var_dump($attendees);
	}
 ?>

 <div class="main">
	<div class="container">
		<?php if($role ==1):?>
			<h3>List of users</h3>
			<button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Add User</button>
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<th>User No</th>
					<th>User Name</th>
					<th>User Role</th>
					<th>Operation</th>
				</thead>
				<tbody>
				<?php foreach($users as $user): ?>
					<tr>
						<td><?php echo $user['idattendee']; ?></td>
						<td class="username<?php echo $user['idattendee']; ?>"><?php echo $user['name']; ?></td>
						<td class="role<?php echo $user['idattendee']; ?>"><?php echo $user['rolename']; ?></td>
						<td>
							<?php if($user['idattendee'] != 1):?>
							<button class="btn btn-info editUser" data-id="<?php echo $user['idattendee'] ?>">edit</button>
							<button class="btn btn-warning deletUser" data-id="<?php echo $user['idattendee'] ?>">delete</button>
						<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
		<?php if($role ==1):?>
			<h3>List of venues</h3>
			<button class="btn btn-primary" data-toggle="modal" data-target="#addVenueModal">Add venue</button>
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<th>Venue No</th>
					<th>Venue Name</th>
					<th>Venue capacity</th>
					<th>Operation</th>
				</thead>
				<tbody>
				<?php foreach($venues as $ven): ?>
					<tr>
						<td><?php echo $ven->getId(); ?></td>
						<td class="venue<?php echo $ven->getId(); ?>"><?php echo $ven->getName(); ?></td>
						<td class="capacity<?php echo $ven->getId(); ?>"><?php echo $ven->getCap(); ?></td>
						<td>
							<button class="btn btn-info editVenue" data-id="<?php echo $ven->getId(); ?>">edit</button>
							<button class="btn btn-warning deletVenue" data-id="<?php echo $ven->getId(); ?>">delete</button>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
		<h3>List of events</h3>
		<button class="btn btn-primary" data-toggle="modal" data-target="#addEventModal">Add event</button>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<th>Event No</th>
				<th>Event Name</th>
				<th>Date start</th>
				<th>Date end</th>
				<th>allow number</th>
				<th>venue</th>
				<th>Operation</th>
			</thead>
			<tbody>
			<?php foreach($events as $ev): ?>
				<tr>
					<td><?php echo $ev['idevent']; ?></td>
					<td class="eventname<?php echo $ev['idevent']; ?>"><?php echo $ev['name']; ?></td>
					<td class="datestart<?php echo $ev['idevent']; ?>"><?php echo $ev['datestart']; ?></td>
					<td class="dateend<?php echo $ev['idevent']; ?>"><?php echo $ev['dateend']; ?></td>
					<td class="numberallowed<?php echo $ev['idevent']; ?>"><?php echo $ev['numberallowed']; ?></td>
					<td class="eventvenue<?php echo $ev['idevent']; ?>"><?php echo $ev['venue']; ?></td>
					<td>
						<button class="btn btn-info editEvent" data-id="<?php echo $ev['idevent'] ?>">edit</button>
						<button class="btn btn-warning deletEvent" data-id="<?php echo $ev['idevent'] ?>">delete</button>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<h3>List of sessions</h3>
		<button class="btn btn-primary" data-toggle="modal" data-target="#addSessionModal">Add session</button>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<th>Session No</th>
				<th>Session Name</th>
				<th>Date start</th>
				<th>Date end</th>
				<th>allow number</th>
				<th>event</th>
				<th>Operation</th>
			</thead>
			<tbody>
			<?php foreach($sessions as $ses): ?>
				<tr>
					<td><?php echo $ses['idsession']; ?></td>
					<td class="sessionname<?php echo $ses['idsession']; ?>"><?php echo $ses['name']; ?></td>
					<td class="sstartdate<?php echo $ses['idsession']; ?>"><?php echo $ses['startdate']; ?></td>
					<td class="senddate<?php echo $ses['idsession']; ?>"><?php echo $ses['enddate']; ?></td>
					<td class="snumberallowed<?php echo $ses['idsession']; ?>"><?php echo $ses['numberallowed']; ?></td>
					<td class="sevent<?php echo $ses['idsession']; ?>"><?php echo $ses['event']; ?></td>
					<td>
						<button class="btn btn-info editSession" data-id="<?php echo $ses['idsession'] ?>">edit</button>
						<button class="btn btn-warning deletSession" data-id="<?php echo $ses['idsession'] ?>">delete</button>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<h3>List of attendees</h3>
		<button class="btn btn-primary" data-toggle="modal" data-target="#addAttendeeModal">Add Attendee</button>
		<?php if($_SESSION['role'] == '1'){echo "<button class='btn btn-success' data-toggle='modal' data-target='#addManagerModal'>Add Manager</button>";} ?>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<th>Attendee No</th>
				<th>Attendee Name</th>
				<th>Session/Event name</th>
				<th>Role name</th>
				<th>Operation</th>
			</thead>
			<tbody>
			<?php foreach($attendees as $att): ?>
				<tr>
					<td><?php echo $att['idattendee']; ?></td>
					<td class="attname<?php echo $att['idattendee']; ?>"><?php echo $att['attname']; ?></td>
					<td class="attsession<?php echo $att['idattendee']; ?>"><?php echo $att['sessionname']; ?></td>
					<td class="rolename<?php echo $att['idattendee']; ?>"><?php echo $att['rolename']; ?></td>
					<td>
						<button class="btn btn-warning deletAtt" 
						data-id="<?php echo $att['idattendee'].'-'.$att['ids'].'-'.$att['rolename'] ?>">delete</button>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</div>

<!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add User</h4>
      </div>
      <div class="modal-body">
        <form action="./operation.php" id="addUserForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
	            <input type="hidden" name="m" value="adduser">
	            <div class="form-group">
	                <label for="name" class="col-sm-3 control-label"></i>name</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="name" id="name" placeholder="name"><span id="warn-username" style="color:red;display:none;" ">name can't be empty</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="psd" class="col-sm-3 control-label">Password</label>
	                <div class="col-sm-9">
	                    <input type="password" class="form-control" name="password" id="psd" placeholder="Password"><span id="warn-password" style="color:red;display:none;" ">password can't be empty</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="email" class="col-sm-3 control-label">role</label>
	                <div class="col-sm-9">
	                    <select class="form-control" name="role">
		                    <option value="1">admin</option>
		                    <option value="2">event manager</option>
		                    <option value="3">attendee</option>
		                </select>
	                </div>
	            </div>
	        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addUser">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- adduser end-->
<!-- Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit User</h4>
      </div>
      <div class="modal-body">
        <form action="./operation.php" id="editUserForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
	            <input type="hidden" name="uid" id="edituid">
	            <input type="hidden" name="m" value="edituser">
	            <div class="form-group">
	                <label for="editname" class="col-sm-3 control-label"></i>Username</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="name" id="editname" placeholder="name"><span id="edit-username" style="color:red;display:none;" ">name can't be empty</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="editpsd" class="col-sm-3 control-label">Password</label>
	                <div class="col-sm-9">
	                    <input type="password" class="form-control" name="password" id="editpsd" placeholder="Password"><span id="edit-password" style="color:red;display:none;" ">password can't be empty</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="email" class="col-sm-3 control-label">role</label>
	                <div class="col-sm-9">
	                    <select class="form-control" name="role">
		                    <option value="1">admin</option>
		                    <option value="2">event manager</option>
		                    <option value="3">attendee</option>
		                </select>
	                </div>
	            </div>
	        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editUserSubmit">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- edit user end -->
<!-- Modal -->
<div class="modal fade" id="addVenueModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Venue</h4>
      </div>
      <div class="modal-body">
        <form action="./operation.php" id="addVenueForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
	            <input type="hidden" name="m" value="addvenue">
	            <div class="form-group">
	                <label for="add_venue_name" class="col-sm-3 control-label"></i>venue name</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="name" id="add_venue_name" placeholder="name"><span id="warn-venuename" style="color:red;display:none;" ">venue name can't be empty</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="add_venue_capacity" class="col-sm-3 control-label">capacity</label>
	                <div class="col-sm-9">
	                    <input type="number" class="form-control" name="capacity" id="add_venue_capacity" placeholder="capacity"><span id="warn-capacity" style="color:red;display:none;" ">capacity can't be empty</span>
	                </div>
	            </div>
	        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addVenue">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- add venue end-->
<!-- Modal -->
<div class="modal fade" id="editVenueModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Venue</h4>
      </div>
      <div class="modal-body">
        <form action="./operation.php" id="editVenueForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
        		<input type="hidden" name="m" value="editvenue">
	            <input type="hidden" name="idvenue" id="idvenue">
	            <div class="form-group">
	                <label for="edit_venue_name" class="col-sm-3 control-label"></i>venue name</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="name" id="edit_venue_name" placeholder="name"><span id="edit-venuename" style="color:red;display:none;" ">venue name can't be empty</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="edit-capacity" class="col-sm-3 control-label">capacity</label>
	                <div class="col-sm-9">
	                    <input type="number" class="form-control" name="capacity" id="edit_venue_capacity" placeholder="capacity"><span id="edit-capacity" style="color:red;display:none;" ">capacity can't be empty</span>
	                </div>
	            </div>
	        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editVenueSubmit">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- edit venue end -->

<!-- Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Event</h4>
      </div>
      <div class="modal-body">
        <form action="./operation.php" id="addEventForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
	            <input type="hidden" name="m" value="addevent">
	            <div class="form-group">
	                <label for="add_event_name" class="col-sm-3 control-label"></i>event name</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="name" id="add_event_name" placeholder="name">
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="add_event_datestart" class="col-sm-3 control-label">datestart</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="datestart" id="add_event_datestart" placeholder="yyyy-mm-dd hh:mm:ss">
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="add_event_dateend" class="col-sm-3 control-label">dateend</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="dateend" id="add_event_dateend" placeholder="yyyy-mm-dd hh:mm:ss">
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="add_event_numberallowed" class="col-sm-3 control-label">numberallowed</label>
	                <div class="col-sm-9">
	                    <input type="number" class="form-control" name="numberallowed" id="add_event_numberallowed" placeholder="numberallowed">
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="add_event_venue" class="col-sm-3 control-label">venue no</label>
	                <div class="col-sm-9">
	                    <input type="number" class="form-control" name="venue" id="add_event_event" placeholder="venue no">
	                </div>
	            </div>
	        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addEvent">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- add event end-->
<!-- Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
      </div>
      <div class="modal-body">
        <form action="./operation.php" id="editEventForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
	            <input type="hidden" name="m" value="editevent">
	            <input type="hidden" name="idevent" value="" id="idevent">
	            <div class="form-group">
	                <label for="add_event_name" class="col-sm-3 control-label"></i>event name</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="name" id="edit_event_name" placeholder="name">
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="add_event_datestart" class="col-sm-3 control-label">datestart</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="datestart" id="edit_event_datestart" placeholder="yyyy-mm-dd hh:mm:ss">
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="add_event_dateend" class="col-sm-3 control-label">dateend</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="dateend" id="edit_event_dateend" placeholder="yyyy-mm-dd hh:mm:ss">
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="add_event_numberallowed" class="col-sm-3 control-label">numberallowed</label>
	                <div class="col-sm-9">
	                    <input type="number" class="form-control" name="numberallowed" id="edit_event_numberallowed" placeholder="numberallowed">
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="add_event_venue" class="col-sm-3 control-label">venue no</label>
	                <div class="col-sm-9">
	                    <input type="number" class="form-control" name="venue" id="edit_event_venue" placeholder="venue no">
	                </div>
	            </div>
	        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editEventSubmit">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- edit event end-->

<!-- Modal -->
<div class="modal fade" id="addSessionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Session</h4>
      </div>
      <div class="modal-body">
        <form action="./operation.php" id="addSessionForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
	            <input type="hidden" name="m" value="addsession">
	            <div class="form-group">
	                <label class="col-sm-3 control-label"></i>session name</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="name" placeholder="name">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-sm-3 control-label">startdate</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="startdate" placeholder="yyyy-mm-dd hh:mm:ss">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-sm-3 control-label">enddate</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="enddate" placeholder="yyyy-mm-dd hh:mm:ss">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-sm-3 control-label">numberallowed</label>
	                <div class="col-sm-9">
	                    <input type="number" class="form-control" name="numberallowed" placeholder="numberallowed">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-sm-3 control-label">event no</label>
	                <div class="col-sm-9">
	                    <select class="form-control" name="event">
	                    	<?php foreach($events as $ev): ?>
	                    		<option value="<?php echo $ev['idevent']; ?>"><?php echo $ev['name']; ?></option>
	                    	<?php endforeach;?>
						</select>
	                </div>
	            </div>
	        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addSession">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- add session end-->
<!-- Modal -->
<div class="modal fade" id="editSessionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Session</h4>
      </div>
      <div class="modal-body">
        <form action="./operation.php" id="editSessionForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
	            <input type="hidden" name="m" value="editsession">
	            <input type="hidden" name="idsession" value="" id="idsession">
	            <div class="form-group">
	                <label class="col-sm-3 control-label"></i>session name</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="name" id="edit_session_name" placeholder="name">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-sm-3 control-label">startdate</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="startdate" id="edit_session_startdate" placeholder="yyyy-mm-dd hh:mm:ss">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-sm-3 control-label">enddate</label>
	                <div class="col-sm-9">
	                    <input type="text" class="form-control" name="enddate" id="edit_session_enddate" placeholder="yyyy-mm-dd hh:mm:ss">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-sm-3 control-label">numberallowed</label>
	                <div class="col-sm-9">
	                    <input type="number" class="form-control" name="numberallowed" id="edit_session_numberallowed" 
	                    placeholder="numberallowed">
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-sm-3 control-label">event no</label>
		                <div class="col-sm-9">
		                    <select class="form-control" name="event">
		                    <?php foreach($events as $ev): ?>
		                    	<option value="<?php echo $ev['idevent']; ?>"><?php echo $ev['name']; ?></option>
		                    <?php endforeach;?>
							</select>
		            </div>
	            </div>
	        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editSessionSubmit">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- edit session end-->

<!-- Modal -->
<div class="modal fade" id="addAttendeeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Attendee</h4>
      </div>
      <div class="modal-body">
        <form action="./operation.php" id="addAttendeeForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
	            <input type="hidden" name="m" value="addattendee">
	            <div class="form-group">
	                <label class="col-sm-3 control-label"></i>attendee name</label>
	                <div class="col-sm-9">
	                	<select class="form-control" name="attendee">
	                    <?php foreach($attendee1 as $att1): ?>
		                    <option value="<?php echo $att1['idattendee']; ?>"><?php echo $att1['attname']; ?></option>
		                <?php endforeach;?>
		                </select>
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-sm-3 control-label"></i>session name</label>
	                <div class="col-sm-9">
	                	<select class="form-control" name="session">
	                    <?php foreach($sessions as $se1): ?>
		                    <option value="<?php echo $se1['idsession']; ?>"><?php echo $se1['name']; ?></option>
		                <?php endforeach; ?>
		                </select>
	                </div>
	            </div>
	        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addAttendee">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- add attendee end-->
<!-- Modal -->
<div class="modal fade" id="addManagerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Manager</h4>
      </div>
      <div class="modal-body">
        <form action="./operation.php" id="addManagerForm" method="POST" class="form-horizontal" style="margin-top: 40px;">
	            <input type="hidden" name="m" value="addmanager">
	            <div class="form-group">
	                <label class="col-sm-3 control-label"></i>manager name</label>
	                <div class="col-sm-9">
	                	<select class="form-control" name="manager">
	                    <?php foreach($manager1 as $man1): ?>
		                    <option value="<?php echo $man1['idattendee']; ?>"><?php echo $man1['attname']; ?></option>
		                <?php endforeach;?>
		                </select>
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-sm-3 control-label"></i>event name</label>
	                <div class="col-sm-9">
	                	<select class="form-control" name="event">
	                    <?php foreach($events as $ev1): ?>
		                    <option value="<?php echo $ev1['idevent']; ?>"><?php echo $ev1['name']; ?></option>
		                <?php endforeach; ?>
		                </select>
	                </div>
	            </div>
	        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addManagerSubmit">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- edit manager end-->



<?php 
echo MyUtils::html_footer();
?>