<?php

namespace App\Http\Controllers;

use App\Models\Hobbies;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    //

    public function index()
    {

        $timezones = $this->getTimezones();
        return view('RegistrationView')->with('timezones', $timezones);
    }

    public function save(Request $request)
    {
        // return $request->all();
        $validator = Validator::make(
            $request->all(),
            [
                'timezone' => 'required',
                'fname' => 'required|string',
                'lname' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'hobbies' => 'required|array|min:1',
            ],
            [
                'timezone.required' => 'Timezone field is required!',
                'fname.required' => 'First Name field is required!',
                'lname.required' => 'Last Name field is required!',
                'email.required' => 'Email field is required!',
                'hobbies.required' => 'Please choose atleast 1 hobbies!',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        try {

            $userCreate = User::create([
                'first_name' => $request->fname,
                'last_name' => $request->lname,
                'email' => $request->email,
                'timezone' => $request->timezone,
            ]);

            $hobbies = $request->hobbies;
            for ($i = 0; $i < count($hobbies); $i++) {
                // print_r($hobbies[$i]);
                $userCreate->hobbies()->create([
                    'hobbies' => $hobbies[$i]
                ]);
            }
            return response()->json(['status' => true, 'message' => 'Success!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    public function list()
    {
        $users = User::with('hobbies')->get();

        // Get the users with matching hobbies and timezone
        foreach ($users as $user) {
            $user['matching_users'] = User::where('id', '!=', $user->id) // Exclude the current user
                ->where('timezone', $user->timezone) // Match the same timezone
                ->whereHas('hobbies', function ($query) use ($user) {
                    $query->whereIn('hobbies', $user->hobbies->pluck('hobbies')->toArray()); // Match hobbies
                })
                ->pluck('first_name') // Get the first names of matching users
                ->toArray(); // Convert to array
        }
        // print_r($users);
        // die;
        return view('ListUsersView')->with('users', $users);
    }
    function getTimezones()
    {
        $timezones = [];
        $offsets = [];
        $now = new DateTime('now', new DateTimeZone('UTC'));

        foreach (DateTimeZone::listIdentifiers() as $timezone) {
            $now->setTimezone(new DateTimeZone($timezone));
            $offsets[] = $offset = $now->getOffset();
            $timezones[$timezone] = '(' . $this->format_GMT_offset($offset) . ') ' . $this->format_timezone_name($timezone);
        }

        array_multisort($offsets, $timezones);
        return $timezones;
    }
    function format_GMT_offset($offset)
    {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset !== false ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }

    function format_timezone_name($name)
    {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }
}