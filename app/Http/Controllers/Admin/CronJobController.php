<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CronJobController extends Controller
{
    public function index(){
        $user = Auth::user();
        $raw = DB::select('SELECT JOB_NAME, JOB_ACTION, START_DATE, REPEAT_INTERVAL, ENABLED
        FROM ALL_SCHEDULER_JOBS');
        return view('screens.admin.manage_cronjob_manual', ["user" => $user, 'raw' => $raw]);
    }

    public function create(Request $request)
{
    $time = $request->timePicker;
    $name = $request->name_cronjob;

    $query = "
        BEGIN
            DBMS_SCHEDULER.CREATE_JOB (
                job_name => :job_name,
                job_type => 'PLSQL_BLOCK',
                job_action => 'UPDATE HTRANS
                                SET ctr_estimasi = ctr_estimasi - 1
                                WHERE status = ''delivery'' AND ctr_estimasi > 0;
                                COMMIT;',
                number_of_arguments => 0,
                start_date => TO_TIMESTAMP_TZ(:start_date, 'YYYY-MM-DD HH24:MI:SS.FF TZR'),
                repeat_interval => NULL,
                end_date => NULL,
                enabled => FALSE,
                auto_drop => FALSE,
                comments => ''
            );

            DBMS_SCHEDULER.SET_ATTRIBUTE(
                name => :job_name,
                attribute => 'logging_level',
                value => DBMS_SCHEDULER.LOGGING_OFF
            );

            DBMS_SCHEDULER.enable(
                name => :job_name
            );
        END;
    ";

    DB::statement($query, [
        'job_name' => "PROYEK.$name",
        'start_date' => "2023-12-16 $time:00.000000000 ASIA/BANGKOK",
    ]);

    return back();
}
}
