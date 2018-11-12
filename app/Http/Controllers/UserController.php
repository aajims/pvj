<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\User;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort     = explode('|', $request->query('sort', 'id|asc'));
        $page     = (int) $request->get('page', 1);
        $limit    = 10;

        $total    = User::all()->count();
        $lastPage = ceil($total / $limit);

        $offset   = ($page - 1) * $limit;

        $from     = $offset;
        $to       = $from + $limit;

        $data     = User::limit($limit)
            ->offset($offset)
            ->orderBy($sort[0], $sort[1])
            ->get();

        return response()->json([
            'total'         => $total,
            'per_page'      => $limit,
            'current_page'  => $page,
            'last_page'     => $lastPage,
            'next_page_url' => ($page == $lastPage) ? null : url()->current() . '?page=' . ($page + 1),
            'prev_page_url' => ($page == 1) ? null : url()->current() . '?page=' . ($page - 1),
            'to'            => $to,
            'from'          => $from,
            'data'          => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'telepon' => 'bail|required',
//            'telepon' => 'required|exists:users,telepon,telepon,:attribute',
            'email'    => 'bail|required|email',
            'level'   => 'bail|required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'errors' => $errors->all()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (User::where('telepon', '=', Input::get('telepon'))->count() > 1) {
            return response()->json([
                'errors' => [
                    'No telepon sudah ada, silahkan masukkan No telepon yang lain !'
                ]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->telepon = $request->input('telepon');
            $user->password = bcrypt($request->input('password'));
            $user->level = $request->input('level');
            $user->nm_merchant = $request->input('nm_merchant');
            $user->logo = $request->input('logo');
            $user->save();

            return response()->json([
                'success' => true
            ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = User::find($id);

        return response()->json($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'telepon' => 'bail|required',
//            'telepon' => 'required|exists:users,telepon,telepon,:attribute',
            'email'    => 'bail|required|email'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'errors' => $errors->all()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (User::where('telepon', '=', Input::get('telepon'))->count() > 1) {
            return response()->json([
                'errors' => [
                    'No telepon sudah ada, silahkan masukkan No telepon yang lain !'
                ]
            ], 400);
        }
//        if (User::find(Auth::id())->telepon === $request->input('telepon')) {
//            return response()->json([
//                'errors'  => ['No Handphone sudah ada, Ganti dengan yang lain !']
//            ], 400);
//        }

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->telepon = $request->input('telepon');
        if(!empty($request->input('password'))){
            $user->password = bcrypt($request->input('password'));
        }
        $user->level = $request->input('level');
        $user->nm_merchant = $request->input('nm_merchant');
        $user->logo = $request->input('logo');
        $user->save();
        return response()->json([
            'success' => true
        ]);
    }

    public function updateProfil(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'telepon' => 'bail|required',
            'email'    => 'bail|required|email'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'errors' => $errors->all()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->telepon = $request->input('telepon');
        $user->save();
        return response()->json([
            'success' => true
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'bail|required|',
            'newpassword' => 'bail|required',
            'confirmpassword' => 'bail|required|same:newpassword',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'errors' => $errors->all()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ( ! Hash::check(
            $request->input('password'),
            Auth::user()->password
        )) {
            return response()->json([
                'errors' => [
                    'Kata sandi lama salah, masukkan kata sandi saat ini !'
                ]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->input('newpassword'));
        $user->save();

        return response()->json([
            'success' => true
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return response()->json([
            'succcess' => true
        ]);
    }
}
