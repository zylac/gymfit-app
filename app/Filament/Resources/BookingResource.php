<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use App\Services\PaymentVerificationService;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('member_id')
                    ->relationship('member', 'name')
                    ->required(),
                Forms\Components\Select::make('pt_id')
                    ->relationship('pt', 'name'),
                Forms\Components\Select::make('membership_plan_id')
                    ->relationship('membershipPlan', 'name'),
                Forms\Components\DateTimePicker::make('schedule_time')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'PENDING_PAYMENT' => 'Pending Payment',
                        'AWAITING_VERIFICATION' => 'Awaiting Verification',
                        'APPROVED' => 'Approved',
                        'REJECTED' => 'Rejected',
                        'COMPLETED' => 'Completed',
                        'EXPIRED' => 'Expired',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('member_notes')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('pt_notes')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pt.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('membershipPlan.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('schedule_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PENDING_PAYMENT' => 'gray',
                        'AWAITING_VERIFICATION' => 'warning',
                        'APPROVED' => 'success',
                        'REJECTED' => 'danger',
                        'COMPLETED' => 'success',
                        'EXPIRED' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('amount')
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'PENDING_PAYMENT' => 'Pending Payment',
                        'AWAITING_VERIFICATION' => 'Awaiting Verification',
                        'APPROVED' => 'Approved',
                        'REJECTED' => 'Rejected',
                        'COMPLETED' => 'Completed',
                        'EXPIRED' => 'Expired',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(function (Booking $record, PaymentVerificationService $service) {
                        $payment = $record->payment;
                        if ($payment && $payment->status === 'PENDING') {
                            $service->verifyPayment($payment->id, auth()->id());
                        } else {
                            $record->update(['status' => 'APPROVED']);
                        }
                    })
                    ->visible(fn (Booking $record): bool => $record->status === 'AWAITING_VERIFICATION'),
                Tables\Actions\Action::make('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->action(function (Booking $record) {
                        $record->update(['status' => 'REJECTED']);
                    })
                    ->visible(fn (Booking $record): bool => $record->status === 'AWAITING_VERIFICATION'),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
