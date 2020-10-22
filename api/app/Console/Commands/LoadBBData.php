<?php

namespace App\Console\Commands;

use Arr;
use DB;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class LoadBBData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bbdata:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads Breaking Bad Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $url = env('BB_API_URL') . 'characters';
            $client = new Client();
            $response = $client->request('GET', $url);

            $characters = json_decode($response->getBody(), true);

            $character_data = [];
            $occupation_data = [];
            $bb_appearance_data = [];
            $bcs_appearance_data = [];
            $statuses = [];
            foreach ($characters as $character) {
                $last_character = $character;
                $char_id = Arr::get($character, 'char_id');
                $now = gmdate('Y-m-d H:i:s');
                $character_data[] = [
                    'id' => $char_id,
                    'name' => Arr::get($character, 'name', ''),
                    'birthday' => date('Y-m-d H:i:s', strtotime(Arr::get($character, 'birthday', null))),
                    'img' => Arr::get($character, 'img', ''),
                    'status' => Arr::get($character, 'status', ''),
                    'nickname' => Arr::get($character, 'nickname', ''),
                    'portrayed' => Arr::get($character, 'portrayed', ''),
                    'category' => Arr::get($character, 'category', ''),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $occupations = Arr::get($character, 'occupation', null);
                if (!empty($occupations)) {
                    foreach ($occupations as $occupation) {
                        $occupation_data[] = [
                            'character_id' => $char_id,
                            'occupation' => $occupation,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }

                $appearances = Arr::get($character, 'appearance', null);
                if (!empty($appearances)) {
                    foreach ($appearances as $bb_appearance) {
                        $bb_appearance_data[] = [
                            'character_id' => $char_id,
                            'season' => $bb_appearance,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }

                $bcs_appearances = Arr::get($character, 'appearance', null);
                if (!empty($bcs_appearances)) {
                    foreach ($bcs_appearances as $bcs_appearance) {
                        $bcs_appearance_data[] = [
                            'character_id' => $char_id,
                            'season' => $bcs_appearance,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }
            }
            DB::table('characters')->insert($character_data);
            DB::table('occupations')->insert($occupation_data);
            DB::table('bb_appearances')->insert($bb_appearance_data);
            DB::table('bcs_appearances')->insert($bcs_appearance_data);
            return true;
        } catch (Throwable $t) {
            var_dump($t->getCode());
            var_dump($t->getMessage());
        }
    }
}
