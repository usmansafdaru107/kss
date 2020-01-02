	$(function () {
		$('img').error(function () {
			$(this).attr("src", "images/default_image.jpg");
		});
		$('.acc_drop').click(function () {

			$('.loader').hide();
			$('.loginMenu').slideToggle();
			logout();
		});

		getAllClasses();

		$('.classesMenuItem').click(function (e) {
			e.preventDefault();

			$('html, body').animate({
				scrollTop: $($(this).attr('href')).offset().top
			}, 600);

		});

		$('.goToRegister').click(function () {
			$('.loginPanel').fadeOut(function () {

				$('.registerPanel').fadeIn(function () {

					$('.goTologin').click(function () {
						$('.registerPanel').fadeOut(function () {

							$('.loginPanel').fadeIn();
						});

					});
				});
			});

		});

		$('.tryDemo').click(function (e) {
			e.preventDefault();
			tryDemo();
		});

		$(document.body).on('click', '.classList .cBox', function (e) {
			e.preventDefault();
			var class_id = $(this).attr('data-id');
			var class_oc = $(this).attr('data-oc');
			var img = $(this).find('.img').attr('style');
			var classTitle = $(this).find('h5').text();
			var classEnrolled = $(this).find('p').text();
			//alert(img);
			overViewClass(class_id);

			$('#classPreview .topbar .img').attr('style', img);
			$('#classPreview .topbar h3').text(classTitle);
			$('#classPreview .topbar p').text(classEnrolled + " students");
			$('#classPreview .tab-content .outc').text(class_oc);

		});

		$('#registerProgram').submit( function(e){
			e.preventDefault();
			program_reg();
		});

		ss_login();
		registerParent();
		inAsStudent();
	});

	var color = ["244,67,54,0.5", "156,39,176,0.5", "63,81,181,0.5", "0,150,136,0.5", "139,195,74,0.5", "255,235,59,0.5", "255,152,0,0.5"];

	function logout() {
		$('a.logoutSponsor').click(function () {
			notify("Logging out....", "success");
			var logoutSettings = {
				"method": "GET",
				"url": "api/sponsor/logout",
				"headers": {
					"cache-control": "no-cache"
				}

			};
			$.ajax(logoutSettings).done(function () {
				sessionStorage['current_page'] = '';
				window.location.href = "index.php?action=login";
			});

		});
	}

	function inAsStudent() {
		$('a.contAsStudent').click(function () {
			notify("Accessing Account", "success");
			var logoutSettings = {
				"method": "GET",
				"url": "api/sponsor/logout",
				"headers": {
					"cache-control": "no-cache"
				}

			};
			$.ajax(logoutSettings).done(function () {
				sessionStorage['current_page'] = '';
				window.location.href = "index.php?action=login";
			});

		});
	}

	function getAllClasses() {

		var getClassesSettings = {
			"type": "GET",
			"async": true,
			"dataType": "json",
			"url": "api/classes",
			"headers": {
				"cache-control": "no-cache"
			}
		};
		$.ajax(getClassesSettings).success(function (response) {
			console.log(JSON.stringify(response))
			$('.classList').html("");
			var appendData = "";
			$.each(response, function (key, value) {
				appendData += '<div class="cBox" data-oc ="' + value.description + '" data-id="' + value.class_id + '" data-toggle="modal" data-target="#classPreview"><div style="background-color:rgba(' + color[key] + ')" class="filterBox"></div>' +
					'<div style=" background-image:url(\'admin/' + value.class_pic + '\'); " class="img"></div>' +
					'<h5>' + value.class_name + '</h5>' +
					//'<p>Enrolled: '+value.enrollments+'</p>'+
					'</div>';

			});
			$('.classList').html(appendData);
		});

	}

	function getAllClassesInList() {

		var getClassesSettings = {
			"type": "GET",
			"async": true,
			"dataType": "json",
			"url": "api/classes",
			"headers": {
				"cache-control": "no-cache"
			}
		};
		$.ajax(getClassesSettings).success(function (response) {
			$('.classListed').html("");
			$('.classListed').prepend('<option value="0">Select a Class</option>');
			$.each(response, function (key, value) {
				var appendData = '<option value="' + value.class_id + '">' + value.short_class_name + '</option>';
				$('.classListed').append(appendData);

			});

		});

	}

	function ss_login() {

		var urlx;
		var gotoX;

		$('.login_sponsor').submit(function (e) {
			e.preventDefault();
			var loginType = $('.login_sponsor .loginType').val();
			if (loginType == 1) {
				urlx = 'api/student/login';
				gotoX = 'student.php';
			} else if (loginType == 2) {
				var urlx = 'api/sponsor/account/login';
				var gotoX = 'account.php';

			}
			console.log('Request ' + urlx + ' Going to ' + gotoX);

			//get variables for login elements	
			var userName = $('.login_sponsor .username').val();
			var loginpassword = $('.login_sponsor .password').val();

			//validating form 
			if (!selectValid_new(".login_sponsor .loginType", "Please select a Login type")) {
				return false;
			} else if (!minMax_a(4, 50, ".login_sponsor .username", "Please Provide a Valid Username or Email")) {
				return false;
			}

			//validating passowrd
			else if (!minMax_a(4, 50, ".login_sponsor .password", "Please Provide a Valid password")) {
				return false;

			}

			var loginData = $('.login_sponsor').serialize();

			var loginSettings = {
				"type": "POST",
				"dataType": "json",
				"url": urlx,
				"headers": {
					"cache-control": "no-cache"
				},
				"data": loginData
			};

			$.ajax(loginSettings).success(function (response) {

				if (response.status == "failed" || response.status == "warning") {
					notify("Sorry " + response.message, "error");
					console.log(JSON.stringify(response));
				} else {
					notify("Logging in.", "success");
					$('#registerParent')[0].reset();

					window.location.href = gotoX;

					console.log(JSON.stringify(response));
				}

			});

		});

	}

	function tryDemo() {
		var loginData = {
			username: 'sampleStudent',
			password: 'sampleStudent'
		}
		notify("Signing into demo Account", "success");
		var loginSettings = {
			"type": "POST",
			"dataType": "json",
			"url": 'api/student/login',
			"headers": {
				"cache-control": "no-cache"
			},
			"data": loginData
		};

		$.ajax(loginSettings).success(function (response) {

			if (response.status == "failed" || response.status == "warning") {
				notify("Sorry " + response.message, "error");
				console.log(JSON.stringify(response));
			} else {

				window.location.href = 'student.php';

			}

		});
	}
	//end of login code
	//Register Parent
	function registerParent() {
		function beforeSubmit() {
			var obj = {};
			var type = $('#registerParent .type').val();
			var f_name = $('#registerParent .f_name').val();
			var l_name = $('#registerParent .l_name').val();
			var dob = $('#registerParent .dob').val();
			var country = $('#registerParent .country').val();
			var email = $('#registerParent .email');
			var phone = $('#registerParent .phone');
			var password1 = $('#registerParent .password1');
			var password2 = $('#registerParent .password2');

			//validating f_name
			if (!minMax_a(2, 200, "#registerParent .f_name", "Please Provide a Valid Name")) {
				obj.status = false;
			} else if (!minMax_a(3, 50, "#registerParent .country", "Please Provide a Valid country")) {
				obj.status = false;
			} else if (!minMax_a(3, 50, "#registerParent .email", "Please Provide a Valid email")) {
				obj.status = false;
			} else if (!minMax_a(9, 15, "#registerParent .phone", "Please Provide a Valid Phone Number")) {
				obj.status = false;
			} else if (!minMax_a(4, 20, "#registerParent .password1", "Please Provide a Valid Password")) {
				obj.status = false;
			} else if (!minMax_a(4, 20, "#registerParent .password", "Please Provide a Valid Password")) {
				obj.status = false;
			} else if ($('#registerParent .password1').val() != $('#registerParent .password').val()) {
				notify("Password Doesn't Match", "error");
				$('#registerParent .password').focus();

				obj.status = false;
			} else {
				obj.status = true;
			}
			//we have an issue in trasfering the data
			var formx = {};
			obj.postdata = formx;

			return obj;

		}
		$("#registerParent").ajaxify({
			url: 'api/sponsor',
			validator: beforeSubmit,
			onSuccess: callBackMethod
		});

		function callBackMethod(response) {
			if (response.status == "failed" || response.status == "warning") {
				notify("Sorry " + response.message, "error");
				console.log(JSON.stringify(response));
			} else {

				notify("Thank you for registering please login to access your account", "success");
				$('#registerParent')[0].reset();
			}

		}

	}

	function overViewClass(class_id) {
		getSubOc(class_id)
	}

	function getSubOc(class_id) {
		var formsettings = {
			"type": "GET",
			"async": true,
			"dataType": "json",
			"url": "api/subjects/class/" + class_id,
			"headers": {
				"cache-control": "no-cache"
			}
		};
		$.ajax(formsettings).success(function (response) {
			//cs_id
			//console.log(JSON.stringify(response));
			$('.subjectsList').html("");

			if (response.status == 'failed') {

				notify("Sorry Cannot get subjects for this class", "warning");

			} else {
				var appendDatac = "";
				$.each(response, function (key, value) {
					// console.log(JSON.stringify(response));
					var class_image = value.subject_logo;

					var imagef = class_image.substring(3);

					appendDatac += '<div data-toggle="modal" data-target="#accountPop" class="subjectGroup" data-name="' + value.subject_name + '" data-id="' + value.cs_id + '" data-toggle="modal" data-target="#popStudy">' +
						'<div class="image" style="background-image:url(' + imagef + ');"></div>' +
						'<div class="description">' +
						'<h4>' + value.subject_name + '</h4>' +
						'<p>Subject No: ' + value.subject_id + '</p>' +
						'</div>' +
						'</div>';

				});
				$('.subjectsList').html(appendDatac);
			}

		});
	}

	function program_reg() {
		var type = $('#registerProgram .type').val();
		var typeE = $('#registerProgram .type');

		var full_name = $('#registerProgram .f_name').val();
		var full_nameE = $('#registerProgram .f_name');

		var location = $('#registerProgram .location').val();
		var locationE = $('#registerProgram .location');

		var email = $('#registerProgram .email').val();
		var emailE = $('#registerProgram .email');

		var phone = $('#registerProgram .phone').val();
		var phoneE = $('#registerProgram .phone');

		var pushButton = $('#registerProgram button');

		if(type=="0" || type===0){
			notify("Registration type is required","warning");
			typeE.focus();
			return false;
		}
		pushButton.text('Registering your details ...').attr("disabled", "disabled");
		typeE.attr("disabled", "disabled");
		full_nameE.attr("disabled", "disabled");
		locationE.attr("disabled", "disabled");
		emailE.attr("disabled", "disabled");
		phoneE.attr("disabled", "disabled");

		

	
		var datax = {
			type: type,
			full_name: full_name,
			location: location,
			email: email,
			phone: phone
		}

		var url = './api/programs/register';
		//application/x-www-form-urlencoded 
	//	notify("Signing into demo Account", "success");
		var postettings = {
			"type": "POST",
			"dataType": "json",
			"url": url,
			"headers": {
				"cache-control": "no-cache"
			},
			"data": datax
		};

		$.ajax(postettings).success(function (data) {
		
				if (data.status == "success") {
					// pusgButton

					pushButton.html('Message sent &nbsp; <i class="fa fa-check"></i>');
					$('.registerProgram').hide()
					$('.success-send').fadeIn()
					$('.success-send p').text(data.message);
					setTimeout(function () {
						$('#registerProgram')[0].reset();
						pushButton.text('Register').removeAttr("disabled");
						typeE.removeAttr("disabled");
						full_nameE.removeAttr("disabled");
						locationE.removeAttr("disabled");
						emailE.removeAttr("disabled");
						phoneE.removeAttr("disabled");
						$('.msg-done').hide()
						$('.registerProgram').fadeIn();
					}, 10000);
					console.log(JSON.stringify(data));
				} else {
					pushButton.html('Message not sent, resend &nbsp; <i class="fa fa-refresh"></i>');
					$('.msg-failed-send').fadeIn()
					$('.msg-failed-send p').text(data.message);
					// $('#sendMessageForm')[0].reset();
					typeE.removeAttr("disabled");
					full_nameE.removeAttr("disabled");
					locationE.removeAttr("disabled");
					emailE.removeAttr("disabled");
					phoneE.removeAttr("disabled");
					pushButton.removeAttr("disabled");
					setTimeout(function () {
						$('.msg-failed-send').hide()
					},10000);
					//pushButton.removeClass('notSent').html('Send Another Message &nbsp; <i class="fa fa-angle-right"></i>');

					console.log(JSON.stringify(data));
				}

			});

	}