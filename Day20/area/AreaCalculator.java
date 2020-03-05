package area; 

import javax.ws.rs.core.*;
import javax.ws.rs.*;
import business.*;

public class AreaCalculator
{
   @Context
   UriInfo uriInfo;
   
   @Path("Hello")
   @GET
   @Produces("application/json")
   public Response helloWorld()
   {
      // use our business layer
      BusinessLayer bl = new BusinessLayer();
      return Response.ok("{\"response\":\"" + 
         bl.sayHello() + "\"}").build();
   }
   
   @Path("Hello/{name}")
   @GET 
   @Produces ("application/json")
   public Response helloName(@PathParam("name") String name)
   {
      return Response.ok("{\"response\":\"" + 
         name + "\"}").build();
      
      
   }
   
   @Path("Rectangle")
   @GET
   @Produces("application/xml")
   public Response calcRectangleXML(
      @DefaultValue("1") @QueryParam("width") double width,
      @DefaultValue("1") @QueryParam("length") double length )
   {
      
   
   
      return Response.ok("<area>"+width*length+"</area>").build();
   }
   
   @Path("Rectangle")
   @GET
   @Produces("application/json")
   public Response calcRectangleJSON(
      @DefaultValue("1") @QueryParam("width") double width,
      @DefaultValue("1") @QueryParam("length") double length )
   {
      
   
   
      return Response.ok("{\"area\":\""+width*length+"\"}").build();
   }
   
   @Path("Circle")
   @GET
   @Produces("application/json")
   public Response calcCircle(
      @QueryParam("radius") double radius 
   )
   {

      return Response.ok("{\"area\":\""+radius*radius*Math.PI+"\"}").build();
   }


} // class