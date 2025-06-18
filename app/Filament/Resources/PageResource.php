<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\RichEditor;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    /**
     * Summary of navigationIcon
     * for change name of menu navigation
     * @var
     */
    public static function getModelLabel(): string
    {
        return 'Halaman';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Halaman'; // or 'Koperasi-Koperasi' if you want a different plural
    }

    /**
     * Summary of getNavigationIcon
     * for custom icon from filament
     * @return string
     */
    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-document'; // Example icon
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Web Site';
    }

    public static function form(Form $form): Form
    {
        return $form
           ->schema([

           Grid::make(12)
            ->schema([

                Card::make([
                 TextInput::make('title')
                ->label('Judul')
                ->required()
                ->live()
                ->afterStateUpdated(fn($state, callable $set) => $set ('slug', Str::slug($state))),
                TextInput::make('slug')->required(),
                RichEditor::make('content')
                ->toolbarButtons([
                    'attachFiles',
                    'blockquote',
                    'bold',
                    'bulletList',
                    'codeBlock',
                    'h2',
                    'h3',
                    'italic',
                    'link',
                    'orderedList',
                    'redo',
                    'strike',
                    'underline',
                    'undo',
                ])

                 ])->columnSpan(8),

                 Card::make([
                CuratorPicker::make('image_path')
                     ->label('Galeri Foto')
                     ->multiple(false)
                ->columnSpan(4),
                Toggle::make('is_published')->label('Published'),


                ])->columnSpan(4),
            ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('image_path')
                ->label('Foto')
                ->size(200),
                TextColumn::make('title')->label('Judul'),
                TextColumn::make('category.name')->label('Kategori')
            ])
            ->filters([
                //
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
