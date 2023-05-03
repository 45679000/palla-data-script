SELECT STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(loan_date,'-', ' ') as date_loan, STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(exp_date,'-', ' ') as loan_expiry FROM loan_s LEFT JOIN receipts_zip ON receipts_zip.acct_no = loan_s.acct_no WHERE STR_TO_DATE(receipts_zip.date, '%d-%b-%y') >= STR_TO_DATE(loan_date, '%d-%b-%y') AND  STR_TO_DATE(receipts_zip.date, '%d-%b-%y') <= STR_TO_DATE(exp_date, '%d-%b-%y') GROUP BY loan_s.id


DATEDIFF(STR_TO_DATE(loan_s.loan_date,'%d-%b-%y'),STR_TO_DATE(receipts_zip.date,'%d/%m/%Y')) <30 AND 
STR_TO_DATE(receipts_zip.date,'%d/%m/%Y') >=  STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')AND 

-- This 100% works to get the id (""loan - id"")
SELECT loan_s.id,STR_TO_DATE(receipts_zip.date,'%d/%m/%Y') as date_of_pay,DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) as diff,receipts_zip.acct_no, STR_TO_DATE(loan_date, '%d-%b-%y') as day,REPLACE(loan_date,'-', ' ') as date_loan, REPLACE(exp_date,'-', ' ') as loan_expiry FROM loan_s LEFT JOIN receipts_zip ON receipts_zip.tel = loan_s.tel WHERE 
loan_s.id = 2 AND 
DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) >=0 AND
DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) <= 30 
GROUP BY loan_s.id 

UPDATE receipts_zip 
LEFT JOIN loan_s ON receipts_zip.tel = loan_s.tel
SET receipts_zip.load_s_id = loan_s.id  WHERE 
                    loan_s.id = 2 AND 
                    DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) >=1 AND
                    DATEDIFF(STR_TO_DATE(receipts_zip.date,'%d/%m/%Y'),STR_TO_DATE(loan_s.loan_date,'%d-%b-%y')) <= 30 

