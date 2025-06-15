<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukHukumResource\Pages;
use App\Filament\Resources\ProdukHukumResource\RelationManagers;
use App\Models\ProdukHukum;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdukHukumResource extends Resource
{
    protected static ?string $model = ProdukHukum::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    /**
     * Summary of navigationIcon
     * for change name of menu navigation
     * @var
     */
    public static function getModelLabel(): string
    {
        return 'Produk Hukum';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Produk Hukum'; // or 'Koperasi-Koperasi' if you want a different plural
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Web Site';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('no_peraturan')->required(),
                TextInput::make('judul')->required(),
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->required(),
                DatePicker::make('tanggal_penetapan')->required(),
                DatePicker::make('tanggal_diundangkan')->required(),
                TextInput::make('no_lembaran_daerah')->required(),
                FileUpload::make('file_produk_hukum')
                    ->directory('produk-hukum-files')
                    ->previewable(true)
                    ->maxSize(20480) // 20 MB
                    ->preserveFilenames()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
            TextColumn::make('no_peraturan')->searchable(),
            TextColumn::make('judul')->limit(50)->searchable(),
            TextColumn::make('file_produk_hukum')
                        ->label('Preview File')
                        ->formatStateUsing(fn ($state) => 'Preview')
                        ->url(fn ($record) => asset('storage/' . $record->file_produk_hukum), true)
                        ->openUrlInNewTab(),
            TextColumn::make('category.name')->label('Kategori')->sortable(),
            TextColumn::make('tanggal_penetapan')->date(),
            TextColumn::make('tanggal_diundangkan')->date(),
            TextColumn::make('no_lembaran_daerah'),
        ])
        ->defaultSort('tanggal_penetapan', 'desc')
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
            'index' => Pages\ListProdukHukums::route('/'),
            'create' => Pages\CreateProdukHukum::route('/create'),
            'edit' => Pages\EditProdukHukum::route('/{record}/edit'),
        ];
    }
}
