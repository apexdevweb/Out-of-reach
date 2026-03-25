DELIMITER $$
CREATE PROCEDURE AdminAccessByIp(IN p_ip VARCHAR(45))
BEGIN
    SELECT *
    FROM ofr_admin 
    WHERE admin_ofr_ip = p_ip 
    LIMIT 1;
END $$
DELIMITER;