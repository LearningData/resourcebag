var Permission = require("../modules/permissions.js").Permission;

exports.permissionMiddleware = function(req, res, next) {
    var key;

    if(req.body.key) {
        key = req.body.key;
    } else {
        key = req.query.key;
    }

    Permission.isAllowed(req.headers.referer, key, function(isAllowed){
        if(isAllowed || process.env.DEV) {
            next();
            return;
        }

        res.send("Permission denied.");
    });
};