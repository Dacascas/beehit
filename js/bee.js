$(document).ready(function() {
    var input = $('input[name=bee]');
    var item = input[Math.floor(Math.random()*input.length)];

    if(input.length == 0) {
        $('input[name=reset]').prop('disabled', false);
        $('input[name=hit]').prop('disabled', true);
    } else {
        item.checked = true;
    }
});