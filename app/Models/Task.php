<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Filament\Forms\Components;

class Task extends Model implements Sortable
{
    use HasFactory, SortableTrait;


    protected $guarded = [];


    public static function getForm(): array
    {
        return [
            Components\Fieldset::make('Información de la tarea')
                ->schema([
                    TextInput::make('title')
                        ->label('Nombre de la tarea')
                        ->autocomplete('off')
                        ->required()
                        ->columnSpanFull()
                        ->maxLength(100),

                    Components\Textarea::make('description')
                        ->label('Descripción de la tarea')
                        ->autocomplete('off')
                        ->rows(6)
                        ->required()
                        ->columnSpanFull()
                        ->maxLength(1000),

                    //due date
                    Components\DateTimePicker::make('due_date')
                        ->label('Fecha de vencimiento')
                        ->seconds(false)
                        ->default(now()->addDays(3))
                        ->required()
                        ->columnSpan(1),

                    Select::make('status')
                        ->label('Estado')
                        ->required()
                        ->columnSpan(1)
                        ->options(TaskStatus::labels())


                ]),

        ];
    }

}
