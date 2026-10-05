<?php

// Lee el CSV y devuelve un array bidimensional [fila][columna] con el tipo de cada casilla
function getBoardFromCsv(string $rutaCSV): array
{
    $board = [];
    $stream = fopen($rutaCSV, 'r');

    while (($row = fgetcsv($stream)) !== false) {
        $board[] = array_map('trim', $row);
    }

    fclose($stream);

    return $board;
}

// Muros y agua no se pueden atravesar
function isBlocked(string $tile): bool
{
    return strpos($tile, 'wall') === 0 || strpos($tile, 'water') === 0;
}

// Fuerza un valor a quedarse entre 0 y max - 1
function keepInside(int $value, int $max): int
{
    return max(0, min($value, $max - 1));
}

// Devuelve la nueva posición [x, y] al moverse. Si la casilla está fuera o bloqueada, no se mueve
function tryMove(array $board, int $x, int $y, int $dx, int $dy): array
{
    $newX = $x + $dx;
    $newY = $y + $dy;

    $isInside = $newX >= 0 && $newY >= 0 && $newY < count($board) && $newX < count($board[0]);

    if (!$isInside || isBlocked($board[$newY][$newX])) {
        return [$x, $y];
    }

    return [$newX, $newY];
}

function getBoardMarkup(array $board, int $playerX, int $playerY): string
{
    $html = '<div class="board-container">';

    foreach ($board as $row) {
        foreach ($row as $tile) {
            $html .= '<div class="tile ' . $tile . '-tile"></div>';
        }
    }

    $html .= '<div class="player-tile" style="left:' . ($playerX * 16) . 'px; top:' . ($playerY * 16) . 'px;"></div>';
    $html .= '</div>';

    return $html;
}

function getControlsMarkup(array $board, int $playerX, int $playerY): string
{
    $directions = [
        'arriba'     => [0, -1],
        'abajo'      => [0, 1],
        'izquierda'  => [-1, 0],
        'derecha'    => [1, 0],
    ];

    $html = '';

    foreach ($directions as $label => [$dx, $dy]) {
        [$x, $y] = tryMove($board, $playerX, $playerY, $dx, $dy);
        $html .= '<a href="?x=' . $x . '&y=' . $y . '">' . $label . '</a> ';
    }

    return $html;
}
