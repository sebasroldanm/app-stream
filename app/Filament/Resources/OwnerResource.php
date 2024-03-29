<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers;
use App\Models\Owner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(isIndividual: true)
                    ->placeholder('No name.'),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(isIndividual: true),
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular()
                    ->defaultImageUrl(url('https://avatar.iran.liara.run/username?username=St')),
                Tables\Columns\ImageColumn::make('preview')
                    ->defaultImageUrl(url('https://placehold.co/600x400?text=No\nImage')),
                tables\Columns\IconColumn::make('isMobile')
                    ->label('Device')
                    ->sortable()
                    ->icon(fn (string $state): string => match ($state) {
                        '1' => 'heroicon-o-device-phone-mobile',
                        '0' => 'heroicon-o-computer-desktop',
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOwners::route('/'),
            // 'create' => Pages\CreateOwner::route('/create'),
            // 'edit' => Pages\EditOwner::route('/{record}/edit'),
        ];
    }
}
