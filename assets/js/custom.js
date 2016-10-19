$(document).ready(function(){

  $(document).scroll(function () {
    var y = $(this).scrollTop();
    if (y > 800) {
      $('.scroll-top').fadeIn();
    } else {
      $('.scroll-top').fadeOut();
    }

  });

  $(document).on('click','.scroll-top',function(){
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });


  $(document).on('click','.edit_event_btn',function(){
    var id=$(this).attr('data-id');
    var title=$(this).attr('data-title');
    var time=$(this).attr('data-time');
    var date=$(this).attr('data-date');
    var address=$(this).attr('data-address');
    var city=$(this).attr('data-city');
    var state=$(this).attr('data-state');
    var pincode=$(this).attr('data-pincode');
    var country=$(this).attr('data-country');
    var company_id=$(this).attr('data-company-id');

    $('#edit-id').val(id);
    $('#title').val(title);
    $('#time').val(time);
    $('#date').val(date);
    $('#address').val(address);
    $('#city').val(city);
    $('#state').val(state);
    $('#pincode').val(pincode);
    $('#country').val(country);
    $('#edit-id').val(id);
    $('#company-id').val(company_id);
    $('#submit-btn').val('Update');
    $('#close-btn').show();
    $("html, body").animate({ scrollTop: 0 }, "fast");
  });
  $(document).on('click','#close-btn',function(){
    $('#edit-id').val(0);
    $('#submit-btn').val('Add');
    $('#close-btn').hide();
    $('#form').trigger('reset');
    $('#edit-image').empty();
  });


  $(document).on('click','.edit_services_btn',function(){
    var id=$(this).attr('data-id');
    var title=$(this).attr('data-title');
    var time=$(this).attr('data-time');
    var start_on=$(this).attr('data-start-on');
    var address=$(this).attr('data-address');
    var city=$(this).attr('data-city');
    var state=$(this).attr('data-state');
    var pincode=$(this).attr('data-pincode');
    var country=$(this).attr('data-country');
    var repeat_by=$(this).attr('data-repeat-by');
    var company_id=$(this).attr('data-company-id');

    $('#edit-id').val(id);
    $('#title').val(title);
    $('#time').val(time);
    $('#start_on').val(start_on);
    $('#address').val(address);
    $('#city').val(city);
    $('#state').val(state);
    $('#pincode').val(pincode);
    $('#country').val(country);
    $('#repeat_by').val(repeat_by);
    $('#company-id').val(company_id);

    $('#submit-btn').val('Update');
    $('#close-btn').show();
    $("html, body").animate({ scrollTop: 0 }, "fast");
  });
  $(document).on('click','.edit_blog_btn',function(){
    var id=$(this).attr('data-id');
    var title=$(this).attr('data-title');
    var description=$(this).attr('data-description');
    var datetime=$(this).attr('data-datetime');
    var image=$(this).attr('data-image');


    $('#edit-id').val(id);
    $('#title').val(title);
    $('#description').val(description);
    $('#datetime').val(datetime);
    $('#edit-image').html('<img src="'+image+'" width="100px" >');

    $('#submit-btn').val('Update');
    $('#close-btn').show();
    $("html, body").animate({ scrollTop: 0 }, "fast");
  });

  $(document).on('click','.edit_verse_btn',function(){
    var id=$(this).attr('data-id');
    var title=$(this).attr('data-title');
    var message=$(this).attr('data-message');
    var date=$(this).attr('data-date');

    $('#edit-id').val(id);
    $('#title').val(title);
    $('#message').val(message);
    $('#date').val(date);

    $('#submit-btn').val('Update');
    $('#close-btn').show();
    $("html, body").animate({ scrollTop: 0 }, "fast");
  });

  $(document).on('click','.edit_youtube_btn',function(){
    var id=$(this).attr('data-id');

    var url=$(this).attr('data-url');
    var date=$(this).attr('data-date');

    $('#edit-id').val(id);
    $('#url').val(url);
    $('#date').val(date);


    $('#submit-btn').val('Update');
    $('#close-btn').show();
    $("html, body").animate({ scrollTop: 0 }, "fast");
  });




  $(function () {
    $("#datepicker").datepicker({
      format:'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true
    }).datepicker('update', new Date());;
  });


});
function checkDec(el){
  var ex = /^[0-9]+\.?[0-9]*$/;
  if(ex.test(el.value)==false){
    el.value = el.value.substring(0,el.value.length - 1);
  }
}