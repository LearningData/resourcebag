var db = require("../modules/database").db;
var Tag = require("../modules/tags").Tag;
var mongo = require("mongodb");
var GridStore = mongo.GridStore;
var ObjectID = mongo.ObjectID;

Resource = function() {
  this.db = db;
  this.db.open(function(){});
};


Resource.prototype.all = function(params, page, limit, callback) {
    this.db.collection("fs.files").find(params).skip((page - 1 ) * limit)
        .limit(limit).toArray(function(err, items) {

        if (err) {
            return callback({"fail": "Error to list all resources."})
        };

        var response = {};
        response.current = page;
        response.next = page + 1;
        response.previous = page - 1;
        response.items = items;

        return callback(response);
    });
};

Resource.prototype.search = function(param, page, limit, callback) {
    this.db.collection("fs.files").find(param)
        .skip((page - 1 ) * limit).limit(limit).toArray(function(err, items){

        var response = {};
        response.current = page;
        response.next = page + 1;
        response.previous = page - 1;
        response.items = items;

        return callback(response);
    });
};

Resource.prototype.get = function(resourceId, callback) {
    var id = "";
    if(resourceId.match(/^[0-9a-fA-F]{24}$/)) {
        id = new ObjectID(resourceId);
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
            console.log(err);
            result = {"fail": "File was not uploaded"};
        } else {
            result = {"success": "File was saved.", "id": id};
        }

        return callback(result);
    });
};

Resource.prototype.update = function(params, callback) {
    var resourceId = new ObjectID(params.id);
    delete params["id"];
    delete params["key"];

    this.db.collection("fs.files").update({"_id": resourceId},
        {$set: params}, function(err, result) {
            if(err) {
                return callback({"fail": "Was not possible to update"})
            }

            return callback({"success": "Resource was uploaded"})
    });
};

Resource.prototype.delete = function(resourceId, callback) {
    resourceId = new ObjectID(resourceId);

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
    GridStore.read(this.db, new ObjectID(resourceId), function(err, data) {
        if(err) {
            console.log("Error to download file");
            return callback({"fail": "Error to download the file"});
        }

        return callback(data);
    });
};

Resource.prototype.addTag = function(id, tag, callback) {
    console.log("Adding tag: " + tag + " to resource: " + id);
    resourceId = new ObjectID(id);

    this.db.collection("fs.files").update({"_id": resourceId},
        {$addToSet: {"metadata.tags": tag}}, function(err, result) {

        return callback(result);
    });
};

Resource.prototype.searchTags = function(params, callback) {
    this.db.collection("fs.files")
            .find(Tag.conditions(params), Tag.visibility)
            .toArray(function(err, items){

        Tag.filter(items, Tag.types, function(tags){
            return callback(tags);
        });
    });
};

exports.Resource = Resource;
