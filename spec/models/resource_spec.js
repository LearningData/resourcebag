process.env.NODE_ENV = 'test';
var Resource = require("../../schemas/resource.js").Resource;

describe("Resource", function(){
    it("returns a empty json", function(){
        var items = Resource.all(function(items){
            return items;
        });

        expect(items).toBe("BLA");
        if(items !== null) console.log("FINISH: " + items[0]);
    });
});