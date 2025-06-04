$(function() {
    $.getJSON('cases.php', function(data) {
        data.forEach(function(filename) {
            $('#container').append(
                "<button id='case-choose' class='case-choose' value='" + filename + "'><img src='images/" + filename + "'></button>"
            );
        });
    });

    $('body').on('click', '#case-choose', function() {
        var textField = $('#case-send-input');
        var value = $(this).val();
        textField.val(textField.val() + '[' + value.replace('/', '') + ']');
        var img = document.createElement('img');
        img.src = 'images/' + value;
        document.getElementById('wrapper').appendChild(img);
    });
});
