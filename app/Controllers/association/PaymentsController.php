<?php
class PaymentsController
{
    public function store()
    {
        $billId = $_POST['bill_id'];
        $amount = $_POST['amount'];

        DB::table('payments')->insert([
            'bill_id' => $billId,
            'member_id' => $_POST['member_id'],
            'amount' => $amount,
            'payment_date' => date('Y-m-d')
        ]);

        DB::table('bills')->where('id', $billId)->update([
            'paid_amount' => DB::raw("paid_amount + $amount"),
            'outstanding_amount' => DB::raw("outstanding_amount - $amount"),
            'status' => DB::raw("
                CASE 
                    WHEN outstanding_amount - $amount <= 0 THEN 'paid'
                    ELSE 'partial'
                END
            ")
        ]);
    }
}
