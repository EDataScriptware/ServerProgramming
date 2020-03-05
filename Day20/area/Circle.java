package area;

public class Circle 
{

   // need to be public for Response to convert to JSON
   // or you would need a method to get JSON. 
   // and call that for Response
   
   public double radius;
   public int id;
   public double area;
   
   public Circle(double r)
   {
      id = 1; // normally would come from db
      radius = r;
      area = Math.PI*radius*radius;   
   }
   
   public Circle()
   {
      // needed for deserialization
   }
   
   
   
   
}