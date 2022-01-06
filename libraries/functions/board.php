<?php 
    function show_board() {
        global $mysqli;

        $sql = 'select * from board';
        $st = $mysqli->prepare($sql);
        
        $st->execute();
        $res = $st->get_results();

        header('Content-type: application/jason');
        print jsano_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
    }
?>