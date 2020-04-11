BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ WRITE;

--Insert User Image
WITH img_ins AS (
  INSERT INTO "image" (img_hash,"description")
  VALUES ($hash, $description)
  RETURNING id AS img_id
)
-- Insert User
INSERT INTO user (username,email,password_hash,"date","address",id_image,$type)
VALUES ($username,$email,$password_hash,$date,$address,img_id,user_role)
SELECT img_id FROM img_ins;

COMMIT;
