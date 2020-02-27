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

import java.util.List;
import java.util.Calendar;
import java.util.Date;
import java.sql.Timestamp;

 @Path("CompanyServices")
public class CompanyServices {

   private BusinessLayer bl = new BusinessLayer();
   private DataLayer dl = null;
   private Gson gson = new Gson();
   private Department dept = null;
   private Employee emp = null;
   private Timecard tc = null;
   
   @Context
   UriInfo uriInfo;
   
   / 
   @Path("/company")
   @GET
   @Produces("application/json")
   public Response deleteAllCompanies(@PathParam("company") String company) {
      
      try{
         dl = new DataLayer("axm6392");
         dl.deleteCompany(company);
         
      }
      catch {
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      }
      finally {
         dl.close();
      }
      return Response.ok("{\"success\":\"" + company + "'s information deleted.\"}").build();
   } // end deleteAllCompanies
   */
   
   @Path("/department")
   @GET
   @Produces("application/json")
   public Response getDepartment(@QueryParam("company") String company, @QueryParam("dept_id") int id){

      try {      
         dl = new DataLayer("axm6392");   
         dept = dl.getDepartment(company, id);   
      } 
      catch (Exception e) {
      	return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      } 
      finally {
      	 dl.close();
      }
      return Response.ok("{\"department\":" + gson.toJson(dept) + "}").build();
   } // end getDepartment
/
   @Path("/departments")
   @GET
   @Produces("application/json")
   public Response getCompanyDepartments(@QueryParam("company") String company){
      
      String response = "[";
      try{
         dl = new DataLayer("axm6392");
         List<Department> departments = new List<Department>();
         departments = dl.getAllDepartment(company);
         for(Department d : departments){ 
            response += "{\"department\":" + gson.toJson(d) + "},";
         }
         
         response = response.substring(0, response.length() - 1);
         response += "]";
      }
      catch(Exception e){
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      }
      finally{
	      dl.close();
      }
      return Response.ok(response).build();
   }
   
   @Path("/department")
   @PUT
   @Consumes("application/json")
   @Produces("application/json")
   public Response updateDepartment(String json){
      dept = gson.fromJson(json, Department.class);
      String company = dept.getCompany();
      int id = dept.getId();
      String no = dept.getDeptNo();
      
      try{
         dl = new DataLayer("axm6392");
         dl.getDepartment(company, id);
      }
      catch(Exception e){
         return Response.status(Response.Status.BAD_REQUEST).entity("error: Department does not exist.").build();
      }
      finally{
	      dl.close();
      }
      // Check if dept_no exists already
      try{
         dl = new DataLayer("axm6392");
         dl.getDepartment(company, no);
         return Response.status(Response.Status.BAD_REQUEST).entity("Department with this 'dept_id' already exists.").build();
      }
      catch(Exception e){
         // Do nothing
      }
      finally{
	      dl.close();
      }
      // Update
      try{
         dl = new DataLayer("axm6392");
         dl.updateDepartment(dept);  
      }
      catch(Exception e){
          return Response.status(Response.Status.BAD_REQUEST).entity("Failed to update.").build();
      }
      finally{
	      dl.close();
      }
      return Response.ok("{\"success\":{\"department\":" + gson.toJson(dept) + "}}").build();
   }
   
   @Path("/department")
   @POST
   @Produces("application/json")
   public Response addDepartment(@FormParam("company") String company, @FormParam("dept_name") String name, @FormParam("dept_no") String no, @FormParam("location") String loc){
      dept = new Department(company, name, no, location);
      // Check if dept_no exists already (we don't want this)
      try{
         dl = new DataLayer("axm6392");
         dl.getDepartment(company, no);
         return Response.status(Response.Status.BAD_REQUEST).entity("Error: Department with this 'dept_no' already exists.").build();
      }
      catch(Exception e){
         // Do nothing
      }
      finally{
	      dl.close();
      }
      // Add
      try{
         dl = new DataLayer("axm6392"); 
         dept = dl.insertDepartment(dept);
         if(dept.getId() <= 0){
            return Response.status(Response.Status.BAD_REQUEST).entity("Failed to add.").build();
         }
      }
      catch(Exception e){
          return Response.status(Response.Status.BAD_REQUEST).entity("Failed to add.").build();
      }
      finally{
	      dl.close();
      }
      return Response.ok("{\"success\":{\"department\":" + gson.toJson(dept) + "}}").build();
   }
   
