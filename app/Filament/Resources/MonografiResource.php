<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonografiResource\Pages;
use App\Filament\Resources\MonografiResource\RelationManagers;
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

class MonografiResource extends Resource
{
    protected static ?string $model = ProdukHukum::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';


    /**
     * Summary of navigationIcon
     * for change name of menu navigation
     * @var
     */
    public static function getModelLabel(): string
    {
        return 'Monografi';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Monografi'; // or 'Koperasi-Koperasi' if you want a different plural
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Web Site';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('category', function ($query) {
                $query->whereIn('name', [
                    'Naskah Akademik',
                    'Edaran',
                    'Ranperda',
                    'Risalah',
                    'Kajian Hukum',
                    'Hasil Analisis dan Evaluasi',
                ]);
            });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('no_peraturan')
                    ->visible(false)
                    ->label('Nomor Putusan'),

                TextInput::make('judul'),

                Select::make('category_id')
                    ->label('Jenis')
                    ->relationship(
                        name: 'category',
                        titleAttribute: 'name',
                        modifyQueryUsing: function (Builder $query) {
                            $query->whereIn('name', [
                                'Naskah Akademik',
                                'Edaran',
                                'Ranperda',
                                'Risalah',
                                'Kajian Hukum',
                                'Hasil Analisis dan Evaluasi',
                            ]);
                        }
                    )
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        '-' => '-',
                        'Berlaku' => 'Berlaku',
                        'Tidak Berlaku' => 'Tidak Berlaku',
                        'Dicabut' => 'Dicabut',
                        'Mencabut' => 'Mencabut',
                    ])
                    ->default('Berlaku'),

                TextInput::make('nama_instansi')->visible(true)->label('Instansi Pembuat'),

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

                DatePicker::make('tanggal_penetapan')->label('Tanggal Terbit'),

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
                TextColumn::make('no_peraturan')->label('No Putusan')->searchable(),
                TextColumn::make('judul')->limit(50)->searchable(),
                TextColumn::make('file_produk_hukum')
                    ->label('Preview File')
                    ->formatStateUsing(fn($state) => 'Preview')
                    ->url(fn($record) => asset('storage/' . $record->file_produk_hukum), true)
                    ->openUrlInNewTab(),
                TextColumn::make('category.name')->label('Jenis Putusan')->sortable(),
                TextColumn::make('tanggal_penetapan')->date(),
                TextColumn::make('tanggal_diundangkan')->visible(false)->date(),
                TextColumn::make('no_lembaran_daerah')->visible(false),
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
            'index' => Pages\ListMonografis::route('/'),
            'create' => Pages\CreateMonografi::route('/create'),
            'edit' => Pages\EditMonografi::route('/{record}/edit'),
        ];
    }
}
