process.env.NODE_ENV = 'test';
var Resource = require("../../schemas/resource.js").Resource;

describe("Resource", function(){
    var resource = {
        "name": "test_file_server.txt",
        "path": "/tmp/test_file_server.txt"
    };

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
});