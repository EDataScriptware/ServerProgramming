var express = require('express');
var router = express.Router();
var businessLayer = require("../businessLayer.js");
var dataLayer = require("../companydata/index.js");
var json = express.json();
var urlEncodedPaser = express.urlencoded({extended:false});

router.route('/') .all(function(req, res, next)
{
  bl = new businessLayer();
    next();
})

.get(function(req, res)
{
    var company = req.query.company;
    var ID = req.query.emp_id;

    if(!bl.validateCompanyName(company)) 
    {
        return bl.invalidCompany(res);
    }

    if(!(id > 0)) 
    {
        return bl.badRequest(res, "Invalid employee ID given.");
    }
    try 
    {
        var dl = new dataLayer(company);
        var emp = dl.getEmployee(id);
        if (emp !== null)
        {
            return bl.jsonOk(res, emp);
        }
        else
        {
            return bl.errorRequest(res, "Unable to find the given Employee ID.")
        }
    }

    catch(ex)
    {
        console.log(ex);
        return bl.errorMessage(res);
    }
})

.post(urlEncodedPaser, function(req, res)
{
    var company = req.body.company;

    if(!bl.validateCompanyName(company))
    {
        return bl.invalidCompany(res);
    }

    try
    {
        var dl = new dataLayer(company);

        var empName = req.body.emp_name;
        var empNo = req.body.emp_no;
        var hireDate = req.body.hire_date;
        var job = req.body.job;
        var salary = parseFloat(req.body.salary);
        var departmentID = parseInt(req.body.dept_id);
        var managerID = parseInt(req.body.mng_id);

        if(dl.getDepartment(company, departmentID) === null) 
        {
            return bl.badRequest(res, "Department ID given not found.");
        }
      
        if(!(managerID === 0 || dl.getEmployee(managerID) !== null))
        {
            return bl.errorRequest(res, "Manager ID given not found.");
        }

        var validDate = bl.buildAndValidateDate(hireDate);
        if(validDate === null) 
        {
            return bl.badRequest(res, "Hiring date given is invalid.");
        }

        if(!empNo.includes("-"+company))
        {
            empNo = empNo += "-" + company;
        }

        var newEmp = dl.insertEmployee(new dl.Employee(empName, empNo, validDate, job, salary, departmentID, managerID));

        if(newEmp === null)
        {
            return bl.badRequest(res, "Employee Number or ID already exists or not all information is given.");
        }

        return bl.jsonOk(res, newEmp);
    }
    catch(ex)
    {
        console.log(ex);
        return bl.errorMessage(res);
    }
})

.put(json, function(req, res) {
    var company = req.body.company;

    if(!bl.validateCompanyName(company))
    {
        return bl.invalidCompany(res);
    }

    try
    {
        var dl = new DataLayer(company);

        var employeeID = req.body.emp_id;
        if(typeof employeeID === 'undefined')
        {
            return bl.badRequest(res, "Employee ID is not given.")
        }

        var oldEmp = dl.getEmployee(employeeID);

        if(oldEmp === null)
        {
            return bl.errorRequest(res, "Employee requested unable to be found.")
        }

        var empName = typeof req.body.emp_name !== 'undefined' ? String(req.body.emp_name) : oldEmp.getEmpName();
        var empNo = typeof req.body.emp_no !== 'undefined' ? String(req.body.emp_no) : oldEmp.getEmpNo();
        var hireDate = typeof req.body.hire_date !== 'undefined' ? bl.buildAndValidateDate(String(req.body.hire_date)) : oldEmp.getHireDate();
        var job = typeof req.body.job !== 'undefined' ? String(req.body.job) : oldEmp.getJob();
        var salary = typeof req.body.salary !== 'undefined' ? parseFloat(req.body.salary) : oldEmp.getSalary();
        var departmentID = typeof req.body.dept_id !== 'undefined' ? parseInt(req.body.dept_id) : oldEmp.getDeptId();
        var managerID = typeof req.body.mng_id !== 'undefined' ? parseInt(req.body.mng_id) : oldEmp.getMngId();

        if(dl.getDepartment(company, departmentID) === null)
        {
            return bl.badRequest(res, "Department ID given not found");
        }
        
        if(!(managerID === 0 || dl.getEmployee(managerID) !== null)) 
        {
            return bl.errorRequest(res, "Manager ID given not found");
        }

        if(hireDate === null)
        {
            return bl.badRequest(res, "Hire Date is not valid");
        }

        if(!empNo.includes("-"+company))
        {
            empNo = empNo += "-" + company;
        }

        oldEmp.setEmpName(empName);
        oldEmp.setEmpNo(empNo);
        oldEmp.setHireDate(hireDate);
        oldEmp.setJob(job);
        oldEmp.setSalary(salary);
        oldEmp.setDeptId(departmentID);
        oldEmp.setMngId(managerID);

        var updatedEmp = dl.updateEmployee(oldEmp);

        if(updatedEmp === null) 
        {
            return bl.badRequest(res, "Requested employee does not exist or duplicate employee number given.")
        }

        return bl.jsonOk(res, updatedEmp);

    }
    catch(ex)
    {
        console.log(ex);
        return bl.errorMessage(res);
    }
})

.delete(function(req, res)
{
    var company = req.query.company;
    var employeeID = req.query.emp_id;

    if(!bl.validateCompanyName(company))
    {
        return bl.invalidCompany(res);
    }

    if(!(employeeID > 0))
    {
        return bl.badRequest(res, "Invalid employee ID given.");
    }
    try
    {
        var dl = new DataLayer(company);
        var deleted = dl.deleteEmployee(employeeID); 

        if(!(deleted > 0)) 
        {
            return bl.errorRequest(res, "Employee ID not found")
        }

        return bl.messageOk(res, "Employee " + employeeID + " deleted");
    }
    catch(ex) 
    {
        console.log(ex);
        return bl.errorMessage(res);
    }
});

module.exports = router;