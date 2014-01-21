var Resource = require("../schemas/resource.js").Resource;
var Permission = require("../modules/permissions.js").Permission;

exports.list = function(req, res) {
    Resource.all(function(items){
        res.send(items);
    });
};

exports.search = function(req, res) {
    var param = req.params.param;
    var re = new RegExp(param);

    Resource.search({"filename": re}, function(items){
        res.send(items);
    });
};

exports.searchTags = function(req, res) {
    var param = req.params.param;

    Resource.search({"metadata.type-tags": {$in: [param]}}, function(items){
        res.send(items);
    });
};

exports.show = function(req, res) {
    var id = req.params.id;
    Resource.get(id, function(resource){
        res.send(resource);
    });
};

exports.create = function(req, res) {
    var resource = req.files.file;

    Permission.isAllowed(req.headers.referer, req.body.key, function(isAllowed){
        if(isAllowed) {
            Resource.save(resource, req.body, function(result){
                if(req.query.redirect) {
                    res.redirect(req.query.redirect);
                } else {
                    res.send(result);
                }
            });
        } else {
            res.send("Permission denied.");
        }
    });
};

exports.download = function(req, res) {
    var id = req.params.id;

    Resource.download(id, function(data){
        Resource.get(id, function(resource){
            console.log("Downloading file: " + resource.filename);

            res.setHeader('Content-disposition',
                'attachment; filename=' + resource.filename);
            res.send(data);
        });
    });
};

exports.delete = function(req, res) {
    var id = req.params.id;

    Resource.delete(id, function(response){
        res.send(response);
    });
};