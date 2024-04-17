<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Carbon\Carbon;
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


    /**
     * Task filament Form
     * @return array
     */
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

                    Components\DateTimePicker::make('due_date')
                        ->label('Fecha de vencimiento')
                        ->seconds(false)
                        ->default(now()->addDays(3))
                        ->columnSpan(1),

                    Select::make('status')
                        ->label('Estado')
                        ->required()
                        ->columnSpan(1)
                        ->options(TaskStatus::labels()),

                    TextInput::make('progress')
                        ->label('% de progreso')
                        ->maxValue(100)
                        ->columnSpan(1)
                        ->numeric(),

                    Components\Toggle::make('urgent')
                        ->label('Urgente')
                        ->columnSpan(1)
                        ->default(false)
                        ->inline(false),
                ]),

        ];
    }

    //devuelve la fecha con formato
    public function getFormattedDueDateAttribute(): string
    {
        return Carbon::parse($this->due_date)->isoFormat('dddd, D [de] MMMM [de] YYYY');
    }

}
