<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MoveMoveIo\DaData\Enums\Language;
use MoveMoveIo\DaData\Facades\DaDataAddress;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->id;
        $addresses = DB::table('addresses')
            ->where('user_id', '=', $user)
            ->get();
        return $addresses;
    }

    public function search(Request $request)
    {
        $query = $request['query'];
        $dadata = DaDataAddress::prompt($query, 10, Language::RU);
        return $dadata;
    }

    public function save(Request $request)
    {
        $user = $request->user_id;

        $address = new Address();
        $address->user_id = $request->user_id;
        $address->address = $request->address;
        $address->save();

        $addresses = DB::table('addresses')
            ->where('user_id', '=', $user)
            ->get();
        return $addresses;
    }
}
