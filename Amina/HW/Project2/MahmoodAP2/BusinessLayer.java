package MahmoodAP2;

import companydata.*;

import java.util.List;
import java.util.Calendar;
import java.util.Date;
import java.sql.Timestamp;

public class BusinessLayer {

   public String departmentToJSON(Department dept) {
      String json = "{";
      
      json += "\"dept_id\": " + dept.getId() + ",";
      json += "\"company\": " + dept.getCompany() + ",";
      json += "\"dept_name\": " + dept.getDeptName() + ",";
      json += "\"dept_no\": " + dept.getDeptNo() + ",";
      json += "\"location\": " + dept.getLocation();
      
      json += "}";
      return json;
   }
   
      public String employeeToJSON(Employee empl) {
      String json = "{";
      
      json += "\"emp_id\": " + empl.getId() + ",";
      json += "\"emp_name\": " + empl.getEmpName() + ",";
      json += "\"emp_no\": " + empl.getEmpNo() + ",";
      json += "\"emp_hiredate\": " + empl.getHireDate() + ",";
      json += "\"job\": " + empl.getJob() + ",";
      json += "\"salary\": " + empl.getSalary() + ",";
      json += "\"dept_id\": " + empl.getDeptId() + ",";
      json += "\"mng_id\": " + empl.getMngId() + ",";
      
      json += "}";
      return json;
   }
   
//       public String timecardToJSON(Timecard dept) {
//       String json = "{";
//       
//       json += "\"dept_id\": " + timecard.getId() + ",";
//       json += "\"company\": " + timecard.getStartTime() + ",";
//       json += "\"dept_name\": " + timecard.getEndTime() + ",";
//       json += "\"dept_no\": " + timecard.getEmpId() + ",";
//       
//       json += "}";
//       return json;
//    }
}