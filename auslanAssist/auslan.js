
$(function(){
  $("body").keyup(function (e) {

    if (e.which == 13) {
      var pass = $("#input-pass").val();
      if(pass !== ""){
        $("#input-icon").trigger("click");
      }

    }
  });
});



$(document).ready(function(){ 

  $("#cat_segment").on("click touch",function(){
    $("#category_div").removeClass("d-none");
    $("#word_div").addClass("d-none");
  });

  $("#word_segment").on("click touch",function(){
    $("#word_div").removeClass("d-none");
    $("#category_div").addClass("d-none");
  });

      $('.colorPickerClass').change(function(){
        
        var cat_id = $(this).data("cat_id");
        
        $("#colorPicker_"+cat_id).val(this.value);
        var val = $("#colorPicker_"+cat_id).val();
        $("#hex_text_"+cat_id).html(val);
       }); 
});



const icon = document.querySelector(".fa-search");
const search = document.querySelector(".search");

icon.onclick = function () {
	search.classList.toggle("active");
};



$('#staticParent').on('click', '#remove_filters', function() {
  $(".no-results").addClass("d-none");

  $(".card-container").each(function() {
    $(this).removeClass("d-none");
  });
  $("#filter_text").html("");
});

let file;
const browse = document.getElementById("browse");
const input = document.getElementById("media");



$(".week-filters").on("click touch",function(){
  var filter = $(this).data("week");
  $(".no-results").addClass("d-none");

  var n = 0;
  $("#filter_text").html('Filtered: Week '+filter+ '<i id="remove_filters" class=" bi bi-x-circle-fill"></i>');

  $(".card-container").each(function() {
    if (!$(this).hasClass(filter)) {
      $(this).addClass("d-none");
      }else{
        $(this).removeClass("d-none");
        n++;
      }
  });

  /// no results
if(n == 0){
  $(".no-results").removeClass("d-none");
}

});

$(".filtering-tags").on("click touch",function(){
  var filter = $(this).data("filter");
  $(".no-results").addClass("d-none");

  $("#filter_text").html('Filtered: '+filter+ '<i id="remove_filters" class="bi bi-x-circle-fill"></i>');
  var n = 0;

  $(".card-container").each(function() {
    if (!$(this).hasClass(filter)) {
      $(this).addClass("d-none");
      }else{
        $(this).removeClass("d-none");
        n++;

      }
  });

  /// no results
  if(n == 0){
  $(".no-results").removeClass("d-none");
}

});



jQuery("#searchBarInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    var n = 0;
    $(".no-results").addClass("d-none");
    $("#filter_text").html("");

    
    $('.card-container').each(function() {
      var word = $(this).data("word");
      if(word.toLowerCase().indexOf(value)){
        $(this).addClass("d-none");
      }else{
        $(this).removeClass("d-none");
        n++;

      }

    });
  /// no results
  if(n == 0){
  $(".no-results").removeClass("d-none");
}
  });


    $(document).ready(function() {
  var front = document.getElementsByClassName("front");
  var back = document.getElementsByClassName("back");

  var highest = 0;
  var absoluteSide = "";

  for (var i = 0; i < front.length; i++) {
    if (front[i].offsetHeight > back[i].offsetHeight) {
      if (front[i].offsetHeight > highest) {
        highest = front[i].offsetHeight;
        absoluteSide = ".front";
      }
    } else if (back[i].offsetHeight > highest) {
      highest = back[i].offsetHeight;
      absoluteSide = ".back";
    }
  }
  $(".front").css("height", highest);
  $(".back").css("height", highest);
  $(absoluteSide).css("position", "absolute");

  $(".card").click( function () {
      $(this).toggleClass("flip");
  });


});
