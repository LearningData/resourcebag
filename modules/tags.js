var Tag = {
    types: ["type-tags", "level-tags", "topic-tags"],
    visibility: {
        "_id": 0,
        "metadata.type-tags": 1,
        "metadata.level-tags": 1,
        "metadata.topic-tags": 1
    },
    conditions: function(params){
        var conditions = { $or: [
            {"metadata.type-tags": {$ne: ""}},
            {"metadata.level-tags": {$ne: ""}},
            {"metadata.topic-tags": {$ne: ""}},
        ]};

        for(param in params){
            conditions[param] = params[param];
        }

        return conditions;
    },
    filter: function(items, types, callback){
        var tags = [];

        items.forEach(function(item){
            types.forEach(function(type){
                if(item.metadata[type] !== undefined){
                    if(item.metadata[type].constructor === Array){
                        item.metadata[type].forEach(function(tag){
                            if(tags.indexOf(tag) == -1){
                                if(tag.constructor === String){
                                    tags.push(tag);
                                }
                            }
                        });
                    } else {
                        if(tags.indexOf(item.metadata[type]) == -1){
                            tags.push(item.metadata[type]);
                        }
                    }
                }
            });
        });

        callback(tags);
    }
}

exports.Tag = Tag;
