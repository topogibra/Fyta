BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ WRITE;

--Insert User Image
WITH img_ins AS (
  INSERT INTO "image" ("path","description")
  VALUES ($path, $description)
  RETURNING id AS img_id
)
-- Insert User
INSERT INTO user (username,email,password_hash,"date","address",id_image,"Customer")
VALUES ($username,$email,$password_hash,$date,$address,img_id,user_role)
SELECT img_id FROM img_ins;

COMMIT;