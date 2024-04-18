<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum TaskStatus: string
{
    use IsKanbanStatus;

    case Todo = 'Por Hacer';
    case Doing = 'Haciendo';
    case Done = 'Hecho';

    public static function labels(): array
    {
        return [
            'Haciendo' => 'Haciendo',
            'Por Hacer' => 'Por Hacer',
            'Hecho' => 'Hecho',
        ];
    }
}




