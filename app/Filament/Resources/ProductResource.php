<?php

namespace App\Filament\Resources;


use App\Enums\ProductStatusEnum;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages\ProductImages;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-c-queue-list';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::End;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                ->schema([
                        TextInput::make('title')
                        ->live(onBlur: true)
                        ->required()
                        ->afterStateUpdated(
                            function (string $operation, $state, callable $set){
                                $set('slug', Str::slug($state));
                            }
                        ),
                        TextInput::make('slug')->required(),
                        Select::make('department_id')
                        ->relationship('department', 'name')
                        ->label(__('Department'))
                        ->preload()
                        ->searchable()
                        ->reactive() //makes the field reactive to changes in the department field
                        ->required()
                        ->afterStateUpdated(function (callable $set){
                            $set('category_id', null); //reset the category field when the department changes
                        }),
                        Select::make('category_id')
                        ->relationship(
                            'category',
                            'name',
                            function (Builder $query, callable $get) {
                                $departmentId = $get('department_id'); //get selected department ID
                                if ($departmentId) {
                                    $query->where('department_id', $departmentId); //filter categories based on department
                                }
                            }
                        )->label(__('Category'))
                        ->preload()
                        ->searchable()
                        ->reactive()
                        ->required()
                ]),
                Forms\Components\RichEditor::make('description')
                ->required()
                ->toolbarButtons([
                    'bold',
                    'italic',
                    'underline',
                    'strikeThrough',
                    'codeBlock',
                    'link',
                    'bulletedList',
                    'numberedList',
                    'orderedList',
                    'h2',
                    'h3',
                    'h1',
                    'blockquote',
                    'undo',
                    'redo',
                    'table',
                ])
                ->columnSpan(2),
                TextInput::make('price')
                ->required()
                ->numeric(),
                TextInput::make('quantity')
                ->integer(),
                Select::make('status')
                ->options(ProductStatusEnum::labels())
                ->default(ProductStatusEnum::Draft->value)
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('images')
                    ->collection('images')
                    ->limit(1)
                    ->label('Image')
                    ->conversion('thumb'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->words(20),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors(ProductStatusEnum::colors())
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()

            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ProductStatusEnum::labels()),
                Selectfilter::make('department_id')
                    ->relationship('department', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'images' => Pages\ProductImages::route('/{record}/images'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            EditProduct::class,
            ProductImages::class
        ]);
    }
}
