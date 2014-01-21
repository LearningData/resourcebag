var domains = require("../config/servers").domains;
var url = require("url");

var Permission = {
    isAllowed: function(referer, callback) {
        if(referer) {
            var hostname = url.parse(referer).hostname;
            if(domains.indexOf(hostname) >= 0) {
                callback(true);
                return;
            }
        }

        callback(false);
        return;
    }
};

exports.Permission = Permission;