   @Path("/department")
   @DELETE
   @Produces("application/json")
   public Response deleteDepartment(@QueryParam("company") String company, @QueryParam("dept_id") int id){
      try{
         dl = new DataLayer("axm6392");
         dl.deleteDepartment(company, id);
      }
      catch(Exception e){
         return Response.status(Response.Status.NOT_FOUND).build();
      }
      finally{
	      dl.close();
      }
      return Response.ok("{\"success\":\"Department " + id + " from " + company + " deleted.\"}").build();
   }
   */
  
   @Path("/employees")
   @GET
   @Produces("application/json")
   public Response getEmployee(@QueryParam("emp_id") int id){
      try{
         dl = new DataLayer("axm6392");
         emp = dl.getEmployee(id);  
      }
      catch(Exception e){
         return Response.status(Response.Status.NOT_FOUND).build();
      }
      finally{
	      dl.close();
      }
      return Response.ok("{\"employee\":" + gson.toJson(emp) + "}").build();
   }
   
   @Path("/employees")
   @GET
   @Produces("application/json")
   public Response getCompanyEmployees(@QueryParam("company") String company){
      String response = "[";
      try{
         dl = new DataLayer("axm6392");
         List<Employee> employees = new List<Employee>();
         employees = dl.getAllEmployee(company);
         for(Employee e : employees){ 
            response += "{\"employee\":" + gson.toJson(e) + "},";
         }

         response = response.substring(0, response.length() - 1);
         response += "]";
      }
      catch(Exception e){
         return Response.status(Response.Status.NOT_FOUND).build();
      }
      finally{
	      dl.close();
      }
      return Response.ok(response).build();
   }
   
   @Path("/employee")
   @POST
   @Produces("application/json")
   public Response addEmployee(@FormParam("company") String company, 
                               @FormParam("emp_name") String name, 
                               @FormParam("emp_no") String no, 
                               @FormParam("hire_date") Date date, 
                               @FormParam("job") String job, 
                               @FormParam("salary") double salary, 
                               @FormParam("dept_id") String deptId, 
                               @FormParam("mng_id") String mngId){
      emp = new Employee(comany, name, no, date, job, salary, deptId, mngId);
      int empId = emp.getId();
      // Get the company from the emp_no
      String company = no.substring(0, no.indexOf("-"));
      // Check if dept_id exists (we want this)
      try{
         dl = new DataLayer("axm6392");
         dl.getDepartment(company, deptId);
      }
      catch(Exception e){
         return Response.status(Response.Status.BAD_REQUEST).entity("error: 'dept_id' does not exist.").build();
      }
      finally{
	      dl.close();
      }
      // Check if mng_id exists (we want this)
      try{
         dl = new DataLayer("axm6392");
         dl.getEmployee(company, mngId);
      }
      catch(Exception e){
         return Response.status(Response.Status.BAD_REQUEST).entity("error: 'mng_id' does not exist.").build();
      }
      finally{
	      dl.close();
      }
      // Check date is not after current date
      DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
	   Date currentDate = new Date();
	   currentDate = dateFormat.format(currentDate); 
      if(date.compareTo(currentDate) > 0){
         return Response.status(Response.Status.BAD_REQUEST).entity("Date cannot be in the future.").build();
      }
      // Check date is not a weekend
      Calendar c = Calendar.getInstance();
      c.setTime(date);
      int dayOfWeek = c.get(Calendar.DAY_OF_WEEK);
      if(dayOfWeek == 6 || dayOfWeek == 7){
         return Response.status(Response.Status.BAD_REQUEST).entity("Date cannot be on the weekend.").build();
      }
      // Check if emp_id exists already (we don't want this)
      try{
         dl = new DataLayer("axm6392");
         dl.getEmployee(empId);
         return Response.status(Response.Status.BAD_REQUEST).entity("error: Employee with this 'emp_id' already exists.").build();
      }
      catch(Exception e){
         // Do nothing
      }
      finally{
	      dl.close();
      }
      // Add
      try{
         dl = new DataLayer("axm6392"); 
         emp = dl.insertEmployee(emp);
         if(emp.getId() <= 0){
            return Response.status(Response.Status.BAD_REQUEST).entity("Failed to add.").build();
         }
      }
      catch(Exception e){
          return Response.status(Response.Status.BAD_REQUEST).entity("Failed to add.").build();
      }
      finally{
	      dl.close();
      }
      return Response.ok("{\"success\":{\"employee\":" + gson.toJson(emp) + "}}").build();
   }
   
