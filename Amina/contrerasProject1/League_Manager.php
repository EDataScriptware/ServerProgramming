<!DOCTYPE html>
<html>
<head>
  <title>Project 1</title>
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
        <a class="navbar-brand" href="#">League Manager</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active">
          <a href="League_Manager.php">League Manager</a>
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
          <a href="#"><span class="glyphicon glyphicon-user"></span>League Manager</a>
        </li>
        <li>
          <a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container">
    <br>
    <br>
    <hr>
    <div class="table-responsive">
      <h3 align="center">Season table</h3><br>
      <div id="season_table"></div>
    </div><br>
    <br>
    <br>
    <hr>
    <div class="table-responsive">
      <h3 align="center">League table</h3><br>
      <div id="league_table"></div>
    </div><br>
    <br>
    <br>
    <hr>
    <div class="table-responsive">
      <h3 align="center">Sport League Season table</h3><br>
      <div id="slseason_table"></div>
    </div><br>
    <br>
    <br>
    <hr>
    <div class="table-responsive">
      <h3 align="center">Schedule table</h3><br>
      <div id="schedule_table"></div>
    </div><br>
    <br>
    <br>
    <hr>
    <div class="table-responsive">
      <h3 align="center">Team manager and coach table</h3><br>
      <div id="tmcUser_table"></div>
    </div><br>
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
      

  ////////////////////////////////////////////////////////////////////////////////////Season    
         function seasonfetch_data() {
            $.ajax({  
                 url:"AjaxFolders/seasonAjax/select.php",  
                 method:"POST",  
                 success:function(data){  
                      $('#season_table').html(data);  
                 }  
            });  
       }  
       seasonfetch_data();
             $(document).on('click', '#season_btn_add', function(){  
            var year = $('#year').text();  
            var desc = $('#desc').text(); 
            if(year == '')  
            {  
                 alert("Enter year");  
                 return false;  
            } 
             if(desc == '')  
            {  
                 alert("Enter Description");  
                 return false;  
            }  
            $.ajax({  
                 url:"AjaxFolders/seasonAjax/insert.php",  
                 method:"POST",  
                 data:{year:year,desc:desc},  
                 dataType:"text",  
                 success:function(data)  
                 {  
                     seasonfetch_data();
                 }  
            })  
       }); 

       function season_edit_data(id,year,desc)  
       {  
            $.ajax({  
                 url:"AjaxFolders/seasonAjax/edit.php",  
                 method:"POST",  
                 data:{id:id,year:year,desc:desc},  
                 dataType:"text",  
                 success:function(data){  

                      console.log('edit data finished');
                      console.log('received: ' + data);
                 }  
            });  
       }

       $(document).on('blur', '.year', function(){  
            var parent = $(this).parent();
            var id =   parseInt(parent.find('.id').attr('data-old'));
            var year = parent.find('.year').text();  
            var desc = parent.find('.description').text();
            console.log('[id='+id+',year='+year+',description='+desc+']');
            season_edit_data(id,year, desc);  
       });  

           $(document).on('blur', '.description', function(){  
            var parent = $(this).parent();
            var id =   parseInt(parent.find('.id').attr('data-old'));
            var year = parent.find('.year').text();  
            var desc = parent.find('.description').text();
            console.log('[id='+id+',year='+year+',description='+desc+']');
            season_edit_data(id,year, desc);  
       });  

         $(document).on('click', '.season_btn_delete', function(){  
              var parent = $(this).parent().parent();
              var id = parseInt(parent.find('.id').text());   
              console.log(id);
            if(confirm("Are you sure you want to delete this?"))  
            {  
                 $.ajax({  
                      url:"AjaxFolders/seasonAjax/delete.php",  
                      method:"POST",  
                      data:{id:id},  
                      dataType:"text",  
                      success:function(data){  
                           console.log(data);
                           seasonfetch_data();  
                      }  
                 });  
            }  
       });
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////League
  function leaguefetch_data() {
            $.ajax({  
                 url:"AjaxFolders/leagueAjax/select.php",  
                 method:"POST",  
                 success:function(data){  
                      $('#league_table').html(data);  
                 }  
            });  
       }  
       leaguefetch_data();
       $(document).on('click', '#league_btn_add', function(){  
            var name = $('#league_name').text();  

            if(name == '')  
            {  
                 alert("Enter Name");  
                 return false;  
            }  
            $.ajax({  
                 url:"AjaxFolders/leagueAjax/insert.php",  
                 method:"POST",  
                 data:{name:name},  
                 dataType:"text",  
                 success:function(data)  
                 {  
                     leaguefetch_data();
                 }  
            })  
       }); 

       function league_edit_data(id,name)  
       {  
            $.ajax({  
                 url:"AjaxFolders/leagueAjax/edit.php",  
                 method:"POST",  
                 data:{id:id,name:name},  
                 dataType:"text",  
                 success:function(data){  

                      console.log('edit data finished');
                      console.log('received: ' + data);
                 }  
            });  
       }

       $(document).on('blur', '.league_name', function(){  
            var parent = $(this).parent();
            var id =   parseInt(parent.find('.league_id').attr('data-old'));
            var name = parent.find('.league_name').text();  
            console.log('[id='+id+',name='+name+']');
            league_edit_data(id,name);  
            //parent.find('.username').attr('data-old', username);
       });  


       $(document).on('click', '.league_btn_delete', function(){  
              var parent = $(this).parent().parent();
              var id = parseInt(parent.find('.league_id').text());   
              console.log(id);
            if(confirm("Are you sure you want to delete this?"))  
            {  
                 $.ajax({  
                      url:"AjaxFolders/leagueAjax/delete.php",  
                      method:"POST",  
                      data:{id:id},  
                      dataType:"text",  
                      success:function(data){  
                           console.log(data);
                           leaguefetch_data();  
                      }  
                 });  
            }  
       }); 

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////slseason
  function slseasonfetch_data() {
            $.ajax({  
                 url:"AjaxFolders/slseasonAjax/select.php",  
                 method:"POST",  
                 success:function(data){  
                      $('#slseason_table').html(data);  
                 }  
            });  
       }

       slseasonfetch_data();
      $(document).on('click', '#slseason_btn_add', function(){  
           var sport = parseInt($('#slseason_sport').text());  
           var league =  parseInt($('#slseason_league').text());
           var season =  parseInt($('#slseason_season').text());
            if(sport == 0)  
            {  
                 alert("Enter Sport (number)");  
                 return false;  
            }  
            if(league == 0)  
            {  
                 alert("Enter League (number)");  
                 return false;  
            } 
           if(season == 0)  
            {  
                 alert("Enter Season (number)");  
                 return false;  
            } 
            $.ajax({  
                 url:"AjaxFolders/slseasonAjax/insert.php",  
                 method:"POST",  
                 data:{sport:sport,league:league,season:season},  
                 dataType:"text",  
                 success:function(data)  
                 {  
                     slseasonfetch_data();
                 }  
            })  
       });


       function slseason_edit_data(sport,league,season, oldSport)  
       {  
           console.log('sent edit data');
            $.ajax({  
                 url:"AjaxFolders/slseasonAjax/edit.php",  
                 method:"POST",  
                 data:{sport:sport, league:league, season:season, oldSport:oldSport},  
                 dataType:"text",  
                 success:function(data){  

                      console.log('edit data finished');
                      console.log('received: ' + data);
                 }  
            });  
       }  


        $(document).on('blur', '.slseason_sport', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.slseason_sport').text());  
            var oldSport = parseInt(parent.find('.slseason_sport').attr('data-oldSport'));
            var league = parseInt(parent.find('.slseason_league').text()); 
            var season = parseInt(parent.find('.slseason_season').text()); 
            console.log('[sport='+sport+',oldSport='+oldSport+',league='+league+',season='+season+']');
            slseason_edit_data(sport,league, season,oldSport);  
            parent.find('.slseason_sport').attr('data-old', sport);
       });  
           $(document).on('blur', '.slseason_league', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.slseason_sport').text());  
            var oldSport = parseInt(parent.find('.slseason_sport').attr('data-oldSport'));
            var league = parseInt(parent.find('.slseason_league').text()); 
            var season = parseInt(parent.find('.slseason_season').text()); 
            console.log('[sport='+sport+',oldSport='+oldSport+',league='+league+',season='+season+']');
              slseason_edit_data(sport,league, season,oldSport);
            //parent.find('.slseason_sport').attr('data-old', sport);
       });  
         $(document).on('blur', '.slseason_season', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.slseason_sport').text());  
            var oldSport = parseInt(parent.find('.slseason_sport').attr('data-oldSport'));
            var league = parseInt(parent.find('.slseason_league').text()); 
            var season = parseInt(parent.find('.slseason_season').text()); 
            console.log('[sport='+sport+',oldSport='+oldSport+',league='+league+',season='+season+']');
             slseason_edit_data(sport,league, season,oldSport);
            //parent.find('.slseason_sport').attr('data-old', sport);
       });


              $(document).on('click', '.slseason_btn_delete', function(){  
              var parent = $(this).parent().parent();
              var sport = parseInt(parent.find('.slseason_sport').text());   
              console.log(sport);
            if(confirm("Are you sure you want to delete this?"))  
            {  
                 $.ajax({  
                      url:"AjaxFolders/slseasonAjax/delete.php",  
                      method:"POST",  
                      data:{sport:sport},  
                      dataType:"text",  
                      success:function(data){  
                           console.log(data);
                           leaguefetch_data();  
                      }  
                 });  
            }  
       }); 

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Schedule   
  function schedulefetch_data() {
            $.ajax({  
                 url:"AjaxFolders/scheduleAjax/select.php",  
                 method:"POST",  
                 success:function(data){  
                      $('#schedule_table').html(data);  
                 }  
            });  
       }

       schedulefetch_data();  

      $(document).on('click', '#schedule_btn_add', function(){  
           var sport =   parseInt($('#schedule_sport').text());  
           var league =  parseInt($('#schedule_league').text());
           var season =  parseInt($('#schedule_season').text());
           var hometeam =   parseInt($('#schedule_hometeam').text());  
           var awayteam =   parseInt($('#schedule_awayteam').text());
           var homescore =  parseInt($('#schedule_homescore').text());
           var awayscore =  parseInt($('#schedule_awayscore').text());
           var scheduled =  $('#schedule_scheduled').text();
           var completed =  parseInt($('#schedule_completed').text());
            if(sport == 0)  
            {  
                 alert("Enter Sport (number)");  
                 return false;  
            }  
            if(league == 0)  
            {  
                 alert("Enter League (number)");  
                 return false;  
            } 
           if(season == 0)  
            {  
                 alert("Enter Season (number)");  
                 return false;  
            } 
            if(hometeam == 0)  
            {  
                 alert("Enter hometeam");  
                 return false;  
            } 
           if(awayteam == 0)  
            {  
                 alert("Enter awayteam");  
                 return false;  
            } 
           if(homescore == 0)  
            {  
                 alert("Enter homescore");  
                 return false;  
            } 
            if(awayscore == 0)  
            {  
                 alert("Enter awayscore");  
                 return false;  
            } 
           if(scheduled == "")  
            {  
                 alert("Enter this date");  
                 return false;  
            } 
           if(!(completed == 0 ||  completed == 1))  
            {  
                 alert("Enter 0 and 1");  
                 return false;  
            } 
            $.ajax({  
                 url:"AjaxFolders/scheduleAjax/insert.php",  
                 method:"POST",  
                 data:{sport:sport,league:league,season:season,hometeam:hometeam, awayteam:awayteam, homescore:homescore, awayscore:awayscore, scheduled:scheduled, completed:completed},  
                 dataType:"text",  
                 success:function(data)  
                 {  
                     schedulefetch_data();
                 }  
            })  
       });       



       function schedule_edit_data(sport,league,season,hometeam, awayteam, homescore, awayscore, scheduled, completed,oldHT)  
       {  
           console.log('sent edit data');
            $.ajax({  
                 url:"AjaxFolders/scheduleAjax/edit.php",  
                 method:"POST",  
                 data:{sport:sport, league:league, season:season, hometeam:hometeam, awayteam:awayteam, homescore:homescore, awayscore:awayteam, scheduled:scheduled, completed:completed,oldHT:oldHT},  
                 dataType:"text",  
                 success:function(data){  

                      console.log('edit data finished');
                      console.log('received: ' + data);
                 }  
            });  
       } 

         $(document).on('blur', '.schedule_sport', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.schedule_sport').text());  
            var league = parseInt(parent.find('.schedule_league').text()); 
            var season = parseInt(parent.find('.schedule_season').text()); 
            var hometeam = parseInt(parent.find('.schedule_hometeam').text());
            var awayteam = parseInt(parent.find('.schedule_awayteam').text());
            var homescore = parseInt(parent.find('.schedule_homescore').text());
            var awayscore = parseInt(parent.find('.schedule_awayscore').text());
            var scheduled = parent.find('.schdedule_scheduled').text();
            var completed = parseInt(parent.find('.schedule_completed').text());
            var oldHT = parseInt(parent.find('.schedule_hometeam').attr('data-oldHT'));

            console.log('[sport='+sport+',oldHT='+oldHT+',league='+league+',season='+season+',hometeam='+hometeam+',awayteam='+awayteam+',homescore='+homescore+',awayscore='+awayscore+',scheduled='+scheduled+',completed='+completed+']');
            schedule_edit_data(sport,league, season,hometeam, awayteam, homescore, awayscore, scheduled, completed,oldSport);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

             $(document).on('blur', '.schedule_league', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.schedule_sport').text());  
            var league = parseInt(parent.find('.schedule_league').text()); 
            var season = parseInt(parent.find('.schedule_season').text()); 
            var hometeam = parseInt(parent.find('.schedule_hometeam').text());
            var awayteam = parseInt(parent.find('.schedule_awayteam').text());
            var homescore = parseInt(parent.find('.schedule_homescore').text());
            var awayscore = parseInt(parent.find('.schedule_awayscore').text());
            var scheduled = parent.find('.schdedule_scheduled').text();
            var completed = parseInt(parent.find('.schedule_completed').text());
            var oldHT = parseInt(parent.find('.schedule_hometeam').attr('data-oldHT'));

            console.log('[sport='+sport+',oldHT='+oldHT+',league='+league+',season='+season+',hometeam='+hometeam+',awayteam='+awayteam+',homescore='+homescore+',awayscore='+awayscore+',scheduled='+scheduled+',completed='+completed+']');
            schedule_edit_data(sport,league, season,hometeam, awayteam, homescore, awayscore, scheduled, completed,oldSport);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 
                 $(document).on('blur', '.schedule_season', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.schedule_sport').text());  
            var league = parseInt(parent.find('.schedule_league').text()); 
            var season = parseInt(parent.find('.schedule_season').text()); 
            var hometeam = parseInt(parent.find('.schedule_hometeam').text());
            var awayteam = parseInt(parent.find('.schedule_awayteam').text());
            var homescore = parseInt(parent.find('.schedule_homescore').text());
            var awayscore = parseInt(parent.find('.schedule_awayscore').text());
            var scheduled = parent.find('.schdedule_scheduled').text();
            var completed = parseInt(parent.find('.schedule_completed').text());
            var oldHT = parseInt(parent.find('.schedule_hometeam').attr('data-oldHT'));

            console.log('[sport='+sport+',oldHT='+oldHT+',league='+league+',season='+season+',hometeam='+hometeam+',awayteam='+awayteam+',homescore='+homescore+',awayscore='+awayscore+',scheduled='+scheduled+',completed='+completed+']');
            schedule_edit_data(sport,league, season,hometeam, awayteam, homescore, awayscore, scheduled, completed,oldSport);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

        $(document).on('blur', '.schedule_hometeam', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.schedule_sport').text());  
            var league = parseInt(parent.find('.schedule_league').text()); 
            var season = parseInt(parent.find('.schedule_season').text()); 
            var hometeam = parseInt(parent.find('.schedule_hometeam').text());
            var awayteam = parseInt(parent.find('.schedule_awayteam').text());
            var homescore = parseInt(parent.find('.schedule_homescore').text());
            var awayscore = parseInt(parent.find('.schedule_awayscore').text());
            var scheduled = parent.find('.schdedule_scheduled').text();
            var completed = parseInt(parent.find('.schedule_completed').text());
            var oldHT = parseInt(parent.find('.schedule_hometeam').attr('data-oldHT'));

            console.log('[sport='+sport+',oldHT='+oldHT+',league='+league+',season='+season+',hometeam='+hometeam+',awayteam='+awayteam+',homescore='+homescore+',awayscore='+awayscore+',scheduled='+scheduled+',completed='+completed+']');
            schedule_edit_data(sport,league, season,hometeam, awayteam, homescore, awayscore, scheduled, completed,oldSport);  
            parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

            $(document).on('blur', '.schedule_awayteam', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.schedule_sport').text());  
            var league = parseInt(parent.find('.schedule_league').text()); 
            var season = parseInt(parent.find('.schedule_season').text()); 
            var hometeam = parseInt(parent.find('.schedule_hometeam').text());
            var awayteam = parseInt(parent.find('.schedule_awayteam').text());
            var homescore = parseInt(parent.find('.schedule_homescore').text());
            var awayscore = parseInt(parent.find('.schedule_awayscore').text());
            var scheduled = parent.find('.schdedule_scheduled').text();
            var completed = parseInt(parent.find('.schedule_completed').text());
            var oldHT = parseInt(parent.find('.schedule_hometeam').attr('data-oldHT'));

            console.log('[sport='+sport+',oldHT='+oldHT+',league='+league+',season='+season+',hometeam='+hometeam+',awayteam='+awayteam+',homescore='+homescore+',awayscore='+awayscore+',scheduled='+scheduled+',completed='+completed+']');
            schedule_edit_data(sport,league, season,hometeam, awayteam, homescore, awayscore, scheduled, completed,oldSport);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

                $(document).on('blur', '.schedule_homescore', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.schedule_sport').text());  
            var league = parseInt(parent.find('.schedule_league').text()); 
            var season = parseInt(parent.find('.schedule_season').text()); 
            var hometeam = parseInt(parent.find('.schedule_hometeam').text());
            var awayteam = parseInt(parent.find('.schedule_awayteam').text());
            var homescore = parseInt(parent.find('.schedule_homescore').text());
            var awayscore = parseInt(parent.find('.schedule_awayscore').text());
            var scheduled = parent.find('.schdedule_scheduled').text();
            var completed = parseInt(parent.find('.schedule_completed').text());
            var oldHT = parseInt(parent.find('.schedule_hometeam').attr('data-oldHT'));

            console.log('[sport='+sport+',oldHT='+oldHT+',league='+league+',season='+season+',hometeam='+hometeam+',awayteam='+awayteam+',homescore='+homescore+',awayscore='+awayscore+',scheduled='+scheduled+',completed='+completed+']');
            schedule_edit_data(sport,league, season,hometeam, awayteam, homescore, awayscore, scheduled, completed,oldSport);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 
             $(document).on('blur', '.schedule_awayscore', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.schedule_sport').text());  
            var league = parseInt(parent.find('.schedule_league').text()); 
            var season = parseInt(parent.find('.schedule_season').text()); 
            var hometeam = parseInt(parent.find('.schedule_hometeam').text());
            var awayteam = parseInt(parent.find('.schedule_awayteam').text());
            var homescore = parseInt(parent.find('.schedule_homescore').text());
            var awayscore = parseInt(parent.find('.schedule_awayscore').text());
            var scheduled = parent.find('.schdedule_scheduled').text();
            var completed = parseInt(parent.find('.schedule_completed').text());
            var oldHT = parseInt(parent.find('.schedule_hometeam').attr('data-oldHT'));

            console.log('[sport='+sport+',oldHT='+oldHT+',league='+league+',season='+season+',hometeam='+hometeam+',awayteam='+awayteam+',homescore='+homescore+',awayscore='+awayscore+',scheduled='+scheduled+',completed='+completed+']');
            schedule_edit_data(sport,league, season,hometeam, awayteam, homescore, awayscore, scheduled, completed,oldSport);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

            $(document).on('blur', '.schdedule_scheduled', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.schedule_sport').text());  
            var league = parseInt(parent.find('.schedule_league').text()); 
            var season = parseInt(parent.find('.schedule_season').text()); 
            var hometeam = parseInt(parent.find('.schedule_hometeam').text());
            var awayteam = parseInt(parent.find('.schedule_awayteam').text());
            var homescore = parseInt(parent.find('.schedule_homescore').text());
            var awayscore = parseInt(parent.find('.schedule_awayscore').text());
            var scheduled = parent.find('.schdedule_scheduled').text();
            var completed = parseInt(parent.find('.schedule_completed').text());
            var oldHT = parseInt(parent.find('.schedule_hometeam').attr('data-oldHT'));

            console.log('[sport='+sport+',oldHT='+oldHT+',league='+league+',season='+season+',hometeam='+hometeam+',awayteam='+awayteam+',homescore='+homescore+',awayscore='+awayscore+',scheduled='+scheduled+',completed='+completed+']');
            schedule_edit_data(sport,league, season,hometeam, awayteam, homescore, awayscore, scheduled, completed,oldSport);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

         $(document).on('blur', '.schedule_completed', function(){  
            //var usernamedata = $(this).data("username");  
            var parent = $(this).parent();
            var sport = parseInt(parent.find('.schedule_sport').text());  
            var league = parseInt(parent.find('.schedule_league').text()); 
            var season = parseInt(parent.find('.schedule_season').text()); 
            var hometeam = parseInt(parent.find('.schedule_hometeam').text());
            var awayteam = parseInt(parent.find('.schedule_awayteam').text());
            var homescore = parseInt(parent.find('.schedule_homescore').text());
            var awayscore = parseInt(parent.find('.schedule_awayscore').text());
            var scheduled = parent.find('.schdedule_scheduled').text();
            var completed = parseInt(parent.find('.schedule_completed').text());
            var oldHT = parseInt(parent.find('.schedule_hometeam').attr('data-oldHT'));

            console.log('[sport='+sport+',oldHT='+oldHT+',league='+league+',season='+season+',hometeam='+hometeam+',awayteam='+awayteam+',homescore='+homescore+',awayscore='+awayscore+',scheduled='+scheduled+',completed='+completed+']');
            schedule_edit_data(sport,league, season,hometeam, awayteam, homescore, awayscore, scheduled, completed,oldSport);  
            //parent.find('.schedule_hometeam').attr('data-oldHT', hometeam);
       }); 

           $(document).on('click', '.schedule_btn_delete', function(){  
              var parent = $(this).parent().parent();
              var hometeam = parseInt(parent.find('.schedule_hometeam').text());   
              console.log(hometeam);
            if(confirm("Are you sure you want to delete this?"))  
            {  
                 $.ajax({  
                      url:"AjaxFolders/scheduleAjax/delete.php",  
                      method:"POST",  
                      data:{hometeam:hometeam},  
                      dataType:"text",  
                      success:function(data){  
                           console.log(data);
                           leaguefetch_data();  
                      }  
                 });  
            }  
       }); 

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////team manager and coach
         function tmcfetch_data()  
       {  
            $.ajax({  
                 url:"AjaxFolders/tmcuserAjax/select.php",  
                 method:"POST",  
                 success:function(data){  
                      $('#tmcUser_table').html(data);  
                 }  
            });  
       }  
       tmcfetch_data(); 

       $(document).on('click', '#tmcuser_btn_add', function(){  
            var username = $('#tmcusername').text();  
            var role = parseInt($('#tmcrole').text()); 
            var password =  $('#tmcpassword').text();  
            var team = parseInt($('#tmcteam').text()); 
            var league = parseInt($('#tmcleague').text());
            if(username == '')  
            {  
                 alert("Enter Username");  
                 return false;  
            }  
            if(!(role == 3 || role == 4))  
            {  
                 alert("Enter Team manager(3) or Enter Coach (4)");  
                 return false;  
            }  
            if(password == '')  
            {  
                 alert("Enter Password");  
                 return false;  
            }  
            if(team == 0)  
            {  
                 alert("Enter Team");  
                 return false;  
            }  
            if(league == 0)  
            {  
                 alert("Enter league");  
                 return false;  
            }  

            $.ajax({  
                 url:"AjaxFolders/tmcuserAjax/insert.php",  
                 method:"POST",  
                 data:{username:username, role:role, password:password, team:team, league:league},  
                 dataType:"text",  
                 success:function(data)  
                 {  
                       tmcfetch_data(); 
                       fetch_data(); 
                 }  
            })  
       });

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