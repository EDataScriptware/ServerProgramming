/*
    NAME: Edward Riley



*/

var DataLayer = require("./companydata/index.js");
var express = require('express');
var cookieParser = require('cookie-parser');
 
var dl = new DataLayer("emr9018");
var app = express();
app.use(cookieParser())

// Needed for POST method
var urlencodedParser = express.urlencoded({extended:false});

// Start the server
var server = app.listen(8080, function() {
    var host = server.address().address;
    if (host == "::") // more user friendly
    {
        host = "localhost";
    }
    var port = server.address().port;
    console.log("Listening on " + host + ":"+  port);
});

//Import the routers for each path
var basepath = "/CompanyServices";
var department = require('./router/department.js');
var departments = require('./router/departments.js');
var employee = require('./router/employee.js');
var employees = require('./router/employees.js');
var timecard = require('./router/timecard.js');
var timecards = require('./router/timecards.js');
var company = require('./router/companyServices.js');

// Using routers to connect to categories.
app.use(basepath +'/company', company);
app.use(basepath +'/department', department);
app.use(basepath +'/departments', departments);
app.use(basepath +'/employee', employee);
app.use(basepath +'/employees', employees);
app.use(basepath +'/timecard', timecard);
app.use(basepath +'/timecards', timecards);