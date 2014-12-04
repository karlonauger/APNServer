$('#UserNotification_Button').click(function() {
  $('.alert').hide();
  $('#UserNotification_Message').focus();
});

$("#UserNotification_Message").keydown(function(event){
  if(event.keyCode == 13){ // Enter
    event.preventDefault();
    submitNotification();
  }
});

$('#UserNotification_Submit').click(function() {
  submitNotification();
});

function submitNotification() {
  $('.alert').hide();

  var message = $('#UserNotification_Message').val();
  message = $.trim(message);
  $('#UserNotification_Message').val(message);

  if (message != '')
  {
    pushNotification(message);
  }
  else
  {
    $('#UserNotification_Error').text("Error: Please Enter a Message");
    $('#UserNotification_Error').show();
    $('#UserNotification_Message').focus();
  }
}

function pushNotification(message)
{
  $.ajax({
      type: "POST",
      url: "pushNotification.php",
      async: false,
      data: {"message": message}
    })
      .done(function( returnStr ) {
        console.log(returnStr);
        var returnArray = JSON.parse(returnStr);
        if(returnArray['errors'] == "")
        {
          $('#UserNotification_Success').show();
          console.log(returnArray);
        }
        else
        {
          $('#UserNotification_Error').text("Error: "+returnArray['errors']);
          $('#UserNotification_Error').show();
        }
      });   
}