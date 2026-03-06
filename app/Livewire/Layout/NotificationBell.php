<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class NotificationBell extends Component
{
    // Escuchamos eventos por si otro componente pide actualizar la campana
    protected $listeners = ['refreshNotifications' => '$refresh'];

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->unreadNotifications->where('id', $notificationId)->first();
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.layout.notification-bell', [
            'notifications' => auth()->user()->unreadNotifications()->take(5)->get(),
            'unreadCount' => auth()->user()->unreadNotifications()->count()
        ]);
    }
}
