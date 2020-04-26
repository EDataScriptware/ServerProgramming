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

router.route('/') .get(function(req, res) {
        var bl = new businessLayer();

        var company = req.query.company;

        //to check if the company name is valid
        if(!bl.validateCompanyName(company)) {
            return bl.invalidCompany(res);
        }

        try {
            var dl = new dataLayer(company);
            var depts = dl.getAllDepartment(company);

            if(!(depts.length > 0)) {
                return bl.errorRequest(res, "No departments found for company")
            }

            return bl.messageOk(res, depts);
        }
        catch(ex) {
            console.log(ex);
            return bl.errorMessage(res);
        }
    });

module.exports = router;
