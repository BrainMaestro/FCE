SET @semester = 'Spring 2015';
UPDATE sections SET locked='1', mid_evaluation='0', final_evaluation='0' WHERE semester=@semester;
DELETE FROM accesskeys WHERE key_crn IN (SELECT crn FROM sections WHERE semester=@semester);
DELETE FROM evaluations WHERE crn IN (SELECT crn FROM sections WHERE semester=@semester);