<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Users\Pages\EditUser;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SkillsRelationManager extends RelationManager
{
    protected static string $relationship = 'skills';

    protected static ?string $title = 'Skills';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $pageClass === EditUser::class && $ownerRecord->hasPermissionTo('can-fix');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Skill Name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('name', 'asc')
            ->columns([
                TextColumn::make('name')
                    ->label('Skill')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Create Skill')
                    ->modalHeading('Create New Skill')
                    ->modalDescription('Create a new skill and attach it to this user')
                    ->authorize(fn () => auth()->user()->can('add-skills')),
                AttachAction::make()
                    ->label('Attach Skill')
                    ->modalHeading('Attach Existing Skill')
                    ->modalDescription('Attach an existing skill to this user')
                    ->authorize(fn () => $this->canAttachDetach())
                    ->preloadRecordSelect(),
            ])
            ->recordActions([
                DetachAction::make()
                    ->authorize(fn () => $this->canAttachDetach()),
                DeleteAction::make()
                    ->authorize(fn () => auth()->user()->can('manage-skills')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->authorize(fn () => $this->canAttachDetach()),
                    DeleteBulkAction::make()
                        ->authorize(fn () => auth()->user()->can('manage-skills')),
                ]),
            ]);
    }

    protected function canAttachDetach(): bool
    {
        $currentUser = auth()->user();
        $ownerRecord = $this->getOwnerRecord();

        return $currentUser->can('manage-users') || $currentUser->id === $ownerRecord->id;
    }
}
