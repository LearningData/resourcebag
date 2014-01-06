var Resource = require("../schemas/resource.js").Resource;

exports.list = function(req, res) {
    Resource.all(function(items){
        res.send(items);
    });
};

exports.search = function(req, res) {
    var param = req.params.param;

    Resource.search(param, function(items){
        res.send(items);
    });
};

exports.show = function(req, res) {
    var id = req.params.id;
    Resource.show(id, function(resource){
        res.send(resource);
    });
};

exports.create = function(req, res) {
    var resource = req.files.file;

    Resource.save(resource, function(result){
        res.send(result);
    });
};

exports.download = function(req, res) {
    var id = req.params.id;

    Resource.download(id, function(data){
        res.send(data);
    });
};

exports.delete = function(req, res) {
    var id = req.params.id;

    Resource.delete(id, function(response){
        res.send(response);
    });
};