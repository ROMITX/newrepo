<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Action;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    protected static ?string $recordTitleAttribute = 'user_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            
            ->columns([
                Tables\Columns\TextColumn::make('attendance_date')
                    ->date(),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('attendance_date')
                ->options(Attendance::all()->pluck('attendance_date','attendance_date')),
                Tables\Filters\Filter::make('selectmonth')
                ->form([
                    Forms\Components\Select::make('month')
                    ->options([
                        1 =>"January",
                        2 =>"February",
                        3 =>"March", 
                        4 =>"April", 
                        5 =>"May", 
                        6 =>"June", 
                        7 =>"July",
                        8 =>"August",
                        9 =>"September",
                        10 =>"October",
                        11 =>"November",
                        12 =>"December"
                    ])

                ])
                ->query(function (Builder $query, $data): Builder {
                    return $query
                        ->when(
                            $data['month'],
                            fn (Builder $query, $data): Builder => $query->whereDate('attendance_date', '>=', "2023-$data-01"),
                        )
                        ->when(
                            $data['month'],
                            fn (Builder $query, $data): Builder => $query->whereDate('attendance_date', '<=', "2023-$data-30" ),
                        );
                }),
                
                Tables\Filters\Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_from'),
                    Forms\Components\DatePicker::make('created_until'),
                    
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('attendance_date', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('attendance_date', '<=', $date),
                        );
                })
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
