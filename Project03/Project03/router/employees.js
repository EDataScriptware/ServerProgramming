var express = require('express');
var router = express.Router();
var businessLayer = require("../businessLayer.js");
var dataLayer = require("../companydata/index.js");

router.route('/') .get(function(req, res) {
        var bl = new businessLayer();

        var company = req.query.company;

        //to check if the company name is valid
        if(!bl.validateCompanyName(company)) {
            return bl.invalidCompany(res);
        }

        try {
            var dl = new dataLayer(company);
            var emps = dl.getAllEmployee(company);

            if(!(emps.length > 0)) {
                return bl.errorRequest(res, "No employees found for company")
            }

            return bl.jsonOk(res, emps);
        }
        catch(ex) {
            console.log(ex);
            return bl.errorMessage(res);
        }
    });

module.exports = router;
