var mongo = require("mongodb");
var config = require("../config/database").config;
var Server = mongo.Server;
var Db = mongo.Db;

var server = new Server(config.server, config.port, {auto_reconnect: true});

exports.db = new Db(config.name, server, {safe: false});