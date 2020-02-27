<!DOCTYPE html>
<html>
<head>
  <title>Project1</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js">
  </script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
  </script>
  <link href="css/project1UI.css" rel="stylesheet" type="text/css">
</head>
<body>
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Sport Manager</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active">
          <a href="coachNteamManager.php">Coach and Team Manager</a>
        </li>
        <li>
          <a href="team.php">Team</a>
        </li>
        <li>
          <a href="schedule.php">Schedule</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="#"><span class="glyphicon glyphicon-user"></span>Coach and Team Manager</a>
        </li>
        <li>
          <a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Login</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container">
  <br>
    <br>
    <br>
    <hr>
    <div class="table-responsive">
      <h3 align="center">Position table</h3><br>
      <div id="position_table"></div>
    </div><br>
    <br>
    <br>
    <hr>
    <div class="table-responsive">
      <h3 align="center">Player table</h3><br>
      <div id="player_table"></div>
    </div>
  </div>
</body>
</html>
<script>
   
   /////////////////////////////////////////////////////////User

  $(document).ready(function(){//Someone touchs on any action events  
      
  //////////////////////////////////////////////////////////////////////////////////////////////////////////Position
  function positionfetch_data() {
            $.ajax({  
                 url:"AjaxFolders/positionAjax/select.php",  
                 method:"POST",  
                 success:function(data){  
                      $('#position_table').html(data);  
                 }  
            });  
       }  
       positionfetch_data();
       $(document).on('click', '#pos_btn_add', function(){  
            var name = $('#pos_name').text();  

            if(name == '')  
            {  
                 alert("Enter Name");  
                 return false;  
            }  
            $.ajax({  
                 url:"AjaxFolders/positionAjax/insert.php",  
                 method:"POST",  
                 data:{name:name},  
                 dataType:"text",  
                 success:function(data)  
                 {  
                     positionfetch_data();
                 }  
            })  
       }); 

       function position_edit_data(id,name)  
       {  
            $.ajax({  
                 url:"AjaxFolders/positionAjax/edit.php",  
                 method:"POST",  
                 data:{id:id,name:name},  
                 dataType:"text",  
                 success:function(data){  

                      console.log('edit data finished');
                      console.log('received: ' + data);
                 }  
            });  
       }

       $(document).on('blur', '.pos_name', function(){  
            var parent = $(this).parent();
            var id =   parseInt(parent.find('.pos_id').attr('data-oldPosID'));
            var name = parent.find('.pos_name').text();  
            console.log('[id='+id+',name='+name+']');
            position_edit_data(id,name);  
            //parent.find('.username').attr('data-old', username);
       });  


       $(document).on('click', '.pos_btn_delete', function(){  
              var parent = $(this).parent().parent();
              var id = parseInt(parent.find('.pos_id').text());   
              console.log(id);
            if(confirm("Are you sure you want to delete this?"))  
            {  
                 $.ajax({  
                      url:"AjaxFolders/positionAjax/delete.php",  
                      method:"POST",  
                      data:{id:id},  
                      dataType:"text",  
                      success:function(data){  
                           console.log(data);
                           positionfetch_data();  
                      }  
                 });  
            }  
       }); 


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Player
  function playerfetch_data() {
            $.ajax({  
                 url:"AjaxFolders/playerAjax/select.php",  
                 method:"POST",  
                 success:function(data){  
                      $('#player_table').html(data);  
                 }  
            });  
       }

       playerfetch_data();  
          $(document).on('click', '#ply_btn_add', function(){  
           var id =   parseInt($('#ply_id').text());  
           var firstname = ('#ply_firstname').text();
           var lastname =   ('#ply_lastname').text();
           var dateofbirth =  ('#ply_dateofbirth').text();  
           var jerseynumber =   parseInt($('#ply_jerseynumber').text());
           var team =  parseInt($('#ply_team').text());
            if(id == 0)  
            {  
                 alert("Enter id (number)");  
                 return false;  
            }  
            if(firstname == "")  
            {  
                 alert("Enter First Name");  
                 return false;  
            } 
           if(lastname == "")  
            {  
                 alert("Enter Last Name");  
                 return false;  
            } 
            if(dateofbirth == "")  
            {  
                 alert("Enter Date of Birth");  
                 return false;  
            } 
           if(jerseynumber == 0)  
            {  
                 alert("Enter the number of the jersey");  
                 return false;  
            } 
           if(team == 0)  
            {  
                 alert("Enter the number of team");  
                 return false;  
            } 
            $.ajax({  
                 url:"AjaxFolders/playerAjax/insert.php",  
                 method:"POST",  
                 data:{id:id,firstname:firstname,lastname:lastname,dateofbirth:dateofbirth, jerseynumber:jerseynumber, team:team},  
                 dataType:"text",  
                 success:function(data)  
                 {  
                     playerfetch_data();
                 }  
            })  
       });  


           function player_edit_data(id,firstname,lastname,dateofbirth,jerseynumber,team)  
       {  
           console.log('sent edit data');
            $.ajax({  
                 url:"AjaxFolders/playerAjax/edit.php",  
                 method:"POST",  
                 data:{id:id,firstname:firstname,lastname:lastname,dateofbirth:dateofbirth, jerseynumber:jerseynumber, team:team},  
                 dataType:"text",  
                 success:function(data){  

                      console.log('edit data finished');
                      console.log('received: ' + data);
                 }  
            });  
       } 


           $(document).on('blur', '.ply_firstname', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var id = parseInt(parent.find('.ply_id').text());  
            var firstname = parent.find('.ply_firstname').text(); 
            var lastname = parent.find('.ply_lastname').text(); 
            var dateofbirth = parent.find('.ply_dateofbirth').text();
            var jerseynumber = parseInt(parent.find('.ply_jerseynumber').text());
            var team = parseInt(parent.find('.ply_team').text());
            console.log('[id='+id+',firstname='+firstname+',lastname='+lastname+',dateofbirth='+dateofbirth+',jerseynumber='+jerseynumber+',team='+team+']');
            player_edit_data(id,firstname,lastname,dateofbirth,jerseynumber,team);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

         $(document).on('blur', '.ply_lastname', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var id = parseInt(parent.find('.ply_id').text());  
            var firstname = parent.find('.ply_firstname').text(); 
            var lastname = parent.find('.ply_lastname').text(); 
            var dateofbirth = parent.find('.ply_dateofbirth').text();
            var jerseynumber = parseInt(parent.find('.ply_jerseynumber').text());
            var team = parseInt(parent.find('.ply_team').text());
            console.log('[id='+id+',firstname='+firstname+',lastname='+lastname+',dateofbirth='+dateofbirth+',jerseynumber='+jerseynumber+',team='+team+']');
            player_edit_data(id,firstname,lastname,dateofbirth,jerseynumber,team);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

         $(document).on('blur', '.ply_dateofbirth', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var id = parseInt(parent.find('.ply_id').text());  
            var firstname = parent.find('.ply_firstname').text(); 
            var lastname = parent.find('.ply_lastname').text(); 
            var dateofbirth = parent.find('.ply_dateofbirth').text();
            var jerseynumber = parseInt(parent.find('.ply_jerseynumber').text());
            var team = parseInt(parent.find('.ply_team').text());
            console.log('[id='+id+',firstname='+firstname+',lastname='+lastname+',dateofbirth='+dateofbirth+',jerseynumber='+jerseynumber+',team='+team+']');
            player_edit_data(id,firstname,lastname,dateofbirth,jerseynumber,team);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

        $(document).on('blur', '.ply_jerseynumber', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var id = parseInt(parent.find('.ply_id').text());  
            var firstname = parent.find('.ply_firstname').text(); 
            var lastname = parent.find('.ply_lastname').text(); 
            var dateofbirth = parent.find('.ply_dateofbirth').text();
            var jerseynumber = parseInt(parent.find('.ply_jerseynumber').text());
            var team = parseInt(parent.find('.ply_team').text());
            console.log('[id='+id+',firstname='+firstname+',lastname='+lastname+',dateofbirth='+dateofbirth+',jerseynumber='+jerseynumber+',team='+team+']');
            player_edit_data(id,firstname,lastname,dateofbirth,jerseynumber,team);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

         $(document).on('blur', '.ply_team', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var id = parseInt(parent.find('.ply_id').text());  
            var firstname = parent.find('.ply_firstname').text(); 
            var lastname = parent.find('.ply_lastname').text(); 
            var dateofbirth = parent.find('.ply_dateofbirth').text();
            var jerseynumber = parseInt(parent.find('.ply_jerseynumber').text());
            var team = parseInt(parent.find('.ply_team').text());
            console.log('[id='+id+',firstname='+firstname+',lastname='+lastname+',dateofbirth='+dateofbirth+',jerseynumber='+jerseynumber+',team='+team+']');
            player_edit_data(id,firstname,lastname,dateofbirth,jerseynumber,team);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

          $(document).on('click', '.ply_btn_delete', function(){  
              var parent = $(this).parent().parent();
              var id = parseInt(parent.find('.ply_id').text());   
              console.log(id);
            if(confirm("Are you sure you want to delete this?"))  
            {  
                 $.ajax({  
                      url:"AjaxFolders/playerAjax/delete.php",  
                      method:"POST",  
                      data:{id:id},  
                      dataType:"text",  
                      success:function(data){  
                           console.log(data);
                           playerfetch_data();  
                      }  
                 });  
            }  
       }); 


  }); //End Documentation 
</script>