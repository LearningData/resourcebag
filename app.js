var express = require('express');
var files = require('./routes/resources');
var http = require('http');

var app = express();

// all environments
app.set('port', process.env.PORT || 3000);
app.use(express.logger('dev'));
app.use(express.json());
app.use(express.multipart());
app.use(express.urlencoded());
app.use(express.methodOverride());
app.use(express.cookieParser('your secret here'));
app.use(express.session());
app.use(app.router);
app.use(express.bodyParser({ keepExtensions: true, uploadDir: "/tmp/uploads/" }));

// development only
if ('development' == app.get('env')) {
  app.use(express.errorHandler());
}

app.get('/resources', files.list);
app.get('/resources/:id', files.show);
app.get('/resources/download/:id', files.download);
app.post('/resources', files.create);
app.delete('/resources/:id', files.delete);

http.createServer(app).listen(app.get('port'), function(){
  console.log('Running File Server on port ' + app.get('port'));
});
