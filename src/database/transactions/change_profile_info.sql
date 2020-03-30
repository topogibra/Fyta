BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ 

WITH user_updated AS (
UPDATE user
SET   username = $username,
      email = $new_email,
      password_hash = $password_hash,
      "date" = $date,
      "address" = $address
WHERE email = $old_email
RETURNING id_image
)
UPDATE "image"
SET    "path" = $path
WHERE id_image = user_updated.id_image;



COMMIT;