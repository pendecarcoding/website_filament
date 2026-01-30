<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PutusanResource\Pages;
use App\Filament\Resources\PutusanResource\RelationManagers;
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
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PutusanResource extends Resource
{
    protected static ?string $model = ProdukHukum::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';



    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('category', function ($query) {
                $query->whereIn('name', [
                    'Mahkamah Agung',
                    'Mahkamah Konstitusi',
                    'PN Bengkalis',
                    'PN Pekanbaru',
                    'PTUN Pekanbaru',
                    'PT Pekanbaru',
                    'PTUN Medan',
                ]);
            });
    }
    /**
     * Summary of navigationIcon
     * for change name of menu navigation
     * @var
     */
    public static function getModelLabel(): string
    {
        return 'Putusan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Putusan'; // or 'Koperasi-Koperasi' if you want a different plural
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Web Site';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('no_peraturan')
                ->label('Nomor Putusan'),

                TextInput::make('judul'),

                Select::make('category_id')
                    ->label('Jenis Putusan')
                    ->relationship('category', 'name')
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Inkrah' => 'Inkrah',
                    ])
                    ->default('Berlaku'),

                RichEditor::make('abstract')
                    ->label('Abstrak')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'bulletList',
                        'orderedList',
                        'undo',
                        'redo',
                    ])
                    ->columnSpanFull()->visible(false),

                DatePicker::make('tanggal_penetapan'),

                DatePicker::make('tanggal_diundangkan')->visible(false),

                TextInput::make('no_lembaran_daerah')->visible(false),

                FileUpload::make('file_produk_hukum')
                    ->directory('produk-hukum-files')
                    ->label('Upload File Putusan (PDF)')
                    ->previewable(true)
                    ->maxSize(20480)
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
                    ->formatStateUsing(fn($state) => 'Preview')
                    ->url(fn($record) => asset('storage/' . $record->file_produk_hukum), true)
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
            'index' => Pages\ListPutusans::route('/'),
            'create' => Pages\CreatePutusan::route('/create'),
            'edit' => Pages\EditPutusan::route('/{record}/edit'),
        ];
    }
}
