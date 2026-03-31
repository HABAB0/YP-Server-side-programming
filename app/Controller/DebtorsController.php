<?php

namespace Controller;

use Model\Accommodation;
use Src\Request;
use Src\View;

class DebtorsController
{
    public function debtors(Request $request): string
    {

        $debtors = Accommodation::with(['room', 'roomer'])
            ->where(function($query) {
                $query->where('payment_status', 'overdue')
                    ->orWhere(function($q) {
                        $q->where('payment_status', 'pending')
                            ->where('payment_due_date', '<', date('Y-m-d'));
                    });
            })
            ->where('status', 'active')
            ->orderBy('payment_due_date', 'ASC')
            ->get();

        return (new View())->render('site.debtors.debtors', [
            'debtors' => $debtors
        ]);
    }

    public function markAsPaid(int $id, Request $request): void
    {
        $user = app()->auth->user();
        if (!$user || $user->role_id !== 1) {
            app()->route->redirect('/forbidden');
            exit;
        }

        $accommodation = Accommodation::find($id);
        if ($accommodation) {
            $accommodation->payment_status = 'paid';
            $accommodation->save();
        }

        app()->route->redirect('/debtors');
        exit;
    }
}