ALTER TABLE `15_21` CHANGE `COL 1` `acct_no` VARCHAR(7) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 2` `transction` VARCHAR(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 3` `client` VARCHAR(31) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 4` `tel` VARCHAR(13) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 5` `loan_amount` VARCHAR(11) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 6` `interest` VARCHAR(9) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 7` `rate` VARCHAR(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 8` `total_amount` VARCHAR(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 9` `loan_date` VARCHAR(9) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 10` `exp_date` VARCH[...]

ALTER TABLE `15_21` ADD `client_id` INT NOT NULL AFTER `id`, ADD `loan_id` INT NOT NULL AFTER `client_id`, ADD `error` VARCHAR(5000) NOT NULL AFTER `loan_id`, ADD `approved` INT NOT NULL AFTER `error`, ADD `approved_error` VARCHAR(5000) NOT NULL AFTER `approved`, ADD `disbursed` INT NOT NULL AFTER `approved_error`, ADD `disbursed_error` VARCHAR(5000) NOT NULL AFTER `disbursed`, ADD `receipted` INT NOT NULL AFTER `disbursed_error`, ADD `receipted_error` VARCHAR(5000) NOT NULL AFTER `receipted`;

ALTER TABLE receipts_3_19jan ADD id INT PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE `receipts_3_19jan` CHANGE `COL 1` `acct_no` INT(6) NULL DEFAULT NULL, CHANGE `COL 2` `rct_no` INT(7) NULL DEFAULT NULL, CHANGE `COL 3` `client` VARCHAR(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 4` `tel` VARCHAR(13) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 5` `description` VARCHAR(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 6` `date` VARCHAR(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 7` `amount` INT(5) NULL DEFAULT NULL, CHANGE `COL 8` `branch` VARCHAR(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 9` `sub_region` VARCHAR(22) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;

ALTER TABLE `receipts_31_2__jan` ADD id INT PRIMARY KEY AUTO_INCREMENT,CHANGE `COL 1` `acct_no` INT(6) NULL DEFAULT NULL, CHANGE `COL 2` `rct_no` INT(7) NULL DEFAULT NULL, CHANGE `COL 3` `client` VARCHAR(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 4` `tel` VARCHAR(13) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 5` `description` VARCHAR(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 6` `date` VARCHAR(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 7` `amount` INT(5) NULL DEFAULT NULL, CHANGE `COL 8` `branch` VARCHAR(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE `COL 9` `sub_region` VARCHAR(22) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;


INSERT INTO `loans` (`client_id`, `acct_no`, `transction`, `client`, `tel`, `loan_amount`, `interest`, `rate`, `total_amount`, `loan_date`, `exp_date`, `region`, `sub_region`, `loan_Id`, `error`, `approved`, `approved_error`, `disbursed`, `disbursed_error`) SELECT `client_id`, `acct_no`, `transction`, `client`, `tel`, `loan_amount`, `interest`, `rate`, `total_amount`, `loan_date`, `exp_date`, `region`, `sub_region`, `loan_id`, `error`, `approved`, `approved_error`,`disbursed`,`disbursed_error` FROM loans_31_dec
INSERT INTO `loans` (`client_id`,`client`,`loan_amount`, `loan_date`, `exp_date`,`loan_Id`) SELECT `client_id`, `client`, `loan_amount`,`loan_date`, `exp_date`,`loan_Id` FROM loans_
INSERT INTO `receipts` (`acct_no`, `rct_no`, `client`, `tel`, `Description`, `date`, `amount`, `branch`, `sub_region`, `loan_id`, `posted`, `posted_error`) SELECT acct_no,rct_no,client,tel,Description,date,amount,branch,sub_region,receipts_zip.load_s_id,posted,posted_error FROM receipts_zip

SELECT 
    *, COUNT(transction)
FROM
    loans WHERE str_to_date(loan_date, '%d-%b-%Y') >= str_to_date('01/02/2023', '%d/%m/%Y') AND region IN('Eastlands')
GROUP BY 
    transction
HAVING 
    COUNT(transction) > 1;

    SELECT * FROM loans WHERE tel IN (SELECT tel FROM loans WHERE id = 6410) ORDER BY STR_TO_DATE(loans.loan_date, '%d-%b-%Y') ASC

UPDATE m_loan_transaction LEFT JOIN m_payment_detail ON m_payment_detail.id=m_loan_transaction.payment_detail_id LEFT JOIN receipts ON receipts.rct_no = m_payment_detail.receipt_number SET transaction_date = STR_TO_DATE(date, '%d/%m/%Y') WHERE rct_no = 26673;

MariaDB [fineract_default_data]> UPDATE m_loan_transaction as t LEFT JOIN m_payment_detail as p ON p.id = t.payment_detail_id LEFT JOIN receipts as r ON r.rct_no = p.receipt_number SET t.transaction_date = STR_TO_DATE(r.date, '%d/%m/%Y') WHERE p.receipt_number = '26457';
UPDATE m_loan_transaction as t LEFT JOIN m_payment_detail as p ON p.id = t.payment_detail_id LEFT JOIN receipts as r ON r.rct_no = p.receipt_number SET t.transaction_date = STR_TO_DATE(r.date, '%d/%m/%Y') WHERE MONTH(STR_TO_DATE(r.date, '%d/%m/%Y'))= 12;

UPDATE m_loan_transaction as t LEFT JOIN m_payment_detail as p ON p.id = t.payment_detail_id LEFT JOIN receipts as r ON r.rct_no = p.receipt_number SET t.transaction_date = STR_TO_DATE(r.date, '%d/%m/%Y') WHERE MONTH(STR_TO_DATE(r.date, '%d/%m/%Y'))= '12';
ERROR 1292 (22007): Truncated incorrect DECIMAL value: ''
MariaDB [fineract_default_data]>

UPDATE m_loan_transaction as t LEFT JOIN m_payment_detail as p ON p.id = t.payment_detail_id LEFT JOIN receipts as r ON r.rct_no = p.receipt_number SET t.transaction_date = STR_TO_DATE(r.date, '%d/%m/%Y') WHERE MONTH(STR_TO_DATE(r.date, '%d/%m/%Y'))= '12'

UPDATE table2 AS b1, ( SELECT b.id, MIN(IFNULL(a.views, 0)) AS counted 
                       FROM table1 a 
                       JOIN table2 b ON a.id = b.id 
                       GROUP BY id 
                       HAVING counted > 0 ) AS b2
SET b1.number = b2.counted
WHERE b1.id = b2.id

UPDATE m_loan_transaction as t,( SELECT p.id as p_id, date_new FROM m_payment_detail as p LEFT JOIN receipts as r ON r.rct_no = p.receipt_number WHERE MONTH(date_new) = 12) as t2 SET t.transaction_date = t2.date_new WHERE t2.p_id = t.payment_detail_id