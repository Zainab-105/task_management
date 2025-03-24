<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\{DB, Hash, Storage};
use Spatie\Permission\Models\Role;
use Exception;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.users.index')->with(['custom_title' => 'Users']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.users.create')->with(['custom_title' => 'User']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $role = Role::where('name', $request->role)->first();
        $details                    =   $request->all();
        $details['password']        =   Hash::make('Admin@123');
        $user = User::create($details);

        $user->assignRole($role->name);
        $user->update(['role_id' => $user->roles->first()->id]);

        if( $user->save() ) {
            flash('User account created successfully!')->success();
        } else {
            flash('Unable to save user. Please try again later.')->error();
        }
        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.pages.users.view', compact('user'))->with(['custom_title' => 'User']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.pages.users.edit', compact('user'))->with(['custom_title' => 'User']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(UserRequest $request, User $user)
    {
        try{
            DB::beginTransaction();
            
            $details    =   $request->all();
            $user->fill($details);
            $role = Role::where('name', $request->role)->first();
            $user->syncRoles([$role->name]);
            $user->update(['role_id' => $user->roles->first()->id]);
            if( $user->save() ) {
                DB::commit();
                flash('User details updated successfully!')->success();
            } else {
                flash('Unable to update user. Try again later')->error();
            }
            return redirect(route('users.index'));
            
        }catch(QueryException $e){
            DB::rollback();
            return redirect()->back()->flash('error',$e->getMessage());
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $records = [];
        $users = User::where('role_id','!=',1)->orderBy($sort_column, $sort_order);

        if ($search != '') {
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('created_at', 'like', "%{$search}%");
            });
        }

        $count = $users->count();
        $records['recordsTotal'] = $count;
        $records['recordsFiltered'] = $count;
        $records['data'] = [];

        $users = $users->offset($offset)->limit($limit)->orderBy($sort_column, $sort_order)->latest()->get();
        foreach ($users as $user) {

            $records['data'][] = [
                'id'            =>  $user->id,
                'name'          =>  $user->name ?? "--",
                'email'         =>  $user->email ? '<a href="mailto:' . $user->email . '" >' . $user->email . '</a>' : "--",
                'created_at'    =>  $user->created_at->format('d-m-Y'),
                'role_id'       =>  ucfirst($user->roles->first()->name),
                'action'        =>  view('admin.layouts.includes.actions')->with(['custom_title' => 'User', 'id' => $user->id], $user)->render(),
            ];
        }
        return $records;
    }

    public function checkEmail(Request $request)
    {
        $id = $request->id ?? 0;
        $existEmail = "false";
    	$count = User::query();

    	$count = $count->where([
    			['id', '<>', $id],
    			'email' => $request->email,
    		])->count();

        if( $count == 0 ){
            if($request->type == 'user-forgot-password' || $request->type == 'vendor-forgot-password'){
                $existEmail = "false";
            }else{
                $existEmail = "true";
            }
        }else{
            if($request->type == 'user-forgot-password' || $request->type == 'vendor-forgot-password'){
                $existEmail = "true";
            }else{
                $existEmail = "false";
            }
        }

        return $existEmail;
    }

    public function checkPassword(Request $request)
    {
        if(Hash::check($request->old_password, $request->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

}
