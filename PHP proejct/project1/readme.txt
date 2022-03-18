1. How to run project
	1.1 copy the lab directory to your php workdirectory.
	1.2 use your database account to modify the mysql configuration, the config of mysql in /lab/php/MMysql.clss.php file.
	1.3 the config that need to edit is 
		protected $_host = 'localhost'; // database ip/host
	    protected $_port = 3306; // port
	    protected $_user = 'xxl7750'; // database username
	    protected $_pass = 'Phrthe9&alleghenies'; // database password
	    protected $_dbName = "xxl7750"; // database name

	1.4 You can access the homepage via http://localhost/lab/index.php, when you complete the above steps.

2. The users of system
	super admin role:
		username:admin,password:123456
	admin role:
		username:tom,password:123456
	manager role:
		username:jack,password:123456
		username:william,password:123456
	attendee role:
		username:rose,password:123456
		username:jam,password:123456

3. How this system is implemented
	3.1 All operations except login require user login.
	3.2 Use MMysql.class.php to implement the database function which uses PDO.
	3.3 Passwords are hashed using sha256 before storage to database.
	3.4 When attendee role user login, they can view all events that include session, and they can apply session.
	3.5 In Registration page, admin or event manager can confirm the registration of attendee.
	3.6 In the admin page, the operations of delete use ajax to submit and use jquery to remove the html if delete succeessfully.
	3.7 The Input of user will be validated on the both frontend and server, and sanitized by server.
	3.8 Common elements are created using functions of MyUtils.class.php and some function are used for re-usability.
	3.9 Database functions use PDO with Object Mapping have implemented in Add/Edit/Delete/View venues.

