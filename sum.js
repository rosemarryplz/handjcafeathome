calc_total();

$(".choose").on('change', function(){
  var parent = $(this).closest('tr');
  var price  = parseFloat($('.price',parent).text());
  var choose = parseFloat($('.choose',parent).val());

  $('.total',parent).text(choose*price);

  calc_total();
});

function calc_total(){
  var sum = 0;
  $(".total").each(function(){
    sum += parseFloat($(this).text());
  });
  $('#sum').text(sum);
}