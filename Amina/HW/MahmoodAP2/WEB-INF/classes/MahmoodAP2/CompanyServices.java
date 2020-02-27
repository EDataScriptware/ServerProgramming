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
      Department jDept = gson.fromJson(json, Department.class);
      String company = jDept.getCompany();
      int id = jDept.getId();
      String deptNo = jDept.getDeptNo();
      
      try {      
         dl = new DataLayer("axm6392");      
        Department dept = dl.getDepartment(company, id);
        
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
         if (jDept.getLocation() != null)
         {
            dept.setLocation(jDept.getLocation());
         } else {
            return Response.ok("error: not able to get location").build();
         }
         
         dept = dl.updateDepartment(dept);
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
      return Response.ok("{\"success\":{\"department\":" + dept).build();
   }//end updateDepartment
   
   @Path("department")
   @DELETE
   @Produces("application/json")
   public Response deleteDepartments(@QueryParam("company") String company, @QueryParam("dept_id") int deptId){
      DataLayer dl = null;
      String json = "";
   
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
      
         return Response.ok("{\"success\":" + json).build();
      } 
      catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } 
      finally {
         dl.close();
      } 
   }//end getEmployee
   
   //Returns the requested list of Employees.
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
   
      try {      
         dl = new DataLayer("axm6392");  
         Date hire_date = new SimpleDateFormat("yyyy-MM-dd").parse(date);
         emp = new Employee(name, empNo, new java.sql.Date(hire_date.getTime()), job, salary, deptId, mngId);    
         Employee empl = dl.getEmployee(emp.getMngId());
      
         if (empl == null) {
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
      
         // Add
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
         Timecard times = dl.getTimecard(timecardId);  
         
         if(times != null) {
            json = "{\"timecard\": "+ bl.timecardToJSON(times);
            json += "}";
         } else{
            return Response.ok("error: not able to get timecard").build();
         }
         
         return Response.ok("{\"success\":" + json).build();
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
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
   public Response insertTimecard(@FormParam("company") String company,
                                  @FormParam("timecard_id") int tcId, 
                                  @FormParam("start_time") String start, 
                                  @FormParam("end_time") String end,
                                  @FormParam("emp_id") int empId) {
                                  
      DataLayer dl = null;
      String json = "";  
      
      try {      
         dl = new DataLayer("axm6392"); 
         Timestamp start_time = new Timestamp(new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(start).getTime());
         Timestamp end_time = new Timestamp(new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(end).getTime());                  
         tc = new Timecard(tcId, start_time, end_time, empId); 
         Date startDateOnly = new SimpleDateFormat("yyyy-MM-dd").parse(start);
         Date endDateOnly = new SimpleDateFormat("yyyy-MM-dd").parse(end); 
         Date startDate = new Date(start_time.getTime());
         Date endDate = new Date(end_time.getTime()); 
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
         
         if(startDateOnly.compareTo(currentDate) > 0){
            return Response.status(Response.Status.BAD_REQUEST).entity("Start time cannot be in the future.").build();
         }
         if(startDateOnly.compareTo(weekBefore) < 0){
            return Response.status(Response.Status.BAD_REQUEST).entity("Start time cannot be later than a week old.").build();
         }
         
         // Check end is one hour greater than start and on same date
         long milliseconds1 = start_time.getTime();
         long milliseconds2 = end_time.getTime();
         long diff = milliseconds2 - milliseconds1;
         long hours = diff / (60 * 60 * 1000);
         Calendar cEnd = Calendar.getInstance();
         cEnd.setTime(endDate);  
         Calendar cStart = Calendar.getInstance();
         cStart.setTime(startDate); 
          if(myCompare(cStart,cEnd) != 0){
            return Response.status(Response.Status.BAD_REQUEST).entity("Start and end time must be on the same day.").build();
         }
         
         if(hours < 1) {
            return Response.status(Response.Status.BAD_REQUEST).entity("Start and end time must be at least an hour apart.").build();
         }
         

         int dayOfWeekStart = cStart.get(Calendar.DAY_OF_WEEK);
         if(dayOfWeekStart == 6 || dayOfWeekStart == 7){
            return Response.status(Response.Status.BAD_REQUEST).entity("Start date cannot be on the weekend.").build();
         }

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
   
      try {  
         JsonReader rdr = Json.createReader(new StringReader(json));
         javax.json.JsonObject obj = rdr.readObject();
        
         String company = obj.getString("company");
         int empId = obj.getInt("emp_id");
         String start = obj.getString("start_time");
         String end = obj.getString("end_time");
         int timeId = obj.getInt("timecard_id");

//you need to get the current timecard first instad of new TimreCard 
         dl = new DataLayer("axm6392");
         Timecard timeObj = new Timecard();
         tc = dl.getTimecard(timeId);
         //those are strings, you'll have to convert them like in insert
         tc.setStartTime(timeObj.getStartTime());
        // tc.setStartTime(start);
         tc.setEndTime(timeObj.getEndTime());
         tc.setEmpId(empId);
      	   
         tc = dl.updateTimecard(tc);
      } catch (Exception e) {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } finally {
         dl.close();
      }
      return Response.ok("{\"success\":{\"Timecard\":" + bl.timecardToJSON(tc)).build();
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
   
   private int myCompare(Calendar c1, Calendar c2) {
    if (c1.get(Calendar.YEAR) != c2.get(Calendar.YEAR)) 
        return c1.get(Calendar.YEAR) - c2.get(Calendar.YEAR);
    if (c1.get(Calendar.MONTH) != c2.get(Calendar.MONTH)) 
        return c1.get(Calendar.MONTH) - c2.get(Calendar.MONTH);
    return c1.get(Calendar.DAY_OF_MONTH) - c2.get(Calendar.DAY_OF_MONTH);
  }
   
}// end CompanyServices class