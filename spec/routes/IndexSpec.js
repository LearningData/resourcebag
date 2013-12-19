var request = require('supertest');
var express = require('express');

var app = express();

// app.get('/', function(req, res){
//   res.send(200, {});
// });

describe("GET /", function() {
    it("returns status code 200", function(done) {
        expect(app.get("/")).toBe(200);
        expect(true).toBe(true);
    });
});