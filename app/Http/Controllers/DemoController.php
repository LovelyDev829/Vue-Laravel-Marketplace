<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Schema;
use ZipArchive;
use File;
use App\Models\Translation;
use Artisan;
use Cache;

class DemoController extends Controller
{
    public function __construct()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 600);
    }

    public function cron_1()
    {
        if (env('DEMO_MODE') != 'On') {
            return back();
        }
        $this->drop_all_tables();
        $this->import_demo_sql();

        cache_clear();
    }

    public function cron_2()
    {
        if (env('DEMO_MODE') != 'On') {
            return back();
        }
        $this->remove_folder();
        $this->extract_uploads();
    }


    public function drop_all_tables()
    {
        Schema::disableForeignKeyConstraints();
        foreach (DB::select('SHOW TABLES') as $table) {
            $table_array = get_object_vars($table);
            Schema::drop($table_array[key($table_array)]);
        }
    }

    public function import_demo_sql()
    {
        $sql_path = base_path('demo.sql');
        DB::unprepared(file_get_contents($sql_path));
    }

    public function extract_uploads()
    {
        $zip = new ZipArchive;
        $zip->open(base_path('public/uploads.zip'));
        $zip->extractTo('public/uploads');
    }

    public function remove_folder()
    {
        File::deleteDirectory(base_path('public/uploads'));
    }

    public function insert_trasnalation_keys()
    {
        $fn = fopen(base_path('resources/web-translations.txt'), "r");

        while (!feof($fn)) {
            $result = fgets($fn);

            $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($result)));
            
            if($lang_key){
                Translation::updateOrCreate(
                    ['lang' => 'en', 'lang_key' => $lang_key],
                    ['lang_value' => $result]
                );
            }
        }

        fclose($fn);
        cache_clear();
    }
}
