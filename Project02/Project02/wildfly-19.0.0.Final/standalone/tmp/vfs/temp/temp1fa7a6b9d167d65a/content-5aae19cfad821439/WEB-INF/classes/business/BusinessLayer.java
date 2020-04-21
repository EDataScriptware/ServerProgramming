package business; 

import javax.ws.rs.core.*;
import javax.ws.rs.*;
 
import companydata.*; 


public class BusinessLayer
{
   
   public String departmentJSONFormat(Department department) {
      String jsonString = "{";
      
      jsonString += "\"dept_id\": " + department.getId() + ",";
      jsonString += "\"company\": " + department.getCompany() + ",";
      jsonString += "\"dept_name\": " + department.getDeptName() + ",";
      jsonString += "\"dept_no\": " + department.getDeptNo() + ",";
      jsonString += "\"location\": " + department.getLocation();
               
      jsonString += "}";
      return jsonString;
   }
   
   public String employeeJSONFormat(Employee employee) {
      String jsonString = "{";
      
      jsonString += "\"emp_id\": " + employee.getId() + ",";
      jsonString += "\"emp_name\": " + employee.getEmpName() + ",";
      jsonString += "\"emp_no\": " + employee.getEmpNo() + ",";
      jsonString += "\"emp_hiredate\": " + employee.getHireDate() + ",";
      jsonString += "\"job\": " + employee.getJob() + ",";
      jsonString += "\"salary\": " + employee.getSalary() + ",";
      jsonString += "\"dept_id\": " + employee.getDeptId() + ",";
      jsonString += "\"mng_id\": " + employee.getMngId() + ",";
      
      jsonString += "}";
      return jsonString;
   }
   
   public String timecardJSONFormat(Timecard timecard) {
      String jsonString = "{";
   
      jsonString += "\"timecard_id\": " + timecard.getId() + ",";
      jsonString += "\"start_time\": " + timecard.getStartTime() + ",";
      jsonString += "\"end_time\": " + timecard.getEndTime() + ",";
      jsonString += "\"emp_id\": " + timecard.getEmpId() + ",";
   
      jsonString += "}";
      return jsonString;
   }

   
   
}