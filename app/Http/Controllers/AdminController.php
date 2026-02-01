<?php

namespace App\Http\Controllers;

use App\Exports\BoothCheckin as ExportsBoothCheckin;
use App\Exports\PesertaExport;
use App\Models\Admin;
use App\Models\Booth;
use App\Models\BoothCheckin;
use App\Models\Broadcast;
use App\Models\Handbook;
use App\Models\HandbookCategory;
use App\Models\Scan;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WaDevice;
use App\Notifications\EmailChanged;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function login(Request $request) {
        if ($request->method() == "GET") {
            $message = Session::get('message');
            
            return view('admin.login', [
                'message' => $message,
            ]);
        } else {
            $loggingIn = Auth::guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if (!$loggingIn) {
                return redirect()->back()->withErrors([
                    'Kombinasi email dan password tidak tepat'
                ]);
            }

            return redirect()->route('admin.dashboard');
        }
    }
    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with([
            'message' => "Berhasil logout"
        ]);
    }
    public function dashboard(Request $request) {
        $me = me('admin');
        $message = Session::get('message');
        $isValid = $request->isValid ?? false;
        $users = 0;
        $transactions = [];

        if ($isValid) {
            $users = User::whereHas('transaction', function ($query) {
                $query->where('payment_status', 'PAID');
            })->get(['ID'])->count();
            $transactions = Transaction::where('payment_status', 'PAID')->with(['ticket'])->get(['id', 'payment_amount']);
        } else {
            $users = User::all(['id'])->count();
            $transactions = Transaction::with(['ticket'])->get(['id', 'payment_amount']);
        }

        return view('admin.dashboard', [
            'me' => $me,
            'message' => $message,
            'users' => $users,
            'transactions' => $transactions,
            'isValid' => $isValid,
        ]);
    }
    public function ticket(Request $request) {
        $me = me('admin');
        $message = Session::get('message');
        $categories = TicketCategory::orderBy('name', 'ASC')->with(['tickets'])->get();

        return view('admin.ticket.index', [
            'me' => $me,
            'message' => $message,
            'categories' => $categories,
        ]);
    }
    public function booth(Request $request) {
        $me = me('admin');
        $message = Session::get('message');
        $filter = [];
        $booths = Booth::where($filter)->get();

        return view('admin.booth.index', [
            'me' => $me,
            'message' => $message,
            'booths' => $booths,
        ]);
    }
    public function peserta(Request $request) {
        $me = me('admin');
        $message = Session::get('message');
        $filterCount = 0;
        $tickets = Ticket::orderBy('name', 'ASC')->get();

        $u = new User();
        if ($request->q != "") {
            $u = $u->where('name', 'LIKE', "%".$request->q."%")->orWhereHas('transaction', function ($query) use ($request) {
                $query->where('id', $request->q);
            });
        }

        if ($request->ticket_id != null) {
            $filterCount += 1;
            $u = $u->whereHas('transaction', function ($query) use ($request) {
                $query->where('ticket_id', $request->ticket_id);
            });
        }
        if ($request->payment_status != null) {
            $filterCount += 1;
            $u = $u->whereHas('transaction', function ($query) use ($request) {
                $query->where('payment_status', $request->payment_status);
            });
        }

        $users = $u->orderBy('created_at', 'DESC')
        ->with(['transaction.ticket'])
        ->paginate(25);

        if ($request->download == 1) {
            $filename = "Data_Peserta-Exported_at_" . Carbon::now()->isoFormat('DD-MMM-Y') . ".xlsx";

            return Excel::download(
                new PesertaExport([
                    'peserta' => $users
                ]),
                $filename
            );
        }

        return view('admin.peserta.index', [
            'me' => $me,
            'message' => $message,
            'request' => $request,
            'users' => $users,
            'tickets' => $tickets,
            'filterCount' => $filterCount,
        ]);
    }
    public function updatePeserta(Request $request, $id) {
        $u = User::where('id', $id);
        $user = $u->first();

        $u->update([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'nik' => $request->nik,
        ]);

        if ($request->email != $user->email) {
            // Send notif
            $user->notify(new EmailChanged([
                'user' => $user,
                'email' => $request->email,
            ]));
        }

        return redirect()->back()->with([
            'message' => "Berhasil mengubah data peserta"
        ]);
    }
    public function handbook(Request $request) {
        $me = me('admin');
        $message = Session::get('message');

        $categories = HandbookCategory::orderBy('priority', 'DESC')->orderBy('updated_at', 'DESC')->get();
        $book = new Handbook();
        if ($request->q != "") {
            $book = $book->where('title', 'LIKE', "%".$request->q."%");
        }
        if ($request->category_id != null) {
            $book = $book->whereHas('categories', function ($query) use ($request) {
                $query->where('handbook_categories.id', $request->category_id);
            });
        }
        $handbooks = $book->orderBy('created_at', 'DESC')->with(['categories'])->get();

        if ($request->method() == "GET") {
            return view('admin.handbook.index', [
                'me' => $me,
                'message' => $message,
                'request' => $request,
                'categories' => $categories,
                'handbooks' => $handbooks,
            ]);
        } else {
            return response()->json([
                'categories' => $categories,
                'handbooks' => $handbooks,
            ]);
        }
    }
    public function broadcast(Request $request) {
        $me = me();
        $message = Session::get('message');
        $devices = WaDevice::orderBy('name', 'ASC')->get();
        $broadcasts = Broadcast::orderBy('created_at', 'DESC')
        ->with(['device'])
        ->paginate(25);

        return view('admin.broadcast.index', [
            'me' => $me,
            'message' => $message,
            'request' => $request,
            'devices' => $devices,
            'broadcasts' => $broadcasts,
        ]);
    }
    public function registrasiCheckin(Request $request) {
        $me = me();
        $message = Session::get('message');

        $check = Scan::orderBy('created_at', 'DESC')->with(['user', 'transaction', 'ticket']);
        $checkins = $check->paginate(25);

        return view('admin.checkin.registrasi', [
            'me' => $me,
            'message' => $message,
            'request' => $request,
            'checkins' => $checkins,
        ]);
    }
    public function boothCheckin(Request $request) {
        $me = me();
        $message = Session::get('message');
        $booths = Booth::orderBy('name', 'ASC')->get();
        $filter = [];

        if ($request->booth_id != null) {
            array_push($filter, ['booth_id', $request->booth_id]);
        }
        
        $check = BoothCheckin::where($filter)->orderBy('created_at', 'DESC')->with(['user', 'booth']);
        if ($request->download == 1) {
            $filename = "Data_Checkin_Booth"."-Exported_at_" . Carbon::now()->isoFormat('DD-MMM-Y') . ".xlsx";
            $checkins = $check->get();

            return Excel::download(
                new ExportsBoothCheckin([
                    'role' => "ADMIN",
                    'checkins' => $checkins,
                ]),
                $filename
            );
        }

        $checkins = $check->paginate(25);

        return view('admin.checkin.booth', [
            'me' => $me,
            'message' => $message,
            'request' => $request,
            'booths' => $booths,
            'checkins' => $checkins,
        ]);
    }

    public function scan(Request $request) {
        $p = json_decode(base64_decode($request->p));

        $trx = Transaction::where('id', $p->trx_id);
        $transaction = $trx->with(['user', 'ticket'])->first();
        $scan = null;
        $check = Scan::where([
            ['user_id', $p->user_id],
            ['transaction_id', $p->trx_id],
        ])->first();

        if (
            $transaction->payment_status == "PAID" &&
            $transaction->user_id == $p->user_id &&
            $check == null
        ) {

            if ($request->confirm != "y") {
                return view('admin.scan', [
                    'trx' => $transaction,
                    'p' => $request->p,
                ]);
            }

            $scan = Scan::create([
                'user_id' => $transaction->user_id,
                'transaction_id' => $p->trx_id,
                'ticket_id' => $transaction->ticket_id,
            ]);
            $scan = Scan::where('id', $scan->id)->with(['user', 'transaction', 'ticket'])->first();

            if ($request->response_type == "api") {
                return response()->json([
                    'scan' => $scan,
                    'message' => "Berhasil scan"
                ]);
            } else {
                return redirect()->route('admin.dashboard')->with([
                    'message' => "Berhasil scan"
                ]);
            }
        } else {
            $message = "Gagal melakukan scan";
            if ($check != null) {
                $message = "Sudah cek-in dengan QR ini.";
            } else if ($transaction == null || $transaction->payment_status != "PAID" || $transaction->user_id != $p->user_id) {
                $message = "Transaksi tidak valid";
            }

            if ($request->response_type == "api") {
                return response()->json([
                    'scan' => $scan,
                    'message' => $message
                ]);
            } else {
                return redirect()->back()->withErrors([
                    $message,
                ]);
            }
        }
    }

    public function admins(Request $request) {
        $message = Session::get('message');
        $filter = [];
        $me = me('admin');

        if ($request->role != "") {
            array_push($filter, ['role', $request->role]);
        }

        $admins = Admin::where($filter)->orderBy('name', 'ASC')->get();

        return view('admin.index', [
            'request' => $request,
            'message' => $message,
            'admins' => $admins,
            'me' => $me,
        ]);
    }

    public function store(Request $request) {
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with([
            'message' => "Berhasil menambahkan " . $admin->name . " sebagai " . $request->role,
        ]);
    }
    public function delete($id) {
        $adm = Admin::where('id', $id);
        $admin = $adm->first();

        $adm->delete();

        return redirect()->back()->with([
            'message' => "Berhasil menghapus " . $admin->name 
        ]);
    }
    public function update(Request $request, $id) {
        $me = me('admin');
        $adm = Admin::where('id', $id);
        $admin = $adm->first();
        $passwordChanged = false;

        $toUpdate = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password != "") {
            $toUpdate['password'] = bcrypt($request->password);
            $passwordChanged = true;
        }

        $adm->update($toUpdate);

        if ($passwordChanged && $me->id == $id) {
            Auth::guard('admin')->logout();

            return redirect()->route('admin.login')->with([
                'message' => "Mohon login kembali dengan password baru"
            ]);
        }

        return redirect()->back()->with([
            'message' => "Berhasil mengubah " . $admin->name 
        ]);
    }

    public function generalSettings(Request $request) {
        if ($request->method() == "GET") {
            $message = Session::get('message');
            return view('admin.settings.general', [
                'message' => $message,
            ]);
        } else {
            $toChange = ['APP_NAME', 'EMAIL', 'PHONE'];
            foreach ($toChange as $item) {
                changeEnv($item, $request->{$item});
            }

            return redirect()->back()->with([
                'message' => "Berhasil menyimpan pengaturan"
            ]);
        }
    }
    public function emailSettings(Request $request) {
        if ($request->method() == "GET") {
            $message = Session::get('message');
            return view('admin.settings.email', [
                'message' => $message,
            ]);
        } else {
            $toChange = ['MAIL_HOST', 'MAIL_USERNAME', 'MAIL_PASSWORD'];
            foreach ($toChange as $item) {
                changeEnv($item, $request->{$item});
            }

            return redirect()->back()->with([
                'message' => "Berhasil menyimpan pengaturan"
            ]);
        }
    }
    public function whatsappSettings(Request $request) {
        $devices = WaDevice::orderBy('created_at', 'DESC')->get();
        $message = Session::get('message');

        return view('admin.settings.whatsapp.index', [
            'devices' => $devices,
            'message' => $message,
        ]);
    }
    public function removeWhatsapp(Request $request, $id) {
        $dev = WaDevice::where('id', $id);
        $device = $dev->first();

        $dev->delete();

        Http::post(env('WA_URL') . "/disconnect", [
            'client_id' => $device->client_id,
        ]);

        return redirect()->back()->with([
            'message' => "Berhasil menghapus perangkat " . $device->name,
        ]);
    }
    public function setWhatsappPrimary(Request $request, $id) {
        $dev = WaDevice::where('id', $id);
        $device = $dev->first();

        $devices = WaDevice::where([])->update(['is_primary' => false]);

        $dev->update([
            'is_primary' => true,
        ]);

        return redirect()->back()->with([
            'message' => "Berhasil menjadikan perangkat " . $device->name . " sebagai utama",
        ]);
    }
    public function callbackWa(Request $request) {
        $devices = WaDevice::all(['id']);
        $isPrimary = $devices->count() > 0 ? false : true;

        $device = WaDevice::create([
            'client_id' => $request->client_id,
            'name' => $request->name,
            'number' => $request->number,
            'profile_picture' => $request->profile_picture,
            'is_primary' => $isPrimary,
        ]);

        return response()->json([
            'ok',
        ]);
    }

    public function foHome() {
        return view('fo.home');
    }
}
