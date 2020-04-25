var express = require('express');
var cookieParser = require('cookie-parser');

var app = express();
app.use(cookieParser())

// needed for POST METHOD.
var urlencodedParser = express.urlencoded({extended:false});


app.use(express.static('public'));

app.get('/index.html', function(req, res)
{
    res.sendFile(__dirname+"/index.html");
})

// GET METHOD
app.get('/process_get', function(req, res)
{
    response = 
    {
        first_name:req.query.first_name,
        last_name:req.query.last_name
    };
    console.log(response);
    res.end(JSON.stringify(response));

});

// POST METHOD
app.post('/process_post', urlencodedParser, function(req, res)
{
    response = 
    {
        first_name:req.body.first_name,
        last_name:req.body.last_name
    };

    console.log(response);
    res.end(JSON.stringify(response));

});

app.get('/',function(req,res)
{
    
    
    console.log("Got a GET request for the homepage!");
    console.log(req.cookies);
    
    // res.send("Hello GET!");
    res.end(JSON.stringify(req.cookies));

    
});


app.post('/', function(req, res)
{
    console.log("Got a POST request for the homepage!");
    res.send("Hello POST!")

});


app.get('/list_user', function(req, res)
{
    console.log("Got a GET request for /list_user!");
    res.send("User listing!")

});

app.delete('/del_user', function(req, res)
{
    console.log("Got a DELETE request for /del_user!");
    res.send("Hello DELETE!")

});


app.get('/ab*cd',function(req, res)
{
    console.log("Got a GET request for /del_user!");
    res.send("Page pattern match!"); 
});



var server = app.listen(8081, function()
{
    var host = server.address().address;
    var port = server.address().port;
    
    console.log("Listening at http://" + host + ":" + port);

})