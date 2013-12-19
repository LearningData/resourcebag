var express = require('express');
var files = require('./routes/files');
var http = require('http');

var app = express();

// all environments
app.set('port', process.env.PORT || 3000);
app.use(express.logger('dev'));
app.use(express.json());
app.use(express.urlencoded());
app.use(express.methodOverride());
app.use(express.cookieParser('your secret here'));
app.use(express.session());
app.use(app.router);

// development only
if ('development' == app.get('env')) {
  app.use(express.errorHandler());
}

app.get('/files', files.list);
app.get('/files/:id', files.show);
app.post('/files', files.create);
app.put('/files/:id', files.update);
app.delete('/files/:id', files.delete);

http.createServer(app).listen(app.get('port'), function(){
  console.log('Running File Server on port ' + app.get('port'));
});
