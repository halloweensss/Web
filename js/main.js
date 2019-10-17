$(document).ready(function () {
    //Open Search
    $("#SuggestionInput").click(function (event) {
        $(".suggestion-container-items").css('display', 'block');
        $(".suggestion-container-items").fadeIn('slow').css('height', 'auto');
        event.stopPropagation();
    });

    $('body').click(function () {
        $(".suggestion-container-items").fadeOut('500');
        $(".suggestion-container-items").css('display', 'none');
    });
});