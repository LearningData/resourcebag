var Permission = require("../modules/permissions.js").Permission;

exports.permissionMiddleware = function(req, res, next) {
    Permission.isAllowed(req.headers.referer, req.body.key, function(isAllowed){
        if(isAllowed) {
            next();
            return;
        }

        res.send("Permission denied.");
    });
};