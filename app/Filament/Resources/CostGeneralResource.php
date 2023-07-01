<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CostGeneralResource\Pages;
use App\Filament\Resources\CostGeneralResource\RelationManagers;
use App\Models\CostGeneral;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class CostGeneralResource extends Resource
{
    protected static ?string $model = CostGeneral::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Cost manager';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->join('type_other_costs','type_other_costs.id','=','cost_generals.type_other_cost_id')
            ->join('schools','schools.id','=','type_other_costs.school_id')
            ->where('school_id', auth()->user()->school->id)
            ->select('cost_generals.*')
            ->orderBy('cost_generals.created_at','DESC');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->required(),
                Forms\Components\Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('amount')->sortable(),
                Tables\Columns\IconColumn::make('active')->sortable()
                    ->boolean(),

            ])
            ->filters([
                SelectFilter::make('Type cost')->relationship('typeOtherCost','name'),
                //SelectFilter::make('Scolaryear')->relationship('typeOtherCost','scolaryYear.name'),
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
            'index' => Pages\ManageCostGenerals::route('/'),
        ];
    }
}
