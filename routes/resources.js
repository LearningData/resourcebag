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

exports.searchTags = function(req, res) {
    var param = req.params.param;

    resource.search({"metadata.type-tags": {$in: [param]}}, function(items){
        res.send(items);
    });
};

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