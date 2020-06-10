// var sum = 0;
// for(let i = 2;i<process.argv.length;i++) {
//     sum += Number(process.argv[i]);
// }
// console.log(sum)
const fs = require('fs');
const logData = require("./logData")

fs.readFile(process.argv[2], logData.log)
