
$(document).ready(function(){
  $('.myfile').first().css('background-color','#ccc');

});
/*=============================================
= display file content =
===============================================*/

$(document).on('click','.myfile',function(){
var file_id=$(this).attr('data-id');
$('.myfile').css('background-color','#fff');
$(this).css('background-color','#ccc');

  $.ajax({
    type: "GET",
    processData: false,
    contentType: false,
    url:$('form[name="myfiles"]').attr('action')+'/'+file_id,
    success: function(result){
      $('#filecontent').html(result.data);

    }
  });

});

/*=============================================
= delete file  =
===============================================*/

$(document).on('click','.delete_myfile',function(){
  var file_id=$(this).attr('data-id');
  //show as confirm
alertify.confirm('Are you sure to delete this file?',function (e) {
        if (e) {
            
            console.log("sdsds");
        } else {

            console.log("nooooo");
        }

});

});