   @Path("/employee")
   @PUT
   @Consumes("application/json")
   @Produces("application/json")
   public Response updateEmployee(String json){
      emp = gson.fromJson(json, Employee.class);
      
      int empId = emp.getId();
      String empName = emp.getEmpName();
      String no = emp.getEmpNo();
      Date date = emp.getHireDate();
      int deptId = emp.getDeptId();
      int mngId = emp.getMngId();
      // Get the company from the emp_no
      String company = no.substring(0, no.indexOf("-"));
      // Check if employee exists (we want this)
      try{
         dl = new DataLayer("axm6392");
         dl.getEmployee(empId);
      }
      catch(Exception e){
         return Response.status(Response.Status.BAD_REQUEST).entity("error: Employee does not exist.").build();
      }
      finally{
	      dl.close();
      }
      // Check if dept_id exists (we want this)
      try{
         dl = new DataLayer("axm6392");
         dl.getDepartment(company, deptId);
      }
      catch(Exception e){
         return Response.status(Response.Status.BAD_REQUEST).entity("error: 'dept_id' does not exist.").build();
      }
      finally{
	      dl.close();
      }
      // Check if mng_id exists (we want this)
      try{
         dl = new DataLayer("axm6392");
         dl.getEmployee(company, mngId);
      }
      catch(Exception e){
         return Response.status(Response.Status.BAD_REQUEST).entity("error: 'mng_id' does not exist.").build();
      }
      finally{
	      dl.close();
      }
      // Check date is not after current date
      DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
	   Date currentDate = new Date();
	   currentDate = dateFormat.format(currentDate); 
      if(date.compareTo(currentDate) > 0){
         return Response.status(Response.Status.BAD_REQUEST).entity("Date cannot be in the future.").build();
      }
      // Check date is not a weekend
      Calendar c = Calendar.getInstance();
      c.setTime(date);
      int dayOfWeek = c.get(Calendar.DAY_OF_WEEK);
      if(dayOfWeek == 6 || dayOfWeek == 7){
         return Response.status(Response.Status.BAD_REQUEST).entity("Date cannot be on the weekend.").build();
      }
      // Update
      try{
         dl = new DataLayer("axm6392");
         dl.updateEmployee(emp);  
      }
      catch(Exception e){
          return Response.status(Response.Status.BAD_REQUEST).entity("Failed to update.").build();
      }
      finally{
	      dl.close();
      }
      return Response.ok("{\"success\":{\"employee\":" + gson.toJson(dept) + "}}").build();
   } // end updateEmployee
   
   @Path("/employee")
   @DELETE
   @Produces("application/json")
   public Response deleteEmployee(@QueryParam("emp_id") int id){
      try{
         dl = new DataLayer("axm6392");
         dl.deleteEmployee(id);
      }
      catch(Exception e){
         return Response.status(Response.Status.NOT_FOUND).build();
      }
      finally{
	      dl.close();
      }
      return Response.ok("{\"success\":\"Employee " + id + " deleted.\"}").build();
   } // end deleteEmployee
   
   @Path("/timecard")
   @GET
   @Produces("application/json")
   public Response getTimecardId(@QueryParam("timecard_id") int id){
      try{
         dl = new DataLayer("axm6392");
         tc = dl.getTimecard(id);  
      }
      catch(Exception e){
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      }
      finally{
	      dl.close();
      }
      return Response.ok("{\"timecard\":" + gson.toJson(tc) + "}").build();
   } // end getTimecardId
   
   @Path("/timecards")
   @GET
   @Produces("application/json")
   public Response getTimecardsId(@QueryParam("emp_id") int id){
      String response = "[";
      try{
         dl = new DataLayer("axm6392");
         List<Timecard> timecards = new List<Timecard>();
         timecards = dl.getAllTimecard(id);
         for(Timecard t : timecards){ 
            response += "{\"timecard\":" + gson.toJson(t) + "},";
         }
         
         response = response.substring(0, response.length() - 1);
         response += "]";
      }
      catch(Exception e){
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      }
      finally{
	      dl.close();
      }
      return Response.ok(response).build();
   } //end getTimecardsId
   
