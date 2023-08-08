-- First of all seed Database with Users and counties
-- npdes counter migration
INSERT INTO `cdis`.`npdes_counter`
(`id`,
 `county_id`,
 `general`,
 `individual`)
SELECT `id`, `county`, `general`, `individual`
FROM cdis_july_11.next_npdes;


#fix empty counties which have district information
UPDATE cdis_july_11.project
set county_id = 1
where conservation_district = 'BCCD';

UPDATE cdis_july_11.project
set county_id = 2
where conservation_district = 'MCCD';

-- PROJECTS WHICH ARE NOT ASSOCIATED WITH ANY USER SET USER_ID TO NULL  (DANGLING PROJECTS)
UPDATE cdis_july_11.`project`
set emp_number = null
where cdis_july_11.project.EMP_NUMBER not in (select id from cdis.users);

-- fix users_id in projects
update cdis_july_11.project
set emp_number = null
where emp_number like '%RT3%';

-- insert data in projects table
INSERT INTO cdis.projects(id, user_id, county_id, entry_number, name, plan_type, is_closed, memo, created_at,
                          updated_at)

SELECT PROJECT_NUMBER                            AS id,
       NULLIF(EMP_NUMBER, '')                    AS user_id,
       nullif(county_id, '')                     AS county_id,
       ENTRY_NUMBER                              AS entry_number,
       replace(project, "\\'", "'")              AS name,
       NPDES_NUMB                                AS PLAN_TYPE,
       CASE WHEN is_closed = 1 THEN 1 ELSE 0 END AS is_closed,
       memo,
       CURRENT_TIMESTAMP,
       CURRENT_TIMESTAMP
FROM `cdis_july_11`.`project`;


