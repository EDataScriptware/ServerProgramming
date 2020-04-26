var express = require('express');
var app = express();

//Import the routers for each path
var basepath = "/CompanyServices";
var department = require('./routes/department.js');
var departments = require('./routes/departments.js');
var employee = require('./routes/employee.js');
var employees = require('./routes/employees.js');
var timecard = require('./routes/timecard.js');
var timecards = require('./routes/timecards.js');
var company = require('./routes/companyServices.js');

/*Connect app and routers*/
app.use(basepath +'/company', company);
app.use(basepath +'/department', department);
app.use(basepath +'/departments', departments);
app.use(basepath +'/employee', employee);
app.use(basepath +'/employees', employees);
app.use(basepath +'/timecard', timecard);
app.use(basepath +'/timecards', timecards);

/*Start the server and print where it is listening*/
var server = app.listen(8080, function() {
    var host = server.address().address;
    var port = server.address().port;
    console.log("Project 3 Sever listening at http://%s:%s", host,port);
});
