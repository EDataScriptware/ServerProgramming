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
            for (int i = 1; i <= 5; i++)
            {
                products.Add(new Product(){Name = "Product"+i, Id=i});
            }
        }

        [HttpGet]
        public IEnumerable<Product> GetAll()
        {
            return this.products;
        }

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

    } // class

} //namespace

/*
[Route("somepath/{id}/{code=code}")]
[HttpGet]
*/