<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Comment;

class ManageSubscriptionController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        
        if ($user->stripe_id == null) {
            $user->createAsStripeCustomer();
        }
        
        $checkout = $request->user()
            ->newSubscription('default', 'price_1J1ocnK5S8iIkUD8hQIz26qk')
            ->checkout([
                'success_url' => route('dashboard.index'),
                'cancel_url' => route('subscription')
            ]);
        
        return Inertia::render('ManageSubscription', [
            'stripeKey' => config('cashier.key'),
            'checkoutSessionId' => $checkout->id
        ]);

        // return Inertia::render('ManageSubscription', [
        //     'checkout' => $checkout,
        // ]);
    }

    public function getPortal(Request $request)
    {
        $user = $request->user();

        $stripe = new \Stripe\StripeClient(config('cashier.secret'));
        $portal = $stripe->billingPortal->sessions->create([
            'customer' => $user->stripe_id,
            'return_url' => route('dashboard.index'),
        ]);

        // return redirect($portal->url);
        // return redirect()->away($portal->url);
        
        return response()->json([
            'url' => $portal->url
        ]);
    }

}
