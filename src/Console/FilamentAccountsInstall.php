<?php

namespace TomatoPHP\FilamentAccounts\Console;

use Illuminate\Console\Command;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;
use TomatoPHP\FilamentTypes\Models\Type;

class FilamentAccountsInstall extends Command
{
    use RunCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'filament-accounts:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install package and publish assets';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Publish Vendor Assets');
        $this->callSilent('optimize:clear');
        $this->artisanCommand(['migrate']);
        $this->artisanCommand(['optimize:clear']);
        if (config('filament-accounts.features.types') && class_exists(\TomatoPHP\FilamentTypes\Models\Type::class)) {
            $typesArray = [
                [
                    'name' => [
                        'ar' => 'عميل',
                        'en' => 'Customer',
                    ],
                    'key' => 'customer',
                    'for' => 'accounts',
                    'type' => 'type',
                    'icon' => 'heroicon-c-user-group',
                    'color' => '#d91919',
                ],
                [
                    'name' => [
                        'ar' => 'حساب',
                        'en' => 'Account',
                    ],
                    'key' => 'account',
                    'for' => 'accounts',
                    'type' => 'type',
                    'icon' => 'heroicon-c-user-circle',
                    'color' => '#0a56d9',
                ],
                [
                    'name' => [
                        'ar' => 'تحت المراجعة',
                        'en' => 'Pending',
                    ],
                    'key' => 'pending',
                    'for' => 'contacts',
                    'type' => 'status',
                    'icon' => 'heroicon-c-pause-circle',
                    'color' => '#ffcf00',
                ],
                [
                    'name' => [
                        'ar' => 'جاري المتابعة',
                        'en' => 'Active',
                    ],
                    'key' => 'active',
                    'for' => 'contacts',
                    'type' => 'status',
                    'icon' => 'heroicon-c-play-circle',
                    'color' => '#1897ff',
                ],
                [
                    'name' => [
                        'ar' => 'تم اغلاقها',
                        'en' => 'Closed',
                    ],
                    'key' => 'closed',
                    'for' => 'contacts',
                    'type' => 'status',
                    'icon' => 'heroicon-c-check-circle',
                    'color' => '#38fc34',
                ],
                [
                    'name' => [
                        'ar' => 'الموافقة علي الحساب',
                        'en' => 'Account Approve',
                    ],
                    'key' => 'account_approve',
                    'for' => 'contacts',
                    'type' => 'type',
                    'icon' => 'heroicon-c-check-circle',
                    'color' => '#38fc34',
                ],
            ];
            foreach ($typesArray as $item) {
                $checkFirst = Type::query()->where('key', $item['key'])->first();
                if (! $checkFirst) {
                    Type::query()->create($item);
                }
            }
        }

        $this->info('Filament Accounts installed successfully.');
    }
}
