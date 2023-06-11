<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Scopes\TenantScope;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\Rules;
use function PHPUnit\Framework\isEmpty;

class SocialMediaRegisterUserController
{
    public function store(Request $request, string $provider)
    {
        try {
            $user = Socialite::driver($provider)->user();

//            $rules = [
//                'name' => ['required', 'string', 'max:255'],
//                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
//            ];
//
//            $request->validate($rules);

          $request->session()->regenerate();


            if (!User::withoutGlobalScope(TenantScope::class)->where("email", $user->getEmail())->exists()) {
                $user = User::updateOrCreate(
                    ["{$provider}_id" => $user->getId()],
                    ['name' => $user->getName(), 'password' => Hash::make(Str::password()), 'email' => $user->getEmail()]);

              event(new Registered($user));
            }

        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
        // redirect con token y cookie para una nuevo pagina de web de fronted /redirect?token=123&cookie=123
        // en el front almacenar la cookie y el token en localstorage
        $authUser =  User::withoutGlobalScope(TenantScope::class)->where("email", $user->getEmail())->first();
        Auth::login($authUser);

        return redirect()->away(env('FRONTEND_URL'));
    }
}
