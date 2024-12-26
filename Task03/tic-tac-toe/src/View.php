<?php

declare(strict_types=1);

namespace webuser\TicTacToe\View;

use function cli\line;

class View
{
    public static function showProgress($isCheck): void
    {
        if ($isCheck) {
            line("Компьютер играет за крестики");
        } else {
            line("Вы играете за крестики");
        }
    }

    public function showGame(): void
    {

        line("This is the game intereface");
    }

    public static function showLose(): void
    {
        line("Компьютер победил. Попробуйте еще раз!");
    }

    public static function showWin(): void
    {
        line("Вы победили! Поздравляем!");
    }

    public static function showDraw(): void
    {
        line("Ничья. Попробуйте еще раз!");
    }

    public static function showHint(): void
    {
        line("Эта клетка занята, попробуйте еще раз!");
    }

    public static function showBoard(array $board): void
    {
        $n = count($board);

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($j < 2) {
                    echo($board[$i][$j] . " | ");
                } else {
                    echo($board[$i][$j]) ;
                }
            }
            if ($i < 2) {
                line(PHP_EOL . "---------");
            }
        }
        line();
    }

    public static function showErrorMessage(): void
    {
        line("Произошла ошибка, возможно, Вы ввели неверное значение. Попробуйте еще раз!");
    }
}
