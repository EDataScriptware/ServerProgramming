/*
    NAME: Edward Riley
    PROFESSOR: Bryan French
    TA: Josh Haber
    ASSIGNMENT: Project 03
    DATE: April 28, 2020
*/

var DataLayer = require("./companydata/index.js");
var express = require('express');
var cookieParser = require('cookie-parser');
 
var dl = new DataLayer("emr9018");
var app = express();
app.use(cookieParser())

// Starts the server at Port 8080
var server = app.listen(8080, function() {
    var host = server.address().address;
    if (host == "::") // more user friendly for IT because I like seeing localhost:8080 than :::8080
    {
        host = "localhost";
    }
    var port = server.address().port;
    console.log("Listening on " + host + ":"+  port);
});

// Checks to see if the server is working
app.get('/',function(req,res)
{
    console.log("Got a GET request for the root page!");

    res.send("Connection works!");
});

// Import class object for each path
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