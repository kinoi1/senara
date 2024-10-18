<?php

namespace App\Providers;

use App\Models\MainModel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\QueryException; // Import exception untuk menangkap kegagalan query
use Illuminate\Support\Facades\Log; // Untuk logging jika terjadi error

class SidebarServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('backend.layouts.sidebar', function ($view) {
            try {
                // Ambil hakaksesid dari session
                // $hakaksesid = Session::get('HakAksesID');

                // if (!$hakaksesid) {
                //     throw new \Exception('Hak Akses ID tidak ditemukan di session.');
                // }

                // Filter menu berdasarkan hakaksesid
                $menuid = MainModel::GetMenuID(1)->first();
                // if (!$menuid) {
                //     throw new \Exception('Gagal mendapatkan Menu ID berdasarkan HakAksesID.');
                // }
                // var_dump($menuid);
                // Ubah JSON menjadi array
                // $menuid = json_decode($menuid);

                $menuid = json_decode($menuid->MenuID, true);

                
                // if (json_last_error() !== JSON_ERROR_NONE) {
                //     throw new \Exception('Gagal mengonversi JSON ke array: ' . json_last_error_msg());
                // }

                // Ambil data menu berdasarkan menu ID
                $menu = MainModel::GetMenu($menuid);

                if (!$menu) {
                    throw new \Exception('Gagal mendapatkan menu.');
                }

                // Bagikan data ke view
                $view->with('Menu', $menu);
            } catch (QueryException $e) {
                // Menangkap error terkait query
                Log::error('Query error: ' . $e->getMessage());
                $view->with('Menu', []); // Mengirimkan array kosong jika ada error
                $view->withErrors(['message' => 'Terjadi kesalahan pada query database.']);
            } catch (\Exception $e) {
                // Menangkap error lainnya
                Log::error('Error: ' . $e->getMessage());
                $view->with('Menu', []); // Mengirimkan array kosong jika ada error
                $view->withErrors(['message' => $e->getMessage()]);
            }
        });
    }
}