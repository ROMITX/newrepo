<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\AttendanceResource;
use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;

use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Table;
use Filament\Tables;

class ViewUser extends ViewRecord
{ 
    protected static ?string $model = Attendance::class;
    protected static string $resource = UserResource::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('attendance_date')
                    ->date(),]);
    }

 
    protected function getActions(): array
    {
        return [

            Actions\EditAction::make(),
        ];
    }

    
}
