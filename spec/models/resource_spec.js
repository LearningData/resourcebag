var fs = require("fs");

process.env.NODE_ENV = 'test';
var Resource = require("../../schemas/resource.js").Resource;
var resource = new Resource();

describe("Resource", function(){
    var resourceParams = {
        "name": "test_file_server.txt",
        "path": "/tmp/test_file_server.txt"
    };

    beforeEach(function(){
        fs.openSync(resourceParams.path, "w");
    });

    afterEach(function(){
        fs.unlinkSync(resourceParams.path);
    });

    it("returns a empty json", function(done){
        resource.all(function(items){
            expect(items).toEqual([]);
            done();
        });
    });

    it("requires an owner", function(done){
        resource.save(resourceParams, {}, function(result){
            expect(result).toEqual({"fail": "Resource needs an owner"});
            done();
        });
    });

    it("requires a cliendId", function(done){
        resource.save(resourceParams, {"owner": "test"}, function(result){
            expect(result).toEqual({"fail": "Resource needs a school"});
            done();
        });
    });

    it("requires a file", function(done){
        resource.save({}, {"owner": "test", "clientId": "client"}, function(result){
            expect(result).toEqual({"fail": "Resource needs a file"});
            done();
        });
    });

    it("uploads an file", function(done){
        resource.save(resourceParams, {"owner": "test", "clientId": "client"}, function(result){
            expect(result["success"]).toEqual("File was saved.");
            done();
        });
    });

    it("returns resourceParams id", function(done){
        resource.save(resourceParams, {"owner": "test", "clientId": "client"}, function(result){
            expect(result.id).not.toBeUndefined();
            done();
        });
    });

    it("returns json with all resourceParamss", function(done){
        resource.all(function(items){
            expect(items[0].filename).toEqual(resourceParams.name);
            resourceParams.id = items[0]._id.toString();
            done();
        });
    });

    it("shows json with a specifc id", function(done){
        resource.get(resourceParams.id, function(file){
            expect(file.filename).toEqual(resourceParams.name);
            done();
        });
    });

    it("returns empty json if invalid id", function(done){
        resource.get("invalid", function(file){
            expect(file).toEqual({"fail": 'The id invalid is not valid'});
            done();
        });
    });

    it("removes resourceParams with specifc id", function(done){
        resource.delete(resourceParams.id, function(response){
            expect(response).toEqual({"success": "File was deleted"});
            done();
        });
    });

    it("removes all the resourceParamss", function(done){
        resource.deleteAll(function(response){
            expect(response).toEqual({"success": "Files was deleted"});
            done();
        });
    });
});