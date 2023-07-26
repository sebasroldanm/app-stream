<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModsResource\Pages;
use App\Filament\Resources\UsermodResource\RelationManagers\ModsRelationManager;
use App\Models\Mods;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModsResource extends Resource
{
    protected static ?string $model = Mods::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('snapshotUrl')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('widgetPreviewUrl')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('privateRate'),
                Forms\Components\TextInput::make('p2pRate'),
                Forms\Components\Toggle::make('isNonNude'),
                Forms\Components\Textarea::make('avatarUrl')
                    ->maxLength(65535),
                Forms\Components\Toggle::make('isPornStar'),
                Forms\Components\TextInput::make('id_mod')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->maxLength(255),
                Forms\Components\Toggle::make('doSpy'),
                Forms\Components\Toggle::make('doPrivate'),
                Forms\Components\TextInput::make('gender')
                    ->maxLength(255),
                Forms\Components\Toggle::make('isHd'),
                Forms\Components\Toggle::make('isVr'),
                Forms\Components\Toggle::make('is2d'),
                Forms\Components\Toggle::make('isExternalApp'),
                Forms\Components\Toggle::make('isMobile'),
                Forms\Components\Toggle::make('isModel'),
                Forms\Components\Toggle::make('isNew'),
                Forms\Components\Toggle::make('isLive'),
                Forms\Components\Toggle::make('isOnline'),
                Forms\Components\Textarea::make('previewUrl')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('previewUrlThumbBig')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('previewUrlThumbSmall')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('broadcastServer')
                    ->maxLength(255),
                Forms\Components\TextInput::make('broadcastGender')
                    ->maxLength(255),
                Forms\Components\TextInput::make('snapshotServer')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->maxLength(255),
                Forms\Components\TextInput::make('topBestPlace')
                    ->maxLength(255),
                Forms\Components\TextInput::make('username')
                    ->maxLength(255),
                Forms\Components\TextInput::make('statusChangedAt')
                    ->maxLength(255),
                Forms\Components\TextInput::make('spyRate'),
                Forms\Components\TextInput::make('publicRecordingsRate'),
                Forms\Components\TextInput::make('genderGroup')
                    ->maxLength(255),
                Forms\Components\TextInput::make('popularSnapshotTimestamp')
                    ->maxLength(255),
                Forms\Components\Toggle::make('hasGroupShowAnnouncement'),
                Forms\Components\TextInput::make('groupShowType')
                    ->maxLength(255),
                Forms\Components\TextInput::make('hallOfFamePosition'),
                Forms\Components\TextInput::make('snapshotTimestamp')
                    ->maxLength(255),
                Forms\Components\Textarea::make('hlsPlaylist')
                    ->maxLength(65535),
                Forms\Components\Toggle::make('isAvatarApproved'),
                Forms\Components\Toggle::make('isTagVerified'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('snapshotUrl'),
                Tables\Columns\ImageColumn::make('widgetPreviewUrl'),
                // Tables\Columns\TextColumn::make('privateRate'),
                // Tables\Columns\TextColumn::make('p2pRate'),
                // Tables\Columns\IconColumn::make('isNonNude')
                //     ->boolean(),
                Tables\Columns\ImageColumn::make('avatarUrl'),
                // Tables\Columns\IconColumn::make('isPornStar')
                //     ->boolean(),
                Tables\Columns\TextColumn::make('id_mod'),
                // Tables\Columns\TextColumn::make('country'),
                // Tables\Columns\IconColumn::make('doSpy')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('doPrivate')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('gender'),
                // Tables\Columns\IconColumn::make('isHd')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isVr')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('is2d')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isExternalApp')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isMobile')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isModel')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isNew')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isLive')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isOnline')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('previewUrl'),
                // Tables\Columns\TextColumn::make('previewUrlThumbBig'),
                // Tables\Columns\TextColumn::make('previewUrlThumbSmall'),
                // Tables\Columns\TextColumn::make('broadcastServer'),
                // Tables\Columns\TextColumn::make('broadcastGender'),
                // Tables\Columns\TextColumn::make('snapshotServer'),
                // Tables\Columns\TextColumn::make('status'),
                // Tables\Columns\TextColumn::make('topBestPlace'),
                Tables\Columns\TextColumn::make('username'),
                // Tables\Columns\TextColumn::make('statusChangedAt'),
                // Tables\Columns\TextColumn::make('spyRate'),
                // Tables\Columns\TextColumn::make('publicRecordingsRate'),
                // Tables\Columns\TextColumn::make('genderGroup'),
                // Tables\Columns\TextColumn::make('popularSnapshotTimestamp'),
                // Tables\Columns\IconColumn::make('hasGroupShowAnnouncement')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('groupShowType'),
                // Tables\Columns\TextColumn::make('hallOfFamePosition'),
                // Tables\Columns\TextColumn::make('snapshotTimestamp'),
                // Tables\Columns\TextColumn::make('hlsPlaylist'),
                // Tables\Columns\IconColumn::make('isAvatarApproved')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isTagVerified')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ModsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMods::route('/'),
            'create' => Pages\CreateMods::route('/create'),
            'view' => Pages\ViewMod::route('/{record}'),
            'edit' => Pages\EditMods::route('/{record}/edit'),
        ];
    }
}
