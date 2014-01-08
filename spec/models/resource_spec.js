var fs = require("fs");

process.env.NODE_ENV = 'test';
var Resource = require("../../schemas/resource.js").Resource;

describe("Resource", function(){
    var resource = {
        "name": "test_file_server.txt",
        "path": "/tmp/test_file_server.txt"
    };

    beforeEach(function(){
        fs.openSync(resource.path, "w");
    });

    afterEach(function(){
        fs.unlinkSync(resource.path);
    });

    it("returns a empty json", function(done){
        Resource.all(function(items){
            expect(items).toEqual([]);
            done();
        });
    });

    it("uploads an file", function(done){
        Resource.save(resource, function(result){
            expect(result).toEqual({"success": "File was saved."});
            done();
        });
    });

    it("returns json with all resources", function(done){
        Resource.all(function(items){
            expect(items[0].filename).toEqual(resource.name);
            resource.id = items[0]._id.toString();
            done();
        });
    });

    it("shows json with a specifc id", function(done){
        Resource.get(resource.id, function(file){
            expect(file.filename).toEqual(resource.name);
            done();
        });
    });

    it("removes resource with specifc id", function(done){
        Resource.delete(resource.id, function(response){
            expect(response).toEqual({"success": "File was deleted"});
            done();
        });
    });
});