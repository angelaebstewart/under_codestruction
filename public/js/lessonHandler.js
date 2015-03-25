function viewedVideo() {
    var data = {
        lessonID : lessonID
    };
    $.ajax({
        type: "POST",
        url: viewedVideoURL,
        data: data,
        error: function () {alert("error");}
    })
    .done(function( data ) {
        data = $.parseJSON(data);
        console.log(data);
        if (data.canViewAssessment) {
            $("#assessmentLinkHolder").html(assessmentLinkHTML);
        }
    });
}