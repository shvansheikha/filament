<?php

namespace App\Filament\Resources;

use App\Enums\BoxKindEnum;
use App\Filament\Resources\BoxResource\Pages;
use App\Models\Box;
use App\Models\Part;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BoxResource extends Resource
{
    protected static ?string $model = Box::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function getModelLabel(): string
    {
        return __('box');
    }

    public static function getPluralModelLabel(): string
    {
        return __('boxes');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->translateLabel()
                    ->maxLength(255),

                TextInput::make('name')
                    ->translateLabel()
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

                Select::make('part_id')
                    ->options(fn(Forms\Get $get): Collection => Part::query()
                        ->where('area_id', $get('area_id'))
                        ->pluck('title', 'id'))
                    ->searchable()
                    ->preload()
                    ->afterStateUpdated(fn(Forms\Set $set) => $set('part_id', null))
                    ->createOptionForm([
                        Select::make('area_id')
                            ->relationship('area', 'title')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->required(),

                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                    ]),

                TextInput::make('price')
                    ->numeric()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->placeholder('123,456,789')
                    ->prefix('$'),

                TextInput::make('mobile')
                    ->maxLength(11)
                    ->minLength(11)
                    ->length(11)
                    ->numeric(),

                TextInput::make('arena')
                    ->maxLength(255)
                    ->numeric(),

                TextInput::make('built')
                    ->maxLength(255)
                    ->numeric(),

                TextInput::make('location')
                    ->maxLength(255),

                Forms\Components\Select::make('tags')
                    ->relationship('tags', 'title')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                    ]),

                TextInput::make('box_number')
                    ->maxLength(255)
                    ->numeric(),

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
                TextColumn::make('title')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('mobile'),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),

                ToggleColumn::make('is_active'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
                                $query->where('price', '>=', $from);
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
                                $query->where('price', '<=', $to);
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
            ->modifyQueryUsing(fn($query) => $query->where('user_id', auth()->id())->where('kind', BoxKindEnum::SELL))
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoxes::route('/'),
            'create' => Pages\CreateBox::route('/create'),
            'edit' => Pages\EditBox::route('/{record}/edit'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('settings')->action('changeLang'),
        ];
    }

    public function changeLang()
    {
        $lang = app()->getLocale();

        $lang = $lang == 'en' ? 'fa' : 'en';

        app()->setLocale($lang);
    }
}
