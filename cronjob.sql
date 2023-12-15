BEGIN
    DBMS_SCHEDULER.CREATE_JOB (
            job_name => '"PROYEK"."CRONJOB_HTRANS"',
            job_type => 'PLSQL_BLOCK',
            job_action => 'UPDATE HTRANS
SET ctr_estimasi = ctr_estimasi - 1
WHERE status = ''delivery'' AND ctr_estimasi > 0;
COMMIT;',
            number_of_arguments => 0,
            start_date => NULL,
            repeat_interval => 'FREQ=DAILY;BYDAY=MON,TUE,WED,THU,FRI,SAT,SUN;BYHOUR=12;BYMINUTE=0;BYSECOND=0',
            end_date => NULL,
            enabled => FALSE,
            auto_drop => FALSE,
            comments => '');




    DBMS_SCHEDULER.SET_ATTRIBUTE(
             name => '"PROYEK"."CRONJOB_HTRANS"',
             attribute => 'logging_level', value => DBMS_SCHEDULER.LOGGING_OFF);



    DBMS_SCHEDULER.enable(
             name => '"PROYEK"."CRONJOB_HTRANS"');
END;


BEGIN
    DBMS_SCHEDULER.CREATE_JOB (
            job_name => '"PROYEK".""',
            job_type => 'PLSQL_BLOCK',
            job_action => 'UPDATE HTRANS
SET ctr_estimasi = ctr_estimasi - 1
WHERE status = ''delivery'' AND ctr_estimasi > 0;
COMMIT;',
            number_of_arguments => 0,
            start_date => TO_TIMESTAMP_TZ('2023-12-16 12:32:21.000000000 ASIA/BANGKOK','YYYY-MM-DD HH24:MI:SS.FF TZR'),
            repeat_interval => NULL,
            end_date => NULL,
            enabled => FALSE,
            auto_drop => FALSE,
            comments => '');




    DBMS_SCHEDULER.SET_ATTRIBUTE(
             name => '"PROYEK".""',
             attribute => 'logging_level', value => DBMS_SCHEDULER.LOGGING_OFF);



    DBMS_SCHEDULER.enable(
             name => '"PROYEK".""');
END;
