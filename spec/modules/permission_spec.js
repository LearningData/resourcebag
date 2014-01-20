process.env.NODE_ENV = 'test';
var Permission = require("../../modules/permissions.js").Permission;

describe("Permission", function() {
    it("returns false", function(done){
        Permission.isAllowed("http://invalid:3000", function(response){
            expect(response).toBe(false);
            done();
        });
    });

    it("returns true", function(done){
        Permission.isAllowed("http://localhost:3000", function(response){
            expect(response).toBe(true);
            done();
        });
    });
});