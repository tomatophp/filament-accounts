<?php

namespace TomatoPHP\FilamentAccounts\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use TomatoPHP\FilamentAccounts\Services\GenerateAuth;

class FilamentAuthGenerate extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tomato-auth:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate controller for API auth on selected guard';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $table=$this->ask('what is the table name of this guard? (ex: users)');
        $checkIfTableExists = Schema::hasTable($table);

        while (!$checkIfTableExists){
            $this->error('Table does not exists please select another table');
            $table=$this->ask('what is the table name of this guard? (ex: users)');
            $checkIfTableExists = Schema::hasTable($table);
        }

        $guard=$this->ask('what is the guard name? (ex: users)');

        $this->warn('make sure you have added the guard to config/auth.php');
        $this->warn('make sure the col selected is exists in the table and is unique');
        $loginBy=$this->ask('what is the col you went to login by? (ex: email|phone)');
        $checkIfTableHasCol = Schema::hasColumn($table, $loginBy);

        while (!$checkIfTableHasCol){
            $this->error('Sorry your table dont have this col please select another col');
            $loginBy=$this->ask('what is the col you went to login by? (ex: email|phone)');
            $checkIfTableHasCol = Schema::hasColumn($table, $loginBy);
        }

        $loginType=$this->ask('what is the type of this col? (ex: email|tel|text)');

        while ($loginType !== 'email' && $loginType !== 'tel' && $loginType !== 'text'){
            $this->error('Sorry your type is not valid please select another type');
            $loginType=$this->ask('what is the type of this col? (ex: email|tel|text)');
        }
        $this->warn('make sure that the selected model is extend from \Illuminate\Foundation\Auth\User class');
        $model=$this->ask('please set the model of the guard? (ex: App\Models\User)');

        $isModel=false;
        while(!$isModel){
            if(class_exists($model)){
                $checkModelIns = app($model);
                if($checkModelIns instanceof \Illuminate\Foundation\Auth\User){
                    $isModel = true;
                }
            }
            else {
                $this->error('Please select a valid \Illuminate\Foundation\Auth\User Model');
                $model=$this->ask('please set the model of the guard? (ex: App\Models\User)');
            }
        }
        $this->warn('you must add 3 cols on the table to active this:');
        $this->warn('string:otp_code:null');
        $this->warn('timestamp:otp_active_at:null');
        $this->warn('bool:is_active:true');
        $checkOTP=$this->ask('do you went to active OTP check and activate user? (ex: yes[y], no[n])');
        $isSelectedTrue = false;
        while(!$isSelectedTrue){
            if($checkOTP === 'yes' || $checkOTP==='y'){
                $isSelectedTrue = true;
                $checkOTP = true;
            }
            elseif($checkOTP === 'no' || $checkOTP==='n'){
                $isSelectedTrue = true;
                $checkOTP = false;
            }
            else {
                $this->error('Please select a valid (yes[y], no[n])');
                $checkOTP=$this->ask('do you went to active OTP check and activate user? (ex: yes[y], no[n])');
                $isSelectedTrue=false;
            }
        }
        $moduleBase=$this->ask('do you like to publish it on a selected model? (ex: yes[y], no[n])');
        $isModelBaseTrue = false;
        while(!$isModelBaseTrue){
            if($moduleBase === 'yes' || $moduleBase==='y'){
                $isModelBaseTrue=true;
                $moduleBase=true;
                $moduleName=$this->ask('Please input your module name? (ex: Translations)');
                $isModuleValid = false;
                while(!$isModuleValid){
                    try {
                        module_path($moduleName);
                        $isModuleValid=true;
                    }catch (\Exception $e){
                        $this->error('Please select a valid Module name');
                        $moduleName=$this->ask('Please input your module name? (ex: Translations)');
                        $isModuleValid=false;
                    }
                }
            }
            else if($moduleBase === 'no' || $moduleBase==='n') {
                $isModelBaseTrue=true;
                $moduleBase=false;
                $moduleName = null;
            }
            else {
                $isModelBaseTrue=false;
                $this->error('Please select a valid (yes[y], no[n])');
                $moduleBase=$this->ask('do you like to publish it on a selected model? (ex: yes[y], no[n])');
            }
        }

        $authGenerator = new GenerateAuth(
            $guard,
            $loginBy,
            $loginType,
            $model,
            $checkOTP,
            $moduleBase,
            $moduleName
        );

        $authGenerator->generate();

        $this->info('The Auth Build has build a full controller for you please check your route list route:list');
        return 1;
    }
}
