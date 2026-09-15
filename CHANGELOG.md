# Changelog

## v5.0.0

- Support Filament v5 and Laravel 12 / 13 (Livewire 4, PHP 8.2+).
- Requires `tomatophp/filament-types` ^5.0 and `maatwebsite/excel` ^3.1.64 or ^4.0.
- `AccountTypes::getUrl()` matches the Filament page signature (#20, thanks @Montaserz).
- The Accounts Types page creates the default `customer` / `account` types the first time it is opened (requires tomatophp/filament-types ^5.0.1).
- The account column works in tables rendered outside a panel request.
- Export / import classes declare the return types required by `maatwebsite/excel` 4.
- Export and import actions use the v5 `schema()` API.
- The accounts service can evaluate the impersonation guard / redirect closures.
- README: `auth.php` guard example, `useTypes()` docs, impersonation via `lab404/laravel-impersonate`.
- Extend the Pest test suite (account types page, install command, export / import, every plugin feature).
