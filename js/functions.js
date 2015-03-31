$(document).ready(function () {
  
  /* --- Open Section --- */
  $(".section").click(function () {
    $(this).addClass("section-expand");
    $(".switch-section").show();
    $(".section-close").show(0);
    $(".switch-section").addClass("switch-section-open");
	$('#searchBox').css("display", "none");
  })
  
  /* --- Close Section --- */
  $(".section-close").click(function () {
    $(".section").removeClass("section-expand");
    $(".switch-section").hide();
	$(".switch-section").removeClass("switch-section-open");
    $(".section-close").hide(0);
    $(".section-about i, .section-services i, .section-folio i, .section-blog i, .section-contact i").removeClass("active");
	$('#searchBox').css("display", "block");;
  })
  
  /* --- Side Menu --- */
/*  $(".switch-section").click(function () {
    $(this).toggleClass("switch-section-open");
  })*/
  
  /* --- Switch Section --- */
  $(".section-about").click(function () {
    $(".section").removeClass("section-expand");
    $("#about").addClass("section-expand");
  })
  $("#about").click(function () {
    $(".section-about i").toggleClass("active");
  })

  $(".section-services").click(function () {
    $(".section").removeClass("section-expand");
    $("#services").addClass("section-expand");
  })
  $("#services").click(function () {
    $(".section-services i").toggleClass("active");
  })

  $(".section-folio").click(function () {
    $(".section").removeClass("section-expand");
    $("#folio").addClass("section-expand");
  })
  $("#folio").click(function () {
    $(".section-folio i").toggleClass("active");
  })

  $(".section-blog").click(function () {
    $(".section").removeClass("section-expand");
    $("#blog").addClass("section-expand");
  })
  $("#blog").click(function () {
    $(".section-blog i").toggleClass("active");
  })

  $(".section-contact").click(function () {	
    $(".section").removeClass("section-expand");
    $("#contact").addClass("section-expand");
  })
  $("#contact").click(function () {	
    $(".section-contact i").toggleClass("active");
  })

  /* --- Active Filter Menu --- */
  $(".switch-section a i, .filter a").click(function (e) {
    $(".switch-section a i, .filter a").removeClass("active");
    $(this).addClass("active");
    e.preventDefault();
  });

});

