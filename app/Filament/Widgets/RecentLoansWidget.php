<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentLoansWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Loan::query()
                    ->with(['user', 'equipment'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('equipment.name')
                    ->label(__('Device'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('Status'))
                    ->colors([
                        'warning' => 'pendiente',
                        'primary' => 'activo',
                        'success' => 'devuelto',
                        'danger' => 'rechazado',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pendiente' => __('Pending'),
                        'activo' => __('Active'),
                        'devuelto' => __('Returned'),
                        'rechazado' => __('Rejected'),
                        default => ucfirst($state),
                    }),

                Tables\Columns\TextColumn::make('fecha_solicitud')
                    ->label(__('Date'))
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->heading(__('Recent Loans'));
    }

    public static function canView(): bool
    {
        return auth()->user()->isAdmin();
    }
}