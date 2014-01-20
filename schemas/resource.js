var db = require("../modules/database").db;
var mongo = require("mongodb");
var BSON = mongo.BSONPure;
var GridStore = mongo.GridStore;
var ObjectID = mongo.ObjectID;

var Resource = {
    all: function(callback) {
        db.open(function(err, db) {
            if(!err) {
                db.collection("fs.files").find().toArray(function(err, items){
                    db.close();
                    callback(items);
                });
            }
        });
    },
    search: function(param, callback) {
        db.open(function(err, db) {
            db.collection("fs.files").find(param).toArray(function(err, items){
                db.close();
                callback(items);
            });
        });
    },
    get: function(resourceId, callback) {
        var id = new BSON.ObjectID(resourceId);
        db.open(function(err, db) {
            db.collection("fs.files").findOne({'_id': id}, function(err, resource){
                db.close();

                if(err) {
                    console.log("Error to show file " + resourceId);
                    callback({"fail": "The id " + resourceId + " does not exist."});
                }

                callback(resource);
            });
        });
    },
    save: function(resource, params, callback) {
        db.close();
        if(!params.owner) {
            callback({"fail": "Resource needs an owner"});
            return;
        }
        if(!params.clientId) {
            callback({"fail": "Resource needs a school"});
            return;
        }
        db.open(function(err, db) {
            params["content_type"] = resource.type;

            var gridStore = new GridStore(db, new ObjectID(),
                resource.name, "w", {"metadata": params});

            gridStore.writeFile(resource.path, function(err, result) {
                db.close();

                if(err) {
                    console.log("Error to upload file.");
                    result = {"fail": "File was not upload"};
                } else {
                    result = {"success": "File was saved."};
                }

                callback(result);
            });
        });
    },
    delete: function(resourceId, callback) {
        db.open(function(err, db) {
            resourceId = new BSON.ObjectID(resourceId);

            db.collection("fs.files").remove({'_id':resourceId}, {safe:true}, function(err, result) {
                db.close();

                if (err) {
                    callback({"fail": "File was not deleted - " + err});
                } else {
                    callback({"success": "File was deleted"});
                }
            });
        });
    },
    deleteAll: function(callback) {
        db.close();
        db.open(function(err, db) {
            db.collection("fs.files").remove({}, function(err, result) {
                if (err) {
                    db.close();
                    callback({"fail": "Files was not deleted - " + err});
                } else {
                    db.close();
                    callback({"success": "Files was deleted"});
                }
            });
        });
    },
    download: function(resourceId, callback) {
        db.open(function(err, db) {
            GridStore.read(db, new BSON.ObjectID(resourceId), function(err, data) {
                db.close();
                if(err) {
                    console.log("Error to download file");
                }
                callback(data);
            });
        });
    }
};

exports.Resource = Resource;