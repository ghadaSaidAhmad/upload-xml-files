

/*=============================================
= display file content =
===============================================*/
var file_id;
$(document).on('click','.myfile',function(){

file_id=$(this).attr('data-id');
$('.myfile').css('background-color','#fff');
$(this).css('background-color','#ccc');

  $.ajax({
    type: "GET",
    // processData: false,
    // contentType: '',
    // dataType:'html',
    url:$('form[name="myfiles"]').attr('action')+'/'+file_id,
    success: function(result){

      $('#filecontent').html(result.data);
      fetch_data(file_id);

    }
  });

});

/*=============================================
= delete file  =
===============================================*/

$(document).on('click','.delete_myfile',function(){
  var my_row=$(this);
  // e.preventDefault();
  var file_id=$(this).attr('data-id');
                  $.confirm({
                      title: "Confirm deletion",
                      content: "Are you sure, you want to delete?",
                      buttons: {
                          confirm: {

                              action:function() {
                                  $.get('/myfiles/'+file_id+'/delete', function(data) {
                                      $.alert("Deleted successfully");
                                      //table.row( $(self).parents('tr') ).remove().draw();
                                      my_row.closest('tr').remove();
                                      $('#filecontent').html('');
                                  });
                              },
                              text: "Confirm"
                          },
                          cancel: {
                              text: "Cancel"
                          }
                      }
                  });

});




  function fetch_data(id)
  {
  var id=id;
   var dataTable = $('#user_data').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "ajax" : {

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
     url:'/fetchRows',
     data:{file_id:id},
     type:"POST"
    }
   });
  }

  function update_data(id, column_name, value)
  {
   $.ajax({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     },
    url:'/updateRow',
    method:"POST",
    data:{id:id, column_name:column_name, value:value},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
     $('#user_data').DataTable().destroy();
       fetch_data(file_id);
    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);
  }

  $(document).on('blur', '.update', function(){
   var id = $(this).data("id");
   var column_name = $(this).data("column");
   var value = $(this).text();
   update_data(id, column_name, value);
  });

  $('#add').click(function(){
   var html = '<tr>';
   html += '<td contenteditable id="data1"></td>';
   html += '<td contenteditable id="data2"></td>';
   html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
   html += '</tr>';
   $('#user_data tbody').prepend(html);
  });

  $(document).on('click', '#insert', function(){
   var first_name = $('#data1').text();
   var last_name = $('#data2').text();
   if(first_name != '' && last_name != '')
   {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
     url:'insertRow',
     method:"POST",
     data:{first_name:first_name, last_name:last_name},
     success:function(data)
     {
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
    fetch_data(file_id);
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
   else
   {
    alert("Both Fields is required");
   }
  });

  $(document).on('click', '.delete', function(){
   var id = $(this).attr("id");
   if(confirm("Are you sure you want to remove this?"))
   {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
     url:'/deleteRow',
     method:"POST",
     data:{id:id},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data(file_id);
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
  });
