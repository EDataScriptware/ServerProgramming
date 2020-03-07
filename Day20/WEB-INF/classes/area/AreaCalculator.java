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
      @QueryParam("radius") 
      double radius)
   {
   
      return Response.ok("{\"area\":\""+radius*radius*Math.PI+"\"}").build();
   }
   
   @Path("Circle")
   @GET
   @Produces("application/json")
   public Response createCircle(
      @QueryParam("radius")
       double radius)
   {
      // create the object and put in DB, we're assuming 
      // id of 1 is returned for db
      // also assuming the link we're returning would actually work
      Circle c = new Circle(radius);
      Link lnk = Link.fromUri(uriInfo.getPath()+"/"+c.id)
         .rel("self").build();
         
      return Response.status(Response.Status.CREATED)
         .location(lnk.getUri()).build();
   
   }

   @Path("Circle")
   @GET
   @Produces("application/json")
   public Response updateCircle(@PathParam("id") int d, Circle circleIn)
   {
      // body comes in as a String, Circle is parsing it, or 
      // you would use String circleIn and parse it yourself
      // do some validation and update in db either case
      boolean exists = true;
      if (!exists)
      {
         return Response.status(Response.Status.NOT_FOUND).build();     
      }
      
      if (circleIn.radius == 0)
      {
         return Response.status(Response.Status.BAD_REQUEST)
            .entity("Bad data passed in").build();     
      }
      return Response.ok("Circle Updated").build();
   }

   @Path("Circle")
   @GET
   @Produces("application/json")
   public Response deleteCircle(@PathParam("id") int d)
   {
      // body comes in as a String, Circle is parsing it, or 
      // you would use String circleIn and parse it yourself
      // do some validation and update in db either case
      boolean exists = true;
      if (!exists)
      {
         return Response.status(Response.Status.NOT_FOUND).build();     
      }
      return Response.ok("Circle Deleted").build();
   }

} // class