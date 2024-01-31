$(document).ready(function() {
    $("#button-estudiante").on("click", function() {
    $("#links-estudiante").slideToggle();
    $(".fa-arrow-turn-down", this).toggleClass("arrow-toggle");
    });
});