BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ 

INSERT INTO discount("percentage",date_begin,date_end)
VALUES ($percentage,$date_begin,$date_end);

COMMIT;