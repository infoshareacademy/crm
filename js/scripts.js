$(function () {
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        $(this).find(".fa-bars").toggleClass("fa-rotate-90");
    });
});
