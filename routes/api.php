<?php

use App\Http\Controllers\PendaftarApiController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'email atau password salah'
        ], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer'
    ]);
});


Route::get('/pendaftar/{id}/pdf/download', [PendaftarApiController::class, 'downloadPdf']);

Route::middleware('auth:sanctum')->group(function () {



    Route::get('/test-log', function () {
        Log::info('✅ Tes log berhasil');
        return 'Log dicetak';
    });

    Route::get('/pendaftar', [PendaftarApiController::class, 'index']);
    Route::get('/pendaftar/{id}', [PendaftarApiController::class, 'show']);
    Route::post('/pendaftar', [PendaftarApiController::class, 'store']);
    Route::put('/pendaftar/{id}', [PendaftarApiController::class, 'update']);
    Route::delete('/pendaftar/{id}', [PendaftarApiController::class, 'destroy']);
    Route::get('/pendaftar/{id}/pdf', [PendaftarApiController::class, 'cetakPdf']);

});


Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $token = $request->user()->currentAccessToken();

    if ($token) {
        $token->delete();
        return response()->json(['message' => 'Logout berhasil']);
    } else {
        return response()->json(['message' => 'Token tidak ditemukan'], 401);
    }
})
    ?>