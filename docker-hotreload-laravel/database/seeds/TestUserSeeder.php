<?php 

class TestUserSeeder extends Seeder
{
    /**
     * Run database seeds
     * 
     * @return void
     */
    public function run() 
    {
        $iadSupscription = test_user::firstOrNew([
            'test_id' => '1',
            'user_id' => '82',
            'grade' => '6.0'
        ]);

        $iitorgSubscription = test_user::firstOrNew([
            'test_id' => '2',
            'user_id' => '82'
        ]);
        $idaanSubscription = test_user::firstOrNew([
            'test_id' => '3',
            'user_id' => '82'
        ]);

        $iadSupscription -> save();
        $iitorgSubscription -> save();
        $idaanSubscription -> save();
    }
}