<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\NewsletterSubscriber;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('customerGroup', 'newsletterSubscription')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'customer_group_id' => 'required|exists:customer_groups,id',
            'is_admin' => 'boolean',
            'newsletter' => 'boolean',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'customer_group_id' => $request->customer_group_id,
            'is_admin' => $request->boolean('is_admin', false),
        ]);
    
        $newsletterData = [
            'user_id' => $user->id,
            'email' => $user->email,
            'is_subscribed' => $request->boolean('newsletter', true),
            'subscribed_at' => $request->boolean('newsletter') ? now() : null,
        ];
    
        \Log::debug("Creating newsletter subscription for user {$user->id}: ", $newsletterData);
        $subscription = NewsletterSubscriber::create($newsletterData);
        \Log::debug("Newsletter subscription created: ID {$subscription->id}");
    
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'customer_group_id' => 'required|exists:customer_groups,id',
            'is_admin' => 'boolean',
            'newsletter' => 'nullable|boolean', // Allow null for unchecked
        ]);
    
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'customer_group_id' => $request->customer_group_id,
            'is_admin' => $request->boolean('is_admin', $user->is_admin),
        ]);
    
        // Determine subscription status: true if checked, false if unchecked
        $isSubscribed = $request->has('newsletter') ? true : false;
        $subscription = $user->newsletterSubscription;
    
        if (!$subscription) {
            \Log::debug("No existing subscription for user {$user->id}, creating new one.");
            $subscription = NewsletterSubscriber::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'is_subscribed' => $isSubscribed,
                'subscribed_at' => $isSubscribed ? now() : null,
            ]);
        } else {
            \Log::debug("Updating existing subscription for user {$user->id}. Current is_subscribed: {$subscription->is_subscribed}, New: " . ($isSubscribed ? 1 : 0));
            $subscription->update([
                'email' => $user->email,
                'is_subscribed' => $isSubscribed,
                'subscribed_at' => $isSubscribed ? ($subscription->subscribed_at ?? now()) : null,
            ]);
        }
    
        \Log::debug("Subscription after update: ", $subscription->toArray());
    
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    // Add method to toggle subscription status from admin
    public function toggleSubscription(Request $request, User $user)
    {
        $subscription = $user->newsletterSubscription ?? NewsletterSubscriber::create([
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        $subscription->update([
            'is_subscribed' => !$subscription->is_subscribed,
            'subscribed_at' => $subscription->is_subscribed ? null : now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Subscription status updated.');
    }
}