$(function () {
  "use strict";
  var url = window.location + "";
  var path = url.replace(
    window.location.protocol + "//" + window.location.host + "/",
    ""
  );
  var element = $("ul#sidebarnav a").filter(function () {
    return this.href === url || this.href === path; // || url.href.indexOf(this.href) === 0;
  });
  element.parentsUntil(".sidebar-nav").each(function (index) {
    if ($(this).is("li") && $(this).children("a").length !== 0) {
      $(this).children("a").addClass("active");
      $(this).parent("ul#sidebarnav").length === 0
        ? $(this).addClass("active")
        : $(this).addClass("selected");
    } else if (!$(this).is("ul") && $(this).children("a").length === 0) {
      $(this).addClass("selected");
    } else if ($(this).is("ul")) {
      $(this).addClass("in");
    }
  });

  element.addClass("active");

  $("#sidebarnav >li >a.has-arrow").on("click", function (e) {
    e.preventDefault();
  });

  $(document).on("click", ".has-nav-item",function(){
    $(this).find("a.has-arrow").toggleClass("active");
    $(this).find('ul').toggleClass('in');
  });

  // Auto scroll to the active nav
  if ($(window).width() > 768 || window.Touch) {
    $(".scroll-sidebar").animate(
      {
        scrollTop: $("#sidebarnav .sidebar-item.selected").offset().top - 250,
      },
      500
    );
  }
});
