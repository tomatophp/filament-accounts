<?php

namespace TomatoPHP\FilamentAccounts\Import;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use TomatoPHP\FilamentAccounts\Models\Account;

class ImportAccounts implements ToCollection
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if (str($row[0])->contains(trans('filament-accounts::messages.accounts.columns.id'))) {
                continue;
            } else {
                $account = Account::query()->firstOrCreate([
                    'email' => $row[2] ?? null,
                    'phone' => $row[3] ?? null,
                    'username' => $row[2] ?? null,
                ], [
                    'name' => $row[1],
                    'email' => $row[2] ?? null,
                    'phone' => $row[3] ?? null,
                    'username' => $row[2] ?? null,
                    'address' => $row[4] ?? null,
                    'type' => $row[5] ?? 'account',
                    'is_active' => $row[6] ?? false,
                ]);

                if ($account->exists) {
                    $account->update([
                        'name' => $row[1],
                        'email' => $row[2] ?? null,
                        'phone' => $row[3] ?? null,
                        'username' => $row[2] ?? null,
                        'address' => $row[4] ?? null,
                        'type' => $row[5] ?? 'account',
                        'is_active' => $row[6] ?? false,
                    ]);
                }
            }
        }
    }
}
