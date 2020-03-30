BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ; 

WITH user_removed AS (
  DELETE FROM "user"
  WHERE email = $email
  RETURNING *
)
INSERT INTO user_removal (reason,username)
VALUES ($reason, user_removed.username);

COMMIT;