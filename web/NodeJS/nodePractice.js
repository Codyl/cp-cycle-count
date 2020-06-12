// var sum = 0;
// for(let i = 2;i<process.argv.length;i++) {
//     sum += Number(process.argv[i]);
// }
// console.log(sum)
// const fs = require('fs');
// const logData = require("./logData")

// fs.readFile(process.argv[2], logData.log)

var http = require('http');
var http = require('url');
var process = require('process');
http.createServer(function onRequest(req, res) {
  res.writeHead(200, {'Content-Type': 'application/json'});
  if(process.env.PATH == "/home")
  {
    res.write('<h1>Welcome to the Home Page</h1>');
  }

  else if(process.env.PATH == "/getData")
  {
      res.json({
          "name":"Br. Lillywhite",
          "class":"cs313"
      });
      res.send(res.json)
  }
  else {
    res.writeHead(404, {'Content-Type': 'text/html'});
      res.write("Page not found");
  }
  res.end();
}).listen(8888);
console.log("working?!")