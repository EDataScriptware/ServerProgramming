package service; 


import java.util.List;
import java.util.Map;
import java.util.Date;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.sql.Timestamp;
import javax.json.*;
import javax.json.stream.*;
import javax.json.stream.JsonParser.*;
import java.io.*;
// import javax.jws.*; "(actually you're getting rid of that)" 15:29 Closed Caption

import companydata.*; 

import javax.ws.rs.core.*;
import javax.ws.rs.*;
import business.*;


@Path("CompanyServices")
public class ProjectTwo
{
   @Context
   UriInfo uriInfo;
   
   @Path("Hello/{name}")
   @GET
   @Produces("application/json")
   public Response helloName(@PathParam("name") String name) 
   {
      return Response.ok("{\"hi\":\"" + name + "\"}").build();
   }
   
}