import spincrement from '.lib/jquery.spincrement.min.js';
import spincrement from '.lib/jsplumb.min.js';
// require('jsplumb');
alert("sooqa");

jsPlumb.ready(function() {

  var bezier = jsPlumb.getInstance({
    PaintStyle:{
      strokeWidth:2,
      stroke:'#fff',
    },
    Connector: 'Bezier',
    Anchors: ["Center", "Center"]
  });

  bezier.connect({
    source: "tcy_projects1",
    target: "tcy_projects2",
    endpoint: "Rectangle"
  });
  bezier.connect({
    source: "tcy_projects2",
    target: "tcy_projects3",
    endpoint: "Rectangle"
  });
  bezier.connect({
    source: "tcy_projects3",
    target: "tcy_projects4",
    endpoint: "Rectangle"
  });

  bezier.connect({
    source: "tcy_projects_left",
    target: "tcy_projects1",
    endpoint: "Rectangle"
  });
  bezier.connect({
    source: "tcy_projects4",
    target: "tcy_projects_right",
    endpoint: "Rectangle"
  });



  bezier.draggable("tcy_projects1");
  bezier.draggable("tcy_projects2");
  bezier.draggable("tcy_projects3");
  bezier.draggable("tcy_projects4");

  // bezier.draggable("tcy_projects1_dot");
  // bezier.draggable("tcy_projects1_dot_l");
  // bezier.draggable("tcy_projects1_dot_r");
  //
  // bezier.draggable("tcy_projects4_dot");
  // bezier.draggable("tcy_projects4_dot_l");
  // bezier.draggable("tcy_projects4_dot_r");

  var straight = jsPlumb.getInstance({
    PaintStyle:{
      strokeWidth:2,
      stroke:'#fff',
    },
    Connector: 'Straight',
    Anchors: ["Center", "Center"]
  });

  bezier.connect({
    source: "tcy_projects1",
    target: "tcy_projects1_dot",
    endpoint: "Rectangle"
  });
  bezier.connect({
    source: "tcy_projects1_dot",
    target: "tcy_projects1_dot_l",
    endpoint: "Rectangle"
  });
  bezier.connect({
    source: "tcy_projects1_dot",
    target: "tcy_projects1_dot_r",
    endpoint: "Rectangle"
  });

  bezier.connect({
    source: "tcy_projects4",
    target: "tcy_projects4_dot",
    endpoint: "Rectangle"
  });
  bezier.connect({
    source: "tcy_projects4_dot",
    target: "tcy_projects4_dot_l",
    endpoint: "Rectangle"
  });
  bezier.connect({
    source: "tcy_projects4_dot",
    target: "tcy_projects4_dot_r",
    endpoint: "Rectangle"
  });

});


$(document).ready(function () {

  $('.industries-item__number').on('click', function(e) {
    e.preventDefault();
    $(this).parent().find('.industries-item-overlay').addClass('industries-item-overlay__visible slide-in-bck-center');
  });
  $('.industries-item-overlay__button').on('click', function(e) {
    e.preventDefault();
    $('.industries-item-overlay').removeClass('industries-item-overlay__visible');
  });



var show = true;
var countbox = $(".spincrement").closest(".countbox");
$(window).on("scroll load resize", function () {
  if (!show) return false;                    // Отменяем показ анимации, если она уже была выполнена

    var w_top = $(window).scrollTop();        // Количество пикселей на которое была прокручена страница
    var e_top = $(countbox).offset().top;     // Расстояние от блока со счетчиками до верха всего документа

    var w_height = $(window).height();        // Высота окна браузера
    var d_height = $(document).height();      // Высота всего документа

    var e_height = $(countbox).outerHeight(); // Полная высота блока со счетчиками

    if (w_top + 200 >= e_top || w_height + w_top == d_height || e_height + e_top < w_height) {
      $('.js-counter').css('opacity', '1');
      $(".spincrement").spincrement({
        from: 0,                  // Стартовое число
        to: null,                 // Стартовое число
        decimalPlaces: 0,         // Сколько знаков оставлять после запятой
        decimalPoint: "",         // Разделитель десятичной части числа
        thousandSeparator: "",    // Разделитель тыcячных
        fade: true,
        easing: "spincrementEasing",
        duration: 4000,           // Продолжительность анимации в миллисекундах
        leeway: 50           // Продолжительность анимации в миллисекундах
      });
      show = false;
    }
  });

});












