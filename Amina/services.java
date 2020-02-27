import companydata.*;
import com.google.gson.*;
import java.util.*;
import java.net.*;
import org.apache.commons.io.*;
import java.nio.charset.StandardCharsets;
import java.util.List;
import java.util.Calendar;
import java.util.Date;
import java.sql.Timestamp;

public class services {

   public static void main(String args[]) {
      DataLayer dl = null;
 //include company in employee no because unique     
      try {
         dl = new DataLayer("bdfvks");
         List<Department> departments = dl.getAllDepartment("bdfvks");  
         List<Employee> employees = dl.getAllEmployee("bdfvks");
         List<Timecard> timecards = dl.getAllTimecard(14);
         GsonBuilder builder = new GsonBuilder();
         Gson gson = builder.create();
         
         
         String QueryParams;
         
         
        /* Department dept = new Department("bdfvks","accounting","d10","new york");
         dept = dl.insertDepartment(dept);
         if (dept.getId() > 0) {
            System.out.println("inserted id: "+ dept.getId());
         } else {
            System.out.println("Not inserted");
         } 
*/
         
         
         //Path: /company
         //Verb: DELETE

         
         //delete all for a company
      /*   
         @Path("/company")
         @DELETE
         @Produces("application/json")
         
         int numRowsDeleted = dl.deleteCompany("esb3618");
         System.out.println("Number of rows deleted: "+numRowsDeleted);
      */
         
         //Path: /department
         //Verb: GET
        /* 
         @Path("/department")
         @GET
         @Produces("application/json")
         QueryParams = "company=bdfvks&1=id";
         
         Department department = dl.getDepartment("bdfvks",1); 
     
         //Print the department details
         System.out.println("\n\nCurrent Department:");
         System.out.println(gson.toJson(department));         
         /*System.out.println(department.getId());
         System.out.println(department.getCompany());
         System.out.println(department.getDeptName());
         System.out.println(department.getDeptNo());
         System.out.println(department.getLocation());*/
      
         //Path: /departments
         //Verb: GET
      /*
         @Path("/departments")
         @GET
         @Produces("application/json")
         QueryParams = "company=bdfvks";
         
         
         for(Department d : departments ){
            System.out.println(gson.toJson(d));         
           /* System.out.println(d.getId());
            System.out.println(d.getCompany());
            System.out.println(d.getDeptName());
            System.out.println(d.getDeptNo());
            System.out.println(d.getLocation());  
            System.out.println("--------\n\n");
         }
      */
         //Path: /department
         //Verb: PUT
         
     /*  
         @Path("/department")
         @PUT
         @Consumes("application/json")
         @Produces("application/json")
         
         Department department = dl.getDepartmentNo("bdfvks","d10"); //CHECK IF EXIST
     
         //Print the department details
         System.out.println("\n\nCurrent Department:");
         System.out.println(gson.toJson(department));  */     

         /*System.out.println(department.getId());
         System.out.println(department.getCompany());
         System.out.println(department.getDeptName());
         System.out.println(department.getDeptNo()); // CHECK UNIQUE
         System.out.println(department.getLocation());*/
         
         //Path: /department
         //Verb: POST
         
         @Path("/department")
         @POST
         @Produces("application/json")
         
         Department department = dl.getDepartment("bdfvks",2); 
    
         
         department.setDeptName("mystery");
         department.setDeptNo("bdfvks_d10"); //CHECK UNIQUE
         department.setLocation("buffalo");
         department = dl.updateDepartment(department);
         
         //Print the updated department details
         System.out.println("\n\nUpdated Department:");
         System.out.println(gson.toJson(department));
         //System.out.println(department.getId());
         //System.out.println(department.getCompany());
         //System.out.println(department.getDeptName());
         //System.out.println(department.getDeptNo());
         //System.out.println(department.getLocation());

         
         //Path: /department
         //Verb: DELETE
         @Path("/department")
         @DELETE
         @Produces("application/json")
         
         QueryParams = "company=bdfvks&dept_id=5";
         
         /*
         
        // department id must exist
        //    and all employees should be deleted first
        int deleted = dl.deleteDepartment("bdfvks",5);
         if (deleted >= 1) {
            System.out.println("\nDepartment deleted");
         } else {
            System.out.println("\nDepartment not deleted");
         } */
         
         //Path: /employee
         //Verb: GET
         @Path("/employee")
         @GET
         @Produces("application/json")
         QueryParams = "company=ritesb3618&emp_id=2";
         
        /* 
         //employee number must exist
         Employee employee = dl.getEmployee(14); 
     
         //Print the employee details
         System.out.println(employee.getId());
         System.out.println(employee.getEmpName());          
         System.out.println(employee.getEmpNo());
         System.out.println(employee.getHireDate());
         System.out.println(employee.getJob()); 
         System.out.println(employee.getSalary());
         System.out.println(employee.getDeptId());
         System.out.println(employee.getMngId());            
         System.out.println("--------\n\n");
         */
         //Path: /employees
         //Verb: GET
         @Path("/employees")
         @GET
         @Produces("application/json")
        /*
         QueryParams = "bdfvks";
         
         for(Employee empl : employees ){
            System.out.println(gson.toJson(empl));                  
            //System.out.println(empl.getId());
            //System.out.println(empl.getEmpName());          
            //System.out.println(empl.getEmpNo());
            //System.out.println(empl.getHireDate());
            //System.out.println(empl.getJob()); 
            //System.out.println(empl.getSalary());
            //System.out.println(empl.getDeptId());
            //System.out.println(empl.getMngId());           
            System.out.println("--------\n\n");
         }
         */
         //Path: /employee
         //Verb: POST
         @Path("/employee")
         @POST
         @Produces("application/json")
         
         /*
            Additional validations: 
               company – must be your RIT username
               dept_id must exist as a Department in your company
               mng_id must be the record id of an existing Employee in your company. Use 0 if the first employee or any other employee that doesn’t have a manager.
               hire_date must be a valid date equal to the current date or earlier (e.g. current date or in the past)
               hire_date must be a Monday, Tuesday, Wednesday, Thursday or a Friday. It cannot be Saturday or Sunday.
               emp_id must be unique amongst all employees in the database, including those of other companies. You may wish to include your RIT user ID in the employee number somehow.
         */
         
         /*
            FormParam
               “company”=”bdfvks”,
               "emp_name"="french",
               "emp_no"="esb3618-e1b",
               "hire_date"="2018-06-16",
               "job"="programmer",
               "salary"=5000.0,
               "dept_id"=1,
               "mng_id"=2 
         */
         
         
        
      /* // manager id must exist as an employee, unless they don't have a manager
         Employee emp = new Employee("TestRun","test01", new java.sql.Date(new java.util.Date().getTime()),"Developer",80000.00, 121, 0);
         emp = dl.insertEmployee(emp);
         if (emp.getId() > 0) {
            System.out.println("inserted id: "+ emp.getId());
         } else {
            System.out.println("Not inserted");
         } 
         */
         
         //Path: /employee
         //Verb: PUT
         @Path("/employee")
         @PUT
         @Consumes("application/json")
         @Produces("application/json")
         /*
         
         employee.setSalary(60000.00);
         employee.setJob("Test Job");
         employee = dl.updateEmployee(employee);
         
         //Print the updated employee details
         System.out.println("\n\nUpdated Employee:");
         System.out.println(employee.getId());
         System.out.println(employee.getEmpName());          
         System.out.println(employee.getEmpNo());
         System.out.println(employee.getHireDate());
         System.out.println(employee.getJob()); 
         System.out.println(employee.getSalary());
         System.out.println(employee.getDeptId());
         System.out.println(employee.getMngId());            
         System.out.println("--------\n\n");
         */
         //Path: /employee
         //Verb: DELETE
         /*
         @Path("/employee")
         @DELETE
         @Produces("application/json")
        // REMEMBER: if a manager, all employees that they manage must be deleted or assigned
        //    to another manager        
         int deletedEmp = dl.deleteEmployee(2);
         if (deletedEmp >= 1) {
            System.out.println("\nEmployee deleted");
         } else {
            System.out.println("\nEmployee not deleted");
         } */
         
         
         //Path: /timecard
         //Verb: GET
         
         /*
         @Path("/timecard")
         @GET
         @Produces("application/json")
         Timecard timecard = dl.getTimecard(1);
         System.out.println("\n\nCurrent Timecard:");
         System.out.println(timecard.getId());
         System.out.println(timecard.getStartTime());          
         System.out.println(timecard.getEndTime());
         System.out.println(timecard.getEmpId());            
         System.out.println("--------\n\n");
         */
         
         //Path: /timecards
         //Verb: GET
         /*
         @Path("/timecards")
         @GET
         @Produces("application/json")
         for(Timecard tcard : timecards ){        
            System.out.println(tcard.getId());
            System.out.println(tcard.getStartTime());          
            System.out.println(tcard.getEndTime());
            System.out.println(tcard.getEmpId());            
            System.out.println("--------\n\n");
         }*/
         
         
         //Path: /timecard
         //Verb: POST
         
         /*
         @Path("/timecard")
         @POST
         @Produces("application/json")
         Timestamp startTime = new Timestamp(new Date().getTime());
         Calendar cal = Calendar.getInstance();
         cal.setTimeInMillis(startTime.getTime());
         cal.add(Calendar.HOUR, 5);
         
         //REMBEMBER: employee must exist
         Timecard tc = new Timecard(startTime,
                  new Timestamp(cal.getTime().getTime()),14);        
         tc = dl.insertTimecard(tc);
         if (tc.getId() > 0) {
            System.out.println("inserted id: "+ tc.getId());
         } else {
            System.out.println("Not inserted");
         }*/

         
         //Path: /timecard
         //Verb: PUT
         
         /*
         @Path("/timecard")
         @PUT
         @Consumes("application/json")
         @Produces("application/json")
         cal.setTimeInMillis(timecard.getStartTime().getTime());
         cal.add(Calendar.HOUR, 8);
         timecard.setEndTime(new Timestamp(cal.getTime().getTime()));
         timecard = dl.updateTimecard(timecard);
         
         System.out.println("\n\nUpdated Timecard:");
         System.out.println(timecard.getId());
         System.out.println(timecard.getStartTime());          
         System.out.println(timecard.getEndTime());
         System.out.println(timecard.getEmpId());            
         System.out.println("--------\n\n");
*/
         
         
         
         //Path: /timecard
         //Verb: DELETE
         
      /*
         @Path("/timecard")
         @DELETE
         @Produces("application/json")
          //REMEMBER: timecard id must exist
         int deletedTC = dl.deleteTimecard(1);
         if (deletedTC >= 1) {
            System.out.println("\nTimecard deleted");
         } else {
            System.out.println("\nTimecard not deleted");
         }        */
      
     
        } catch (Exception e) {
         System.out.println("Problem with query: "+e.getMessage());
      } finally {
         dl.close();
      }
      
   }
   
}
