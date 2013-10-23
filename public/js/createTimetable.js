var timetableFunctions = (function() {

    var getTextInline = function( data ) {
        var text = []
        if ( data.subject ) {
            text.push(data.subject)
        }
        if ( data.teacher ) {
            text.push( data.teacher )
        }
        if ( data.room ) {
            text.push( data.room )
        }
        text = text.join (" | ")
        return text
    }

    var getTextBlock = function( data ) {
        var text = "<span data-subject-id=\"" + data["class-id"] + "\" class=\"subject\">" + (data.subject || "") + "</span>"
        text += "<span>" + (data.teacher || "") + "</span>"
        text += "<span>" + (data.room || "") + "</span>"
        return text
    }

    return {
        getTimetableTextInline: getTextInline,
        getTimetableTextBlock: getTextBlock
    }
})()

