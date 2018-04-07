<?php

namespace Parserbin\Console\Commands;

use Illuminate\Console\Command;
use Parserbin\Models\Language;
use Parserbin\Models\Parser;
use Parserbin\Models\Script;

class SandboxCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sandbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $data = json_decode(file_get_contents('bins.json'));
        foreach ($data as $row) {
            $hash = $row->hash;
            $input = $row->input;
            $scripts = json_decode($row->scripts);
            $parser = new Parser();
            $parser->hash = $hash;
            $parser->input = $input;
            $parser->save();

            foreach ($scripts as $script) {
                $scrObject = new Script();
                $scrObject->parser()->associate($parser);
                $scrObject->content = $script;
                $scrObject->language()->associate(Language::default());
                $scrObject->save();
            }
        }
    }
}
