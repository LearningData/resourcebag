var mongo = require("mongodb");
var Server = mongo.Server;
var Db = mongo.Db;
var BSON = mongo.BSONPure;

var server = new Server('localhost', 27017, {auto_reconnect: true});
db = new Db('file-server', server);

db.open(function(err, db) {
    if(!err) {
        console.log("Connected to 'file-server' database");
        db.collection('bla', {strict:true}, function(err, collection) {
            if (err) {
                console.log("The 'file-server' collection doesn't exist.");
            }
        });
    }
});

exports.list = function(req, res) {
    db.collection('bla', function(err, collection) {
        collection.find().toArray(function(err, items) {
            res.send(items);
        });
    });
};

exports.show = function(req, res) {
    var id = req.params.id;
    console.log('Retrieving file: ' + id);
    db.collection('bla', function(err, collection) {
        collection.findOne({'_id':new BSON.ObjectID(id)}, function(err, item) {
            res.send(item);
        });
    });
};

exports.create = function(req, res) {
    var file = req.body;
    console.log('Adding file: ' + JSON.stringify(file));
    db.collection('bla', function(err, collection) {
        collection.insert(file, {safe:true}, function(err, result) {
            if (err) {
                res.send({'error':'An error has occurred'});
            } else {
                console.log('Success: ' + JSON.stringify(result[0]));
                res.send(result[0]);
            }
        });
    });
};

exports.update = function(req, res) {
    var id = req.params.id;
    var file = req.body;
    console.log('Updating file: ' + id);
    console.log(JSON.stringify(file));
    db.collection('bla', function(err, collection) {
        collection.update({'_id':new BSON.ObjectID(id)}, file, {safe:true}, function(err, result) {
            if (err) {
                console.log('Error updating file: ' + err);
                res.send({'error':'An error has occurred'});
            } else {
                console.log('' + result + ' document(s) updated');
                res.send(file);
            }
        });
    });
};

exports.delete = function(req, res) {
    var id = req.params.id;
    console.log('Removing file: ' + id);

    db.collection('bla', function(err, collection) {
        collection.remove({'_id':new BSON.ObjectID(id)}, {safe:true}, function(err, result) {
            if (err) {
                res.send({'error':'An error has occurred - ' + err});
            } else {
                console.log('' + result + ' document(s) deleted');
                res.send(req.body);
            }
        });
    });
};