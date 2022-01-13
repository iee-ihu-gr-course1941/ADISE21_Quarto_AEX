<?php
require_once "../libraries/conn/connection.php";
require_once "../libraries/functions/board.php";
require_once "../libraries/functions/gamePlay.php";
require_once "../libraries/functions/users.php";


$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

switch ($r = array_shift($request)) {
    case 'board' :
        switch ($b = array_shift($request)) {
            case '':
            case null: handle_board($method);
                break;  
            case 'piece': handle_piece($method, $request[0], $request[1], $input);
                break;
            default: header("HTTP/1.1 404 Not Found");           
        }
        break;
    case 'status' : 
        if(sizeof($request)==0) {
            handle_status($method);
        } else {
            header("HTTP/1.1 404 Not Found");
        }
        break;
    case 'players' : handle_player($method, $request, $input);
        break;
    default: header("HTTP/1.1 404 Not Found");
    exit;            
}

function handle_board($method) {

    if($method == 'GET'){
        show_board();
    }else if ($method == 'POST') {
        reset_board();
    }else {
        header('HTTP/1.1405 Method Not Allowed');
    }
}  

function handle_piece($method, $x, $y, $input) {

}
function handle_player($method, $p,$input) {
    switch ($b=array_shift($p)) {
	//	case '':
	//	case null: if($method=='GET') {show_users($method);}
	//			   else {header("HTTP/1.1 400 Bad Request"); 
	//					 print json_encode(['errormesg'=>"Method $method not allowed here."]);}
    //                break;
        case 'Player_1': 
		case 'Player_2': handle_user($method, $b,$input);
					break;
		default: header("HTTP/1.1 404 Not Found");
				 print json_encode(['errormesg'=>"Player $b not found."]);
                 break;
	}
}

function handle_status($method) {
    if($method == 'GET'){
        show_status();
    }else {
        header('HTTP/1.1405 Method Not Allowed');
    }
}
?>