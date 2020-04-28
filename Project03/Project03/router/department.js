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
    var company = String(req.query.company);
    var id = req.query.dept_id;

    if(!bl.validateCompanyName(company))
    {
        return bl.invalidCompany(res);
    }

    if(!(id > 0))
    {
        return bl.badRequest(res, "Invalid department ID provided.");
    }
    try {
        var dl = new dataLayer(company);
        var dept = dl.getDepartment(company, id);
        if(dept !== null)
        {
            return bl.messageOk(res, dept);
        }
        else
        {
            return bl.errorRequest(res, "Unable to find the provided department ID.")
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
    var company = String(req.body.company);

    if(!bl.validateCompanyName(company)) 
    {
        return bl.invalidCompany(res);
    }

    try 
    {
        var dl = new dataLayer(company);
        var deptName = String(req.body.dept_name);
        var deptNo = String(req.body.dept_no);
        var location = String(req.body.location);

        if(!deptNo.includes("-" + company)) 
        {
            deptNo = deptNo += "-" + company;
        }

        if(deptName !== "" && deptNo !== "-"+company && location !== "") 
        {
            var dept = new dl.Department(company, deptName, deptNo, location);
            dept = dl.insertDepartment(dept);

            if(dept !== null)
            {
                return bl.messageOk(res, dept);
            }
            else
            {
                return bl.badRequest(res, "Department number already exists!")
            }

        }
        else
        {
            return bl.badRequest(res, "Invald parameters provided");
        }
    }
    catch(ex) {
        console.log(ex);
        return bl.errorMessage(res);
    }
})

.put(json, function(req, res) 
{    
    var company = req.body.company;

    if(!bl.validateCompanyName(company))
    {
        return bl.invalidCompany(res);
    }

    try 
    {
        var dl = new dataLayer(company);

        var deptId = req.body.dept_id;
        if(typeof deptId === 'undefined')
        {
            return bl.badRequest(res, "Department ID is not provided.")
        }

        var oldDept = dl.getDepartment(company, deptId);

        if(oldDept === null)
        {
            return bl.errorRequest(res, "Department requested could not be found")
        }

        var deptName = typeof req.body.dept_name !== 'undefined' ? String(req.body.dept_name) : oldDept.getDeptName();
        var deptNo = typeof req.body.dept_no !== 'undefined' ? String(req.body.dept_no) : oldDept.getDeptNo();
        var location = typeof req.body.location !== 'undefined' ? String(req.body.location) : oldDept.getLocation();

        oldDept.setDeptName(deptName);
        oldDept.setDeptNo(deptNo);
        oldDept.setLocation(location);

        if(!oldDept.getDeptNo().includes("-" + oldDept.getCompany()))
        {
            oldDept.setDeptNo(oldDept.getDeptNo() + "-" + oldDept.getCompany());
        }

        var updatedDept = dl.updateDepartment(oldDept);
        
        if(updatedDept === null) 
        {
            return bl.badRequest(res, "Requested department does not exist or duplicate department number provided")
        }

        return bl.jsonOk(res, updatedDept);

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
    var id = req.query.dept_id;

    if(!bl.validateCompanyName(company)) 
    {
        return bl.invalidCompany(res);
    }

    if(typeof id === 'undefined' || id <= 0)
    {
        return bl.badRequest(res, "No or improper Depratment ID provided")
    }

    try 
    {
        var dl = new dataLayer(company);
        var rows = dl.deleteDepartment(company, id);

        if(rows === 0)
        {
            return bl.errorRequest(res, "Provided department does not exist for the provided company")
        }
        return bl.messageOk(res, "Department "+id+" from "+company+" successfully deleted")
    }
    catch(ex) {
        console.log(ex);
        return bl.errorMessage(res);
    }
});

module.exports = router;
