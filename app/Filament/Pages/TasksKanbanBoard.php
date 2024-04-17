<?php

namespace App\Filament\Pages;

use App\Enums\TaskStatus;
use App\Models\Task;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class TasksKanbanBoard extends KanbanBoard
{

    public int $recordIdToDelete = 1;

    protected static ?string $title = 'Gestión de Tareas';

    protected static string $model = Task::class;

    protected static string $statusEnum = TaskStatus::class;

    protected bool $editModalSlideOver = false;

    protected string $editModalTitle = 'Modificar Tarea';

    protected string $editModalSaveButtonLabel = 'Guardar';

    protected string $editModalCancelButtonLabel = 'Cancelar';

    protected string $editModalWidth = '2xl';


    /**
     * Get the records to be displayed on the board.
     * @return Collection
     */
    protected function records(): Collection
    {
        return Task::latest('updated_at')
            ->whereUserId(auth()->id())
            ->get();
    }


    /**
     * Called when a record is moved to a new status.
     * @param int $recordId
     * @param string $status
     * @param array $fromOrderedIds
     * @param array $toOrderedIds
     * @return void
     */
    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        Task::find($recordId)->update(['status' => $status]);
        Task::setNewOrder($toOrderedIds);
    }

    /**
     * Called when a record is moved to a new position within the same status.
     * @param int $recordId
     * @param string $status
     * @param array $orderedIds
     * @return void
     */
    public function onSortChanged(int $recordId, string $status, array $orderedIds): void
    {
        Task::setNewOrder($orderedIds);
    }

    /**
     * Get the schema for the edit modal form.
     * @param int|null $recordId
     * @return array
     */
    protected function getEditModalFormSchema(null|int $recordId): array
    {
        return Task::getForm();
    }


    /**
     * Get the data for the edit modal.
     * @param $recordId
     * @param array $data
     * @return array
     */
    protected function getEditModalRecordData($recordId, $data): array
    {
        $this->recordIdToDelete = $recordId;
        return Task::find($recordId)->toArray();
    }


    /**
     * Additional data to be passed to the edit modal.
     * @param $recordId
     * @param array $data
     * @param array $state
     * @return void
     */
    protected function editRecord($recordId, array $data, array $state): void
    {
        Task::findOrNew($recordId)->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'due_date' => $data['due_date'],
            'status' => $data['progress'] == 100 ? TaskStatus::Done : $data['status'],
            'progress' => $data['progress'],
            'urgent' => $data['urgent'],
        ]);
    }


    /**
     * Get the actions to be displayed in the header.
     * @return array|\Filament\Actions\Action[]|\Filament\Actions\ActionGroup[]
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->model(Task::class)
                ->modalWidth('2xl')
                ->form(Task::getForm())
                ->modalHeading('Crear Tarea')
                ->mutateFormDataUsing(function ($data) {
                    $data['user_id'] = auth()->id();
                    $data['status'] = $data['progress'] == 100 ? TaskStatus::Done : $data['status'];
                    return $data;
                })
                ->modalSubmitActionLabel('Crear')
                ->modalCancelActionLabel('Cancelar')
                ->createAnother(false)
                ->label('Crear Tarea'),
        ];
    }


    /**
     * Get the actions to be displayed in the footer.
     * @param Task $record
     * @return DeleteAction
     */
    protected function deleteAction(): DeleteAction
    {

        $record = Task::findOrNew($this->recordIdToDelete);

        return DeleteAction::make('delete')
            ->record($record)
            ->extraAttributes([
                'class' => 'mt-3',
            ])
            ->icon('heroicon-o-trash')
            ->requiresConfirmation()
            ->modalHeading('Eliminar Tarea')
            ->modalSubmitActionLabel('Eliminar')
            ->modalCancelActionLabel('Cancelar')
            ->requiresConfirmation()
            ->modalHeading('Eliminar Tarea')
            ->modalDescription(fn(Task $record) => new HtmlString
            ('¿Estás seguro de que quieres borrar la tarea: <br> ' . $record->title . ' ?'))
            ->modalSubmitActionLabel('Sí, elimínelo.')
            ->action(function ($record) {
                $record->delete();

                Notification::make()
                    ->success()
                    ->title('Tarea Eliminada')
                    ->body('Se ha eliminado correctamente la Tarea.')
                    ->send();
            })

            ;
    }


}
