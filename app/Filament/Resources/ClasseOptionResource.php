<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClasseOptionResource\Pages;
use App\Filament\Resources\ClasseOptionResource\RelationManagers;
use App\Models\ClasseOption;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClasseOptionResource extends Resource
{
    protected static ?string $model = ClasseOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-color-swatch';
    protected static ?string $navigationGroup = 'School manager';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->join('sections', 'sections.id', '=', 'classe_options.section_id')
            ->join('schools', 'schools.id', '=', 'sections.school_id')
            ->where('sections.school_id', auth()->user()->school->id)
            ->select('classe_options.*');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('section_id')
                    ->relationship('section', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),

            ])
            ->filters([
                SelectFilter::make('Année scolaire')->relationship('section','name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClasseOptions::route('/'),
        ];
    }
}
