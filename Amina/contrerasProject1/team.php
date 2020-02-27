<html>  
      <head>  
           <title>Project 1</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <link rel="stylesheet" type="text/css" href="css/project1UI.css">
      </head>  
      <body>  
            <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                <div class="navbar-header">
                  <a class="navbar-brand" href="#">Sport Manager</a>
                </div>
                <ul class="nav navbar-nav">
                  <li class="active"><a href="admin.php">User</a></li>
                  <li><a href="team.php">Team</a></li>
                  <li><a href="schedule.php">Schedule</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="#"><span class="glyphicon glyphicon-user"></span>User</a></li>
                  <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
              </div>
            </nav>
           <div class="container">  
                <br />  
                <br />  
                <br />  
                <div class="table-responsive">  
                     <h3 align="center">View </h3><br />  
                     <div id="viewTeam"></div>                 
                </div>   
           </div>  
      </body>  
 </html>  
 <script>
    $(document).ready(function(){  

      function fetch_data()  
      {  
           $.ajax({  
                url:"teamPage/select.php",  
                method:"POST",  
                success:function(data){  
                     $('#viewTeam').html(data);  
                }  
           });  
      }  
      fetch_data();  


       });
 </script>