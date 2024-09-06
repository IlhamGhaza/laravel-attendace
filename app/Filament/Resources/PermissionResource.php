<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use App\Models\Permission;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-minus-circle';

    protected static ?string $navigationGroup = 'Attendance';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('date_permission')
                    ->required(),
                Forms\Components\Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image(),
                Forms\Components\Toggle::make('is_approved')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(isIndividual: true)
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_permission')
                    ->date()
                    ->searchable(isIndividual: true)
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reason'),
                Tables\Columns\ImageColumn::make('image')
                    //disk = 'public/permissions'
                    ->disk('permissions')
                    ->getStateUsing(fn ($record) => $record->image ? asset('storage/permissions/'.ltrim($record->image, '/')) : null)
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('created_at')
                    ->label('Date Permission')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                // Tables\Filters\Filter::make('date_permission')
                //     ->label('Date Permission')
                //     ->form([
                //         Forms\Components\DatePicker::make('start_date')
                //             ->label('Start Date')
                //             ->placeholder('Select start date'),
                //         Forms\Components\DatePicker::make('end_date')
                //             ->label('End Date')
                //             ->placeholder('Select end date'),
                //     ])
                //     ->query(function ($query, array $data) {
                //         if ($data['start_date']) {
                //             $query->whereDate('created_at', '>=', $data['start_date']);
                //         }
                //         if ($data['end_date']) {
                //             $query->whereDate('created_at', '<=', $data['end_date']);
                //         }
                //         return $query;
                //     }),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('approve')
                    ->label('Approve')
                    ->action(function ($record) {
                        // Ubah status permission menjadi approved
                        $record->is_approved = 1;
                        $record->save();

                        // Kirim notifikasi ke user
                        self::sendNotificationToUser($record->user_id, 'Permission Anda telah disetujui.');
                    })
                    ->requiresConfirmation()
                    ->color('primary')
                   //if succes create notification success change
                    ->successNotificationTitle('Permission approved successfully'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
                    // Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'view' => Pages\ViewPermission::route('/{record}'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function sendNotificationToUser($userId, $message)
    {
        // Dapatkan FCM token user dari tabel 'users'
        $user = User::find($userId);
        $token = $user->fcm_token;

        // Kirim notifikasi ke perangkat Android
        $messaging = app('firebase.messaging');
        $notification = Notification::create('Status Izin', $message);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        $messaging->send($message);
    }
}
