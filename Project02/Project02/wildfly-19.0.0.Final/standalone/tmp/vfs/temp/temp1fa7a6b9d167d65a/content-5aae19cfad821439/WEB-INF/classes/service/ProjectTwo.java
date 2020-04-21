package service; 


import java.util.*;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.sql.Timestamp;
import javax.json.*;
import javax.json.stream.*;
import javax.json.stream.JsonParser.*;
import java.io.*;

import com.google.gson.*; // <---- GSON stuff
// import javax.jws.*; "(actually you're getting rid of that)" 15:29 Closed Caption

import companydata.*; 

import javax.ws.rs.core.*;
import javax.ws.rs.*;
import business.*;


@Path("CompanyServices")
public class ProjectTwo
{
   BusinessLayer businessLayer = new BusinessLayer();
   Gson gson = new Gson();
   Department department;
   Employee employee;
   Timecard timecard;
   
   @Context
   UriInfo uriInfo;
   
   
   // 0 - SAMPLE
   @Path("Hello/{name}")
   @GET
   @Produces("application/json")
   public Response helloName(@PathParam("name") String name) 
   {
      return Response.ok("{\"hi\":\"" + name + "\"}").build();
   }
      
   // 4 - delete all companies
   @Path("company")
   @DELETE
   @Produces("application/json")
   public Response deleteAllCompanies(@QueryParam("company") String company)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
   
