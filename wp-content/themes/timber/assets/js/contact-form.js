jQuery(document).ready(function ($) {
  $(document).on('submit', '#portfolio-form-data', function () {
    let formData = $(this).serializeArray();

    $.ajax({
      url: object_form.settings.ajaxUrl,
      type: 'POST',
      data: {
        action: 'portfolio_submit_contact',
        formData: formData
      },
      dataType: 'json',
      beforeSend: function () {},
      success: function (response) {
        if (response) {

        }
      }
    })
  })
})

let formValidator = {
  isEmail: function (s) {
    return this.test(s, '^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+@[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$')
  }
}