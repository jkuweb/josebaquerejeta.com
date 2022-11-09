let form = document.getElementById('contactForm');
		let name = document.getElementById('contact_form_name');
		let email = document.getElementById('contact_form_email');
		let message = document.getElementById('contact_form_message'); 
		let subject = document.getElementById('contact_form_subject'); 

		function onSubmit(token) {
          form.submit();
        }

    // Function that loads recaptcha on form input focus
    function reCaptchaOnFocus() {
      var head = document.getElementsByTagName('head')[0]
      var script = document.createElement('script')
      script.type = 'text/javascript';
      script.src = 'https://www.google.com/recaptcha/api.js'
      head.appendChild(script);

      // remove focus to avoid js error:
      name.removeEventListener('focus', reCaptchaOnFocus)
      email.removeEventListener('focus', reCaptchaOnFocus)
    };
    // add initial event listener to the form inputs
    name.addEventListener('focus', reCaptchaOnFocus, false);
    email.addEventListener('focus', reCaptchaOnFocus, false);