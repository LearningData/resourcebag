var db = require("../modules/database").db;
var mongo = require("mongodb");
var BSON = mongo.BSONPure;
var GridStore = mongo.GridStore;
var ObjectID = mongo.ObjectID;

var Resource = {
    collection: db.collection("fs.files"),
    all: function(callback) {
        Resource.collection.find().toArray(function(err, items){
            callback(items);
        });
    },
    search: function(param, callback) {
        Resource.collection.find({filename: param}).toArray(function(err, items){
            callback(items);
        });
    },
    show: function(resourceId, callback) {
        resourceId = new BSON.ObjectID(resourceId);

        Resource.collection.findOne({'_id': resourceId}, function(err, resource){
            if(err) {
                console.log("Error to show file " + resourceId);
                return;
            }

            callback(resource);
        });
    },
    save: function(resource, callback) {
        var gridStore = new GridStore(db, new ObjectID(), "w");
        console.log("RES: " + resource);
        gridStore.writeFile(resource.path, function(err, result) {
            if(err) {
                console.log("Error to upload file.");
                result = {"fail": "File was not upload"};
            } else {
                result = {"success": "File was saved."};
            }

            callback(result);
        });
    },
    delete: function(resourceId, callback) {
        resourceId = new BSON.ObjectID(resourceId);

        Resource.collection.remove({'_id':resourceId}, {safe:true}, function(err, result) {
            if (err) {
                callback({"fail": "File was not deleted - " + err});
            } else {
                console.log('' + result + ' file deleted');
                callback({"success": "File was deleted"});
            }
        });
    },
    download: function(resourceId, callback) {
        GridStore.read(db, new BSON.ObjectID(resourceId), function(err, data) {
            if(err) {
                console.log("Error to download file");
            }

            callback(data);
        });
    }
};

exports.Resource = Resource;