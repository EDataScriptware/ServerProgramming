/**
 * Amina Mahmood
 * Mr. French
 * ISTE-341 - Project 2
 * CompanyServices 
 */
package MahmoodAP2;
 
import companydata.*;

import javax.ws.rs.core.*;
import javax.ws.rs.*;
import com.google.gson.*;

import java.util.*;
import java.io.*;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.sql.Timestamp;
import javax.json.*;
import javax.json.stream.*;
import javax.json.stream.JsonParser.*;
//import javax.json.JsonObject;

@Path("CompanyServices")
public class CompanyServices {

   BusinessLayer bl = new BusinessLayer();
   private Gson gson = new Gson();
   private Department dept = null;
   private Employee emp = null;
   private Timecard tc = null;
   
   @Context
   UriInfo uriInfo;
   
   @Path("company")
   @DELETE
   @Produces("application/json")
   public Response deleteAllCompanies(@QueryParam("company") String company){
      DataLayer dl = null;
      String json = "";
   
      try {          
         dl = new DataLayer("axm6392");  
         List<Department> depts = dl.getAllDepartment(company);
         dl.deleteCompany(company);
         
         if(depts.size() > 0) {
            
            
            json = "{success: "+company+"'s information deleted}[";
            for(Department dept : depts) {
               json += bl.departmentToJSON(dept);
               json += ",";//seperate json objects
            }
         
            json = json.replaceAll(",$", "");
            json += "]";//close the array
            
            return Response.ok(json).build();
         } else {
            return Response.ok("success: all company deleted").build();
         }
         
       
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
   
   }//end deleteAllCompanies
   
   @Path("department")
   @GET
   @Produces("application/json")
   public Response getDepartment(@QueryParam("company") String company, @QueryParam("dept_id") int id){
      DataLayer dl = null;
      String json = "";
   
      try {      
         dl = new DataLayer("axm6392");  
         List<Department> depts = dl.getAllDepartment(company);
         dept = dl.getDepartment(company, id);    
         
         if(depts.size() > 0) {
         
            json = "{\"department\":"+gson.toJson(dept)+"}[";
            for(Department dept : depts) {
               json += bl.departmentToJSON(dept);
               json += ",";//seperate json objects
            }
            
            json = json.replaceAll(",$", "");
            json += "]";//close the array
            
         } else {
            return Response.ok("success: get all department").build();
         }
         //return Response.ok(json).build();
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
      return Response.ok(json).build();
   }// end getDepartment
   
   @Path("departments")
   @GET
   @Produces("application/json")
   public Response getCompanyDepartments(@QueryParam("company") String company){
      DataLayer dl = null;
      String json = "";
   
      try {      
         dl = new DataLayer("axm6392");  
         List<Department> departments = new ArrayList<Department>();
         departments = dl.getAllDepartment(company);
             
         for(Department dept : departments) {
            json += bl.departmentToJSON(dept);
            json += ",";//seperate json objects
         }
         
         json = json.replaceAll(",$", "");
         json += "]";//close the array 
         
         return Response.ok(json).build();
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
   
   }//end getCompanyDepartments
   
   @Path("department")
   @POST
   @Produces("application/json")
   public Response insertCompanyDepartment(@FormParam("company") String company, @FormParam("dept_name") String deptName, @FormParam("dept_no") String deptNo, @FormParam("location") String location){
      DataLayer dl = null;
      String json = "";
      dept = new Department(company, deptName, deptNo, location);
      
      try {
         dl = new DataLayer("axm6392");
         dept = dl.insertDepartment(dept);
         if(dept.getId() <= 0){
            return Response.status(Response.Status.BAD_REQUEST).entity("Failed to add.").build();
         }
      }
      catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } 
      finally {
         dl.close();
      }
      return Response.ok("{\"success\":{\"department\":" + dept).build();
   }//end createCompanyDepartment
   
   @Path("department")
   @PUT
   @Consumes("application/json")
   @Produces("application/json")
   public Response updateDepartment(String json){
      DataLayer dl = null;
      //String json = null;
      Department jDept = gson.fromJson(json, Department.class);
      String company = jDept.getCompany();
      int id = jDept.getId();
      String deptNo = jDept.getDeptNo();
      
      try {      
         dl = new DataLayer("axm6392");      
        /* Debug */ Department dept = dl.getDepartment(company, id);
         //see what additional fields are in the json besides id and company
         //then call dept.set... for each one
         /* Debug */
         if (jDept.getDeptName() != null) 
         {
            dept.setDeptName(jDept.getDeptName());
         } else {
            return Response.ok("error: not able to get DeptName").build();
         }
         if (jDept.getDeptNo() != null)
         {
            dept.setDeptNo(jDept.getDeptNo());
         } else {
            return Response.ok("error: not able to get DeptNo").build();
         }
         //else
         if (jDept.getLocation() != null)
         {
            dept.setLocation(jDept.getLocation());
         } else {
            return Response.ok("error: not able to get location").build();
         }
         
         //else
         //then call the update method in the datalayer using the dept object that you called the set nethods on
         dept = dl.updateDepartment(dept);
         //you need to return dept to json
       
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
      // Check if dept_no exists already you don't need this part
   //       try{
   //          dl = new DataLayer("axm6392");
   //          dl.getDepartmentNo(company, deptNo);
   //          return Response.status(Response.Status.BAD_REQUEST).entity("Department with this 'dept_id' already exists.").build();
   //       }
   //       catch(Exception e){
   //          // Do nothing
   //       }
   //       finally{
   // 	      dl.close();
   //       }
      
      return Response.ok("{\"success\":{\"department\":" + dept).build();
   }//end updateDepartment
   
   @Path("department")
   @DELETE
   @Produces("application/json")
   public Response deleteDepartments(@QueryParam("company") String company, @QueryParam("dept_id") int deptId){
      DataLayer dl = null;
      String json = null;
   
      try {      
         dl = new DataLayer("axm6392");      
         dl.deleteDepartment(company, deptId);
      } 
      catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } 
      finally {
         dl.close();
      }
      return Response.ok("{\"success\":\"Department " + deptId + " form " + company + " deleted.\"}").build();
   }//end deleteDepartments
   
   @Path("employee")
   @GET
   @Produces("application/json")
   public Response getEmployee(@QueryParam("company") String company, @QueryParam("emp_id") int empId){
      DataLayer dl = null;
      String json = "";
      BusinessLayer bl = new BusinessLayer();
   
      try {      
         dl = new DataLayer("axm6392");
         Employee emp = dl.getEmployee(empId);
         
         if (emp != null) {
            json = "{\"employee\": "+ bl.employeeToJSON(emp);
            json += "}";
         } else {
            return Response.ok("error: not able to get employee").build();
         }
      
         //return your json here
         return Response.ok("{\"success\":" + json).build();
      } 
      catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } 
      finally {
         dl.close();
      } 
   }//end getEmployee
   
   /*8. Returns the requested list of Employees.*/
   @Path("employees")
   @GET
   @Produces("application/json")
   public Response getCompanyEmployees(@QueryParam("company") String company){
      DataLayer dl = null;
      String json = "";
   
      try {      
         dl = new DataLayer("axm6392");    
         List<Employee> employee = new ArrayList<Employee>();
         employee = dl.getAllEmployee(company);  
         
         for(Employee empl : employee) {
            json += bl.employeeToJSON(empl);
            json += ",\n";//seperate json objects
         }
         
         json = json.replaceAll(",$", "");
         json += "]";//close the array
         
         
         return Response.ok(json).build();
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
   
   }//end getCompanyEmployees
 
 
   @Path("employee")
   @POST
   @Produces("application/json")
   public Response insertEmployee(@FormParam("company") String company,                                  
                                  @FormParam("emp_name") String name, 
                                  @FormParam("emp_no") String empNo, 
                                  @FormParam("hire_date") String date,
                                  @FormParam("job") String job,
                                  @FormParam("salary") double salary,
                                  @FormParam("dept_id") int deptId,
                                  @FormParam("mng_id") int mngId){
      DataLayer dl = null;
      String json = "";
      //Department jDept = gson.fromJson(json, Department.class);
      //Employee jEmpl = gson.fromJson(json, Employee.class);
      //you need to convert the string date paramater to date before the next line
     
     // String comp = ; //just use the parameter
      //int id = jDept.getId();
   
      try {      
         dl = new DataLayer("axm6392");  
         Date hire_date = new SimpleDateFormat("yyyy-MM-dd").parse(date);
         emp = new Employee(name, empNo, new java.sql.Date(hire_date.getTime()), job, salary, deptId, mngId);    
         Employee empl = dl.getEmployee(emp.getMngId());
      
         if (empl == null) {
          //  empl.setMngId(empl.getMngId()); 
          //there is an error unless this is the first employee
            return Response.ok("error: manager doesn't exist").build();
         
         }
                     
         // Check date is not after current date
         DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
         Date currentDate = new Date();
         Date indate = new SimpleDateFormat("yyyy-MM-dd").parse(date);
      
         //currentDate = dateFormat.format(currentDate); 
         if(indate.compareTo(currentDate) > 0){
            return Response.status(Response.Status.BAD_REQUEST).entity("Date cannot be in the future.").build();
         }
         
         // Check date is not a weekend
         Calendar c = Calendar.getInstance();
         c.setTime(indate);
         int dayOfWeek = c.get(Calendar.DAY_OF_WEEK);
         if(dayOfWeek == 6 || dayOfWeek == 7){
            return Response.status(Response.Status.BAD_REQUEST).entity("Date cannot be on the weekend.").build();
         }
      
         int empId = empl.getId();
         if(empId <= 0){
            return Response.status(Response.Status.BAD_REQUEST).entity("Failed to add.").build();
         }
         
         emp = dl.insertEmployee(emp);
         if (emp == null) {
            return Response.status(Response.Status.BAD_REQUEST).entity("error: It already has existed.").build();
         }
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
      return Response.ok("{\"success\":" + bl.employeeToJSON(emp)).build();
   }//end createEmployee
   
   @Path("employee")
   @PUT
   @Consumes("application/json")
   @Produces("application/json")
   public Response updateEmployee(String json){
      DataLayer dl = null;
      
      try {  
         JsonReader rdr = Json.createReader(new StringReader(json));
         javax.json.JsonObject obj = rdr.readObject();
         int empId = obj.getInt("emp_id");
         String company = obj.getString("company");
         String emp_name = obj.getString("emp_name");
         String emp_no = obj.getString("emp_no");
         Date hire_date = new SimpleDateFormat("yyyy-MM-dd").parse(obj.getString("hire_date"));         
         String job = obj.getString("job");
         Double salary = obj.getJsonNumber("salary").doubleValue();
         int dept_id = obj.getInt("dept_id");
         int mng_id = obj.getInt("mng_id");
      
         dl = new DataLayer("axm6392");   
         emp = dl.getEmployee(empId);
         emp.setEmpName(emp_name);
         emp.setEmpNo(emp_no);
         emp.setHireDate(new java.sql.Date(hire_date.getTime()));
         emp.setJob(job);
         emp.setDeptId(dept_id);
         emp.setMngId(mng_id);
      	   
         emp = dl.updateEmployee(emp);
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
      return Response.ok("{\"success\":{\"Employee\":" + bl.employeeToJSON(emp)).build();
   }//end updateEmployee
   
   @Path("employee")
   @DELETE
   @Produces("application/json")
   public Response deleteEmployee(@QueryParam("company") String company, @QueryParam("emp_id") int empId){
      DataLayer dl = null;
      String json = "";
   
      try {      
         dl = new DataLayer("axm6392");      
         dl.deleteEmployee(empId);
         
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
      return Response.ok("{\"success\":\"Employee " + empId + " form " + company + " deleted.\"}").build();
   }//end deleteEmployee
   
   @Path("timecard")
   @GET
   @Produces("application/json")
   public Response getTimecard(@QueryParam("company") String company, @QueryParam("timecard_id") int timecardId){
      DataLayer dl = null;
      String json = "";
   
      try {      
         dl = new DataLayer("axm6392");      
         //List<Timecard> times = dl.getAllTimecard(timecardId);
         Timecard times = dl.getTimecard(timecardId);  
         
         if(times != null) {
         
            //json = "{\"timecard\":"+gson.toJson(times)+"}[";
               
            //for(Timecard time : times) {
               //json += bl.timecardToJSON(tc);
               //json += ",";//seperate json objects
            //}
            
            json = "{\"timecard\": "+ bl.timecardToJSON(times);
            json += "}";
            
            //json = json.replaceAll(",$", "");
            //json += "]";//close the array
         } else{
            return Response.ok("error: not able to get timecard").build();
         }
         
         return Response.ok("{\"success\":" + json).build();
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
      //return Response.ok(json).build();
   }//end getTimecard
   
   @Path("timecards")
   @GET
   @Produces("application/json")
   public Response getEmployeeTimecards(@QueryParam("company") String company, @QueryParam("emp_id") int empId){
      DataLayer dl = null;
      String json = "";
   
      try {      
         dl = new DataLayer("axm6392");  
         List<Timecard> times = new ArrayList<Timecard>();
         times = dl.getAllTimecard(empId);
         
         /*
         
         List<Department> departments = new ArrayList<Department>();
         departments = dl.getAllDepartment(company);
         
         */ 
         
         if(times.size() > 0) {
         
            json = "{\"department\":"+gson.toJson(times)+"}[";
            for(Timecard time : times) {
               json += bl.timecardToJSON(time);
               json += ",";//seperate json objects
            }
            
            json = json.replaceAll(",$", "");
            json += "]";//close the array 
         } else {
            return Response.ok("error: not able to get all timecard").build();
         }
         
         return Response.ok(json).build();
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
   
   }//end getEmployeetimecards
   
   @Path("timecard")
   @POST
   @Consumes("application/json")
   @Produces("application/json")
   public Response insertTimecard(@FormParam("timecard_id") int tcId, 
                                  @FormParam("emp_id") int empId, 
                                  @FormParam("start_time") Timestamp start, 
                                  @FormParam("end_time") Timestamp end){
                                  
                                  //make sure start is of type Date
      DataLayer dl = null;
      String json = "";  
      tc = new Timecard(tcId, start, end, empId); 
      Date startDate = new Date(start.getTime());
      Date endDate = new Date(end.getTime());
      try {      
         dl = new DataLayer("axm6392");  
         dl.getTimecard(tcId);
         dl.getEmployee(empId);
                     
         // Check date is not after current date
         DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
         Date currentDate = new Date();
         
         String sCurrentDate = ""; 
         sCurrentDate = dateFormat.format(currentDate);
         
         
      
         Calendar previousWeekDay = Calendar.getInstance();
         previousWeekDay.add(Calendar.WEEK_OF_YEAR, -1);
         Date weekBefore = previousWeekDay.getTime();
         
         if(startDate.compareTo(currentDate) > 0){
            return Response.status(Response.Status.BAD_REQUEST).entity("Start time cannot be in the future.").build();
         }
         if(startDate.compareTo(weekBefore) < 0){
            return Response.status(Response.Status.BAD_REQUEST).entity("Start time cannot be later than a week old.").build();
         }
         
         // Check end is one hour greater than start and on same date
         long milliseconds1 = start.getTime();
         long milliseconds2 = end.getTime();
         long diff = milliseconds2 - milliseconds1;
         long hours = diff / (60 * 60 * 1000);
         if(startDate.compareTo(endDate) != 1){
            return Response.status(Response.Status.BAD_REQUEST).entity("Start and end time must be on the same day.").build();
         }
         
         if(hours < 1) {
            return Response.status(Response.Status.BAD_REQUEST).entity("Start and end time must be at least an hour apart.").build();
         }
         
         Calendar cStart = Calendar.getInstance();
         cStart.setTime(startDate);
         int dayOfWeekStart = cStart.get(Calendar.DAY_OF_WEEK);
         if(dayOfWeekStart == 6 || dayOfWeekStart == 7){
            return Response.status(Response.Status.BAD_REQUEST).entity("Start date cannot be on the weekend.").build();
         }
         Calendar cEnd = Calendar.getInstance();
         cEnd.setTime(endDate);
         int dayOfWeekEnd = cEnd.get(Calendar.DAY_OF_WEEK);
         if(dayOfWeekEnd == 6 || dayOfWeekEnd == 7){
            return Response.status(Response.Status.BAD_REQUEST).entity("End date cannot be on the weekend.").build();
         }
         // Check start and end are between 06:00:00 and 18:00:00
         SimpleDateFormat hourFormat = new SimpleDateFormat("HH");
         String timeStart = hourFormat.format(startDate);
         int hourStart = Integer.parseInt(timeStart);
         if(hourStart < 6 || hourStart > 18){
            return Response.status(Response.Status.BAD_REQUEST).entity("Start time must be between 06:00:00 and 18:00:00.").build();
         }
         String timeEnd = hourFormat.format(endDate);
         int hourEnd = Integer.parseInt(timeEnd);
         if(hourEnd < 6 || hourEnd > 18){
            return Response.status(Response.Status.BAD_REQUEST).entity("End time must be between 06:00:00 and 18:00:00.").build();
         }
         
         try{
            dl = new DataLayer("axm6392");
            List<Timecard> timecards = new ArrayList<Timecard>();
            timecards = dl.getAllTimecard(empId);
            for(Timecard t : timecards){ 
               Timestamp startTemp = t.getStartTime();
               Date startDateTemp = new Date(startTemp.getTime());
               if(startDateTemp.compareTo(startDate) == 1){
                  return Response.status(Response.Status.BAD_REQUEST).entity("Start date cannot be on the same date as another Timecard.").build();
               }
            }
         }
         catch(Exception e){
            return Response.status(Response.Status.NOT_FOUND).build();
         }
         finally{
            dl.close();
         }
       
         tc = dl.insertTimecard(tc);
         if (tc.getId() <= 0) {
            return Response.status(Response.Status.BAD_REQUEST).entity("error: It already has existed.").build();
         }
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
      return Response.ok("{\"success\":{\"timecard\":" + bl.timecardToJSON(tc)).build();
   
   }//end createTimecard
   
   @Path("timecard")
   @PUT
   @Consumes("application/json")
   @Produces("application/json")
   public Response updateTimecard(String json){
      DataLayer dl = null;
      Timecard timeObj = new Timecard();
   
      try {  
         JsonReader rdr = Json.createReader(new StringReader(json));
         javax.json.JsonObject obj = rdr.readObject();
         String company = obj.getString("company");
         int timeId = obj.getInt("timecard_id");
         String start = obj.getString("start_time");
         //Timestamp start = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(obj.getString("start_time"));
         String end = obj.getString("end_time");
         int empId = obj.getInt("emp_id");
         //DateFormat df = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        
       //String startDate_string = df.format(timeObj.getStartTime()); 
          //String endDate_string = df.format(timeObj.getEndTime());
         
         dl = new DataLayer("axm6392");
         tc = dl.getTimecard(timeId);
         tc.setStartTime(timeObj.getStartTime());
         tc.setEndTime(timeObj.getEndTime());
         tc.setEmpId(empId);
      	   
         tc = dl.updateTimecard(tc);
      } catch (Exception e) {
         System.out.println(e);
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
      return Response.ok("{\"success\":{\"Employee\":" + bl.timecardToJSON(tc)).build();
   }//end updateTimecard
   
   @Path("timecard")
   @DELETE
   @Produces("application/json")
   public Response deleteTimecard(@QueryParam("company") String company, @QueryParam("timecard_id") int timecardId){
      DataLayer dl = null;
      String json = "";
   
      try {      
         dl = new DataLayer("axm6392");   
         dl.deleteTimecard(timecardId);   
         
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
      return Response.ok("{\"success\":\"Timecard " + timecardId + " form " + company + " deleted.\"}").build();
   }//end deleteTimecard
}// end CompanyServices class