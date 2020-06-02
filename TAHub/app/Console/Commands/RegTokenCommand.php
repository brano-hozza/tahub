<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RegTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate reg token';

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
     * @return mixed
     */
    public function handle()
    {
        $token = new \App\RegToken();
        $new_token = Str::random(60);
        $nehash = $new_token;
        $token->token = \hash("sha256", $new_token);
        $token->save();
        $this->info($nehash);
    }
}
