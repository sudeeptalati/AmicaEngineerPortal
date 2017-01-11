ALTER TABLE "servicecalls" ADD "status_log" TEXT;

ALTER TABLE "jobstatus" ADD "keyword" TEXT;

UPDATE "systemconfig" SET "id"='2', "parameter"='api_key', "value"='TESTINGAMICA', "name"='api_key' WHERE "rowid" = 2


UPDATE "jobstatus" SET "id"='54', "name"='Claim Rejected', "info"='The claim for this job is Rejected', "html"='<div style="color:white;padding: 5px 5px 5px 30px; border-radius: 10px;background:#da4f49" >Claim Rejected</div>', "active"='1', "keyword"='CLAIM_REJECTED' WHERE "rowid" = 54;

UPDATE "jobstatus" SET "id"='56', "name"='Pending More Info', "info"='Pending More Info', "html"='<div style="color:white;padding: 5px 5px 5px 30px; border-radius: 10px;background:#faa732" >Pending More Info </div> ', "active"='1', "keyword"='PENDING_MORE_INFO' WHERE "rowid" = 56;
