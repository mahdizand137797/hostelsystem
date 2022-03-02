function validateForm() {
  var x = document.forms["myForm"]["u_username"].value; 
  if (x == "" || x == null) {
    alert("نام کاربری باید وارد شده باشد");
    return false;
  }
}

function validateForm() {
  var x = document.forms["myForm"]["u_email"].value;
  if (x == "" || x == null) {
    alert("ایمیل را وارد کنید");
    return false;
  }
}

$(document).ready(function () {

  $('#contact-form').validate({
      rules: {
        u_username: {
              minlength: 2,
              required: true
          },
          u_password: {
              minlength: 2,
              required: true
          }
      },
      highlight: function (element) {
          $(element).closest('.control-group').removeClass('success').addClass('error');
      },
      success: function (element) {
          element.text('OK!').addClass('valid')
              .closest('.control-group').removeClass('error').addClass('success');
      }
  });
  });

  $(function() {
    $('#input1').on('keypress', function(e) {
        if (e.which == 32){
            console.log('فشردن کلید space مجاز نیست');
            return false;
        }
    });
});


$(function() {
  $('#u_username').on('keypress', function(e) {
      if (e.which == 32){
          console.log('فشردن کلید space مجاز نیست');
          return false;
      }
  });
});

$(function() {
  $('#u_password').on('keypress', function(e) {
      if (e.which == 32){
          console.log('فشردن کلید space مجاز نیست');
          return false;
      }
  });
});

  $(document).keydown(function(event){
   var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == 32){
      alert("فشردن کلید space مجاز نیست ")
    }
});

var check = function() {
  if (document.getElementById('exampleInputPassword1').value ==
    document.getElementById('exampleInputPassword1').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'password matching';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'password not matching';
  }
}


$(document).ready(function(){

  jQuery.validator.addMethod("noSpace", function(value, element) { 
    return value == '' || value.trim().length != 0;  
  }, "No space please and don't leave it empty");


  $("form").validate({
     rules: {
        name: {
            noSpace: true
        }
     }
  });


})

$(document).ready(function() {

  jQuery.validator.addMethod("noSpace", function(value, element) { 
     return value.indexOf(" ") < 0 && value != ""; 
  }, "Space are not allowed");

  $("#myform").validate({
    errorLabelContainer: $("#error"),
    rules: {
      u_username: { required: true, noSpace: true },
      exampleInputEmail1: { required: true, noSpace: true }
    },
    messages: {
      u_username: { required: 'Please enter your username' },
      exampleInputEmail1 : { required: "Please enter your  email" }
    }
  });

  $('#submit').click(function() {
    var valid = $("#myform").valid();
    if(!valid) {
      return false;
    }
    $.ajax({
      beforeSend: function() {
        // display loading message
      },
      type: "POST",
      url: 'save',
      data:  $('#formdata').serialize(),
      dataType: 'json',
      cache: false,
      success: function(result) {
        if(result.error) {
          // show error message
        }
        else {
          // redirect to another page
        }
      },
      error: function (response, desc, exception) {
        // show ajax error
      },
      complete: function() {
        // hide loading message
      }
    });
  });
});