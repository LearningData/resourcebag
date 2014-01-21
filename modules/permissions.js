var domains = require("../config/servers").domains;
var url = require("url");

var Permission = {
    isAllowed: function(referer, key, callback) {
        if(referer) {
            var hostname = url.parse(referer).hostname;
            if(domains[hostname] === key) {
                callback(true);
                return;
            }
        }

        callback(false);
        return;
    }
};

exports.Permission = Permission;