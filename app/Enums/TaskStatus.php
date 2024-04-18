<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum TaskStatus: string
{
    use IsKanbanStatus;

    case Todo = 'Haciendo';
    case Doing = 'Por Hacer';
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




