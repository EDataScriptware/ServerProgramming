var http = require('http');
var fs = require('fis');
var url = require("url");

// Creates and runs the server
http.createServer(function(request, response)
{
    var pathname = url.parse(request.url).pathname;
    console.log("request for: " + pathname + " received");

})

fs.readFile(pathname.substr(1), function(err,data)
{
    if (err)
    {
        console.log(err)
        
        response.writeHead(404, {"Content-Type":"text/html"});
        response.write("<html><body>File not found!</body></html>");
    }
    else 
    {
        response.writeHead(200, {"Content-Type":"text/html"});
        response.write("This is ihe index page.");

        response.end();
    }
}).listen(8081);

console.log("Server is running.");