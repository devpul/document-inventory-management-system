<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\ShareDokumen;
use Illuminate\Http\Request;
use App\Models\Users;

class DashboardController extends Controller
{
    public function index() {
        // auth yang login saat ini
        $ownerId = auth()->user()->id;

        // user: card total dokumen
        $total_dokumen_user = Dokumen::with(['user', 'log_dokumen'])->where('owner_id', $ownerId)
                                                              ->whereRelation('log_dokumen', 'tanggal_dihapus', '=',null)
                                                              ->count();
        // admin: card total dokumen
        $total_dokumen_users = Dokumen::count();

        // admin: card total user
        $total_user = Users::count();

        // user: recent activity document
        $dokumen_terbaru = Dokumen::with(['user', 'log_dokumen'])
                                    ->where('owner_id', $ownerId)
                                    ->whereRelation('log_dokumen', 'tanggal_dihapus', '=', null)
                                    ->orderBy('id', 'desc')
                                    ->limit(6)
                                    ->get();
        // admin: recent activity document
        $dokumen_terbaru_admin = Dokumen::with(['user', 'log_dokumen'])
                                    ->whereRelation('log_dokumen', 'tanggal_dihapus', '=', null)
                                    ->orderBy('id', 'desc')
                                    ->limit(8)
                                    ->get();

        if( Auth()->user()->role_id == 1 ){
            $total_dibagikan = Dokumen::whereHas('share_dokumen')
                                        ->where('owner_id', '=', $ownerId)
                                        ->count();
        }else{
            $total_dibagikan = Dokumen::whereHas('share_dokumen')->count();
        }
        
        return view ('dashboard.dashboard', 
        compact('total_dokumen_user', 'total_dokumen_users', 
                                'total_user', 'dokumen_terbaru', 
                                'dokumen_terbaru_admin', 'total_dibagikan'));
    }

    public function shared_page()
    {
        $userId = Auth()->user()->id;
        $roleId = Auth()->user()->role_id;


        if( Auth()->user()->role_id == 1 ){
            $shared_document = ShareDokumen::with('user', 'dokumen')
                            ->where('dibagikan_oleh_id', '=', $userId)
                            ->get();
        }else{
            $shared_document = ShareDokumen::with('user', 'dokumen')->get();
        }

        // dd($shared_document, $roleId);
        return view('documents.shared_document', compact('shared_document'));
    }

}
