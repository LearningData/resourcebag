process.env.NODE_ENV = 'test';

var request = require('supertest');
var fileId = "52b3127e1873d06b0c8c987c";

describe("GET /resources", function() {
    it("returns status code 200");
});

describe("GET /resources/" + fileId, function(){
    it("returns status code 200");
});