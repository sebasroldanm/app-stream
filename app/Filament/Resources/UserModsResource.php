<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhotosResource\RelationManagers\PhotosRelationManager;
use App\Filament\Resources\UserModsResource\Pages;
use App\Filament\Resources\UserModsResource\RelationManagers;
use App\Filament\Resources\UserModsResource\RelationManagers\ModsRelationManager;
use App\Models\UserMods;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserModsResource extends Resource
{
    protected static ?string $model = UserMods::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('mod_id')
                    ->required(),
                Forms\Components\TextInput::make('id_mod')
                    ->maxLength(255),
                Forms\Components\Toggle::make('isDeleted'),
                Forms\Components\TextInput::make('name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('birthDate')
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->maxLength(255),
                Forms\Components\TextInput::make('region')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cityId'),
                Forms\Components\TextInput::make('interestedIn')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bodyType')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ethnicity')
                    ->maxLength(255),
                Forms\Components\TextInput::make('hairColor')
                    ->maxLength(255),
                Forms\Components\TextInput::make('eyeColor')
                    ->maxLength(255),
                Forms\Components\TextInput::make('subculture')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('showProfileTo')
                    ->maxLength(255),
                Forms\Components\Textarea::make('amazonWishlist')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('age'),
                Forms\Components\TextInput::make('kingId'),
                Forms\Components\TextInput::make('becomeKingThreshold'),
                Forms\Components\TextInput::make('favoritedCount'),
                Forms\Components\TextInput::make('whoCanChat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('spyRate'),
                Forms\Components\TextInput::make('privateRate'),
                Forms\Components\TextInput::make('p2pRate'),
                Forms\Components\TextInput::make('privateMinDuration'),
                Forms\Components\TextInput::make('p2pMinDuration'),
                Forms\Components\TextInput::make('privateOfflineMinDuration'),
                Forms\Components\TextInput::make('p2pOfflineMinDuration'),
                Forms\Components\TextInput::make('p2pVoiceRate'),
                Forms\Components\TextInput::make('groupRate'),
                Forms\Components\TextInput::make('ticketRate'),
                Forms\Components\TextInput::make('publicRecordingsRate'),
                Forms\Components\TextInput::make('status')
                    ->maxLength(255),
                Forms\Components\TextInput::make('broadcastServer')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ratingPrivate'),
                Forms\Components\TextInput::make('ratingPrivateUsers'),
                Forms\Components\TextInput::make('topBestPlace'),
                Forms\Components\TextInput::make('statusChangedAt')
                    ->maxLength(255),
                Forms\Components\TextInput::make('wentIdleAt')
                    ->maxLength(255),
                Forms\Components\TextInput::make('broadcastGender')
                    ->maxLength(255),
                Forms\Components\Toggle::make('isHd'),
                Forms\Components\Toggle::make('isHls240p'),
                Forms\Components\Toggle::make('isVr'),
                Forms\Components\Toggle::make('is2d'),
                Forms\Components\Toggle::make('isMlNonNude'),
                Forms\Components\Toggle::make('isDisableMlNonNude'),
                Forms\Components\Toggle::make('hasChatRestrictions'),
                Forms\Components\Toggle::make('isExternalApp'),
                Forms\Components\Toggle::make('isStorePrivateRecordings'),
                Forms\Components\Toggle::make('isStorePublicRecordings'),
                Forms\Components\Toggle::make('isMobile'),
                Forms\Components\TextInput::make('spyMinimum'),
                Forms\Components\TextInput::make('privateMinimum'),
                Forms\Components\TextInput::make('privateOfflineMinimum'),
                Forms\Components\TextInput::make('p2pMinimum'),
                Forms\Components\TextInput::make('p2pOfflineMinimum'),
                Forms\Components\TextInput::make('p2pVoiceMinimum'),
                Forms\Components\Textarea::make('previewUrl')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('previewUrlThumbBig')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('previewUrlThumbSmall')
                    ->maxLength(65535),
                Forms\Components\Toggle::make('doPrivate'),
                Forms\Components\Toggle::make('doP2p'),
                Forms\Components\Toggle::make('doSpy'),
                Forms\Components\TextInput::make('snapshotServer')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ratingPosition'),
                Forms\Components\Toggle::make('isNew'),
                Forms\Components\Toggle::make('isLive'),
                Forms\Components\TextInput::make('hallOfFamePosition'),
                Forms\Components\Toggle::make('isPornStar'),
                Forms\Components\TextInput::make('broadcastCountry')
                    ->maxLength(255),
                Forms\Components\TextInput::make('username')
                    ->maxLength(255),
                Forms\Components\TextInput::make('login')
                    ->maxLength(255),
                Forms\Components\TextInput::make('domain')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gender')
                    ->maxLength(255),
                Forms\Components\TextInput::make('genderDoc')
                    ->maxLength(255),
                Forms\Components\TextInput::make('showTokensTo')
                    ->maxLength(255),
                Forms\Components\Textarea::make('offlineStatus')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('offlineStatusUpdatedAt')
                    ->maxLength(255),
                Forms\Components\Toggle::make('isOnline'),
                Forms\Components\Toggle::make('isBlocked'),
                Forms\Components\Textarea::make('avatarUrl')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('avatarUrlThumb')
                    ->maxLength(65535),
                Forms\Components\Toggle::make('isRegular'),
                Forms\Components\Toggle::make('isExGreen'),
                Forms\Components\Toggle::make('isGold'),
                Forms\Components\Toggle::make('isUltimate'),
                Forms\Components\Toggle::make('isGreen'),
                Forms\Components\Toggle::make('hasVrDevice'),
                Forms\Components\Toggle::make('isModel'),
                Forms\Components\Toggle::make('isStudio'),
                Forms\Components\Toggle::make('isAdmin'),
                Forms\Components\Toggle::make('isSupport'),
                Forms\Components\Toggle::make('isFinance'),
                Forms\Components\Toggle::make('isOfflinePrivateAvailable'),
                Forms\Components\Toggle::make('isApprovedModel'),
                Forms\Components\Toggle::make('isDisplayedModel'),
                Forms\Components\Toggle::make('hasAdminBadge'),
                Forms\Components\Toggle::make('isPromo'),
                Forms\Components\Toggle::make('isUnThrottled'),
                Forms\Components\TextInput::make('userRanking')
                    ->maxLength(255),
                Forms\Components\TextInput::make('snapshotTimestamp')
                    ->maxLength(255),
                Forms\Components\TextInput::make('contestGender')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('mod_id'),
                // Tables\Columns\TextColumn::make('id_mod'),
                Tables\Columns\IconColumn::make('isDeleted')
                    ->boolean(),
                Tables\Columns\TextColumn::make('name'),
                // Tables\Columns\TextColumn::make('birthDate'),
                Tables\Columns\TextColumn::make('country'),
                // Tables\Columns\TextColumn::make('region'),
                // Tables\Columns\TextColumn::make('city'),
                // Tables\Columns\TextColumn::make('cityId'),
                // Tables\Columns\TextColumn::make('interestedIn'),
                // Tables\Columns\TextColumn::make('bodyType'),
                // Tables\Columns\TextColumn::make('ethnicity'),
                // Tables\Columns\TextColumn::make('hairColor'),
                // Tables\Columns\TextColumn::make('eyeColor'),
                // Tables\Columns\TextColumn::make('subculture'),
                // Tables\Columns\TextColumn::make('description'),
                // Tables\Columns\TextColumn::make('showProfileTo'),
                // Tables\Columns\TextColumn::make('amazonWishlist'),
                // Tables\Columns\TextColumn::make('age'),
                // Tables\Columns\TextColumn::make('kingId'),
                // Tables\Columns\TextColumn::make('becomeKingThreshold'),
                // Tables\Columns\TextColumn::make('favoritedCount'),
                // Tables\Columns\TextColumn::make('whoCanChat'),
                // Tables\Columns\TextColumn::make('spyRate'),
                // Tables\Columns\TextColumn::make('privateRate'),
                // Tables\Columns\TextColumn::make('p2pRate'),
                // Tables\Columns\TextColumn::make('privateMinDuration'),
                // Tables\Columns\TextColumn::make('p2pMinDuration'),
                // Tables\Columns\TextColumn::make('privateOfflineMinDuration'),
                // Tables\Columns\TextColumn::make('p2pOfflineMinDuration'),
                // Tables\Columns\TextColumn::make('p2pVoiceRate'),
                // Tables\Columns\TextColumn::make('groupRate'),
                // Tables\Columns\TextColumn::make('ticketRate'),
                // Tables\Columns\TextColumn::make('publicRecordingsRate'),
                Tables\Columns\TextColumn::make('status'),
                // Tables\Columns\TextColumn::make('broadcastServer'),
                // Tables\Columns\TextColumn::make('ratingPrivate'),
                // Tables\Columns\TextColumn::make('ratingPrivateUsers'),
                // Tables\Columns\TextColumn::make('topBestPlace'),
                // Tables\Columns\TextColumn::make('statusChangedAt'),
                // Tables\Columns\TextColumn::make('wentIdleAt'),
                // Tables\Columns\TextColumn::make('broadcastGender'),
                // Tables\Columns\IconColumn::make('isHd')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isHls240p')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isVr')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('is2d')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isMlNonNude')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isDisableMlNonNude')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('hasChatRestrictions')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isExternalApp')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isStorePrivateRecordings')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isStorePublicRecordings')
                //     ->boolean(),
                Tables\Columns\IconColumn::make('isMobile')
                    ->boolean(),
                // Tables\Columns\TextColumn::make('spyMinimum'),
                // Tables\Columns\TextColumn::make('privateMinimum'),
                // Tables\Columns\TextColumn::make('privateOfflineMinimum'),
                // Tables\Columns\TextColumn::make('p2pMinimum'),
                // Tables\Columns\TextColumn::make('p2pOfflineMinimum'),
                // Tables\Columns\TextColumn::make('p2pVoiceMinimum'),
                Tables\Columns\ImageColumn::make('previewUrl'),
                // Tables\Columns\TextColumn::make('previewUrlThumbBig'),
                // Tables\Columns\TextColumn::make('previewUrlThumbSmall'),
                // Tables\Columns\IconColumn::make('doPrivate')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('doP2p')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('doSpy')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('snapshotServer'),
                // Tables\Columns\TextColumn::make('ratingPosition'),
                // Tables\Columns\IconColumn::make('isNew')
                //     ->boolean(),
                Tables\Columns\IconColumn::make('isLive')
                    ->boolean(),
                // Tables\Columns\TextColumn::make('hallOfFamePosition'),
                // Tables\Columns\IconColumn::make('isPornStar')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('broadcastCountry'),
                // Tables\Columns\TextColumn::make('username'),
                // Tables\Columns\TextColumn::make('login'),
                // Tables\Columns\TextColumn::make('domain'),
                // Tables\Columns\TextColumn::make('gender'),
                // Tables\Columns\TextColumn::make('genderDoc'),
                // Tables\Columns\TextColumn::make('showTokensTo'),
                // Tables\Columns\TextColumn::make('offlineStatus'),
                // Tables\Columns\TextColumn::make('offlineStatusUpdatedAt'),
                // Tables\Columns\IconColumn::make('isOnline')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isBlocked')
                //     ->boolean(),
                Tables\Columns\ImageColumn::make('avatarUrl'),
                // Tables\Columns\TextColumn::make('avatarUrlThumb'),
                // Tables\Columns\IconColumn::make('isRegular')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isExGreen')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isGold')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isUltimate')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isGreen')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('hasVrDevice')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isModel')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isStudio')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isAdmin')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isSupport')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isFinance')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isOfflinePrivateAvailable')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isApprovedModel')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isDisplayedModel')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('hasAdminBadge')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isPromo')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('isUnThrottled')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('userRanking'),
                // Tables\Columns\TextColumn::make('snapshotTimestamp'),
                // Tables\Columns\TextColumn::make('contestGender'),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime(),
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
            PhotosRelationManager::class,
            ModsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserMods::route('/'),
            'create' => Pages\CreateUserMods::route('/create'),
            'view' => Pages\ViewUserMods::route('/{record}'),
            'edit' => Pages\EditUserMods::route('/{record}/edit'),
        ];
    }
}
