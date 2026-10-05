<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/src/functions.php');

$board = getBoardFromCsv(__DIR__ . '/src/board_data/board1.csv');

$num_rows = count($board);
$num_columns = count($board[0]);

// Las coordenadas de la URL se limitan al tablero por si llegan fuera de rango
$player_x = keepInside((int) ($_GET['x'] ?? 0), $num_columns);
$player_y = keepInside((int) ($_GET['y'] ?? 0), $num_rows);

$board_markup = getBoardMarkup($board, $player_x, $player_y);
$controls_markup = getControlsMarkup($board, $player_x, $player_y);

include(__DIR__ . '/templates/index.tpl.php');
