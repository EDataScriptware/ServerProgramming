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
    var id = req.query.emp_id;

    if(!bl.validateCompanyName(company)) 
    {
        return bl.invalidCompany(res);
    }

    if(!(id > 0)) 
    {
        return bl.badRequest(res, "Invalid employee id provided");
    }
    try 
    {
        //dept_id is valid, continue
        var dl = new dataLayer(company);
        var emp = dl.getEmployee(id);
        if (emp !== null)
        {
            return bl.jsonOk(res, emp);
        }
        else
        {
            return bl.errorRequest(res, "Could not find provided Employee Id")
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
        //make the datalayer
        var dl = new dataLayer(company);

        //get the rest of the parameters
        var empName = req.body.emp_name;
        var empNo = req.body.emp_no;
        var hireDate = req.body.hire_date;
        var job = req.body.job;
        var salary = parseFloat(req.body.salary);
        var deptId = parseInt(req.body.dept_id);
        var mngId = parseInt(req.body.mng_id);

        if(dl.getDepartment(company, deptId) === null) 
        {
            return bl.badRequest(res, "Department ID provided not found");
        }
      
        if(!(mngId === 0 || dl.getEmployee(mngId) !== null))
        {
            return bl.errorRequest(res, "Manager ID provided not found");
        }

        var validDate = bl.buildAndValidateDate(hireDate);
        if(validDate === null) 
        {
            return bl.badRequest(res, "Hire Date provided is not valid");
        }

        if(!empNo.includes("-"+company))
        {
            empNo = empNo += "-" + company;
        }

        var newEmp = dl.insertEmployee(new dl.Employee(empName, empNo, validDate, job, salary, deptId, mngId));

        if(newEmp === null)
        {
            return bl.badRequest(res, "Employee Number or ID already exists or not all parameters provided");
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
        var dl = new DataLayer(company);//build the dl

        var empId = req.body.emp_id;
        if(typeof empId === 'undefined')
        {
            return bl.badRequest(res, "Employee ID is not provided.")
        }

        var oldEmp = dl.getEmployee(empId);

        if(oldEmp === null)
        {
            return bl.errorRequest(res, "Employee requested unable to be found.")
        }

        var empName = typeof req.body.emp_name !== 'undefined' ? String(req.body.emp_name) : oldEmp.getEmpName();
        var empNo = typeof req.body.emp_no !== 'undefined' ? String(req.body.emp_no) : oldEmp.getEmpNo();
        var hireDate = typeof req.body.hire_date !== 'undefined' ? bl.buildAndValidateDate(String(req.body.hire_date)) : oldEmp.getHireDate();
        var job = typeof req.body.job !== 'undefined' ? String(req.body.job) : oldEmp.getJob();
        var salary = typeof req.body.salary !== 'undefined' ? parseFloat(req.body.salary) : oldEmp.getSalary();
        var deptId = typeof req.body.dept_id !== 'undefined' ? parseInt(req.body.dept_id) : oldEmp.getDeptId();
        var mngId = typeof req.body.mng_id !== 'undefined' ? parseInt(req.body.mng_id) : oldEmp.getMngId();

        if(dl.getDepartment(company, deptId) === null)
        {
            return bl.badRequest(res, "Department ID provided not found");
        }
        
        if(!(mngId === 0 || dl.getEmployee(mngId) !== null)) 
        {
            return bl.errorRequest(res, "Manager ID provided not found");
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
        oldEmp.setDeptId(deptId);
        oldEmp.setMngId(mngId);

        var updatedEmp = dl.updateEmployee(oldEmp);

        if(updatedEmp === null) 
        {
            return bl.badRequest(res, "Requested employee does not exist or duplicate employee number provided")
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
    var empId = req.query.emp_id;

    if(!bl.validateCompanyName(company))
    {
        return bl.invalidCompany(res);
    }

    if(!(empId > 0))
    {
        return bl.badRequest(res, "Invalid employee ID provided");
    }
    try
    {
        var dl = new DataLayer(company);
        var deleted = dl.deleteEmployee(empId); 

        if(!(deleted > 0)) 
        {
            return bl.errorRequest(res, "Employee ID not found")
        }

        return bl.messageOk(res, "Employee " + empId + " deleted");
    }
    catch(ex) 
    {
        console.log(ex);
        return bl.errorMessage(res);
    }
});

module.exports = router;