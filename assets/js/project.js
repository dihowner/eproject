$(document).ready(function() {
	var button, data, response;
	
	//Sign up button...
	$("#signUp").click(function(e) {
		e.preventDefault();
		button = $("#signUp");
		response = $("#response");
		
		data = {
			signUp : "signUp",
			fname : $("#fname").val(),
			phoneno : $("#phoneno").val(),
			emailaddress : $("#emailaddress").val(),
			password : $("#password").val(),
			confPass : $("#confPass").val()
		}
		
		response.fadeIn();
		response.removeClass("alert alert-danger");
		response.removeClass("alert alert-success");
		response.html("");
		
		if($("#fname").val().length == 0 || $("#phoneno").val().length == 0 || $("#emailaddress").val().length == 0 || $("#password").val().length == 0 || $("#confPass").val().length == 0) {
			response.html("<b>Error :</b> Please fill all field").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#fname").val().length == 0) {
			response.html("<b>Error :</b> Enter your name").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#phoneno").val().length == 0 || $("#phoneno").val().length < 11) {
			response.html("<b>Error :</b> Please enter a valid mobile number").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#emailaddress").val().length == 0) {
			response.html("<b>Error :</b> Please enter a valid email address").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#password").val().length == 0 || $("#phoneno").val().length < 5) {
			response.html("<b>Error :</b> Please enter a strong password").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#confPass").val().length == 0 || $("#password").val() != $("#confPass").val() ) {
			response.html("<b>Error :</b> Please password do not match").addClass("alert alert-danger").fadeOut(3000);
		} else {
			
			$.ajax({
				url: "process.php",
				data: data,
				type: "post",
				beforeSend: function() {
					button.html("Processing <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
				},
				success: function(msg) {
					
					if($.trim(msg) == "incorrect_email") {
						response.html("<b>Error : </b> Email address is not valid").addClass("alert alert-danger").fadeOut(5000);
						button.html('Join Us');
						button.prop('disabled', false);
					} else if($.trim(msg) == "incorrect_phone") {
						response.html("<b>Error : </b> Please enter a valid mobile number").addClass("alert alert-danger").fadeOut(5000);
						button.html('Join Us');
						button.prop('disabled', false);					
					} else if($.trim(msg) == "pass_no_match") {
						response.html("<b>Error : </b> Password do not match").addClass("alert alert-danger").fadeOut(5000);
						button.html('Join Us');
						button.prop('disabled', false);
					} else if($.trim(msg) == "email_exists") {
						response.html("<b>Error : </b> Email address is associated with another member").addClass("alert alert-danger").fadeOut(5000);
						button.html('Join Us');
						button.prop('disabled', false);
					} else if($.trim(msg) == "mobile_exists") {
						response.html("<b>Error : </b> Mobile number is associated with another member").addClass("alert alert-danger").fadeOut(5000);
						button.html('Join Us');
						button.prop('disabled', false);					
					} else if($.trim(msg) == "success") {
						response.html("<b>Congratulations : </b> Your account has been created, kindly check your email inbox or spam folder for verification link").addClass("alert alert-success");
						button.html('Join Us');				
					} else {
						response.html(msg);
						button.html("Join Us");
						button.prop('disabled', false);
					}
				}, 
				error: function(error) {
					response.html(error);
					button.html("Join Us");
					button.prop('disabled', false);
				}
			});
			
		}
		
	});
	
	//Sign In...
	$("#signIn").click(function(e) {
		e.preventDefault();
		button = $("#signIn");
		response = $("#response");
		
		data = {
			signIn : "signIn",
			username : $("#username").val(),
			password : $("#password").val()
		}
		
		response.fadeIn();
		response.removeClass("alert alert-danger");
		response.removeClass("alert alert-success");
		response.html("");
		
		if($("#username").val().length == 0 || $("#password").val().length == 0) {
			response.html("<b>Error :</b> Please fill all field").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#username").val().length == 0) {
			response.html("<b>Error :</b> Enter your email address or mobile number").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#password").val().length == 0) {
			response.html("<b>Error :</b> Please enter your password").addClass("alert alert-danger").fadeOut(3000);
		} else {
			
			$.ajax({
				url: "process.php",
				data: data,
				type: "post",
				beforeSend: function() {
					button.html("Processing <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
				},
				success: function(msg) {
					
					if($.trim(msg) == "incorrect_phone") {
						response.html("<b>Error : </b> Please enter a valid mobile number").addClass("alert alert-danger").fadeOut(5000);
						button.html('Sign In');
						button.prop('disabled', false);					
					} else if($.trim(msg) == "mobile_not_exist") {
						response.html("<b>Error : </b> Mobile number does not exist").addClass("alert alert-danger").fadeOut(5000);
						button.html('Sign In');
						button.prop('disabled', false);
					} else if($.trim(msg) == "email_not_exist") {
						response.html("<b>Error : </b> Email address does not exist").addClass("alert alert-danger").fadeOut(5000);
						button.html('Sign In');
						button.prop('disabled', false);
					} else if($.trim(msg) == "incorrect_pass") {
						response.html("<b>Error : </b> Your password is incorrect").addClass("alert alert-danger").fadeOut(5000);
						button.html('Sign In');
						button.prop('disabled', false);
					} else if($.trim(msg) == "success") {
						response.html("<b>Congratulations : </b> Your account has been created, kindly check your email inbox or spam folder for verification link").addClass("alert alert-success");
						button.html('Sign In');				
					} else {
						response.html(msg);
						button.html("Sign In");
						button.prop('disabled', false);
					}
				}, 
				error: function(error) {
					response.html(error);
					button.html("Sign In");
					button.prop('disabled', false);
				}
			});
			
		}
		
	});
	
	//Modify password...
	$("#changePass").click(function(e) {
		e.preventDefault();
		button = $("#changePass");
		response = $("#response");
		
		data = {
			updatePass : "updatePass",
			currpwd : $("#currpwd").val(),
			newpwd : $("#newpwd").val(),
			re_newpwd : $("#re_newpwd").val()
		}
		
		response.fadeIn();
		response.removeClass("alert alert-danger");
		response.removeClass("alert alert-success");
		response.html("");
		
		if($("#currpwd").val().length == 0 || $("#newpwd").val().length == 0 || $("#re_newpwd").val().length == 0) {
			response.html("<b>Error :</b> Please fill all field").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#currpwd").val().length == 0) {
			response.html("<b>Error :</b> Enter your current password").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#newpwd").val().length < 5) {
			response.html("<b>Error :</b> Password is too short").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#newpwd").val().length < $("#re_newpwd").val().length || $("#newpwd").val() != $("#re_newpwd").val()) {
			response.html("<b>Error :</b> Password do not match").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#currpwd").val() == $("#newpwd").val()) {
			response.html("<b>Error :</b> Current password is the same with new password").addClass("alert alert-danger").fadeOut(3000);
		} else {
			
			$.ajax({
				url: "../process.php",
				data: data,
				type: "post",
				beforeSend: function() {
					button.html("Processing <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
				},
				success: function(msg) {
					if($.trim(msg) == "wrong_currpwd") {
						response.html("<b>Error : </b> Current password is wrong").addClass("alert alert-success");
						button.html('<i class="ti-pencil"></i> Modify Password');	
					} else if($.trim(msg) == "same_pass") {
						response.html("<b>Error : </b> Current password is the same with new password").addClass("alert alert-success");
						button.html('<i class="ti-pencil"></i> Modify Password');	
					} else if($.trim(msg) == "pass_differs") {
						response.html("<b>Error : </b> Password do not match").addClass("alert alert-success");
						button.html('<i class="ti-pencil"></i> Modify Password');	
					} else if($.trim(msg) == "login_needed") {
						response.html("<b>Error : </b> Your session has expired").addClass("alert alert-success");
						button.html('<i class="ti-pencil"></i> Modify Password');	
						setTimeout(function() {
							window.location = "../login";
						}, 5000);
					} else if($.trim(msg) == "updated") {
						response.html("<b>Success : </b> Your password has been updated").addClass("alert alert-success");
						button.html('<i class="ti-pencil"></i> Modify Password');	
						setTimeout(function() {
							window.location = "";
						}, 5000);
					} else {
						response.html(msg);
						button.html('<i class="ti-pencil"></i> Modify Password');	
						button.prop('disabled', false);
					}
				}, 
				error: function(error) {
					response.html(error);
					button.html('<i class="ti-pencil"></i> Modify Password');	
					button.prop('disabled', false);
				}
			});
						
		}
		
	});
	
	//Modify access key...
	$("#changeAccKey").click(function(e) {
		e.preventDefault();
		button = $("#changeAccKey");
		response = $("#response");
		
		data = {
			updateAccKey : "updateAccKey",
			currpwd : $("#currpwd").val(),
			newpwd : $("#newpwd").val(),
			re_newpwd : $("#re_newpwd").val()
		}
		
		response.fadeIn();
		response.removeClass("alert alert-danger");
		response.removeClass("alert alert-success");
		response.html("");
		
		if($("#currpwd").val().length == 0 || $("#newpwd").val().length == 0 || $("#re_newpwd").val().length == 0) {
			response.html("<b>Error :</b> Please fill all field").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#currpwd").val().length == 0) {
			response.html("<b>Error :</b> Enter your current access key").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#newpwd").val().length < 3) {
			response.html("<b>Error :</b> Access key is too short").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#newpwd").val() == "0000") {
			response.html("<b>Error :</b> Default access key (0000) can not be used").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#newpwd").val().length < $("#re_newpwd").val().length || $("#newpwd").val() != $("#re_newpwd").val()) {
			response.html("<b>Error :</b> Access key do not match").addClass("alert alert-danger").fadeOut(3000);
		} else if($("#currpwd").val() == $("#newpwd").val()) {
			response.html("<b>Error :</b> Current access key is the same with new access key").addClass("alert alert-danger").fadeOut(3000);
		} else {
			
			$.ajax({
				url: "../process.php",
				data: data,
				type: "post",
				beforeSend: function() {
					button.html("Processing <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
				},
				success: function(msg) {
					if($.trim(msg) == "login_needed") {
						response.html("<b>Error : </b> Your session has expired").addClass("alert alert-danger");
						button.html('<i class="ti-pencil"></i> Modify Access key');	
						setTimeout(function() {
							window.location = "../login";
						}, 5000);
					} else if($.trim(msg) == "number_only") {
						response.html("<b>Error : </b> Only numbers are allowed").addClass("alert alert-danger");
						button.html('<i class="ti-pencil"></i> Modify Access key');	
						button.prop('disabled', false);
					} else if($.trim(msg) == "def_zero") {
						response.html("<b>Error : </b> Default access key (0000) can not be used").addClass("alert alert-danger");
						button.html('<i class="ti-pencil"></i> Modify Access key');
						button.prop('disabled', false);	
					} else if($.trim(msg) == "wrong_curr_access") {
						response.html("<b>Error : </b> Wrong access key supplied").addClass("alert alert-danger");
						button.html('<i class="ti-pencil"></i> Modify Access key');	
						button.prop('disabled', false);
					} else if($.trim(msg) == "same_access") {
						response.html("<b>Error : </b> Current access key is the same with new access key").addClass("alert alert-danger");
						button.html('<i class="ti-pencil"></i> Modify Access key');	
						button.prop('disabled', false);
					} else if($.trim(msg) == "updated") {
						response.html("<b>Success : </b> Your access key has been updated").addClass("alert alert-success");
						button.html('<i class="ti-pencil"></i> Modify Access key');	
						setTimeout(function() {
							window.location = "";
						}, 5000);
					} else {
						response.html(msg);
						button.html('<i class="ti-pencil"></i> Modify Access key');	
						button.prop('disabled', false);
					}
				}, 
				error: function(error) {
					response.html(error);
					button.html('<i class="ti-pencil"></i> Modify Access key');	
					button.prop('disabled', false);
				}
			});
						
		}
		
	});
	
	
	//Verify account number
	$("#verifyAccntBtn").click(function(e) {
		e.preventDefault();
		
		button = $("#verifyAccntBtn");
		response = $("#response");
		var accNo = $("#accNo").val();
		var bank_Name = $("#bank_Name").val();
		
		response.fadeIn();
		response.removeClass("alert alert-danger");
		response.removeClass("alert alert-success");
		response.html("");
		
		data = {
			getAcct : "getAcct",
			accNo : accNo,
			bank_Name : bank_Name
		}
		
		if(accNo.length == 0 || bank_Name.length == 0) {
			response.html("<b>Error :</b> Please fill all field").addClass("alert alert-danger").fadeOut(3000);
		} else {
			
			$.ajax({
				url: "../process.php",
				data: data,
				type: "post",
				beforeSend: function() {
					button.html("Verifying <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
					response.html("Getting account details");
				},
				success: function(msg) {
					if($.trim(msg) == "login_needed") {
						response.html("<b>Error : </b> Your session has expired").addClass("alert alert-danger");
						button.html('Verify Account');	
						setTimeout(function() {
							window.location = "../login";
						}, 5000);
					} else {
						response.html(msg);
						button.html('Verify Account');
						button.prop('disabled', false);
					}
				}, 
				error: function(error) {
					response.html(error);
					button.html('<i class="ti-pencil"></i> Modify Access key');	
					button.prop('disabled', false);
				}
			});
			
		}
		
	});
	
	$("#degree").on("change", function() {
		if($.trim($(this).val()) == "others") {
			$("#degreeBox").html("<label for='department'><b>Degree Awarded:</b></label><input required class='form-control' type='text' name='degreeName' placeholder='Enter degree awarded'>");
		} else { $("#degreeBox").html(""); }
	});
	
	$("#department").on("change", function() {
		if($.trim($(this).val()) == "others") {
			$("#deptBox").html("<label for='department'><b>Department Name:</b></label><input required class='form-control' type='text' name='deptName' placeholder='Enter department name'>");
		} else { $("#deptBox").html(""); }
	});
	
	//load airtime network with image
	$("#networkName").change(function() {
        var network = $(this).val();
        var imgdiv = $('#imghere');
		if(network === ""){
            imgdiv.html("");
        } else if(network == "mtn") {
            imgdiv.html('<img src="../assets/images/mtn.jpg" width="110px" class="img img-thumbnail img-fluid" height="110px">');
        } else if(network == "glo") {
            imgdiv.html('<img src="../assets/images/glo.jpg" width="110px" class="img img-thumbnail img-fluid" height="110px">');
        } else if(network == "airtel") {
            imgdiv.html('<img src="../assets/images/airtel.jpg" width="110px" class="img img-thumbnail img-fluid" height="110px">');
        } else if(network == "9mobile") {
            imgdiv.html('<img src="../assets/images/9mobile.jpg" width="110px" class="img img-thumbnail img-fluid" height="110px">');
        }
    });
	
	//airtime amount...
	$("#airAmnt").keyup(function() {
        var airAmnt = $(this).val();
        var percent = $("#percent").val();
        var toPay = airAmnt;
        if(airAmnt > 0) {
           toPay = (airAmnt - ((airAmnt*percent)/100));
           $("#amnts").val(toPay);
           $("#amnt").val(toPay);
        } else {
            $("#amnts").val(toPay);
           $("#amnt").val(toPay);
        }
    });
	
	//load data network with image
	$("#dataName").change(function() {
	    var dataName = $(this).val();
	    var dataVolume = $("#dataVolume");
	    var data = "network="+dataName;
        var imgdiv = $('#imghere');
        
        //alert (dataName);
        
        if(dataName === "") {
	        dataVolume.html("");
	        imgdiv.html("");
	        $("#Priceamnt").html("");
	    } else {
	        if(dataName === "SME" || dataName === "Direct"){
                imgdiv.html('<img src="../assets/images/mtn.jpg" width="110px" class="img img-thumbnail img-fluid" height="110px">');
            } else if(dataName === "Glo"){
                imgdiv.html('<img src="../assets/images/glo.jpg" width="110px" class="img img-thumbnail img-fluid" height="110px">');
            } else if(dataName === "Airtel"){
                imgdiv.html('<img src="../assets/images/airtel.jpg" width="110px" class="img img-thumbnail img-fluid" height="110px">');
            } else if(dataName === "9Mobile"){
                imgdiv.html('<img src="../assets/images/9mobile.jpg" width="110px" class="img img-thumbnail img-fluid" height="110px">');
            }
            
            $.ajax({
                url: "../process.php?fetchdaTas",
	            data: data,
	            type: "post",
	            beforeSend: function() {
	                dataVolume.html("<b>Please wait <i class='ti-reload fa-spin'></i>");
	            },
	            success: function(resp) {
					dataVolume.html(resp);
	            }
            })
	    }
	});
    
	//Request for Password...
	$("#requestLink").click(function(e) {
		e.preventDefault();
		button = $("#requestLink");
		
		var username = $("#username").val();
		if(username == "" || username == undefined) {
			Swal.fire({
				icon: "error",
				title: "Provide Username",
				html: "Please enter your email address or mobile number"
			});
		} 
		else {
			data = "username="+username;
			$.ajax({
				url: "process.php?requestLink",
				data: data,
				type: "post",
				beforeSend: function() {
					button.html("Processing <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
				},
				success: function(response) {
					
					if($.trim(response) == "incorrect_phone") {
						button.html("Request Link").prop("disabled", false);
						Swal.fire({
							icon: "error",
							title: "Incorrect Phone",
							html: "Mobile number provided is invalid"
						});
					}
					else if($.trim(response) == "user_not_found") {
						button.html("Request Link").prop("disabled", false);
						Swal.fire({
							icon: "error",
							title: "Not Found",
							html: "User information does not exists"
						});
					}
					else if($.trim(response) == "failed") {
						button.html("Request Link").prop("disabled", false);
						Swal.fire({
							icon: "error",
							title: "Error",
							html: "An unknown error occurred. We could not send email to your email address, please try again later"
						});
					}
					else {
						Swal.fire({
							icon: "success",
							title: "Mail Sent",
							html: "Email address sent successfully, kindly check your email address inbox or spam folder"
						}).then((result) => {
							if (result.isConfirmed) { window.location = ''; }
						});
					}
					
				}
			});
		}		
		
	});
    
	//Search for decoder...
	$("#decoderName").on("change", function(e) {
		e.preventDefault();
		
		var decoderName = $(this).val();
		response = $("#decoder_list");
		
		if(decoderName == "" || decoderName == undefined) {
			response.html("");
		} 
		else {
			
			data = "decoderName="+decoderName;
		
			$.ajax({
				url: "../process.php?getDecoder",
				data: data,
				type: "post",
				beforeSend: function() {
					response.html("Fetching decoder <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);
				},
				success: function(result) {
					response.html(result);
				}
			});

		}
		
	});
	
	//Verify Decoder...
	$("#verifydecoder").click(function(e) {
		e.preventDefault();

		var decoderName = $("#decoderName").val();
		var decoderPackage = $("#decoderPackage").val();
		var iucNo = $("#iucNo").val();
		response = $("#customerInfo");
		button = $("#verifydecoder");

		if(decoderName == "" || decoderName == undefined) {
			Swal.fire({
				icon: "error",
				title: "Select Decoder",
				html: "Please select a decoder of your choice"
			});
		}
		else if(decoderPackage == "" || decoderPackage == undefined) {
			Swal.fire({
				icon: "error",
				title: "Select Package",
				html: "Please select a decoder package of your choice"
			});
		}
		else if(iucNo == "" || iucNo == undefined) {
			Swal.fire({
				icon: "error",
				title: "Provide IUC",
				html: "Please enter decoder or iuc number"
			});
		} 
		else {

			data = "cableName="+decoderName+"&iucNo="+iucNo;
			
			$.ajax({
				url: "../process.php?verifyIUC",
				data: data,
				type: "post",
				beforeSend: function() {
					response.html("Verifying customer credential <i class='fa fa-spinner'></i>");
					button.html("Processing <i class='fa fa-spinner'></i>").prop("disabled", true);
				},
				success: function(result) {
					response.html(result);
					button.html("Verify Decoder").prop("disabled", false);
				}
			})
		
		}

	});

});

function getData() {
	var gsmdata = document.getElementById("gsmdata").value;
	var data_amnt; //amount field...
	
	if(gsmdata === "") {
		document.getElementById("Priceamnt").innerHTML = "";
	} else {
		
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("Priceamnt").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "../process.php?fetchdataPrices&gsmdata=" + gsmdata, true);
		xmlhttp.send();
	}
}