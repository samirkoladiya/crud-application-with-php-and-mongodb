<?php
include 'connection.php';
$user_id = $_GET['id'];
$user_details = $db->tbl_users->findOne(['_id' => new MongoDB\BSON\ObjectID( $user_id )]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CRUD with MongoDB Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container" style="margin-top: 5em;">
   <div class="row">
      <div class="col-md-6">
         <form id="user_form" name="user_form" method="post">
            <div class="form-group">
               <label for="name">Name</label>
               <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php echo $user_details->name; ?>">
             </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $user_details->email; ?>">
          </div>
          <input type="hidden" name="user_id" value="<?php echo $user_details->_id; ?>">
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <script>
            $("#user_form").submit(function(e) {

                e.preventDefault();
               
                var form = $(this);
                var actionUrl = form.attr('action');
                
                $.ajax({
                    type: "POST",
                    url: 'update.php',
                    data: form.serialize(),
                    success: function(data)
                    {
                      var data = $.trim(data);
                      if(data > 0)
                      {
                        alert("Record successfully updated.");
                        window.location.href = './';
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
</div>
</body>
</html>