/**
 * PHP Email Form Validation and AJAX Submission
 * Works with BootstrapMade templates or any contact form
 */

document.addEventListener('DOMContentLoaded', () => {

  const forms = document.querySelectorAll('.php-email-form');

  forms.forEach(function(form) {

    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const action = form.getAttribute('action');
      const recaptcha = form.getAttribute('data-recaptcha-site-key');

      if (!action) {
        displayError(form, 'Form action attribute is missing!');
        return;
      }

      form.querySelector('.loading').classList.add('d-block');
      form.querySelector('.error-message').classList.remove('d-block');
      form.querySelector('.sent-message').classList.remove('d-block');

      let formData = new FormData(form);

      fetch(action, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(response => response.text())
        .then(data => {
          form.querySelector('.loading').classList.remove('d-block');

          if (data.trim() === 'OK') {
            form.querySelector('.sent-message').classList.add('d-block');
            form.reset();
          } else {
            displayError(form, data ? data : 'Form submission failed.');
          }
        })
        .catch((error) => {
          form.querySelector('.loading').classList.remove('d-block');
          displayError(form, error);
        });

    });

  });

});

/** Function to display error messages */
function displayError(form, message) {
  form.querySelector('.error-message').innerHTML = message;
  form.querySelector('.error-message').classList.add('d-block');
}
