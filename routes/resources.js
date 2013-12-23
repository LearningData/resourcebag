var Resource = require("../schemas/resource.js").Resource;

exports.list = function(req, res) {
    Resource.all(function(items){
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
    console.log('Adding file: ' + req.files.file.name);
    var resource = req.files.file;

    Resource.save(resource, function(result){
        res.send(result);
    });
};

exports.download = function(req, res) {
    var id = req.params.id;

    GridStore.read(db, new BSON.ObjectID(id), function(err, data) {
        if(err) {
            console.log("Error to download file");
        }

        res.send(data);
    });
};

exports.delete = function(req, res) {
    var id = req.params.id;
    console.log('Removing file: ' + id);

    db.collection('fs.files', function(err, collection) {
        collection.remove({'_id':new BSON.ObjectID(id)}, {safe:true}, function(err, result) {
            if (err) {
                res.send({'error':'An error has occurred - ' + err});
            } else {
                console.log('' + result + ' file deleted');
                res.send(req.body);
            }
        });
    });
};