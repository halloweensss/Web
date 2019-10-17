$(document).ready(function () {
    //Open Search
    $("#SuggestionInput").click(function (event) {
        $(".suggestion-container-items").css('display', 'block');
        event.stopPropagation();
    });

    $('body').click(function () {
        $(".suggestion-container-items").css('display', 'none');
    });
});