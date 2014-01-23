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

    it("requires an owner", function(done){
        Resource.save(resource, {}, function(result){
            expect(result).toEqual({"fail": "Resource needs an owner"});
            done();
        });
    });

    it("requires a cliendId", function(done){
        Resource.save(resource, {"owner": "test"}, function(result){
            expect(result).toEqual({"fail": "Resource needs a school"});
            done();
        });
    });

    it("requires a file", function(done){
        Resource.save({}, {"owner": "test", "clientId": "client"}, function(result){
            expect(result).toEqual({"fail": "Resource needs a file"});
            done();
        });
    });

    it("uploads an file", function(done){
        Resource.save(resource, {"owner": "test", "clientId": "client"}, function(result){
            expect(result["success"]).toEqual("File was saved.");
            done();
        });
    });

    it("returns resource id", function(done){
        Resource.save(resource, {"owner": "test", "clientId": "client"}, function(result){
            expect(result.id).not.toBeUndefined();
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

    it("returns empty json if invalid id", function(done){
        Resource.get("invalid", function(file){
            expect(file).toEqual({"fail": 'The id invalid is not valid'});
            done();
        });
    });

    it("removes resource with specifc id", function(done){
        Resource.delete(resource.id, function(response){
            expect(response).toEqual({"success": "File was deleted"});
            done();
        });
    });

    it("removes all the resources", function(done){
        Resource.deleteAll(function(response){
            expect(response).toEqual({"success": "Files was deleted"});
            done();
        });
    });
});