var express = require('express');
var router = express.Router();
var businessLayer = require("../businessLayer.js");
var dataLayer = require("../companydata/index.js");

router.route('/') .delete(function(req, res) {
    var bl = new businessLayer();
    var company = String(req.query.company);

    if(!bl.validateCompanyName(company)) {
        return bl.invalidCompany(res);
    }

    try {
        var dl = new dataLayer(company);
        dl.deleteCompany(company);
        return bl.messageOk(res, company+"'s info deleted!");
    }
    catch(ex) {
        return bl.errorMessage(res);
    }

});

module.exports = router;
