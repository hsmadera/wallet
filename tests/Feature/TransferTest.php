<?php

namespace Tests\Feature;

use App\Transfer;
use App\Wallet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostTransfer()
    {
        $wallet = factory(Wallet::class)->create();
        $tranfer = factory(Transfer::class)->make();
        $response = $this->json('POST','/api/transfer',[
            'description'=>$tranfer->description,
            'amount'=>$tranfer->amount,
            'wallet_id'=>$wallet->id
        ]);

        $response->assertJsonStructure([
            'id','description','amount','wallet_id'
        ])->assertStatus(201);

        $this->assertDatabaseHas('transfers',[
            'description'=>$tranfer->description,
            'amount'=>$tranfer->amount,
            'wallet_id'=>$wallet->id
        ]);

        $this->assertDatabaseHas('wallets',[
           'id'=> $wallet->id,
           'money'=>$wallet->money + $tranfer->amount
        ]);
    }
}
