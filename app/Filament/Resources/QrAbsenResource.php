<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QrAbsenResource\Pages;
use App\Models\QrAbsen;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QrAbsenResource extends Resource
{
    protected static ?string $model = QrAbsen::class;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationGroup = 'Company';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //date
                Forms\Components\DatePicker::make('date')
                    ->label('Date')
                    ->default(now())
                    ->required(),
                Forms\Components\TextInput::make('qr_checkin')
                    ->default(fn () => self::generateQRCodeCheckin())
                    ->disabled(),
                Forms\Components\TextInput::make('qr_checkout')
                    ->default(fn () => self::generateQRCodeCheckout())
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->searchable()->toggleable()->sortable(),
                Tables\Columns\ImageColumn::make('qr_checkin')
                    ->label('Check-in QR')
                    //  ->getStateUsing(function ($state) {
                //     return '<img src="data:image/png;base64,' . $state . '" width="200"/>';
                // }),
                    ->getStateUsing(fn ($record) => self::generateQrCode($record->qr_checkin)),
                Tables\Columns\ImageColumn::make('qr_checkout_image')
                    ->label('Check-out QR')
                    ->getStateUsing(fn ($record) => self::generateQrCode($record->qr_checkout)),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('amber')
                    ->action(function (QrAbsen $record) {
                        $qrCodeCheckin = self::generateQrCode($record->qr_checkin);
                        $qrCodeCheckout = self::generateQrCode($record->qr_checkout);

                        $data = [
                            'qrAbsen' => $record,
                            'qrCodeCheckin' => $qrCodeCheckin,
                            'qrCodeCheckout' => $qrCodeCheckout,
                        ];

                        $pdf = Pdf::loadView('pdf1', $data);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'qr_absen_'.$record->date.'.pdf');
                    })
                    ->icon('heroicon-o-document-text')
                    // ->openUrlInNewTab()
                    ->tooltip('Download PDF'),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make()->color('success'),
                Tables\Actions\ForceDeleteAction::make()->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListQrAbsens::route('/'),
            'create' => Pages\CreateQrAbsen::route('/create'),
            'view' => Pages\ViewQrAbsen::route('/{record}'),
            'edit' => Pages\EditQrAbsen::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    protected static function generateQRCodeCheckin()
    {
        do {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $code = substr(str_shuffle($characters), 0, 6);
        } while (QrAbsen::where('qr_checkin', $code)->exists());

        return $code;
    }

    protected static function generateQRCodeCheckout()
    {
        do {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $code = substr(str_shuffle($characters), 0, 6);
        } while (QrAbsen::where('qr_checkout', $code)->exists());

        return $code;
    }

    private static function generateQrCode($data)
    {
        if ($data === null) {
            return null;
        }

        $qrCode = QrCode::create($data)
            ->setSize(200)
            ->setMargin(10);
        $writer = new PngWriter;
        $result = $writer->write($qrCode);

        return 'data:image/png;base64,'.base64_encode($result->getString());
    }
}
