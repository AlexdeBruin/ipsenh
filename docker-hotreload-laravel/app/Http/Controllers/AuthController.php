<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Role;
use App\Specialisation;
use App\Student_Info;


class AuthController extends Controller
{
    public function signup(Request $registration_form)
    {
        $student_role = Role::where('name', 'student')->first();
        $teacher_role = Role::where('name', 'teacher')->first();
        $admin_role  = Role::where('name', 'admin')->first();

        $registration_role_from_form = $registration_form->role_assignment;
        
        $registration_form->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
            'first_name' => $registration_form->first_name,
            'last_name' => $registration_form->last_name,
            'zip_code' => $registration_form->zip_code,
            'birthdate' => date('Y-m-d', strtotime($registration_form->birthdate)),
            'address' => $registration_form->address,
            'email' => $registration_form->email,
            'password' => bcrypt($registration_form->password)
        ]);

        $user->save();
        
        if($registration_role_from_form == 'student') {
            $student_specialisation = Specialisation::where('name', 'propedeuse')->first();

            $student_information = new Student_Info;
            $student_information->student_number = $registration_form->student_number;
            $student_information->specialisation()->associate($student_specialisation);

            $user->studentInfo()->save($student_information);

            $user->roles()->sync($student_role);
        } 

        if($registration_role_from_form == 'teacher') {
            $user->roles()->sync($teacher_role);
        } 

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
  
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        // if ($request->remember_me)
        //     $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
  
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}