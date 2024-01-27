<?php

namespace App\Filament\Resources;

use App\Enums\BoxKindEnum;
use App\Filament\Resources\RentResource\Pages;
use App\Models\Rent;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;

class RentResource extends Resource
{
    protected static ?string $model = Rent::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    public static function getModelLabel(): string
    {
        return __('rent');
    }

    public static function getPluralModelLabel(): string
    {
        return __('rents');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->maxLength(255),

                Select::make('type_id')
                    ->relationship('type', 'title')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->required(),

                Select::make('area_id')
                    ->relationship('area', 'title')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->createOptionForm([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->required(),

                TextInput::make('mobile')
                    ->maxLength(11)
                    ->minLength(11)
                    ->length(11)
                    ->numeric(),

                TextInput::make('arena')
                    ->maxLength(255)
                    ->numeric(),

                Forms\Components\Select::make('tags')
                    ->relationship('tags', 'title')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                    ]),

                TextInput::make('mortgage')
                    ->numeric()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->placeholder('123,456,789')
                    ->prefix('$'),

                TextInput::make('rent')
                    ->numeric()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->placeholder('123,456,789')
                    ->prefix('$'),

                Textarea::make('address')
                    ->maxLength(65535),

                Textarea::make('description')
                    ->maxLength(65535),

                SpatieMediaLibraryFileUpload::make('image')
                    ->multiple()
                    ->conversion('thumb')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),

                ToggleColumn::make('is_active'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->relationship('type', 'title'),

                Tables\Filters\SelectFilter::make('area')
                    ->relationship('area', 'title')
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('tag')
                    ->relationship('tags', 'title')
                    ->multiple()
                    ->preload(),

                Filter::make('price from')
                    ->form([
                        TextInput::make('from')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->placeholder('123,456,789')
                            ->prefix('$'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['from'],
                            function (Builder $query, $from) {
                                $from = str()->replace(',', '', $from);
                                $query->where('rent', '>=', $from);
                            });
                    }),

                Filter::make('price to')
                    ->form([
                        TextInput::make('to')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->placeholder('123,456,789')
                            ->prefix('$'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['to'],
                            function (Builder $query, $to) {
                                $to = str()->replace(',', '', $to);
                                $query->where('rent', '<=', $to);
                            });
                    }),

                Filter::make('is_active')
                    ->default()
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))

            ], layout: FiltersLayout::AboveContentCollapsible)
            ->filtersFormColumns(3)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn($query) => $query->where('user_id', auth()->id())->where('kind', BoxKindEnum::RENT));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRent::route('/'),
            'create' => Pages\CreateRent::route('/create'),
            'edit' => Pages\EditRent::route('/{record}/edit'),
        ];
    }
}
