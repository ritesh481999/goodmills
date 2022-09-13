<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Models\Bid;
use App\Models\BidFarmer;
use App\Models\FAQ;
use App\Models\User;
use App\Models\News;
use App\Models\Farmer;
use App\Models\Marketing;
use App\Models\SellingRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
	public function index()
	{
		
		$farmerCount = Farmer::count();
		$bidCount = Bid::count();
		$newsCount = News::count();
		$faqCount = FAQ::where('country_id', Auth::user()->selected_country_id)->count();
		$users = User::role(2)->count();
		$sellCount = SellingRequest::count();
		$marketingCount = Marketing::count();

		return view('dashboard', compact('bidCount', 'farmerCount', 'newsCount', 'faqCount', 'users', 'sellCount', 'marketingCount'));
	}

	public  function storeToken(Request $request)
	{

		$user = User::find(auth()->user()->id);
		$user->update(['fcm_token' => $request->token]);

		return response()->json(['status' => 1]);
	}
}
