// Document is ready
jQuery(document).ready(function ($) {
    // Validate Username
    $("#usercheck").hide();    
    $("#user_name").blur(function () {      
      validateUsername();
    });    
    
    // Validate Phone Nummber
    $("#phonecheck").hide();
    $("#user_phone").blur(function () {
      validatePhone();
    });    

    // Validate Email
    $("#emailcheck").hide();
    $("#user_email").blur(function () {
        validateemail();
    });    

    // Validate Budget
    $("#budgetcheck").hide();
    $("#user_budget").blur(function () {
      validatebudget();
    });    

    // Validate Message
    $("#msgcheck").hide();
    $("#user_msg").blur(function () {
      validatemsg();
    });
    
  });

  function validateUsername() {
    let usernameError = true;    
    let usernameValue = jQuery("#user_name").val();
    let username_max_length = jQuery("#user_name").attr('data-attr');
    if (usernameValue.length == "") {
      jQuery("#usercheck").show();
      usernameError = false;
      
    } else if (usernameValue.length > username_max_length) {
      jQuery("#usercheck").show();
      jQuery("#usercheck").html("length of username less than "+username_max_length);
      usernameError = false;      
    } else {
      jQuery("#usercheck").hide();
    }
    return usernameError;
  }

  function validatePhone() {
    let phoneError =true;
    let phoneValue = jQuery("#user_phone").val();
    let phoneValue_max_len = jQuery("#user_phone").attr('data-attr');

    if (phoneValue.length == "") {
      jQuery("#phonecheck").show();
      phoneError = false;
      return false;      
    }
    if (phoneValue.length > phoneValue_max_len) {
      jQuery("#phonecheck").show();
      jQuery("#phonecheck").html(
        "Length of your password less than "+phoneValue_max_len
      );
      jQuery("#phonecheck").css("color", "red");
      phoneError = false;
      return false;      
    } else {
      jQuery("#phonecheck").hide();
    }
    return phoneError;
  }
  function validateemail() {
    let emailError = true;
    let emailValue = jQuery("#user_email").val();
    let email_max_len = jQuery("#user_email").attr('data-attr');
    
    if (emailValue.length == "") {
      console.log("tetsstestsets");
      jQuery("#emailcheck").show();
      emailError = false; 
      return false;
    }
    if (emailValue.length > email_max_len) {
      jQuery("#emailcheck").show();
      jQuery("#emailcheck").html(
        "Length of your email must be between less than "+email_max_len
      );
      emailError = false;
      return false;    
    } else {
      jQuery("#emailcheck").hide();
    }
    return emailError;
}

function validatebudget() {
  let budgetError = true;
  let budgetValue = jQuery("#user_budget").val();
  let budgetValue_max_len = jQuery("#user_budget").attr('data-attr');

  if (budgetValue.length == "") {
    jQuery("#budgetcheck").show();
    budgetError = false;
    return false;
  }
  if (budgetValue.length > budgetValue_max_len) {
    jQuery("#budgetcheck").show();
    jQuery("#budgetcheck").html(
      "Length of your budget less than "+budgetValue_max_len
    );
    budgetError = false;    
    return false;
  } else {
    jQuery("#budgetcheck").hide();
  }
  return budgetError;
}

function validatemsg() {
  let msgError = true;
  let msgValue = jQuery("#user_msg").val();
  let msgValue_max_len = jQuery("#user_msg").attr('data-attr');

  if (msgValue.length == "") {
    jQuery("#msgcheck").show();
    msgError = false;
    return false;
  }
  if ( msgValue.length > msgValue_max_len) {
    jQuery("#msgcheck").show();
    jQuery("#msgcheck").html(
      "Length of your message less than "+msgValue_max_len
    );
    msgError = false;
    return false;
  } else {
    jQuery("#msgcheck").hide();
  }
  return msgError;
}

function sglf_submit_customer_data_func(){
  let usernameError = phoneError = emailError = budgetError = msgError = true;
  usernameError = validateUsername();
  phoneError = validatePhone();
  emailError = validateemail();
  budgetError = validatebudget();
  msgError  = validatemsg();

  var username = jQuery('#user_name').val();
  var userphone = jQuery('#user_phone').val();
  var useremail = jQuery('#user_email').val();
  var userbudget = jQuery('#user_budget').val();
  var usermsg = jQuery('#user_msg').val();

  if (
      usernameError == true &&
      phoneError == true &&
      emailError == true &&
      budgetError ==  true && msgError == true
    ) {      
      jQuery.ajax({
        type: "POST",
        url: slgf_ajax_obj.ajax_url,
        data: {
            action: "slgf_submit_customer_data",
            user_name: username,
            user_phone: userphone,
            user_email: useremail,
            user_budget: userbudget,
            user_msg: usermsg,
        },
        success: function(html) {
          jQuery("#form_success_msg").show();    
          jQuery("#slgf-main-form").trigger('reset');    

        }
      });

    }      
  return false;
}