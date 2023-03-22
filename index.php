<?php
include 'connection.php';
$tbl_user = $db->tbl_users;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CRUD with MongoDB Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="container" style="margin-top: 5em; margin-bottom: 5em;">
   <div class="row">
      <div class="col-md-6">
         <form id="user_form" name="user_form" method="post">
            <div class="form-group">
               <label for="name">Name</label>
               <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="" required >
             </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="" required >
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <script>
            $("#user_form").submit(function(e) {

                e.preventDefault();
               
                var form = $(this);
                var actionUrl = form.attr('action');
                
                $.ajax({
                    type: "POST",
                    url: 'insert.php',
                    data: form.serialize(),
                    success: function(data)
                    {
                      var data = $.trim(data);
                      if(data > 0)
                      {
                        alert("Record successfully inserted.");
                        window.location.reload();
                      }
                      else
                      {
                        alert("Error.");
                      }
                    }
                });
                
            });
        </script>
      </div>
   </div>
   <div class="row" style="margin-top: 5em;">
      <div class="col-md-8">
         <table class="table" id="user_datatable">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <script type="text/javascript">
               $(document).ready(function() {
                   $('#user_datatable').DataTable({
                     "processing":true,
                     "serverSide":true,
                     "order":[],
                     "ajax":{
                         url : 'datatable.php',
                         type : "POST"
                     },
                     "columnDefs":[
                         {
                            "targets": [2,3],
                            "orderable":false,
                         },
                     ],
                   });
               });
            </script>
          </tbody>
        </table>
      </div>
   </div>
</div>
<script>
   function delete_user(user_id)
   {
      $.ajax({
        type: "POST",
        url: 'delete.php',
        data: 'user_id='+user_id,
        success: function(data)
        {
          var data = $.trim(data);
          if(data > 0)
          {
            alert("Record successfully deleted.");
            $('#user_datatable').DataTable().ajax.reload();
          }
          else
          {
            alert("Error.");
          }
        }
      });
   }
</script>
</body>
</html>