var mongo = require("mongodb");
var Server = mongo.Server;
var Db = mongo.Db;


var server = new Server('localhost', 27017, {auto_reconnect: true});
if(process.env.NODE_ENV !== 'test') {
    db = new Db('file-server', server);
} else {
    db = new Db('file-server', server);
}


db.open(function(err, db) {
    if(!err) {
        console.log("Connected to 'file-server' database");
    }
});

exports.db = db;