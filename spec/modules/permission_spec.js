process.env.NODE_ENV = 'test';
var Permission = require("../../modules/permissions.js").Permission;

describe("Permission", function() {
    it("returns false", function(done){
        Permission.isAllowed("http://test.com:3000", "mykey", function(response){
            expect(response).toBe(false);
            done();
        });
    });

    it("returns true", function(done){
        Permission.isAllowed("http://localhost:3000", "mykey", function(response){
            expect(response).toBe(true);
            done();
        });
    });

    it("returns false without a referer", function(done){
        Permission.isAllowed(null, "mykey", function(response){
            expect(response).toBe(false);
            done();
        });
    });

    it("returns false without a referer", function(done){
        Permission.isAllowed("http://localhost:3000", null, function(response){
            expect(response).toBe(false);
            done();
        });
    });
    it("returns false with invalid url", function(done){
        Permission.isAllowed("invalid", "mykey", function(response){
            expect(response).toBe(false);
            done();
        });
    });
});