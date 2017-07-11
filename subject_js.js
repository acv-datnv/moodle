$(document).ready(function() {
  // modify subject
  $("[name='change']").click(function() {
    $(this).closest('.felement').find('input[type="text"]').removeAttr('disabled');
  });

  // add input field
  $(document).on('click', '#id_addslot', function() {
    var num = $(this).data('num'); // =1
    var form = $(this).closest('form');
    form.find('input[name="num"]').val(num);
    form.submit();
  });

});