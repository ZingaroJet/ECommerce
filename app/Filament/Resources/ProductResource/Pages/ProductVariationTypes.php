<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Enums\ProductVariationTypeEnum;
use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;

class ProductVariationTypes extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected static ?string $title = 'Variation Types';

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    public function form (Form $form): Form{

        return $form
        ->schema([
            Repeater::make('variation_types')
                ->label(false)
                ->relationship()
                ->collapsible()
                ->defaultItems(1)
                ->addActionLabel(__('Add new variation type'))
                ->columns(2)
                ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->options(ProductVariationTypeEnum::labels())
                            ->required()
                            ->searchable(),
                        Repeater::make('options')
                            ->relationship()
                            ->collapsible()
                            ->schema([
                                TextInput::make('name')
                                    ->columnSpan(2)
                                    ->required(),
                                SpatieMediaLibraryFileUpload::make('image')
                                ->image()
                                ->multiple()
                                ->openable()
                                ->downloadable()
                                ->panelLayout('grid')
                                ->collection('images')
                                ->reorderable()
                                ->appendFiles()
                                ->preserveFilenames()
                                ->columnSpan(3)
                            ])
                            ->columnSpan(2)
                    ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

}
