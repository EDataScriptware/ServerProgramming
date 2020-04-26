var express = require('express');
var router = express.Router();
var businessLayer = require("../businessLayer.js");
var dataLayer = require("../companydata/index.js");

/*
* Amina Mahmood
* Project 3 Node
* ISTE 341 - Server Programming
* Professor Bryan French
*/

/* GET home page. */
router.route('/') .get(function(req, res) {
        var bl = new businessLayer();

        var company = req.query.company;
        var empId = parseInt(req.query.emp_id);

        //to check if the company name is valid
        if(!bl.validateCompanyName(company)) {
            return bl.invalidCompany(res);
        }

        try {
            var dl = new dataLayer(company);
            
            if(dl.getEmployee(empId) != null) {
            
                var cards = dl.getAllTimecard(empId);
                
                if(cards.length > 0) {
                   
                   return bl.jsonOk(res, cards);
                   
                } else {
                   return bl.errorRequest(res, "No timecards found for requested employee");
                }
             } else {
                return bl.errorRequest(res, "Employee ID Not Found");
             }
        }
        catch(ex) {
            console.log(ex);
            return bl.errorMessage(res);
        }
    });

module.exports = router;
