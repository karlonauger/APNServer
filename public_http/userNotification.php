
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="shortcut icon" href="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
  <title>Barre Forest Guide - User Notification</title>
</head>

<style type="text/css">
  .alert {
    margin: 15px 0px;
  }
</style>

<body>
  <!-- page content -->
  <div id="content_container" class="container">
    <div class="row-fluid">
      <h1 id="btn-dropdowns" class="page-header">Barre Forest Guide - User Notification</h1>
        <!-- Button trigger modal -->
        <button id="UserNotification_Button" type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#UserNotification">
          User Notification
        </button>
    </div>
  </div>

  <!-- User Notification Modal -->
  <div class="modal fade" id="UserNotification" tabindex="-1" role="dialog" aria-labelledby="UserNotificationLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="UserNotificationLabel">User Notification</h4>
        </div>
        <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon">Message</span>
          <input id="UserNotification_Message" type="text" class="form-control" maxlength="62" placeholder="Message (max 64 characters)">
        </div>
          <div id="UserNotification_Success" class="alert alert-success" role="alert">Your message was sent!</div>
          <div id="UserNotification_Error" class="alert alert-danger" role="alert"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button id="UserNotification_Submit" type="button" class="btn btn-success">Send Notification</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  <script src="include/js/userNotification.js"></script>

</body>
</html>