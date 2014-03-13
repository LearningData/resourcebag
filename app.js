var express = require('express');
var files = require('./routes/resources');
var http = require('http');
var permissionMiddleware = require("./middlewares/permission_middleware.js")
    .permissionMiddleware;

var app = express();

// all environments
app.set('port', process.env.PORT || 3001);
app.use(express.logger('dev'));
app.use(express.json({limit: '1000mb'}));
app.use(express.multipart({limit: '1000mb'}));
app.use(express.urlencoded({limit: '1000mb'}));
app.use(express.methodOverride());
app.use(express.cookieParser('your secret here'));
app.use(express.session());
app.use(app.router);
app.use(express.bodyParser({ keepExtensions: true, uploadDir: "/tmp/uploads/" }));

// development only
if ('development' == app.get('env')) {
  app.use(express.errorHandler());
}

app.get('/resources', permissionMiddleware, files.list);
app.get('/resources/:id', permissionMiddleware, files.show);
app.get('/resources/download/:id', permissionMiddleware, files.download);
app.get('/resources/search/:param', permissionMiddleware, files.search);
app.get('/resources/search/tags/:param', permissionMiddleware, files.searchTags);
app.get('/resources/search/:param/:value', permissionMiddleware, files.searchByParam);
app.post('/resources', permissionMiddleware, files.create);
app.post('/resources/update', permissionMiddleware, files.update);
app.delete('/resources/:id', permissionMiddleware, files.delete);

http.createServer(app).listen(app.get('port'), function(){
  console.log('Running Resourcebag on port ' + app.get('port'));
});
