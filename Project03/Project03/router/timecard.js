var express = require('express');
var router = express.Router();
var businessLayer = require("../businessLayer.js");
var dataLayer = require("../companydata/index.js");
var json = express.json();
var urlEncodedParser = express.urlencoded({extended:false});

router.route('/') .all(function(req, res, next)
{
        bl = new businessLayer();
        next();
})

.get(function(req, res)
{
  var company = req.query.company;
  var id = req.query.timecard_id;

    try 
    {

        if(!bl.validateCompanyName(company)) 
        {
            return bl.invalidCompany(res);
        }      

        var dl = new dataLayer(company);

        if(!(id > 0)) 
        {
            return bl.badRequest(res, "Invalid timecard id provided");
        }

        var card = dl.getTimecard(id);
          
        if(card !== null)   
        {
            return bl.jsonOk(res, card);
        } 
        else 
        {
            return bl.errorRequest(res, "Timecard ID not found.");
        }
    }
    catch(ex)
    {
        console.log(ex);
        return bl.errorMessage(res);
    }

})

.post(urlEncodedParser, function(req, res)
{
  var company = req.body.company;
  var empId = parseInt(req.body.emp_id);
  var start = req.body.start_time;
  var end = req.body.end_time;

    try
    {
        if(!bl.validateCompanyName(company))
        {
            return bl.invalidCompany(res);
        }

        var dl = new dataLayer(company);
        if(dl.getEmployee(empId) === null) 
        {
            return bl.errorRequest(res, "Employee could not be found.");
        }
        
        var empCards = dl.getAllTimecard(empId);

        var timestamps = bl.buildAndValidateTimestamps(start, end, empCards);
        if(timestamps === null)
        {
          return bl.badRequest(res, "Invalid start and/or end dates.");
        }
      
        var newCard = dl.insertTimecard(new dl.Timecard(timestamps[0], timestamps[1], empId));
      
        if(newCard !== null)
        {
            return bl.jsonOk(res, newCard);
        } 
        else 
        {
            return bl.badRequest(res, "Invalid Timecard parameters received.");
        }
  }
  catch(ex)
  {
      return bl.errorMessage(res);
  }
})

.put(json, function(req, res) 
{
  var company = req.body.company;

    try 
    {
        if(!bl.validateCompanyName(company)) 
        {
            return bl.invalidCompany(res);
        }

      var dl = new dataLayer(company);

        if(typeof req.body.timecard_id === "undefined")
        {
            return bl.badRequest(res, "No timecard Id provided");
        }
      
        var id = parseInt(req.body.timecard_id);

        var oldCard = dl.getTimecard(id);

      
        if(oldCard === null)
        {
              return bl.errorRequest(res, "Could not find timecard id provided");
        }

        var empId = (typeof req.body.emp_id !== "undefined") ? parseInt(req.body.emp_id) : oldCard.getEmpId();
        var start = (typeof req.body.start_time !== "undefined") ? req.body.start_time : oldCard.getStartTime();
        var end = (typeof req.body.end_time !== "undefined") ? req.body.end_time : oldCard.getEndTime();

        oldCard.setEmpId(empId);
        oldCard.setStartTime(start);
        oldCard.setEndTime(end);

        var timestamps = bl.buildAndValidateTimestamps(start, end, null);
        if(timestamps === null) 
        {
          return bl.badRequest(res, "Invalid start and/or end dates.");
        }

        var updatedCard = dl.updateTimecard(oldCard);

        if(updatedCard === null)
        {
            return bl.badRequest(res, "Timecard parameters are invalid and card could not be updated");
        }

      return bl.jsonOk(res, updatedCard);
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
    var id = req.query.timecard_id;

    try
    {
        if(!bl.validateCompanyName(company))
        {
            return bl.invalidCompany(res);
        }

      var dl = new dataLayer(company);

      var deleted = dl.deleteTimecard(id);

        if(deleted > 0)
        {
            return bl.messageOk(res, "Timecard " + id + " deleted.")
        }
        else
        {
            return bl.errorRequest(res, "Timecard ID not found.");
        }
  }
  catch(ex) 
  {
      console.log(ex);
      return bl.errorMessage(res);
  }
});

module.exports = router;
