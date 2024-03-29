var Resource = require("../schemas/resource.js").Resource;
var Permission = require("../modules/permissions.js").Permission;
var resource = new Resource();
var pageDefault = 1;
var limitDefault = 12;

exports.list = function(req, res) {
    var page = parseInt(req.query.page) || pageDefault;
    var limit = parseInt(req.query.limit) || limitDefault;
    params = {};

    if(req.query.query){
        try{
            params = JSON.parse(req.query.query);
        }catch(e){
            console.log("Error to parse: " + req.query.query);
            res.send({"status": "error", "message": "Error to parse: " + req.query.query});
        }
    }

    resource.all(params, page, limit, function(items){
        res.send(items);
    });
};

exports.search = function(req, res) {
    var param = req.params.param;
    var re = new RegExp(param);

    var page = parseInt(req.query.page) || pageDefault;
    var limit = parseInt(req.query.limit) || limitDefault;

    resource.search({"filename": re}, page, limit, function(items){
        res.send(items);
    });
};

exports.update = function(req, res) {
    resource.update(req.body, function(result){
        res.send(result)
    });
}

exports.searchByParam = function(req, res) {
    var param = req.params.param;
    var value = req.params.value;
    var page = parseInt(req.query.page) || pageDefault;
    var limit = parseInt(req.query.limit) || limitDefault;
    var params = {};

    params["metadata." + param] = new RegExp(value, "i");

    console.log("Searching by: " + param + " = " + value);

    resource.search(params, page, limit, function(items){
        res.send(items);
    });
}

exports.searchByParamsWithAnd = function(req, res) {
    console.log("Searching by params with and");
    var params = req.query;

    var page = parseInt(params.page) || pageDefault;
    var limit = parseInt(params.limit) || limitDefault;

    delete params["page"];
    delete params["limit"];

    resource.search(params, page, limit, function(items){
        res.send(items);
    });
}

exports.searchByParamsWithOr = function(req, res) {
    console.log("Searching by params with or");
    var params = [];

    for(key in req.query) {
        var param = {};
        param[key] = req.query[key];
        params.push(param);
    }

    var page = parseInt(req.query.page) || pageDefault;
    var limit = parseInt(req.query.limit) || limitDefault;

    delete req.query["page"];
    delete req.query["limit"];

    var query = {$or: params}

    resource.search(query, page, limit, function(items){
        res.send(items);
    });
}

exports.searchTags = function(req, res) {
    var param = req.params.param;
    var page = parseInt(req.query.page) || pageDefault;
    var limit = parseInt(req.query.limit) || limitDefault;

    resource.search({"metadata.type-tags": {$in: [param]}}, page, limit, function(items){
        res.send(items);
    });
};

exports.searchBySubjects = function(req, res) {
    var param = req.params.param;
    var schoolId = req.params.school_id;
    var subjects = req.params.subjects.split(",");;
    var query = {"metadata.school": schoolId,
        "metadata.subject": {$in: subjects}};

    var page = parseInt(req.query.page) || pageDefault;
    var limit = parseInt(req.query.limit) || limitDefault;

    resource.search(query, page, limit, function(items){
        res.send(items);
    });
};

exports.addTag = function(req, res){
    console.log("Adding tag: " +
        req.params.tag + " to Resource: " + req.params.id);

    resource.addTag(req.params.id, req.params.tag, function(response){
        res.end(response);
    });
}

exports.show = function(req, res) {
    var id = req.params.id;
    resource.get(id, function(resource){
        res.send(resource);
    });
};

exports.create = function(req, res) {
    var file = req.files.file;

    resource.save(file, req.body, function(result){
        if(req.query.redirect) {
            res.redirect(req.query.redirect);
        } else {
            res.send(result);
        }
    });
};

exports.download = function(req, res) {
    var id = req.params.id;

    resource.download(id, function(data){
        resource.get(id, function(resource){
            if(resource){
                console.log("Downloading file: " + resource.filename);
                res.setHeader('Content-disposition',
                    'attachment; filename=' + resource.filename);
                res.setHeader('content-type', resource.metadata.content_type);

                res.send(data);
            } else {
                res.send("File not found", 404);
            }
        });
    });
};

exports.delete = function(req, res) {
    var id = req.params.id;

    resource.delete(id, function(response){
        res.send(response);
    });
};

exports.tags = function(req, res) {
    params = {};

    if(req.query.clientId){
        params["metadata.clientId"] = req.query.clientId;
    }

    if(req.query.owner){
        params["metadata.owner"] = req.query.owner;
    }

    if(req.query.visibility){
        params["metadata.visibility"] = parseInt(req.query.visibility);
    }

    if(req.query.subject){
        params["metadata.subject"] = req.query.subject;
    }

    resource.searchTags(params, function(response){
        res.send(response);
    });
};