-- run this query 4 times to get rid of (Test\\\'s) backslashes
UPDATE cdis.projects
SET name = replace(name, "\\'", "'")
where name LIKE "%\\'%";

UPDATE cdis.projects
SET name = replace(name, "\\'", "'")
where name LIKE "%\\'%";

UPDATE cdis.projects
SET name = replace(name, "\\'", "'")
where name LIKE "%\\'%";

UPDATE cdis.projects
SET name = replace(name, "\\'", "'")
where name LIKE "%\\'%";

-- #--------- Municipalities Insertion --------------- #

INSERT INTO `cdis`.`municipalities`
(`id`,
 `name`,
 `municipal_code`,
 `address`,
 `city`,
 `state`,
 `zipcode`,
 `phone_number`,
 `manager_secretary`,
 `ceo`,
 `engineer`,
 `county_id`,
 `created_at`,
 `updated_at`)

SELECT `Municipality`.`ID`,
       `Municipality`.`MUNICIPALITY`,
       `Municipality`.`MUNICIPAL_CODE`,
       `Municipality`.`ADDRESS`,
       `Municipality`.`CITY`,
       `Municipality`.`STATE`,
       `Municipality`.`ZIP`,
       `Municipality`.`PHONE_NUMBER`,
       `Municipality`.`MANAGER_SECRETARY`,
       `Municipality`.`CEO`,
       `Municipality`.`ENGINEER`,
       `Municipality`.`county_id`,
       CURRENT_TIMESTAMP,
       CURRENT_TIMESTAMP
FROM cdis_july_11.`Municipality`;

update cdis_july_11.project
set muni_numb = null;

update cdis_july_11.project AS P
    JOIN cdis_july_11.Municipality AS M
set P.muni_numb = M.id
where P.munic = M.municipality;


-- # -------  PROJECT DETAILS INSERTION  ------- #
INSERT INTO cdis.project_details
(project_id,
 reviewer_id,
 municipality_id,
 tax_parcel,
 watershed,
 receiving_stream,
 plan_date,
 ownership,
 ch_93_class,
 total_acres,
 disturbed_acres,
 created_at,
 updated_at)
SELECT nullif(project_number, '') as project_id,
       nullif(emp_number, ''),
       muni_numb,
       tmp,
       watershed,
       stream,
       CASE
           WHEN CAST(plan_date AS CHAR(11)) = '0000-00-00' THEN NULL
           ELSE
               DATE_FORMAT(plan_date, '%Y-%m-%d')
           END                    as plan_date,
       ownership,
       stream_class,
       total_acres,
       acres_tbd,
       CURRENT_TIMESTAMP(),
       CURRENT_TIMESTAMP()
FROM cdis_july_11.project;

-- # ---------  ENGINEERS INSERTIONS  ------------#
INSERT INTO cdis.project_engineers (project_id, name, company_name, address_1, address_2, city, state,
                                    zipcode, phone_number, phone_number_ext, fax_number, email,
                                    created_at, updated_at)
SELECT project_number as project_id,
       SENTBY,
       ENGINEER       as company_name,
       ENG_ADD1       as address_1,
       ENG_ADD2       as address_2,
       ENG_CITY       as city,
       ENG_STATE      as state,
       ENG_ZIP        as zipcode,
       ENG_PHONE      as phone_number,
       ENG_EXT        as phone_number_ext,
       ENG_FAX        as fax_number,
       ENG_EMAIL      as email,
       CURRENT_TIMESTAMP,
       CURRENT_TIMESTAMP
from cdis_july_11.project;


-- # -------------  LOCATION INSERTIONS  -------------#
-- First of all create this function and Update the name in the insert query at bottom
DELIMITER $$
CREATE
    DEFINER = `root`@`localhost` FUNCTION `new_function`(INPUT LONG) RETURNS float
begin
    declare _POSTION INT;
    DECLARE _POWER LONG;
    DECLARE _NORMAL LONG;
    DECLARE _RETURN_VALUE FLOAT;
    DECLARE _RESULT FLOAT;
    set _POSTION = POSITION('.' IN REVERSE(INPUT));
    SET _POWER = POWER(10, _POSTION-1);
    SET _NORMAL = INPUT * _POWER;
    set _RETURN_VALUE = (FLOOR(((((_NORMAL / _POWER) - FLOOR(_NORMAL / _POWER)) * 60) -
                                FLOOR(((_NORMAL / _POWER) - FLOOR(_NORMAL / _POWER)) * 60)) * _POWER) * 60 / _POWER);
    SET _RESULT = ROUND(_RETURN_VALUE, 4);

    RETURN _RESULT;
END$$
DELIMITER ;


INSERT INTO cdis.project_locations
(project_id,
 address_1,
 address_2,
 city,
 zipcode,
 lat_deg,
 lat_min,
 lat_sec,
 long_deg,
 long_min,
 long_sec,
 created_at,
 updated_at)
SELECT project_number,
       loc,
       physical_address_2,
       physical_address_city,
       physical_address_postal,
       FLOOR(latitude)                              as lat_deg,
       FLOOR((latitude - (FLOOR(latitude))) * 60)   as lat_min,
       new_function(latitude)                       as lat_sec,
       FLOOR(longitude)                             as long_deg,
       FLOOR((longitude - (FLOOR(longitude))) * 60) as long_min,
       new_function(longitude)                      as long_sec,
       current_timestamp(),
       current_timestamp()
from cdis_july_11.project;



-- ---------  APPLICANTS INSERTIONS  ------------#
-- MODIFY id column  to AUTO_INCREMENT AND PRIMARY KEY
-- Exectute the below insert queries
-- Remove the AUTO_KEY and PK from ID column
SET @counter := 0;

INSERT INTO cdis.project_applicants (id, project_id,
                                     name,
                                     company_name,
                                     address_1,
                                     address_2,
                                     city,
                                     state,
                                     zipcode,
                                     phone_number,
                                     phone_number_ext,
                                     fax_number,
                                     email,
                                     created_at,
                                     updated_at)

select @counter := @counter + 1 AS id,
       PROJECT_NUMBER           as project_id,
       APPLIC                   as name,
       APP_COMPANY              as company_name,
       APP_ADD1                 as address_1,
       APP_ADD2                 as address_2,
       APP_CITY                 as city,
       APP_STATE                as state,
       APP_ZIP                  as zipcode,
       APP_PHONE                as phone_number,
       APP_EXT                  as phone_number_ext,
       APP_FAX                  as fax_number,
       APP_EMAIL                as email,
       CURRENT_TIMESTAMP,
       CURRENT_TIMESTAMP
from cdis_july_11.project;


-- # ------- CO-PERMITTIES INSERTIONS -----------#
-- FIX DATABASE BY EXECUTING THE COMMENTED QUERIES
-- DATE IS IN TWO DIFFERENT FORMATS
SELECT date_acquired,
       NULLIF(DATE_FORMAT(STR_TO_DATE(date_acquired, '%m/%d/%Y'), '%Y-%m-%d'), '') AS acq_formated,
       ack_date,
       nullif(DATE_FORMAT(STR_TO_DATE(ack_date, '%m/%d/%Y'), '%Y-%m-%d'), '')      AS ack_formated
FROM cdis_july_11.`Copermitees`
WHERE date_acquired like '%_/%';

UPDATE `cdis_july_11`.`Copermitees`
SET date_acquired = '2019-12-23'
WHERE date_acquired like '%12/23.2019%';


-- CHANGE DATE FORMAT OF SPECIFIC FIELDS FROM m/d/Y to Y-m-d
UPDATE cdis_july_11.Copermitees
SET date_acquired = DATE_FORMAT(STR_TO_DATE(date_acquired, '%m/%d/%Y'), '%Y-%m-%d')
WHERE date_acquired like '%_/%';


-- CHANGE DATE FORMAT OF SPECIFIC FIELDS FROM m/d/Y to Y-m-d
UPDATE cdis_july_11.Copermitees
SET ack_date = DATE_FORMAT(STR_TO_DATE(ack_date, '%m/%d/%Y'), '%Y-%m-%d')
WHERE ack_date like '%_/%';


-- FIX THE SINGLE ROW DATE ISSUE MANUALLY FOR 426 number record
UPDATE cdis_july_11.Copermitees
set ack_date = '2015-10-27'
where id = 426;
UPDATE cdis_july_11.Copermitees
set ack_date = '2016-01-21'
where id = 439;

-- FIX THE FAX FIELD ISSUES
UPDATE `cdis_july_11`.`Copermitees`
set fax = ''
where fax = 'not listed';

-- remove dash(-) to fix formatting issues
UPDATE `cdis_july_11`.`Copermitees`
SET fax = replace(fax, '-', '');

-- Manually fix the formatting of a fax column
UPDATE `cdis_july_11`.`Copermitees`
SET fax = '7172923606'
where fax = '(717) 2923606';

-- fix phone number formatting
UPDATE `cdis_july_11`.`Copermitees`
SET phone = replace(phone, '-', ''),
    phone = replace(phone, '(', ''),
    phone = replace(phone, ')', ''),
    phone = replace(phone, ' ', '');

-- DELETE THE DANGLING PROJECTS COPERMITEES
DELETE
FROM `cdis_july_11`.`Copermitees`
where proj_number = 0
   or proj_number not in (SELECT project_number from `cdis_july_11`.`project`);


INSERT INTO `cdis`.`project_permittees` (`id`, `project_id`, `received_date`, `reviewed_date`, `acknowledged`, `name`,
                                         `company`,
                                         `address_1`, `address_2`, `city`, `state`, `zipcode`, `phone`, `fax`, `email`,
                                         `created_at`, `updated_at`)

SELECT `Copermitees`.`ID`,
       `Copermitees`.`PROJ_NUMBER`,
       nullif(`Copermitees`.`DATE_ACQUIRED`, ''),
       nullif(`Copermitees`.`Ack_Date`, ''),
       `Copermitees`.`Ack`,
       `Copermitees`.`NAME`,
       `Copermitees`.`COMPANY`,
       `Copermitees`.`ADDRESS1`,
       `Copermitees`.`ADDRESS2`,
       `Copermitees`.`CITY`,
       `Copermitees`.`STATE`,
       `Copermitees`.`ZIP`,
       `Copermitees`.`PHONE`,
       `Copermitees`.`FAX`,
       `Copermitees`.`Email`,
       CURRENT_TIMESTAMP,
       CURRENT_TIMESTAMP
FROM `cdis_july_11`.`Copermitees`;

-- # ----------- TIME TRACKING INSERTIONS -------------#

-- deleted 52 dangling records
delete
from `cdis_july_11`.`time_tracking`
where project_number not in (select id from cdis.projects);


-- query to migrate time tracking data
INSERT INTO `cdis`.`project_time_tracking`
(id,
 project_id,
 reviewer_id,
 trx_number,
 trx_date,
 time_category,
 hours,
 submit_type,
 entered_by,
 entered_date,
 created_at,
 updated_at)


SELECT ID,
       PROJECT_NUMBER,
       if(user_id = '' or user_id = 'RT3', null, user_id) as reviewer_id,
       TRX_NUMBER,
       nullif(replace(replace(TRX_DATE, ' 00:00:00', ''), '0000-00-00', ''), ''),
       TIME_CATEGORY,
       HOURS,
       NEW_OR_RESUBMIT,
       ENTERED_BY,
       nullif(replace(replace(ENTER_DATE, ' 00:00:00', ''), '0000-00-00', ''), ''),
       CURRENT_TIMESTAMP,
       CURRENT_TIMESTAMP
from `cdis_july_11`.`time_tracking`;

-- fixes the reviewer id issues
update cdis.project_time_tracking AS tt JOIN cdis.users AS u
    ON (tt.reviewer_id = u.id)
    JOIN reviewers AS r ON (CONCAT(u.first_name, ' ', u.last_name) = r.name)
SET tt.reviewer_id = r.id;

-- # ------------- PROJECT PERMIT INSERTIONS -------------#

-- search html type date row
select *
from cdis_july_11.project
where date_term like '%_/%';


-- fix date format from m/d/y to y-m-d
update cdis_july_11.project
set date_term = nullif(DATE_FORMAT(STR_TO_DATE(date_term, '%m/%d/%Y'), '%Y-%m-%d'), '')
where date_term like '%_/%';

update cdis_july_11.project
set pindi_date = nullif(DATE_FORMAT(STR_TO_DATE(pindi_date, '%m/%d/%Y'), '%Y-%m-%d'), '')
where pindi_date like '%_/%';

-- fix (m/d/y) to (y-m-d) format for npdes_expire_date
update cdis_july_11.project
set npdes_expire_date = nullif(DATE_FORMAT(STR_TO_DATE(npdes_expire_date, '%m/%d/%Y'), '%Y-%m-%d'), '')
where npdes_expire_date like '%/%';

update cdis_july_11.project
set pindi_date = nullif(DATE_FORMAT(STR_TO_DATE(npdes_expire_date, '%m/%d/%Y'), '%Y-%m-%d'), '')
where npdes_expire_date like '%_/%';

UPDATE cdis_july_11.project
SET NP_DATE_R = NULL
WHERE NP_DATE_R < '0000-01-01';

UPDATE cdis_july_11.project
SET NP_DATE_R = NULL
WHERE DAY(NP_DATE_R) = '00';

-- fixes ',' in npdes_expire_date column
UPDATE cdis_july_11.project
SET npdes_expire_date = NULL
where npdes_expire_date = ',';


INSERT INTO cdis.project_permits
(project_id,
 npdes_number,
 received_date,
 pindi_date,
 final_inspection_date,
 permit_complete_date,
 permit_issued_date,
 permit_expiration_date,
 notice_received_date,
 is_notice_received,
 is_notice_acknowledged,
 is_active,
 created_at,
 updated_at)

SELECT PROJECT_NUMBER,
       NPDES_NUMB,
       NULLIF(replace(replace(np_date_r, '0000-00-00', ''), '-00', '-01'), '')         as np_date_r,
       NULLIF(replace(replace(pindi_date, '0000-00-00', ''), '-00', '-01'), '')        as pindi_date,
       NULLIF(replace(replace(date_term, '0000-00-00', ''), '-00', '-01'), '')         as date_term,
       NULLIF(replace(replace(np_date_a, '0000-00-00', ''), '-00', '-01'), '')         as np_date_a,
       NULLIF(replace(replace(np_date_i, '0000-00-00', ''), '-00', '-01'), '')         as np_date_i,

       NULLIF(replace(replace(npdes_expire_date, '0000-00-00', ''), '-00', '-01'), '') as npdes_expire_date,
       NULLIF(replace(replace(not_rcvd, '0000-00-00', ''), '-00', '-01'), '')          as not_rcvd,
       NPDES_DONE,
       NOT_ACK,
       Active,
       current_timestamp(),
       current_timestamp()

from cdis_july_11.project;


-- ----------- CLOSED PROJECTS INSERTIONS ----------#
SET @counter := 0;

INSERT INTO `cdis`.`project_closed`
(`id`,
 `project_id`,
 `box_number`,
 `reason`,
 `notes`,
 `closing_date`,
 `created_at`,
 `updated_at`)


SELECT @counter := @counter + 1 AS id,
       p.PROJECT_NUMBER         AS project_id,
       nullif(box_number, '')   AS box_number,
       nullif(reason, '')       as reason,
       nullif(notes, '')        as notes,
       CASE
           WHEN CAST(date_closed AS CHAR(20)) = '0000-00-00 00:00:00' THEN NULL
           ELSE
               DATE_FORMAT(date_closed, '%Y-%m-%d %h:%i:%s')
           END,
       CURRENT_TIMESTAMP        as create_at,
       CURRENT_TIMESTAMP        as updated_at

FROM cdis_july_11.Closed_Projects_Table as cpt
         left join cdis_july_11.project as p
                   ON cpt.Permit_Number = p.NPDES_NUMB
where cpt.Permit_Number in (select npdes_numb from cdis_july_11.project where npdes_numb <> '')
  and cpt.permit_number <> '';


-- Remove the duplicates using self JOIN
DELETE t1
FROM cdis.project_closed t1
         INNER JOIN cdis.project_closed t2
WHERE t1.id
    < t2.id
  AND t1.project_id = t2.project_id;

-- update the is_closed column in projects table to match the closed_project table
/*update cdis.projects
set is_closed = 1
where id in (select project_id from cdis.project_closed);*/


-- ------------ CONTACTS INSERTIONS ---------------#
INSERT INTO `cdis`.`contacts`
(`id`,
 `county_id`,
 `name`,
 `company`,
 `address`,
 `city`,
 `state`,
 `zipcode`,
 `type`,
 `is_old`,
 `data`)

SELECT id,
       county_id,
       name,
       '',
       address,
       city,
       state,
       zipcode,
       type,
       is_old,
       data
FROM cdis_july_11.contact;

-- fix each contact type issues with JSON data manually by searching them
select *
from contacts
where type = 'engineer'
  AND JSON_VALID(data) = 0;
-- then fix the issues in that data.

-- INVALID JSON contacts(Engineers)
select *
from contacts
where id IN (6311, 6320, 6714, 6737, 6810, 6847);

-- INVALID JSON contacts(Engineers)
select *
from contacts
where id IN (2091, 2357, 2587, 9605, 9871, 10101);


-- # ------- PROJECT FILES DATA INSERTION QUERY ----------#

-- project files
INSERT INTO `cdis`.`project_files`
(`id`,
 `project_id`,
 `user_id`,
 `doctype`,
 `filename`,
 `path`,
 `auth_code`,
 `memo`,
 `created_at`)

SELECT `documents`.`document_id` as id,
       `documents`.`project_id`  as project_id,
       `documents`.`creator_id`  as user_id,
       'file',
       `documents`.`key`         as filename,
       `documents`.`location`    as path,
       `documents`.`authcode`    as auth_code,
       `documents`.`memo`        as memo,
       `documents`.`datetime`    as created_at
FROM `cdis_july_11`.`documents`
where doctype = 'Attached File'
  AND creator_id IN (SELECT id from cdis.users);


-- # ------- PROJECT TRANSACTIONS DATA INSERTION QUERY ----------#
update cdis_july_11.transactions
set county_id = 1
where conservationdistrict = 'BCCD';

update cdis_july_11.transactions
set county_id = 2
where conservationdistrict = 'MCCD';

INSERT INTO `cdis`.`transactions`
(`project_id`,
 `totalacres`,
 `tobedisturb`,
 `tbd_fee`,
 `rev_number`,
 `plan_date`,
 `received`,
 `reviewed`,
 `dist_fee`,
 `tech_init`,
 `dist_chknum`,
 `mccd_cwf_payor`,
 `distfee_payor`,
 `tech_status`,
 `nr`,
 `entry`,
 `mccd_cwf_chknum`,
 `mccd_cwf_fee`,
 `tbdfee_payor`,
 `date_wd`,
 `p_h_fee`,
 `expedite_fee`,
 `exp_check_num`,
 `exp_check_date`,
 `exp_payor`,
 `admin_rev_date`,
 `admin_status`,
 `return_reason`,
 `admin_init`,
 `tbdfee_chknum`,
 `tbdfee_chkdate`,
 `dist_fee_chkdate`,
 `mccd_cwf_chkdate`,
 `is_admin`,
 `fee_type`,
 `county_id`,
 `conservationdistrict`)


SELECT `transactions`.`PROJECT_NU`,
       `transactions`.`TOTALACRES`,
       `transactions`.`TOBEDISTRB`,
       `transactions`.`TBD_FEE`,
       `transactions`.`REV_NUMBER`,
       `transactions`.`PLAN_DATE`,

       CASE
           WHEN CAST(RECEIVED AS CHAR(11)) = '0000-00-00' THEN NULL
           ELSE
               DATE_FORMAT(RECEIVED, '%Y-%m-%d')
           END                               as RECEIVED,
       `transactions`.`REVIEWED`,
       `transactions`.`DIST_FEE`,
       `transactions`.`TECH_INIT`,
       `transactions`.`DIST_CHKNUM`,
       `transactions`.`MCCD_CWF_PAYOR`,
       `transactions`.`DISTFEE_PAYOR`,
       `transactions`.`TECH_STATUS`,
       `transactions`.`NR`,
       `transactions`.`ENTRY`,
       `transactions`.`MCCD_CWF_CHKNUM`,
       `transactions`.`MCCD_CWF_FEE`,
       `transactions`.`TBDFEE_PAYOR`,
       `transactions`.`DATE_WD`,
       `transactions`.`P_H_FEE`,
       `transactions`.`EXPEDITE_FEE`,
       `transactions`.`EXP_CHECK_NUM`,
       CASE
           WHEN CAST(EXP_CHECK_DATE AS CHAR(11)) = '0000-00-00' THEN NULL
           ELSE
               DATE_FORMAT(EXP_CHECK_DATE, '%Y-%m-%d')
           END                               as EXP_CHECK_DATE,
       `transactions`.`EXP_PAYOR`,
       `transactions`.`ADMIN_REV_DATE`,
       `transactions`.`ADMIN_STATUS`,
       `transactions`.`RETURN_REASON`,
       `transactions`.`ADMIN_INIT`,
       `transactions`.`TBDFEE_CHKNUM`,
       `transactions`.`TBDFEE_CHKDATE`,
       `transactions`.`DIST_FEE_CHKDATE`,
       `transactions`.`MCCD_CWF_CHKDATE`,
       CASE WHEN Admin = 1 THEN 1 ELSE 0 END AS Admin,
       ''                                    as fee_type,
       `transactions`.`county_id`,
       `transactions`.`conservationdistrict`

FROM `cdis_july_11`.`transactions`
where project_nu in (select id from cdis.projects);


update transactions  set tech_status = 'inadequate' where tech_status = 'Inad';

-- # -------  PROJECT DETAILS NASICS INSERTIONS ------------#
SELECT project_number, naics
FROM cdis_july_11.project
where naics <> '[]'
  and naics <> '';

-- Make all the naics '' where it has empty array
update cdis_july_11.project
SET naics = ''
where naics = '[]';

-- Clean up array notation around values
update cdis_july_11.project
SET naics = replace(naics, '["', ''),
    naics = replace(naics, '"]', '');

update cdis_july_11.project
set naics = replace(naics, '","', ' ');

-- QUERY GENERATOR To separate the multiple nasics (which were in the single column)  into multiple rows
set @counter := 1;
select concat('insert into `cdis`.`project_details_nasic` select @counter:=@counter+1', ',', np.id, ',',
              'nasic from (select NULL nasic union select ', replace(naics, ' ', ' union select '),
              ') A where nasic IS NOT NULL;')
FROM cdis_july_11.project as op
         join cdis.project_details as np ON op.PROJECT_NUMBER = np.project_id
where naics <> '[]'
  and naics <> ''
  and naics <> 'null'
  and length(naics) > 6;

-- Then execute this
INSERT INTO `cdis`.`project_details_nasic`
(`id`,
 `project_detail_id`,
 `nasic`)
SELECT 1, np.id, naics
FROM cdis_july_11.project as op
         join cdis.project_details as np
              ON op.PROJECT_NUMBER = np.project_id
where naics <> '[]'
  and naics <> ''
  and naics <> 'null';

-- just to verify the records
select *
from cdis.project_details_nasic;

-- delete the rows where nasic column contains multiple values
delete
from cdis.project_details_nasic
where LENGTH(nasic) > 6;

-- # ----  END OF QUERIES ------ # --


--

--

--
--


--

# -------------------------------- PROJECT REVIEWS INSERTIONS --------------------------------#
#delete dangling records which doesn't match with projects
UPDATE cdis_july_11.transactions
set PROJECT_NU = null
where (admin_status <> '' or admin_init <> ''
    or tech_status <> '' or tech_init <> ''
    or return_reason <> '' or date_wd <> '' or admin_rev_date <> '')
  and project_nu not in (select id from cdis.projects);

#fix date format (m-d-y) to (Y-m-d)
# update cdis_july_11.transactions   set admin_rev_date = DATE_FORMAT(STR_TO_DATE(admin_rev_date, '%m-%d-%Y'), '%Y-%m-%d') where ( admin_status <> '' or admin_init <> '' or tech_status <> '' or tech_init <> '' or return_reason <> '' or date_wd <> '' or admin_rev_date <> '') and admin_rev_date like '__-__-201_';

# another fix in admin_rev_date
# update cdis_july_11.transactions set admin_rev_date = '2017-10-25'  where ( admin_status <> '' or admin_init <> ''
#     or tech_status <> '' or tech_init <> ''
#     or return_reason <> '' or date_wd <> '' or admin_rev_date <> '') and admin_rev_date like '__-__-__';

#fix date format issue of reviewed
# update cdis_july_11.transactions  set reviewed = '2017-10-26' where ( admin_status <> '' or admin_init <> ''
#     or tech_status <> '' or tech_init <> '' or return_reason <> '' or date_wd <> '' or admin_rev_date <> '') and reviewed like '__-__-__';

INSERT INTO `cdis`.`project_reviews`
(project_id,
 received_date,
 is_admin,
 admin_review_date,
 admin_status,
 admin_initials,
 reviewed_date,
 tech_status,
 tech_initials,
 return_reason,
 date_withdrawn,
 created_at,
 updated_at)

SELECT PROJECT_NU,
       nullif(replace(received, '0000-00-00', ''), ''),
       admin,
       nullif(admin_rev_date, ''),
       lower(admin_status),
       upper(admin_init),
       nullif(reviewed, ''),
       lower(tech_status),
       upper(tech_init),
       return_reason,
       nullif(date_wd, ''),
       CURRENT_TIMESTAMP,
       CURRENT_TIMESTAMP
from cdis_july_11.transactions
where (admin_status <> '' or admin_init <> ''
    or tech_status <> '' or tech_init <> ''
    or return_reason <> '' or date_wd <> '' or admin_rev_date <> '')
  AND PROJECT_NU in (select project_number from cdis_july_11.project);

#fix the shortname tech_status issues
update cdis.project_reviews
set tech_status = 'adequate'
where tech_status = 'adeq';
update cdis.project_reviews
set tech_status = 'inadequate'
where tech_status = 'inad';


# -------------------------------- PROJECT FEES INSERTIONS --------------------------------#
#DISTRICT FEE INSERTION
truncate cdis.project_fees;
INSERT INTO `cdis`.`project_fees`
(`project_id`,
 `received_date`,
 `is_admin`,
 `submission_type`,
 `review_number`,
 `disturbed_acres`,
 `total_acres`,
 `fee_type`,
 `fee_amount`,
 `check_number`,
 `payer_name`,
 `check_date`)

SELECT project_nu       as project_id,
       CASE
           WHEN CAST(received AS CHAR(11)) = '0000-00-00' THEN NULL
           ELSE
               DATE_FORMAT(received, '%Y-%m-%d %h:%i:%s')
           END          as received_date,
       admin            as is_admin,
       NR               as submit_type,
       REV_NUMBER       as review_number,
       TOBEDISTRB       as distrubed_acres,
       TOTALACRES       as total_acres,
       'dist_fee'       as fee_type,
       DIST_FEE         as fee_amount,
       DIST_CHKNUM      as check_number,
       DISTFEE_PAYOR    as payer_name,
       DIST_FEE_CHKDATE as check_date

FROM cdis_july_11.transactions
where (dist_fee <> 0
    or dist_chknum <> ''
    or DISTFEE_PAYOR <> ''
    or DIST_FEE_CHKDATE <> '')
  AND PROJECT_NU in (select project_number from cdis_july_11.project);

#EXPEDITED FEE INSERTION
#removes $ from fee
update cdis_july_11.transactions
SET EXPEDITE_FEE = 910
where EXPEDITE_FEE like '%\$%';

#removes comma from expedite fee to fix it's type
update `cdis_july_11`.`transactions`
set EXPEDITE_FEE = REPLACE(EXPEDITE_FEE, ',', '')
WHERE EXPEDITE_FEE like '%5,3%';

#removes text from the fee value
update `cdis_july_11`.`transactions`
set EXPEDITE_FEE = 200.00
WHERE EXPEDITE_FEE like '%resub%';

#replaces '' column with 0 to fix the type issues in decimal import
update cdis_july_11.transactions
SET EXPEDITE_FEE = 0
where expedite_Fee = '';

INSERT INTO `cdis`.`project_fees`
(`project_id`,
 `received_date`,
 `is_admin`,
 `submission_type`,
 `review_number`,
 `disturbed_acres`,
 `total_acres`,
 `fee_type`,
 `fee_amount`,
 `check_number`,
 `payer_name`,
 `check_date`)
SELECT project_nu    as project_id,
       CASE
           WHEN CAST(received AS CHAR(11)) = '0000-00-00' THEN NULL
           ELSE
               DATE_FORMAT(received, '%Y-%m-%d')
           END       as received_date,
       admin         as is_admin,
       NR            as submit_type,
       REV_NUMBER    as review_number,
       TOBEDISTRB    as distrubed_acres,
       TOTALACRES    as total_acres,
       'exp_fee'     as fee_type,
       EXPEDITE_FEE  as fee_amount,
       EXP_CHECK_NUM as check_number,
       EXP_PAYOR     as payer_name,
       CASE
           WHEN CAST(EXP_CHECK_DATE AS CHAR(11)) = '0000-00-00' THEN NULL
           ELSE
               DATE_FORMAT(EXP_CHECK_DATE, '%Y-%m-%d')
           END       as check_date

FROM cdis_july_11.transactions
where (EXPEDITE_FEE <> 0.000
    or EXP_CHECK_NUM <> ''
    or EXP_PAYOR <> '')
  AND PROJECT_NU in (select project_number from cdis_july_11.project);

#TBD FEE INSERTION
INSERT INTO `cdis`.`project_fees`
(`project_id`,
 `received_date`,
 `is_admin`,
 `submission_type`,
 `review_number`,
 `disturbed_acres`,
 `total_acres`,
 `fee_type`,
 `fee_amount`,
 `check_number`,
 `payer_name`,
 `check_date`)
SELECT project_nu,
       CASE
           WHEN CAST(received AS CHAR(11)) = '0000-00-00' THEN NULL
           ELSE
               DATE_FORMAT(received, '%Y-%m-%d')
           END   as received_date,
       admin,
       NR,
       REV_NUMBER,
       TOBEDISTRB,
       TOTALACRES,
       'tbd_fee' as fee_type,
       TBD_FEE,
       TBDFEE_CHKNUM,
       TBDFEE_PAYOR,
       TBDFEE_CHKDATE

FROM cdis_july_11.transactions
WHERE (TBD_FEE <> 0 or TBDFEE_CHKNUM <> '' or TBDFEE_PAYOR <> '' or TBDFEE_CHKDATE <> '')
  AND PROJECT_NU in (select project_number from cdis_july_11.project);

#CWF FEE INSERTION
INSERT INTO `cdis`.`project_fees`
(`project_id`,
 `received_date`,
 `is_admin`,
 `submission_type`,
 `review_number`,
 `disturbed_acres`,
 `total_acres`,
 `fee_type`,
 `fee_amount`,
 `check_number`,
 `payer_name`,
 `check_date`)
SELECT project_nu,
       CASE
           WHEN CAST(received AS CHAR(11)) = '0000-00-00' THEN NULL
           ELSE
               DATE_FORMAT(received, '%Y-%m-%d')
           END   as received_date,
       admin,
       NR,
       REV_NUMBER,
       TOBEDISTRB,
       TOTALACRES,
       'cwf_fee' AS fee_type,
       MCCD_CWF_FEE,
       MCCD_CWF_CHKNUM,
       MCCD_CWF_PAYOR,
       MCCD_CWF_CHKDATE

FROM cdis_july_11.transactions
WHERE (MCCD_CWF_FEE <> 0
    OR MCCD_CWF_CHKNUM <> ''
    OR MCCD_CWF_PAYOR <> ''
    OR MCCD_CWF_CHKDATE <> '')
  AND PROJECT_NU in (select project_number from cdis_july_11.project);




# -------------------------------- Reviewer fixes --------------------------  #


