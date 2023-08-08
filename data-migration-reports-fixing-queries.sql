-- activate all the users
update cdis.users set is_active = 1;

update cdis.users set is_active = 0 where id IN (52,
61,
62,
10010,
10012,
10015,
11689,
12160,
12199,
999998)


-- Activate Chris and Janel user from the live server of CDIS.us (Disabled them to prevent adding 00 or 0000 id)


-- -------------------------------------------------------------------------------------------------------------

- fixes Admin Plans on Shelve
update transactions set conservationdistrict = 'BCCD' where project_id = 8248644

-- -------------------------------------------------------------------------------------------------------------
- fixes Tech Plans on Shelves
update transactions set county_id = 2, conservationdistrict = 'MCCD' where project_id = 8251991;
update transactions set is_admin = 0 where project_id = 8252074;
update transactions set is_admin = 0 where project_id = 8250925 and is_admin = 1 order by id desc limit 1;
update transactions set is_admin = 0 where project_id= 8251991;
update projects set user_id = 1 where id IN (8252045,8252148,8251999,8251621,8252052,8252174,8252027,8252176,8251284,8252000,8252059,8252148,8246647,8252207,8252063,8252217,8252066,8252221,8252225,8252068,8250924,8252045,8252235,8252070,8252236,8249190,8252237,8251965,8252238,8252082,8247709,8252083,8252253,8252052,8252255,8252085,8252237,8251889,8248019,8252083,8252262,8252059,8252267,8251682,8252268,8252110,8252269,8252111,8252273,8250831,8252274,8252008,8252280,8250924,8252116,8252176,8252000,8252124,8252174,8251999,8252129,8252221,8252008,8250924,8252027,8252134,8251974,8252124, 8252304, 8252307,8252306, 8252325, 8252326,8252328)


-- -------------------------------------------------------------------------------------------------------------

