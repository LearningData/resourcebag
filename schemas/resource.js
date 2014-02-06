var db = require("../modules/database").db;
var mongo = require("mongodb");
var BSON = mongo.BSONPure;
var GridStore = mongo.GridStore;
var ObjectID = mongo.ObjectID;

Resource = function() {
  this.db = db;
  this.db.open(function(){});
};


Resource.prototype.all = function(callback) {
    this.db.collection("fs.files").find().toArray(function(err, items) {
        return callback(items);
    });
};

Resource.prototype.search = function(param, callback) {
    this.db.collection("fs.files").find(param).toArray(function(err, items){
        return callback(items);
    });
};
Resource.prototype.get = function(resourceId, callback) {
    var id = "";
    if(resourceId.match(/^[0-9a-fA-F]{24}$/)) {
        id = new BSON.ObjectID(resourceId);
    } else {
        return callback({"fail": "The id " + resourceId + " is not valid"});
    }

    this.db.collection("fs.files").findOne({'_id': id}, function(err, resource){
        if(err) {
            console.log("Error to show file " + resourceId);
            return callback({"fail": "The id " + resourceId +
                " does not exist."});
        }

        return callback(resource);
    });
};
Resource.prototype.save = function(resource, params, callback) {
    if(!resource.name) {
        return callback({"fail": "Resource needs a file"});
    }
    if(!params.owner) {
        return callback({"fail": "Resource needs an owner"});
    }
    if(!params.clientId) {
        return callback({"fail": "Resource needs a school"});
    }

    delete params["key"];
    params["content_type"] = resource.type;
    var id = new ObjectID();
    var gridStore = new GridStore(this.db, id,
        resource.name, "w", {"metadata": params});

    gridStore.writeFile(resource.path, function(err, result) {
        if(err) {
            console.log("Error to upload file.");
            result = {"fail": "File was not upload"};
        } else {
            result = {"success": "File was saved.", "id": id};
        }

        return callback(result);
    });
};
Resource.prototype.delete = function(resourceId, callback) {
    resourceId = new BSON.ObjectID(resourceId);

    this.db.collection("fs.files").remove({'_id':resourceId}, {safe:true}, function(err, result) {
        if (err) {
            return callback({"fail": "File was not deleted - " + err});
        } else {
            return callback({"success": "File was deleted"});
        }
    });
};
Resource.prototype.deleteAll = function(callback) {
    this.db.collection("fs.files").remove({}, function(err, result) {
        if (err) {
            return callback({"fail": "Files was not deleted - " + err});
        } else {
            return callback({"success": "Files was deleted"});
        }
    });
};
Resource.prototype.download = function(resourceId, callback) {
    GridStore.read(this.db, new BSON.ObjectID(resourceId), function(err, data) {
        if(err) {
            console.log("Error to download file");
        }
        return callback(data);
    });
};

exports.Resource = Resource;