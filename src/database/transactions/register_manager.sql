BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

--Insert Manager Image
WITH img_ins AS (
  INSERT INTO 'image' ('path','description')
  VALUES ($path, $description)
  RETURNING id AS img_id
)
-- Insert Manager
INSERT INTO user (username,email,password_hash,'date',id_image,'Manager')
VALUES ($username,$email,$password_hash,now(),img_id,user_role)
SELECT img_id FROM img_ins;

COMMIT;