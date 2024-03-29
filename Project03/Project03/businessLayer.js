module.exports = class businessLayer 
{
  DEFAULT_COMPANY_NAME = "emr9018";

  validateCompanyName = function(companyName) 
  {
    if(String(companyName) === this.DEFAULT_COMPANY_NAME) 
    {
      return true;
    }
    else 
    {
      return false;
    }
  }

  validateDate(date) 
  {
    try 
    {
      var newDate = new Date(date);

      if(newDate > new Date() || newDate.getUTCDate() === 0 || newDate.getUTCDate === 6) 
      {
        return null;
      } 
      return newDate.getFullYear() + '-' + (newDate.getMonth() + 1) + '-' + (newDate.getDate() + 1);
    }
    catch(ex) 
    {
        console.log(ex)
        return null
    }
  }

  validateTimestamps(start, end, empCards)
  {
    try
    {
      const moment = require('moment');

      var start_time = moment(start);
      var end_time = moment(end);
      const PRESENT = moment();

      if(!((PRESENT.dayOfYear() - start_time.dayOfYear()) <= 7 && PRESENT.diff(start_time) > 0))
      {
        return null;
      }

      var sameDay = (start_time.dayOfYear() === end_time.dayOfYear());

      if(!(moment.duration(end_time.diff(start_time)).asMinutes() > 59 && sameDay))
      {
        return null;
      }

      if(start_time.day() === 0 || start_time.day() === 6 || end_time.day() === 0 || end_time.day() === 6)
      {
        return null;
      }

      if(!(start_time.hours() >= 6 && start_time.hours() <= 17 && end_time.hours() >= 6 && end_time.hours() <= 17))
      {
        return null;
      }

      if(empCards !== null && empCards.length > 0)
      {
        var valid = true;
        empCards.forEach((card) => {
          var compare_date = moment(card.getStartTime());

          if(compare_date.isSame(start_time, 'month') && compare_date.isSame(start_time, 'day') && compare_date.isSame(start_time, 'year'))
          {
            valid = false;
          }
        });

        if(!valid)
        {
          return null;
        }
      }
      return  [start_time.format('YYYY-MM-DD HH:mm:ss'), end_time.format('YYYY-MM-DD HH:mm:ss')];
    }
    catch(ex)
    {
      console.log(ex)
      return null
    }
  }

  invalidCompany(res)
  {
    return res.status(404).json({error: "Unable to locate the company."}).end();
  }

  badRequest(res, msg) 
  {
    return res.status(400).json({error: msg}).end();
  }

  errorRequest(res, msg)
  {
      return res.status(404).json({error: msg}).end();
  }

  errorMessage(res)
  {
      return res.status(500).json({error: "Something went wrong!"}).end();
  }

  messageOk(res, msg)
  {
      return res.status(200).json({success: msg}).end();
  }

  jsonOk(res, json) {
      return res.status(200).json({success: json}).end();
  }
}