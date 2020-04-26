var express = require('express');
var cookieParser = require('cookie-parser');
 

// ReferenceError: department is not defined
// require('./companydata/department.js'); // gets the department javascript class


//TypeError: department.getDeptID() is not a function
var department = require('./companydata/department.js'); // gets the department javascript class

// SyntaxError: Cannot use import statement outside a module
// import department from './companydata/department.js'; // gets the department javascript class


// Include is not a recognized function 
//include('./companydata/department.js'); // gets the department javascript class

var app = express();
app.use(cookieParser())

// needed for POST METHOD.
var urlencodedParser = express.urlencoded({extended:false});


app.use(express.static('companydata'));

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
    
    
    console.log("Got a GET request for the root page!");
    
    res.send(department.getDeptID());
});


app.post('/', function(req, res)
{
    console.log("Got a POST request for the root page!");
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