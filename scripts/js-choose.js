//document.getElementById('case-choose').addEventListener('click', function() {
//  var l = document.createElement('img');
//  var value = $("#case-choose").val();
//  l.src = 'images/'+ value +'.png';
//  document.body.appendChild(l);
//});

$('body').on('click','#case-choose',function(){
    var textField = $('#case-send-input');
    var value = $(this).val();
    textField.val(textField.val() + '[' + value.replace("/","") + ']') ; 
      var l = document.createElement('img');
    l.src = 'images/'+ value;
    var id ="wrapper";
    document.getElementById(id).appendChild(l);

        



}); 
    // $('body').on('click','#modal',function(){ 

    // }); 
//var value = $('.case-choose').val();
//document.querySelectorAll('.case-choose').forEach(el => {
//  var l = document.createElement('img');
//  l.src = 'images/'+ el.value +'.svg';
//  el.appendChild(l);
//});
var dir = "images/";
var fileextension = ".svg";
$.ajax({
    //This will retrieve the contents of the folder if the folder is configured as 'browsable'
    url: dir,

    success: function (data) {
        //List all .png file names in the page
        $(data).find("a:contains(" + fileextension + ")").each(function () {
            var filename = this.href.replace(window.location.host, "").replace("http://", "").replace("//","");
            filename = filename.replace("https//","");
            $("#container").append("<button id = 'case-choose' class='case-choose' value = '" + filename +"'><img src='" + dir + filename + "'></button>");
        });
    }
});

//      $('.case-choose').each(function(){
//        var buttons = document.querySelectorAll('.case-choose');
//      var value = $(this).val();
//
//      var l = document.createElement('img');
//      l.src = 'images/'+ value +'.png';
//   document.getElementById ().appendChild (l);
//});
//elements = document.querySelectorAll('.class');
//document.addEventListener('event-type', event => {
//    if (event.target.matches('.case-choose')) {
//        caseChoose();
//    }
//});
//
//$('body').on('click','#case-choose',function(){
//    var textField = $('#case-send-input');
//    var value = $("#case-choose").val();
//    textField.val(textField.val() + '[' + value + ']') ;      
//});