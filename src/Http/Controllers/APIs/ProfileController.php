<?php

namespace TomatoPHP\FilamentAccounts\Http\Controllers\APIs;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use TomatoPHP\FilamentAccounts\Facades\FilamentAccountsAuth;
use TomatoPHP\FilamentAccounts\Facades\FilamentAccounts;
use TomatoPHP\FilamentAccounts\Helpers\Response;
use TomatoPHP\FilamentAccounts\Models\Account;

class ProfileController extends Controller
{
    public string $guard = 'web';

    public bool $otp = true;

    public string $model = Account::class;

    public string $loginBy = 'email';

    public string $loginType = 'email';

    public ?string $resource = null;

    /**
     *
     */
    public function __construct()
    {
        $this->guard = config('filament-accounts.guard');
        $this->otp = config('filament-accounts.required_otp');
        $this->model = config('filament-accounts.model');
        $this->loginBy = config('filament-accounts.login_by');
        $this->loginType = config('filament-accounts.login_by');
        $this->resource = config('filament-accounts.resource', null);
    }

    /**
     *  User Profile.
     *
     *  You Can Return user resource data from this APIs.
     *
     * @tags Auth
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request){
        $user = $request->user();
        if($user){
            if($this->resource){
                $user = $this->resource::make($user);
            }

            /**
             * A user resource with Token.
             *
             * @status 200
             * @body array{status: true, message: "Profile Data Load", data: UserResource}
             */
            return response()->json([
                "status" => true,
                "message" => __("Profile Data Load"),
                "data" => $user
            ]);
        }

        /*
          *  Sorry User Not Found!.
          *  @status 404
          *  @body array{status: false, message: 'user not found'}
          */
        return response()->json([
            "status" => false,
            "message" => __('user not found')
        ], 404);
    }

    /**
     *  Update User Profile.
     *
     *  You can update user data by use this APIs.
     *
     * @tags Auth
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request){
        $user = $request->user();

        if($user){
            $request->validate(array_merge(
                [
                    'name' => 'sometimes|string|max:255',
                    'email' => 'sometimes|string|email|max:255|unique:accounts,email,'.$user->id,
                    'phone' => 'sometimes|string|max:255|unique:accounts,phone,'.$user->id,
                ], FilamentAccounts::getApiValidationEdit()
            ));


            $getUserModel = $this->model::find($user->id);

            $data = $request->all();

            if($this->loginBy === 'phone' && $request->has('phone')){
                $data['username'] = $request->get('phone');
            }
            elseif($this->loginBy === 'email' && $request->has('email')){
                $data['username'] = $request->get('email');
            }

            $data['password'] = $getUserModel->password;

            $getUserModel->update($data);


            foreach (FilamentAccounts::getAttachedItems() as $key => $value) {
                if($value === 'media'){
                    if($request->hasFile($key)){
                        $user->addMedia($request->{$key})
                            ->preservingOriginal()
                            ->toMediaCollection($key);
                    }
                }
                else {
                    $user->meta($key, $request->get($key));
                }
            }

            if($this->resource){
                $getUserModel = $this->resource::make($getUserModel);
            }

            /**
             * A user resource with Token.
             *
             * @status 200
             * @body array{status: true, message: "Profile Data Update", data: UserResource}
             */
            return response()->json([
                "status" => true,
                "message" => __("Profile Data Updated"),
                "data" => $getUserModel
            ]);
        }

        /*
          *  Sorry User Not Found!.
          *  @status 404
          *  @body array{status: false, message: 'user not found'}
          */
        return response()->json([
            "status" => false,
            "message" => __('user not found')
        ], 404);
    }

    /**
     *  Update User Password.
     *
     *  You can update user password by use this APIs.
     *
     * @tags Auth
     * @param Request $request
     * @return JsonResponse
     */
    public function password(Request $request){
        $user = $request->user();

        if($user){
            $request->validate([
                'password' => "required|confirmed|min:6|max:191",
            ]);

            $user->password = bcrypt($request->get('password'));
            $user->save();

            /*
              *  If Your Has Token He Can change the password direct without OTP.
              *  @status 200
              *  @body array{status: true, message: "Password Updated"}
              */
            return response()->json([
                "status"=> true,
                "message"=> __("Password Updated")
            ], 200);
        }

        /*
          *  Sorry User Not Found!.
          *  @status 404
          *  @body array{status: false, message: 'user not found'}
          */
        return response()->json([
            "status" => false,
            "message" => __('user not found')
        ], 404);
    }

    /**
     *  Logout User.
     *
     *  You can logout the user by destory tokens and session by use this API.
     *
     * @tags Auth
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request){
        auth($this->guard)->logout();

        $user = $this->model::find($request->user()->id);
        $user->tokens()->delete();

        /*
          *  The user logout success and the tokens destoried.
          *  @status 200
          *  @body array{status: true, message: "Logout Success"}
          */
        return response()->json([
            "status"=> true,
            "message"=> __("Logout Success")
        ], 200);
    }

    /**
     *  Close Account.
     *
     *  You can close your account by send this request, please note that all data for this user will be deleted and you can register again.
     *
     * @tags Auth
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request){
        $user = $request->user();
        $this->model::where("username", $user->username)->delete();

        /*
          *  The account has been close you can register again
          *  @status 200
          *  @body array{status: true, message: "Account Has Been Deleted"}
          */
        return response()->json([
            "status"=> true,
            "message"=> __("Account Has Been Deleted")
        ], 200);
    }
}
