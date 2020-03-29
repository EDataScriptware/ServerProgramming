using System.Collections.Generic;
using Microsoft.AspNetCore.Mvc;
using ProductService.Models;

namespace ProductService.Controllers
{
    [ApiController]
    [Route("[controller]")]

    public class ProductController : Controller
    {

        private List<Product> products = new List<Product>();

        public ProductController()
        {
            CreateProducts();
        }

        private void CreateProducts()
        {
            // for (int i = 1; i <= 5; i++)
            // {
            //     products.Add(new Product(){Name = "Product"+i, Id=i});
            // }
            products.Add(new Product(){Name = "Apples", Id=1, Cost=3.99M});
            products.Add(new Product(){Name = "Peaches", Id=2, Cost=4.05M});
            products.Add(new Product(){Name = "Pumpkin", Id=3, Cost=13.99M});
            products.Add(new Product(){Name = "Apples", Id=4, Cost=8.00M});

        }

       /* [HttpGet]
        public IEnumerable<Product> GetAll()
        {
            return this.products;
        }
*/

        [HttpGet(Name="getNames")]
        public string getNames(long id, string code)
        {
            string result = "";
            for (int i = 0; products.Capacity > i; i++)
            {
                result += products[i].Name + " has a cost of $" + products[i].Cost + "\n";
            }

            return (result);
        }
  
        [HttpGet("Cheapest", Name="getCheapest")]
        public string getCheapest(long id, string code)
        {
            string result = "";

            int targetID = products[0].Id;
            string cheapestName = products[0].Name;
            decimal cheapestCost = products[0].Cost; 

            foreach(Product product in products)
            {
                if(product.Cost <= cheapestCost)
                {
                    cheapestCost = product.Cost;
                    targetID = product.Id;
                    cheapestName = product.Name;
                }
            }

            result = cheapestName + " is the cheapest with the cost of $" + cheapestCost;
            return (result);
        }

        [HttpGet("Costliest", Name="getCostliest")]
        public string getCostliest(long id, string code)
        {
            string result = "";
            int targetID = products[0].Id;
            string expensiveName = products[0].Name;
            decimal expensiveCost = products[0].Cost; 

            foreach(Product product in products)
            {
                if(product.Cost >= expensiveCost)
                {
                    expensiveCost = product.Cost;
                    targetID = product.Id;
                    expensiveName = product.Name;
                }
            }

            result = expensiveName + " is the costliest with the cost of $" + expensiveCost;
            return (result);
        }
        
        [HttpGet("{productName}", Name="getPrice")]
        public string getPrice(string productName, string code)
        {

            decimal foundCost = 0.00M;
            string result;
            foreach(Product productList in products)
            {
                if (productName.ToLower() == productList.Name.ToLower())
                {
                    foundCost = productList.Cost;
                    result = "$" + foundCost + " is the cost for " + productName;
                    return (result);
                }
            }
            return ("Error! Unable to find the cost for " + productName + "!");


        }


        /////////
        /*
        [HttpGet("{id}", Name="GetProduct")]
        public IActionResult GetById(long id)
        {
            Product product = products.Find(x=>x.Id == id);
            if (product == null)
            {
                return NotFound();
            }
            return new ObjectResult(product);
        }

        [HttpPost]
        public IActionResult Create([FromBody] Product product)
        {
            if (product == null || !ModelState.IsValid)
            {
                return BadRequest();
            } 

            // normally we'd validate more and insert into a database
            // and return a link to a new resource but in our case
            // the link won't actually point to anything
            // return 201 status code
            return CreatedAtRoute("GetProduct", new {id=product.Id}, product);
        }

        [HttpPut("{id}")]
        public IActionResult Update(long id, [FromBody] Product product)
        {
            if (product == null || product.Id != id || !ModelState.IsValid)
            {
                return BadRequest();
            } 
            if (!products.Exists(x=>x.Id == id))
            {
                return NotFound();
            }

            // validate further and save changes, return a 204. 
            return new NoContentResult();
        }

        [HttpPut("{id}")]
        public IActionResult Delete(long id)
        {
            if (!products.Exists(x=>x.Id == id))
            {
                return NotFound();
            }

            // here we would delete from database, etc
            return new NoContentResult();
 
        }

        [HttpGet("test/{id}")]
        public string test(long id, string code)
        {
            return ("id: " + id + "c = " + code);
    
        }


      

       */

    } // class

} //namespace

/*
[Route("somepath/{id}/{code=code}")]
[HttpGet]
*/