   @Path("/timecard")
   @POST
   @Produces("application/json")
   public Response addTimecard(@FormParam("timecard_id") int tcId, @FormParam("emp_id") int empId, @FormParam("start_time") Timestamp start,  @FormParam("end_time") Timestamp end){
      tc = new Timecard(tcId, start, end, empId);
      Date startDate = new Date(start.getTime());
      Date endDate = new Date(end.getTime());
      // Check if timecard exists (we want this)
      try{
         dl = new DataLayer("axm6392");
         dl.getTimecard(tcId);
      }
      catch(Exception e){
         return Response.status(Response.Status.BAD_REQUEST).entity("error: Timecard does not exist.").build();
      }
      finally{
	      dl.close();
      }
      // Check if employee exists (we want this)
      try{
         dl = new DataLayer("axm6392");
         dl.getEmployee(empId);
      }
      catch(Exception e){
         return Response.status(Response.Status.BAD_REQUEST).entity("error: Employee does not exist.").build();
      }
      finally{
	      dl.close();
      }
      // Check start is equal to or one week before current date
      DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
	   Date currentDate = new Date();
	   currentDate = dateFormat.format(currentDate);
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
      if(hours < 1){
         return Response.status(Response.Status.BAD_REQUEST).entity("Start and end time must be at least an hour apart.").build();
      }
      // Check start and end date are not on a weekend
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
      // Check start date is not on the same day as another start date
      try{
         dl = new DataLayer("axm6392");
         List<Timecard> timecards = new List<Timecard>();
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
      // Add
      try{
         dl = new DataLayer("axm6392"); 
         tc = dl.insertEmployee(tc);
         if(tc.getId() <= 0){
            return Response.status(Response.Status.BAD_REQUEST).entity("Failed to add.").build();
         }
      }
      catch(Exception e){
          return Response.status(Response.Status.BAD_REQUEST).entity("Failed to add.").build();
      }
      finally{
	      dl.close();
      }
      return Response.ok("{\"success\":{\"timecard\":" + gson.toJson(tc) + "}}").build();
   } // end 
   
   @Path("/timecard")
   @PUT
   @Consumes("application/json")
   @Produces("application/json")
   public Response updateTimecard(String json){
      tc = gson.fromJson(json, Timecard.class);
      int empId = tc.getId();
      Timestamp start = tc.getStartTime();
      Timestamp end = tc.getEndTime();
      Date startDate = new Date(start.getTime());
      Date endDate = new Date(end.getTime());
      // Check if employee exists (we want this)
      try{
         dl = new DataLayer("axm6392");
         dl.getEmployee(empId);
      }
      catch(Exception e){
         return Response.status(Response.Status.BAD_REQUEST).entity("error: Employee does not exist.").build();
      }
      finally{
	      dl.close();
      }
      // Check start is equal to or one week before current date
      DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
	   Date currentDate = new Date();
	   currentDate = dateFormat.format(currentDate);
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
      if(hours < 1){
         return Response.status(Response.Status.BAD_REQUEST).entity("Start and end time must be at least an hour apart.").build();
      }
      // Check start and end date are not on a weekend
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
      // Check start date is not on the same day as another start date
      try{
         dl = new DataLayer("axm6392");
         List<Timecard> timecards = new List<Timecard>();
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
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      }
      finally{
	      dl.close();
      }
      // Update
      try{
         dl = new DataLayer("axm6392");
         dl.updateTimecard(tc);  
      }
      catch(Exception e){
          return Response.status(Response.Status.BAD_REQUEST).entity("Failed to update.").build();
      }
      finally{
	      dl.close();
      }
      return Response.ok("{\"success\":{\"timecard\":" + gson.toJson(tc) + "}}").build();
   } // end
   
   @Path("/timecard")
   @DELETE
   @Produces("application/json")
   public Response deleteTimecard(@QueryParam("timecard_id") int id){
      try{
         dl = new DataLayer("axm6392");
         dl.deleteTimecard(id);
      }
      catch(Exception e){
         return Response.status(Response.Status.INTERNAL_SERVER_ERROR).entity("error: Something went wrong.").build();
      }
      finally{
	      dl.close();
      }
      return Response.ok("{\"success\":\"Timecard " + id + " deleted.\"}").build();
   } // end deleteTimecard
   */
} // end CompanyServices class