var express = require('express');
var router = express.Router();
var businessLayer = require("../businessLayer.js");
var dataLayer = require("../companydata/index.js");
var json = express.json();
var urlEncodedPaser = express.urlencoded({extended:false});

router.route('/') .all(function(req, res, next) {
  bl = new businessLayer();
  next();
})
.get(function(req, res) {
  //GET query params
  var company = String(req.query.company);
  var id = req.query.dept_id;

  //check if company name is valid
  if(!bl.validateCompanyName(company)) {
      return bl.invalidCompany(res);
  }

  //continue if valid, check if id is greater than 0 (is valid)
  if(!(id > 0)) {
      return bl.badRequest(res, "Invalid department id provided");
  }
  try {
      //dept_id is valid, continue
      var dl = new dataLayer(company);
      var dept = dl.getDepartment(company, id);
      if(dept !== null) {
          return bl.messageOk(res, dept);
      } else {
          return bl.errorRequest(res, "Could not find provided department Id")
      }
  }
  catch(ex) {
      console.log(ex);
      return bl.errorMessage(res);
  }
})
.post(urlEncodedPaser, function(req, res) {
  var company = String(req.body.company);

  //check if company name is valid
  if(!bl.validateCompanyName(company)) {
      return bl.invalidCompany(res);
   }

   try {
       var dl = new dataLayer(company);
       //get the params
       var deptName = String(req.body.dept_name);
       var deptNo = String(req.body.dept_no);
       var location = String(req.body.location);

       //Make the deptNo unique
       if(!deptNo.includes("-" + company)) {
           deptNo = deptNo += "-" + company;
       }

       //make sure parameters are set
       if(deptName !== "" && deptNo !== "-"+company && location !== "") {
           var dept = new dl.Department(company, deptName, deptNo, location);
           dept = dl.insertDepartment(dept);

           if(dept !== null) {
               return bl.messageOk(res, dept);
           } else {
               return bl.badRequest(res, "Department Number already exists")
           }

       } else {
           return bl.badRequest(res, "Invald parameters provided");
       }
   }
   catch(ex) {
       console.log(ex);
       return bl.errorMessage(res);
   }

})
.put(json, function(req, res) {
  var company = req.body.company;

 //check if company name is valid
 if(!bl.validateCompanyName(company)) {
     return bl.invalidCompany(res);
  }

  try {

      var dl = new dataLayer(company);

      //get the dept id if comapny is valid - return bad request if not present
      var deptId = req.body.dept_id;
      if(typeof deptId === 'undefined') {
          return bl.badRequest(res, "Deptartment Id Not provided")
      }

      //if dept Id is good to go, get department
      var oldDept = dl.getDepartment(company, deptId);

      //check to make sure dept is not null
      if(oldDept === null) {
          return bl.errorRequest(res, "Department requested could not be found")
      }

      //get the rest of the params
      var deptName = typeof req.body.dept_name !== 'undefined' ? String(req.body.dept_name) : oldDept.getDeptName();
      var deptNo = typeof req.body.dept_no !== 'undefined' ? String(req.body.dept_no) : oldDept.getDeptNo();
      var location = typeof req.body.location !== 'undefined' ? String(req.body.location) : oldDept.getLocation();

      oldDept.setDeptName(deptName);
      oldDept.setDeptNo(deptNo);
      oldDept.setLocation(location);

      /*dept_no validation: to ensure deptNo is unique, we check to see if it contains '-' and the company name and if not we append the company name*/
      if(!oldDept.getDeptNo().includes("-" + oldDept.getCompany())) {
          oldDept.setDeptNo(oldDept.getDeptNo() + "-" + oldDept.getCompany());
       }

      //to update the department
      var updatedDept = dl.updateDepartment(oldDept);
      
      //if updated department is null, return bad request
      if(updatedDept === null) {
          return bl.badRequest(res, "Requested department does not exist or duplicate department number provided")
      }

      return bl.jsonOk(res, updatedDept);

  }
  catch(ex) {
      console.log(ex);
      return bl.errorMessage(res);
  }
})
// delete
.delete(function(req, res) {
  var company = req.query.company;
  var id = req.query.dept_id;

  // to check if the company name is valid
  if(!bl.validateCompanyName(company)) {
      return bl.invalidCompany(res);
  }

  //validate the department id
  if(typeof id === 'undefined' || id <= 0) {
      return bl.badRequest(res, "No or improper Depratment ID provided")
  }

  try {
      var dl = new dataLayer(company);
      var rows = dl.deleteDepartment(company, id);

      if(rows === 0) {
          return bl.errorRequest(res, "Provided department does not exist for the provided company")
      }

      // if department delete, it's succesful deleted
      return bl.messageOk(res, "Department "+id+" from "+company+" successfully deleted")
  }
  catch(ex) {
      console.log(ex);
      return bl.errorMessage(res);
  }
});

module.exports = router;
