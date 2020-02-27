package MahmoodAP2;

import companydata.*;

import java.util.List;
import java.util.Calendar;
import java.util.Date;
import java.sql.Timestamp;

public class BusinessLayer {
   
   // departmentToJSON
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
   
   // employeeToJSON
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
   
   // timecardToJSON
   public String timecardToJSON(Timecard timec) {
   String json = "{";
   
   json += "\"timecard_id\": " + timec.getId() + ",";
   json += "\"start_time\": " + timec.getStartTime() + ",";
   json += "\"end_time\": " + timec.getEndTime() + ",";
   json += "\"emp_id\": " + timec.getEmpId() + ",";
   
   json += "}";
   return json;
}

}