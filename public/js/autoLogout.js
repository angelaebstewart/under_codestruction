var minutesInactive = 0;
var autoLogoutTimer = -1;

$(document).ready(function () {
    initializeAutoLogout();
});

function initializeAutoLogout() {
    setInterval(incrementMinutesInactive, 60000); // every 1 minute

    $(this).mousemove(function (e) {
        minutesInactive = 0;
    });
    $(this).keypress(function (e) {
        minutesInactive = 0;
    });
    
    $("#dontLogoutBtn").click(function (e) {
        $( "#autoLogoutModal" ).modal("hide");
        minutesInactive = 0;
        window.clearTimeout(autoLogoutTimer);
        autoLogoutTimer = -1;
    });
    
    $("#autoLogoutModal").on("hidden.bs.modal", function (e) {
        minutesInactive = 0;
        window.clearTimeout(autoLogoutTimer);
        autoLogoutTimer = -1;
    });
}

function incrementMinutesInactive() {
    minutesInactive++;
    if (minutesInactive >= 9 && autoLogoutTimer == -1) {
        $("#autoLogoutModal").modal("show");
        autoLogoutTimer = window.setTimeout(doAutoLogout, 60000); // 1 minute
    }
}

function doAutoLogout() {
    $(location).attr("href", logoutURL);
    window.clearTimeout(autoLogoutTimer);
    autoLogoutTimer = -1;
    minutesInactive = 0;
}