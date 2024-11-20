<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginAuth(Request $request)
    {
        // email:dns -> validasi email ada @nya
        $request->validate([
            'email'=>'required|email:dns',
            'password'=>'required',
        ]);
        // menyimpan isi form email dan password di variabel $user
        $user = $request->only('email', 'password');
        // Auth::attempt($user) : cek kecocokan email dan pw (HASH) (verifikasi), kalau coock simpan data di riwayat login ( di auth )
        if (Auth::attempt($user)) {
            // jika berhasil memverifikasi, arahkan ke landing_page
            return redirect()->route('landing-page');
        } else {
            // jika gagal memverifikasi, kembali ke halaman login
            return redirect()->back()->with('failed', 'Email atau Password salah!');
        }
        // if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
        //     $user = auth()->user();
        //     if ($user->role == 'admin') {
        //         return redirect()->route('admin')->with('success', 'Berhasil login sebagai administrador!');
        //     } else if ($user->role == 'user') {
        //         return redirect()->route('dashboard')->with('success', 'Berhasil login como usuario!');
        //     }
        // }
    }

    public function logout()
    {
        // menghapus riwayat login
        Auth::logout();
        // arahkan ke halaman login lagi
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all();
        $users = User::where('name', 'like', '%'.$request->search.'%')->orderBy('name', 'asc')->simplePaginate(5);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create-user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'type-role'=>'required',
        ]);

        $proses = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => $request->input('type-role'),
        ]);
        if ($proses) {
            return redirect()->route('user')->with('success', 'Berhasil menambahkan data pengguna!');
        } else {
            return redirect()->route('user.add')->with('failed', 'Gagal menambahkan data pengguna!');
        }
    }

    public function Pagelogin(Request $request) 
    {
        return view('login');
    }

//     public function login(Request $request)
//     {
//         $request->validate([
//             'email'=>'required|email',
//             'password'=>'required',
//         ]);
//         if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
//             $user = auth()->user();
//             if ($user->role == 'admin') {
//                 return redirect()->route('dashboard')->with('success', 'Login Berhasil Sukses!');
//             } elseif ($user->role == 'kasir') {
//                 return redirect()->route('dashboard')->with('success', 'Login Berhasil Sukses!');
//             }

//             return back()->withError([
//                 'email' => 'Email / Password Salah!'
//             ])->withInput($request->only('email'));
//     }
// }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data user yang mau di edit sesuai dengan id {id}
        // Gunakan metode where() untuk mencari data berdasarkan id
        // Metode first() digunakan untuk mengambil data pertama (satu data yang diambil)
        $users = User::where('id', $id)->first();
    
        // Kembalikan view edit user dengan data user yang sudah diambil
        // Gunakan metode compact() untuk mengirimkan data ke view
        // 'users' adalah nama variabel yang akan digunakan di view 'user.edit-user'
        return view('user.edit-user', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data yang dikirimkan melalui request
        // Pastikan nama, email, dan type-role harus diisi
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'type-role' => 'required',
        ]);
    
        // Cari data user yang mau di update sesuai dengan id {id}
        $userBefore = User::where('id', $id)->first();
    
        // Jika data user tidak ditemukan, redirect ke halaman edit user dengan pesan gagal
        if (!$userBefore) {
            return redirect()->route('user.edit')->with('failed', 'User not found!');
        }
    
        // Update data user dengan data yang baru
        // Gunakan metode update() untuk mengupdate data user
        $userBefore->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->input('type-role'),
            'password' => Hash::make($request->password)
        ]);
    
        // Jika password diisi, update password dengan data yang baru
        if ($request->password) {
            $dataUpdate['password'] = Hash::make($request->password);
            $userBefore->update($dataUpdate);
        }
    
        // Redirect ke halaman user dengan pesan sukses
        return redirect()->route('user')->with('success', 'Data User berhasil di update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // mencari data yang akan di hapus dengan where, lalu hapus dengan delete()
        $users = User::where('id', $id)->delete();
            if ($users) {
                // redirect() : kembali ke halaman sebelum destory dijalanin (halaman button delete berada)
                    return redirect()->back()->with('success', 'Data User berhasil dihapus');
                } else {
                    return redirect()->back()->with('failed', 'Data User gagal dihapus');
                }
    }
}
