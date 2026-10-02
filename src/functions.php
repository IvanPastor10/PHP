<?php

function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

function getBoardFromCsv(String $rutaCSV)
{
    $stream = fopen($rutaCSV, 'r');
    $tablero = [];


    if ($stream !== false) {

        while (($fila = fgetcsv($stream)) !== false) {
            $tablero[] = array_map('trim',$fila);
        }

        fclose($stream);
    }

    return $tablero;
}

function getBoardMarkup($board_data, int $player_x = 0, int $player_y = 0){
    $output = '<div class="board-container">';
    foreach($board_data as $fila){
        foreach ($fila as $tile_value){
            $output .= '<div class="tile '.$tile_value.'-tile"></div>';
        }
    }

    $output .= '<div class="player-tile" style="left:'.($player_x * 16).'px; top:'.($player_y * 16).'px;"></div>';

    $output .= '</div>';

    return $output;
}

?>