var Resource = require("../schemas/resource.js").Resource;
var Permission = require("../modules/permissions.js").Permission;
var resource = new Resource();

exports.list = function(req, res) {
    resource.all(function(items){
        res.send(items);
    });
};

exports.search = function(req, res) {
    var param = req.params.param;
    var re = new RegExp(param);

    resource.search({"filename": re}, function(items){
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
    var params = {};
    params["metadata." + param] = new RegExp(value, "i");

    console.log("Searching by: " + param + " = " + value);

    resource.search(params, function(items){
        res.send(items);
    });
}

exports.searchByParamsWithAnd = function(req, res) {
    console.log("Searching by params with and");
    var params = req.query;

    resource.search(params, function(items){
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

    var query = {$or: params}

    resource.search(query, function(items){
        res.send(items);
    });
}

exports.searchTags = function(req, res) {
    var param = req.params.param;

    resource.search({"metadata.type-tags": {$in: [param]}}, function(items){
        res.send(items);
    });
};

exports.searchBySubjects = function(req, res) {
    var param = req.params.param;
    var schoolId = req.params.school_id;
    var subjects = req.params.subjects.split(",");;
    var query = {"metadata.school": schoolId,
        "metadata.subject": {$in: subjects}};

    resource.search(query, function(items){
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
            console.log("Downloading file: " + resource.filename);

            res.setHeader('Content-disposition',
                'attachment; filename=' + resource.filename);
            res.send(data);
        });
    });
};

exports.delete = function(req, res) {
    var id = req.params.id;

    resource.delete(id, function(response){
        res.send(response);
    });
};