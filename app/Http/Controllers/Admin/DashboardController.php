<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Http\Requests;
use App\Models\User;
use App\Models\UserProfile;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UserProfileRequest;
use Exception;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin/dashboard');
    }
    
    public function editProfile()
    {
        return view('admin/editProfile');
    }

    public function updateProfile(UserProfileRequest $request)
    {
        $user = Auth::user();
        //$user = User::with('UserProfile')->findOrFail(Auth::user()->id);

        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        // ]);

        try {
            if ($request->hasFile('avatar')){
                $userProfile = Auth::user()->userProfile;

                $file = $request->file('avatar');
                $destinationPath = 'uploads/user';
                
                //delete previous file
                $old_file_path = $destinationPath.'/'.$userProfile->avatar;
                if (File::exists(public_path($old_file_path))) {
                    File::delete(public_path($old_file_path));
                }

                //Move Uploaded File
                $fileData = $file->move($destinationPath,$file->getClientOriginalName());
                
                //updating user profile info
                $userProfile->avatar = $fileData->getFileName();
                $userProfile->save();
            }
            
            //updating user info
            $user->update($request->all());
            return redirect()->route('admin.editProfile')->with('status','Profile updated successfully !');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['exception' => $e->getMessage()]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
