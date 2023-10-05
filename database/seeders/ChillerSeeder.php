<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChillerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array();
        $merchants = Merchant::all();
        foreach ($merchants as $merchant) {
            $chillers = $this->chillers($merchant->id);
            array_push($data, $chillers[1]);
            // if ($merchant->id % 2 == 1) {
            //     array_push($data, $chillers[0], $chillers[1]);
            // } else {
            // array_push($data, $chillers[1]);
            // }
        }

        DB::table("chillers")->insert($data);
    }

    private function chillers($merchant_id)
    {
        return [
            [
                "merchant_id" => $merchant_id,
                "name" => "CHILLER #" . $merchant_id . " A",
                "merk" => "SHARP",
                "type" => "SCH210Fs",
                "category" => "BESAR",
                "capacity" => 50,
                "photo" => "https://nafla-storage.sg-sin1.upcloudobjects.com/dev-cdn/wmAmxILP6jGQiInWteFS_1673170491.jpg",
                "is_exclusive" => true,
            ],
            [
                "merchant_id" => $merchant_id,
                "name" => "CHILLER #" . $merchant_id,
                "merk" => "SHARP",
                "type" => "SCH250FS",
                "category" => "KECIL",
                "capacity" => 25,
                "photo" => "https://nafla-storage.sg-sin1.upcloudobjects.com/dev-cdn/tKEWfK6EHUrYKtAUtVr2_1673170572.jpg",
                "is_exclusive" => false,
            ],
        ];
    }
}
