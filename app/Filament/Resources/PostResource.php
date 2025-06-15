<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
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

class PostResource extends Resource
{
    protected static ?string $model = Post::class;


/**
     * Summary of navigationIcon
     * for change name of menu navigation
     * @var
     */
    public static function getModelLabel(): string
    {
        return 'Post';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Post'; // or 'Koperasi-Koperasi' if you want a different plural
    }

    /**
     * Summary of getNavigationIcon
     * for custom icon from filament
     * @return string
     */
    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-newspaper'; // Example icon
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
                Textarea::make('content')->required(),

                 ])->columnSpan(8),

                 Card::make([
                CuratorPicker::make('image_path')
                     ->label('Galeri Foto')
                     ->multiple(false)
                ->columnSpan(4),
                Select::make('category_id')
                ->label('Kategori')
                ->relationship('category','name'),
                // DateTimePicker::make('published_at'),

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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
