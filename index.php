<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__.'/src/functions.php');


$board = getBoardFromCSV(__DIR__.'/src/board_data/board1.csv');

$num_rows = count($board);
$num_columns = count($board[0]);

$player_x = (int) ($_GET['x'] ?? 0);
$player_y = (int) ($_GET['y'] ?? 0);

$board_markup = getBoardMarkup($board, $player_x, $player_y);

include(__DIR__.'/templates/index.tpl.php');

?>