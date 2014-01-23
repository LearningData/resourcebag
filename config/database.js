var development = {};
var production = {};
var test = {};
var config = {};

development.server = "localhost";
development.port = 27017;
development.name = "file-server";

test.server = "localhost";
test.port = 27017;
test.name = "file-server-test";

switch(process.env.NODE_ENV) {
case "test":
    console.log("using test database");
    exports.config = test;
    break;
case "production":
    console.log("using production database");
    exports.config = production;
    break;
default:
    console.log("using development database");
    exports.config = development;
    break;
}