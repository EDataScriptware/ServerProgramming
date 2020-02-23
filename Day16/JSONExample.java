import java.io.InputStream;
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
      }
      catch (Exception e)
      {
         e.printStackTrace();
      }
      
      
   }
}