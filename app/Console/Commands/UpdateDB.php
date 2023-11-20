<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updatedb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $data = DB::table('table_product')->get();
            foreach($data as $value){
                $id = DB::table('images')->insertGetId(['uri' => '/storage/vanloiphat/'.$value->photo, 'active' => 1]);
                DB::table('products')->where(['id'=>$value->id])->update(['image_id' => $id]);
            }
            $this->info('Success!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        }
    }
}
