var me = {};
var game_status = {};

$(function(){
    draw_empty_board();
    fill_board();

    $('#quarto_login').click(login_to_game);
});

function draw_empty_board() {
    var t = '<table id="quarto_table">';
    for(var i=4; i>0; i--) {
        t += '<tr>';
        for(var j = 1; j<5; j++) {
            t += '<td id="circle_'+i+'_'+j+'">' + '</td>';
        }
        t+='</tr>';
    } 
    t += '</table>';
    $('#quarto_board').html(t);
}

function fill_board(){
    $.ajax({url: "quarto.php/board/", success: fill_board_by_data}); 
}

function fill_board_by_data(data) {
    for(var i=0; i<data.length; i++) {
        var o = data[i];
        var id = '#circle_'+ o.posX + '_' + o.posY;
        var c = (o.piece==null)?o.posX + ',' + o.posY: o.piece;
        $(id).html(c);
    }
}

function login_to_game() {
    if ($('#username').val() == '') {
        alert('You have to sat a valid username');
        return;
    }
    $.ajax({url: "quarto.php/players/", 
            method: 'PUT', 
            dataType: "json", 
            contentType: 'application/json',
            data: JSON.stringify({username: $('#username').val()}),
            success: login_result,
            error: login_error});
}    

function login_result(data) {
    me = data[0];
    $('#gmae_initializer').hide();
    //update_info();
    //game_start();

}

function login_error(data,y,z,c) {
    var x = data.responseJSON;
    alert(x.errormesg);
}

