<?php

namespace TomatoPHP\FilamentAccounts\Export;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAccounts implements FromCollection, WithHeadings
{
    public function __construct(
        public array $data
    ) {}

    public function headings(): array
    {
        return array_values($this->data['columns']);
    }

    public function collection()
    {
        $select = array_keys(collect($this->data['columns'])->filter(fn ($item, $key) => ! str($key)->contains('.'))->toArray());

        return config('filament-accounts.model')::query()
            ->select($select)
            ->get()
            ->map(function ($item) {
                return collect($this->data['columns'])->map(function ($column, $key) use ($item) {
                    if (str($key)->contains('.')) {
                        $keys = explode('.', $key);
                        if (is_a($item->{$keys[0]}, Collection::class)) {
                            return collect($item->{$keys[0]})->map(fn ($item) => $item->{$keys[1]})->implode(', ');
                        } else {
                            return $item->{$keys[0]}?->{$keys[1]};
                        }

                    }

                    return $item->{$key};
                });
            });
    }
}
