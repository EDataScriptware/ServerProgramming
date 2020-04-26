var DataLayer = require("./companydata/index.js");
var express = require('express');
var cookieParser = require('cookie-parser');
 
var dl = new DataLayer("emr9018");
var app = express();
app.use(cookieParser())

// Needed for POST method
var urlencodedParser = express.urlencoded({extended:false});

app.use(express.static('companydata'));

var server = app.listen(8080, function()
{
    var host = server.address().address;
    var port = server.address().port;
    
    console.log("Listening at http://" + host + ":" + port);

})

app.get('/', function(req, res)
{
    console.log("Got a GET request for the root page!");
});