      try 
      {          
         dataLayer = new DataLayer("emr9018");  
         List<Department> departments = dataLayer.getAllDepartment(company);
         dataLayer.deleteCompany(company);
         
         if(departments.size() > 0) 
         {
            jsonString = "{success: " + company + "'s information deleted}[";
            for(Department dept : departments) 
            {
               jsonString += businessLayer.departmentJSONFormat(dept);
               jsonString += ",";
            }
            jsonString = jsonString.replaceAll(",$", "");
            jsonString += "]";
                    
            return Response.ok(jsonString).build();
         } 
         else 
         {
            return Response.ok("success: all companies deleted!").build();
         }
      }
      catch (Exception e) 
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: " + e.toString()).build();
      } 
      finally 
      {
         dataLayer.close();
      }
   }
   
   // 5 - get specific department
   @Path("department")
   @GET
   @Produces("application/json")
   public Response getSpecificDepartment(@QueryParam("company") String company, @QueryParam("dept_id") int id)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
   
      try
      {      
         dataLayer = new DataLayer("emr9018");  
         List<Department> depts = dataLayer.getAllDepartment(company);
         department = dataLayer.getDepartment(company, id);    
         
         if(depts.size() > 0) 
         {
         
            jsonString = "{\"department\":"+gson.toJson(department)+"}";
            jsonString = jsonString.replaceAll(",$", "");
            
         }
         else
         {
            return Response.ok("success: Get All Departments").build();
         }
      }
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      }
      finally 
      {
         dataLayer.close();
      }
      return Response.ok(jsonString).build();
   }
      
   // 6 - get company departments
   @Path("departments")
   @GET
   @Produces("application/json")
   public Response getCompanyDepartments(@QueryParam("company") String company)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
   
      try 
      {      
         dataLayer = new DataLayer("emr9018");  
         List<Department> departments = new ArrayList<Department>();
         departments = dataLayer.getAllDepartment(company);
             
         for(Department dept : departments) 
         {
            jsonString += businessLayer.departmentJSONFormat(dept);
            jsonString += ",";
         }
         
         jsonString = jsonString.replaceAll(",$", "");
         jsonString += "]";
                  
         return Response.ok(jsonString).build();
      } 
      catch (Exception e) 
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      } 
      finally 
      {
         dataLayer.close();
      }
   }
   
   
   // 7 - update company department
   @Path("department")
   @PUT
   @Consumes("application/json")
   @Produces("application/json")
   public Response updateDepartment(String json)
   {
      DataLayer dataLayer = null;
      Department jDept = gson.fromJson(json, Department.class);
      String company = jDept.getCompany();
      int id = jDept.getId();
      String deptNo = jDept.getDeptNo();
      
      try
      {      
         dataLayer = new DataLayer("emr9018");      
         Department dept = dataLayer.getDepartment(company, id);
        
         if (jDept.getDeptName() != null) 
         {
            dept.setDeptName(jDept.getDeptName());
         }
         else
         {
            return Response.ok("error: unable to recover department name").build();
         }
         if (jDept.getDeptNo() != null)
         {
            dept.setDeptNo(jDept.getDeptNo());
         }
         else
         {
            return Response.ok("error: unable to recover department number").build();
         }
         if (jDept.getLocation() != null)
         {
            dept.setLocation(jDept.getLocation());
         }
         else
         {
            return Response.ok("error: unable to recover department location").build();
         }
         
         dept = dataLayer.updateDepartment(dept);
      }
      catch (Exception e) 
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      } 
      finally
      {
         dataLayer.close();
      }
      return Response.ok("{\"success\":{\"department\":" + department).build();
   }   
   
   // 8 - create a department
   @Path("department")
   @POST
   @Produces("application/json")
   public Response insertCompanyDepartment(@FormParam("company") String company, @FormParam("dept_name") String deptName, @FormParam("dept_no") String deptNo, @FormParam("location") String location)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
      department = new Department(company, deptName, deptNo, location);
      
      try
      {
         dataLayer = new DataLayer("emr9018");
         department = dataLayer.insertDepartment(department);
         if(department.getId() <= 0)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("Failed to add.").build();
         }
      }
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      } 
      finally 
      {
         dataLayer.close();
      }
      return Response.ok("{\"success\":{\"department\":" + department).build();
   }   
   
   // 9 - delete specific department
   @Path("department")
   @DELETE
   @Produces("application/json")
   public Response deleteDepartments(@QueryParam("company") String company, @QueryParam("dept_id") int deptId)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
   
      try 
      {      
         dataLayer = new DataLayer("emr9018");      
         dataLayer.deleteDepartment(company, deptId);
      } 
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      } 
      finally
      {
         dataLayer.close();
      }
      return Response.ok("{\"success\":\"Department " + deptId + " from " + company + " deleted.\"}").build();
   }
      
   // 10 - returns specific employee
   @Path("employee")
   @GET
   @Produces("application/json")
   public Response getEmployee(@QueryParam("company") String company, @QueryParam("emp_id") int empId)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
   
      try 
      {      
         dataLayer = new DataLayer("emr9018");
         Employee emp = dataLayer.getEmployee(empId);
         
         if (emp != null)
         {
            jsonString = "{\"employee\": "+ businessLayer.employeeJSONFormat(emp);
            jsonString += "}";
         }
         else 
         {
            return Response.ok("error: not able to get employee").build();
         }
      
         return Response.ok("{\"success\":" + jsonString).build();
      } 
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      } 
      finally
      {
         dataLayer.close();
      } 
   }
      
   // 11 - gets all employees
   @Path("employees")
   @GET
   @Produces("application/json")
   public Response getCompanyEmployees(@QueryParam("company") String company)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
   
      try 
      {      
         dataLayer = new DataLayer("emr9018");    
         List<Employee> employee = new ArrayList<Employee>();
         employee = dataLayer.getAllEmployee(company);  
         
         for(Employee empl : employee)
         {
            jsonString += businessLayer.employeeJSONFormat(empl);
            jsonString += ",\n";
         }
         
         jsonString = jsonString.replaceAll(",$", "");
         jsonString += "]";
                  
         return Response.ok(jsonString).build();
      }
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      } 
      finally 
      {
         dataLayer.close();
      }
   }


   // 12 - insert a new employee
   @Path("employee")
   @POST
   @Produces("application/json")
   public Response insertEmployee(@FormParam("company") String company, @FormParam("emp_name") String name, @FormParam("emp_no") String empNo, @FormParam("hire_date") String date, @FormParam("job") String job, @FormParam("salary") double salary, @FormParam("dept_id") int deptId, @FormParam("mng_id") int mngId)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
   
      try
      {      
         dataLayer = new DataLayer("emr9018");  
         Date hire_date = new SimpleDateFormat("yyyy-MM-dd").parse(date);
         employee = new Employee(name, empNo, new java.sql.Date(hire_date.getTime()), job, salary, deptId, mngId);    
         Employee empl = dataLayer.getEmployee(employee.getMngId());
      
         if (empl == null)
         {
            return Response.ok("error: manager doesn't exist").build();
         }
                     
         DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
         Date currentDate = new Date();
         Date indate = new SimpleDateFormat("yyyy-MM-dd").parse(date);
      
         if(indate.compareTo(currentDate) > 0)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("Date cannot be in the future.").build();
         }
         
         Calendar c = Calendar.getInstance();
         c.setTime(indate);
         int dayOfWeek = c.get(Calendar.DAY_OF_WEEK);
         if(dayOfWeek == 6 || dayOfWeek == 7)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("Date cannot be on the weekend.").build();
         }
      
         int empId = empl.getId();
         if(empId <= 0)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("Failed to add.").build();
         }
         
         employee = dataLayer.insertEmployee(employee);
         if (employee == null)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("error: It already exists.").build();
         }
      }
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      } 
      finally
      {
         dataLayer.close();
      }
      return Response.ok("{\"success\":" + businessLayer.employeeJSONFormat(employee)).build();
   }
   
   // 13 - updates an employee
   @Path("employee")
   @PUT
   @Consumes("application/json")
   @Produces("application/json")
   public Response updateEmployee(String json)
   {
      DataLayer dataLayer = null;
      
      try
      {  
         JsonReader rdr = Json.createReader(new StringReader(json));
         javax.json.JsonObject jsonObject = rdr.readObject();
         int empId = jsonObject.getInt("emp_id");
         String company = jsonObject.getString("company");
         String emp_name = jsonObject.getString("emp_name");
         String emp_no = jsonObject.getString("emp_no");
         Date hire_date = new SimpleDateFormat("yyyy-MM-dd").parse(jsonObject.getString("hire_date"));         
         String job = jsonObject.getString("job");
         Double salary = jsonObject.getJsonNumber("salary").doubleValue();
         int dept_id = jsonObject.getInt("dept_id");
         int mng_id = jsonObject.getInt("mng_id");
      
         dataLayer = new DataLayer("emr9018");   
         employee = dataLayer.getEmployee(empId);
         employee.setEmpName(emp_name);
         employee.setEmpNo(emp_no);
         employee.setHireDate(new java.sql.Date(hire_date.getTime()));
         employee.setJob(job);
         employee.setDeptId(dept_id);
         employee.setMngId(mng_id);
      	   
         employee = dataLayer.updateEmployee(employee);
      }
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      }
      finally
      {
         dataLayer.close();
      }
      return Response.ok("{\"success\":{\"Employee\":" + businessLayer.employeeJSONFormat(employee)).build();
   }
   
   // 14 - delete employee
   @Path("employee")
   @DELETE
   @Produces("application/json")
   public Response deleteEmployee(@QueryParam("company") String company, @QueryParam("emp_id") int empId)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
   
      try
      {      
         dataLayer = new DataLayer("emr9018");      
         dataLayer.deleteEmployee(empId);
         
      }
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      }
      finally
      {
         dataLayer.close();
      }
      return Response.ok("{\"success\":\"Employee " + empId + " from " + company + " deleted.\"}").build();
   }

   // 15 - get timecard
   @Path("timecard")
   @GET
   @Produces("application/json")
   public Response getTimecard(@QueryParam("company") String company, @QueryParam("timecard_id") int timecardId)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
   
      try
      {      
         dataLayer = new DataLayer("emr9018");      
         Timecard times = dataLayer.getTimecard(timecardId);  
         
         if(times != null)
         {
            jsonString = "{\"timecard\": "+ businessLayer.timecardJSONFormat(times);
            jsonString += "}";
         } 
         else
         {
            return Response.ok("error: not able to get timecard").build();
         }
         
         return Response.ok("{\"success\":" + jsonString).build();
      }
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      }
      finally 
      {
         dataLayer.close();
      }
   }
   
   // 16 - get all timecards
   @Path("timecards")
   @GET
   @Produces("application/json")
   public Response getEmployeeTimecards(@QueryParam("company") String company, @QueryParam("emp_id") int empId)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
   
      try
      {      
         dataLayer = new DataLayer("emr9018");  
         List<Timecard> times = new ArrayList<Timecard>();
         times = dataLayer.getAllTimecard(empId);
         
         if(times.size() > 0)
         {
         
            jsonString = "{\"department\":"+gson.toJson(times)+"}[";
            for (Timecard time : times) 
            {
               jsonString += businessLayer.timecardJSONFormat(time);
               jsonString += ",";
            }
            
            jsonString = jsonString.replaceAll(",$", "");
            jsonString += "]";
         } 
         else
         {
            return Response.ok("error: not able to get all timecard").build();
         }
         
         return Response.ok(jsonString).build();
      } 
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      }
      finally
      {
         dataLayer.close();
      }
   }

   // 17 - insert a timecard
   @Path("timecard")
   @POST
   @Consumes("application/json")
   @Produces("application/json")
   public Response insertTimecard(@FormParam("company") String company, @FormParam("timecard_id") int tcId, @FormParam("start_time") String start, @FormParam("end_time") String end, @FormParam("emp_id") int empId) 
   {
                                  
      DataLayer dataLayer = null;
      String jsonString = "";  
      
      try
      {      
         dataLayer = new DataLayer("emr9018"); 
         Timestamp start_time = new Timestamp(new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(start).getTime());
         Timestamp end_time = new Timestamp(new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(end).getTime());                  
         timecard = new Timecard(tcId, start_time, end_time, empId); 
         Date startDateOnly = new SimpleDateFormat("yyyy-MM-dd").parse(start);
         Date endDateOnly = new SimpleDateFormat("yyyy-MM-dd").parse(end); 
         Date startDate = new Date(start_time.getTime());
         Date endDate = new Date(end_time.getTime()); 
         dataLayer.getTimecard(tcId);
         dataLayer.getEmployee(empId);
                     
         DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
         Date currentDate = new Date();
         
         String sCurrentDate = ""; 
         sCurrentDate = dateFormat.format(currentDate);
         
         Calendar previousWeekDay = Calendar.getInstance();
         previousWeekDay.add(Calendar.WEEK_OF_YEAR, -1);
         Date weekBefore = previousWeekDay.getTime();
         
         if(startDateOnly.compareTo(currentDate) > 0)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("Start time is in the future. That is impossible.").build();
         }
         if(startDateOnly.compareTo(weekBefore) < 0)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("Start time is than more than week old.").build();
         }
         
         long milliseconds1 = start_time.getTime();
         long milliseconds2 = end_time.getTime();
         long diff = milliseconds2 - milliseconds1;
         long hours = diff / (60 * 60 * 1000);
         Calendar calendarEnd = Calendar.getInstance();
         calendarEnd.setTime(endDate);  
         Calendar calendarStart = Calendar.getInstance();
         calendarStart.setTime(startDate);
      
         if(validateDates(calendarStart,calendarEnd) != 0)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("Start time and end time must start and end on the very same day.").build();
         }
         
         if(hours < 1)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("The sum of start and end time must be equal or greater than one hour.").build();
         }
         
         int startDay = calendarStart.get(Calendar.DAY_OF_WEEK);
         int endDay = calendarEnd.get(Calendar.DAY_OF_WEEK);
         
         if(startDay == 6 || startDay == 7)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("Start date cannot start on the weekend. No one likes that.").build();
         }
         
         if(endDay == 6 || endDay == 7)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("End date cannot end on the weekend. No one likes that.").build();
         }
         
         SimpleDateFormat hourFormat = new SimpleDateFormat("HH");
      
         String timeStart = hourFormat.format(startDate);
         int hourStart = Integer.parseInt(timeStart);
      
         String timeEnd = hourFormat.format(endDate);
         int hourEnd = Integer.parseInt(timeEnd);
      
         if(hourStart < 6 || hourStart > 18)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("Start time must be between 06:00:00 (6:00 AM) and 18:00:00 (7:00 PM).").build();
         }
      
         if  (hourEnd < 6 || hourEnd > 18)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("End time must be between 06:00:00 (6:00 AM) and 18:00:00 (7:00 PM).").build();
         }
         
         try
         {
            dataLayer = new DataLayer("emr9018");
            List<Timecard> timecards = new ArrayList<Timecard>();
            timecards = dataLayer.getAllTimecard(empId);
            for(Timecard t : timecards)
            { 
               Timestamp startTemp = t.getStartTime();
               Date startDateTemp = new Date(startTemp.getTime());
               if(startDateTemp.compareTo(startDate) == 1)
               {
                  return Response.status(Response.Status.BAD_REQUEST).entity("One start time per one timecard.").build();
               }
            }
         }
         catch (Exception e)
         {
            return Response.status(Response.Status.NOT_FOUND).build();
         }
         finally
         {
            dataLayer.close();
         }
       
         timecard = dataLayer.insertTimecard(timecard);
         
         if (timecard.getId() <= 0)
         {
            return Response.status(Response.Status.BAD_REQUEST).entity("error: It already has existed.").build();
         }
      }
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      } 
      finally
      {
         dataLayer.close();
      }
      return Response.ok("{\"success\":{\"timecard\":" + businessLayer.timecardJSONFormat(timecard)).build();
   
   }
   
   // 18 - updates timecard
   @Path("timecard")
   @PUT
   @Consumes("application/json")
   @Produces("application/json")
   public Response updateTimecard(String json)
   {
      DataLayer dataLayer = null;
   
      try
      {  
         JsonReader rdr = Json.createReader(new StringReader(json));
         javax.json.JsonObject jsonObject = rdr.readObject();
        
         String company = jsonObject.getString("company");
         int empId = jsonObject.getInt("emp_id");
         String start = jsonObject.getString("start_time");
         String end = jsonObject.getString("end_time");
         int timeId = jsonObject.getInt("timecard_id");
      
         dataLayer = new DataLayer("emr9018");
         Timecard timeObj = new Timecard();
         timecard = dataLayer.getTimecard(timeId);
         timecard.setStartTime(timeObj.getStartTime());
         timecard.setEndTime(timeObj.getEndTime());
         timecard.setEmpId(empId);
      	   
         timecard = dataLayer.updateTimecard(timecard);
      }
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      }
      finally
      {
         dataLayer.close();
      }
      return Response.ok("{\"success\":{\"Timecard\":" + businessLayer.timecardJSONFormat(timecard)).build();
   }
   
   // 19 - delete timecard
   @Path("timecard")
   @DELETE
   @Produces("application/json")
   public Response deleteTimecard(@QueryParam("company") String company, @QueryParam("timecard_id") int timecardId)
   {
      DataLayer dataLayer = null;
      String jsonString = "";
   
      try
      {      
         dataLayer = new DataLayer("emr9018");   
         dataLayer.deleteTimecard(timecardId);   
         
      }
      catch (Exception e)
      {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: "+ e.toString()).build();
      } 
      finally 
      {
         dataLayer.close();
      }
      return Response.ok("{\"success\":\"Timecard " + timecardId + " from " + company + " deleted.\"}").build();
   }
   
   private int validateDates(Calendar calendarOne, Calendar calendarTwo)
   {
      if (calendarOne.get(Calendar.YEAR) != calendarTwo.get(Calendar.YEAR)) 
      {
         return calendarOne.get(Calendar.YEAR) - calendarTwo.get(Calendar.YEAR);
      }
      if (calendarOne.get(Calendar.MONTH) != calendarTwo.get(Calendar.MONTH)) 
      {
         return calendarOne.get(Calendar.MONTH) - calendarTwo.get(Calendar.MONTH);
      }   
      return calendarOne.get(Calendar.DAY_OF_MONTH) - calendarTwo.get(Calendar.DAY_OF_MONTH);
   }

}