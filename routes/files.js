var mongo = require("mongodb");
var GridStore = mongo.GridStore;
var ObjectID = mongo.ObjectID;

var Server = mongo.Server;
var Db = mongo.Db;
var BSON = mongo.BSONPure;

var server = new Server('localhost', 27017, {auto_reconnect: true});
db = new Db('file-server', server);

db.open(function(err, db) {
    if(!err) {
        console.log("Connected to 'file-server' database");
        db.collection('files', {strict:true}, function(err, collection) {
            if (err) {
                console.log("The 'file-server' collection doesn't exist.");
            }
        });
    }
});

exports.list = function(req, res) {
    db.collection('fs.files', function(err, collection) {
        collection.find().toArray(function(err, items) {
            res.send(items);
        });
    });
};

exports.show = function(req, res) {
    var id = req.params.id;
    console.log('Retrieving file: ' + id);
    db.collection('fs.files', function(err, collection) {
        collection.findOne({'_id':new BSON.ObjectID(id)}, function(err, item) {
            if(err) {
                console.log("Error to show file " + id);
                return;
            }

            res.send(item);
        });
    });
};

exports.create = function(req, res) {
    console.log('Adding file: ' + req.files.file.name);
    var gridStore = new GridStore(db, new ObjectID(), "w");
    gridStore.writeFile(req.files.file.path, function(err, result) {
        if(err) {
            console.log("Error to upload file.");
            return;
        }

        res.send({"success": "File was saved."});
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