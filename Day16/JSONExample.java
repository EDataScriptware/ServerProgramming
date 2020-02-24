import java.io.InputStream;
import java.io.StringWriter;
import java.net.URL;

import javax.json.*;
import javax.json.stream.*;
import javax.json.stream.JsonParser.*;

public class JSONExample 
{
   public static void main(String[] args)
   {
      try 
      {
        URL url = new URL("http://www.ist.rit.edu/~bdfvks/454/nationalParks.php?type=json");
        
         InputStream is = url.openStream();

         JsonReader rdr = Json.createReader(is);

         // JsonReader rdr = Json.createReader(new StringReader("youJSONString")); // we have an existing variable above.

         JsonObject obj = rdr.readObject();
         JsonArray parks = obj.getJsonArray("parks");

         for(JsonObject park : parks.getValuesAs(JsonObject.class))
         {
            System.out.print(park.getString("parkName"));
            System.out.print(": ");
            System.out.println(park.getString("parkLocation"));
            
         }
         System.out.println("Done...!");

         is = url.openStream();
         JsonParser parser = Json.createParser(is);

         while (parser.hasNext() )
         {
            Event e = parser.next();
            if (e == Event.KEY_NAME)
            {
               switch (parser.getString() )
               {
                  case "parkName":
                     parser.next();
                     System.out.print(parser.getString() + ": ");
                  break;
                  case "parkLocation":
                     parser.next();
                     System.out.println(parser.getString());
                  break;
                  default: 

                  break;

               }
            }
         } // end while loop

         StringWriter swriter = new StringWriter();
         try (JsonGenerator gen = Json.createGenerator(swriter))
         {
            gen.writeStartObject();
            gen.writeStartArray("parks");

            for (int i=0; i<4; i++)
            {
               gen.writeStartObject()
               .write("parkName", "Park " + (i+1))
               .write("parkLocation", "Location " + (i+1))
               .writeEnd(); // string

            }
            gen.writeEnd(); // array
            gen.writeEnd(); // object
         }
         
         System.out.println(swriter.toString());
         

      }
      catch (Exception e)
      {
         e.printStackTrace();
      }
      
      
   }
}