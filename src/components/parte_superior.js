$(document).ready(function() {
    $("#button-estudiante").on("click", function() {
    $("#links-estudiante").slideToggle();
    $(".fa-caret-down", this).toggleClass("arrow-toggle");
    });
});